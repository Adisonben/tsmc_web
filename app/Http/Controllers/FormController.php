<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Form;
use App\Models\Form_answer;
use App\Models\Form_category;
use App\Models\Form_response;
use App\Models\Form_type;
use App\Models\FormColumn;
use App\Models\FormList;
use App\Models\FormListHasColumn;
use App\Models\Option;
use App\Models\Option_type;
use App\Models\Phone_number;
use App\Models\Quest_group;
use App\Models\Question;
use App\Models\Repair_history_data;
use App\Models\tsm_ai_005_data;
use App\Models\tsm_rp_002_data;
use App\Models\tsm_v_002_data;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form_cates = Form_category::with('formTypes')->get();
        return view('form.manage.formTableType', compact('form_cates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $can_create_forms = ["TSM-V-001", "TSM-HR-003", "TSM-HR-002", "TSM-HR-001"];
        $form_types = Form_type::whereIn("type_code", $can_create_forms)->get();
        $opt_types = Option_type::all();
        return view('form.manage.createForm', compact('form_types', 'opt_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $checkData = json_decode($request->input('checkData'), true); // [{"groupName":"awdada","groupSubText":["dawdawdawdawd"]}]
            // foreach ($checkData ?? [] as $group) {
            //     $fileNames[] = $request->hasFile('groupImage_' . $group['groupName']);
            // }
            $formType = Form_type::find($request->formType);
            $newForm = Form::create([
                'title' => $request->formName,
                'category' => $formType->category,
                'type' => $formType->id,
                'has_comment' => $request->commentCheck ? true : false,
                'has_score' => $request->scoreCheck ? true : false,
                'has_approve' => $request->approveCheck ? true : false,
                'org' => $request->user()->userDetail->org,
                'form_id' => Str::uuid(),
                'created_by' => $request->user()->id,
            ]);

            foreach ($checkData ?? [] as $group) {
                $newGroup = Quest_group::create([
                    'form_id' => $newForm->id,
                    'title' => $group['groupName'],
                    'group_type' => $group['groupType'],
                ]);
                if ($group['groupType'] == "image") {
                    if ($request->hasFile('groupImage_' . $group['groupName'])) {
                        $imgFile = $request->file('groupImage_' . $group['groupName']);
                        $file_name = time() . '_' . md5(uniqid(rand(), true)) . '.' . $imgFile->getClientOriginalExtension();
                        $folderPath = public_path('uploads/formImage');
                        $imgFile->move($folderPath, $file_name);

                        $newGroup->content = $file_name;
                        $newGroup->save();
                    }
                } else if ($group['groupType'] == "check") {
                    if (count($group['checkList'] ?? []) > 0) {
                        foreach ($group['checkList'] as $ques) {
                            $newQuestion = Question::create([
                                'form_id' => $newForm->id,
                                'group_id'=> $newGroup->id,
                                'option_type' => $ques['optType'],
                                'title' => $ques['checktTitle']
                            ]);
                            if ($ques['optType'] == "custom") {
                                foreach ($ques['optionList'] ?? [] as $option) {
                                    Option::create([
                                        'opt_text' => $option['optionText'],
                                        'score' => $option['optionScore'] ?? 1,
                                        'question_id' => $newQuestion->id
                                    ]);
                                }
                            }
                        }
                    }
                } else {

                }
            }
            return response()->json([
                'message' => 'Form has created successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form_types = Form_type::all();
        $opt_types = Option_type::all();
        $form_edit = Form::where('form_id', $id)->first();
        $quest_groups = Quest_group::where('form_id', $form_edit->id)->get();

        // $question_one = Question::where('form_id', $form_edit->id)->first();
        // $sopt_type = $question_one->option_type;
        return view('form.manage.editForm', compact('form_types', 'opt_types', 'form_edit', 'quest_groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $checkData = json_decode($request->input('checkData'), true); // [{"groupName":"awdada","groupSubText":["dawdawdawdawd"]}]
            $formType = Form_type::find($request->formType);
            $updateForm = Form::find($id);
            $updateForm->update([
                'title' => $request->formName,
                'category' => $formType->category,
                'type' => $formType->id,
                'has_comment' => $request->commentCheck ? true : false,
                'has_score' => $request->scoreCheck ? true : false,
                'has_approve' => $request->approveCheck ? true : false,
            ]);

            $quest_group_del_ids = Quest_group::where('form_id', $id)->pluck('id');
            $quest_ids = Question::where('form_id', $id)->pluck('id');

            foreach ($checkData ?? [] as $group) {
                $newGroup = Quest_group::create([
                    'form_id' => $updateForm->id,
                    'title' => $group['groupName'],
                    'group_type' => $group['groupType'],
                ]);
                if ($group['groupType'] == "image") {
                    if ($request->hasFile('groupImage_' . $group['groupName'])) {
                        $imgFile = $request->file('groupImage_' . $group['groupName']);
                        $file_name = time() . '_' . md5(uniqid(rand(), true)) . '.' . $imgFile->getClientOriginalExtension();
                        $folderPath = public_path('uploads/formImage');
                        $imgFile->move($folderPath, $file_name);

                        $newGroup->content = $file_name;
                        $newGroup->save();
                    }
                } else if ($group['groupType'] == "check") {
                    if (count($group['checkList'] ?? []) > 0) {
                        foreach ($group['checkList'] as $ques) {
                            $newQuestion = Question::create([
                                'form_id' => $updateForm->id,
                                'group_id'=> $newGroup->id,
                                'option_type' => $ques['optType'],
                                'title' => $ques['checktTitle']
                            ]);
                            if ($ques['optType'] == "custom") {
                                foreach ($ques['optionList'] ?? [] as $option) {
                                    Option::create([
                                        'opt_text' => $option['optionText'],
                                        'score' => $option['optionScore'] ?? 1,
                                        'question_id' => $newQuestion->id
                                    ]);
                                }
                            }
                        }
                    }
                } else {

                }
            }

            // foreach ($checkData ?? [] as $group) {
            //     $newGroup = Quest_group::create([
            //         'form_id' => $updateForm->id,
            //         'title' => $group['groupName'],
            //     ]);
            //     if (count($group['checkList'] ?? []) > 0) {
            //         foreach ($group['checkList'] as $ques) {
            //             $newQuestion = Question::create([
            //                 'form_id' => $updateForm->id,
            //                 'group_id'=> $newGroup->id,
            //                 'option_type' => $ques['optType'],
            //                 'title' => $ques['checktTitle']
            //             ]);
            //             if ($ques['optType'] == "custom") {
            //                 foreach ($ques['optionList'] ?? [] as $option) {
            //                     Option::create([
            //                         'opt_text' => $option['optionText'],
            //                         'score' => $option['optionScore'] ?? 1,
            //                         'question_id' => $newQuestion->id
            //                     ]);
            //                 }
            //             }
            //         }
            //     }
            // }

            $quest_groups = Quest_group::whereIn('id', $quest_group_del_ids)->get();
            foreach ($quest_groups as $quest_group) {
                if ($quest_group->group_type == "image") {
                    $image_name = $quest_group->content;
                    $filePath = public_path('uploads/formImage/' . $image_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                $quest_group->delete();
            }
            Option::whereIn('question_id', $quest_ids)->delete();
            Question::whereIn('id', $quest_ids)->delete();

            return response()->json([
                'message' => 'Form has updated successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Form::where('id', $id)->delete();
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function showFormTable($formTypeName) {
        // Get all user id that subordinate or same position of this auth user
        $posit_to_query = [Auth()->user()->userDetail->getPosition->id, ...Auth()->user()->userDetail->getPosition->descendants()->pluck('id')];
        $user_id_to_query = User_detail::where('org', Auth()->user()->userDetail->org)->whereIn('position', $posit_to_query)->pluck('user_id');

        $form_type = Form_type::where('name', $formTypeName)->firstOrFail();
        $form_lists = Form::where('type', $form_type->id)->where('org', Auth()->user()->userDetail->org)->get();
        return view('form.manage.formTables', compact('form_type', 'form_lists'));
    }

    public function checkingType() {
        $form_cates = Form_category::with('formTypes')->get();
        return view('form.checking.selectForm', compact('form_cates'));
    }

    public function checkingForm(Request $request, $formid) {
        $formdata = Form::where('form_id', $formid)->firstOrFail();
        $userDetail = User_detail::where('user_id', $request->user()->id)->firstOrFail();
        $quest_groups = Quest_group::where('form_id', $formdata->id)->get();
        $formtype_check = optional($formdata->getType)->name ?? "";
        $formFormat = "";
        switch ($formtype_check) {
            case 'แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ':
                $formFormat = "TSM-HR-003";
                break;
            case 'แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ':
                $formFormat = "TSM-V-003";
                break;
            case 'แบบประเมินความสามารถ':
                $formFormat = "TSM-HR-002";
                break;
            case 'แบบฟอร์มการตรวจสุขภาพ':
                $formFormat = "TSM-HR-001";
                break;

            default:

                break;
        }
        return view('form.checking.formFormat.' . $formFormat, compact('formdata', 'userDetail', 'quest_groups'));
    }

    public function storeCheckedForm(Request $request) {
        try {
            $form = Form::where('id', $request->form_id)->firstOrFail();
            $questions = Question::where('form_id', $request->form_id)->get();
            $formtype_check = optional($form->getType)->name ?? "";
            $resp = Form_response::create([
                'user_id' => $request->user()->id,
                'form_id' => $request->form_id,
                'times' => 0,
                'status' => $form->has_approve ? 2 : 1,
            ]);
            switch ($formtype_check) {
                case 'แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ':
                    $resp->header_data = json_encode([
                        'name' => $request->driverName,
                        'posit' => $request->driverPosit
                    ]);
                    break;
                case 'แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ':
                    $resp->header_data = json_encode([
                        'car_plate' => $request->car_plate,
                    ]);
                    break;
                case 'แบบประเมินความสามารถ':
                    $resp->header_data = json_encode([
                        'driverName' => $request->driverName,
                        'position' => $request->position,
                        'location' => $request->location,
                        'trainerName' => $request->trainerName,
                        'carInfo' => $request->carInfo,
                        'number' => $request->number,
                    ]);
                    break;
                case 'แบบฟอร์มการตรวจสุขภาพ':
                    $resp->header_data = json_encode([
                        'empName' => $request->empName,
                        'position' => $request->position,
                        'empId' => $request->empId,
                        'department' => $request->department,
                        'dob' => $request->dob,
                    ]);
                    break;

                default:

                    break;
            }
            $resp->save();

            if ($questions) {
                foreach ($questions as $ques) {
                    Form_answer::create([
                        'user_id' => $request->user()->id,
                        'resp_id' => $resp->id,
                        'quest_id' => $ques->id,
                        'answer' => $request->input("questid_" . $ques->id) ?? null,
                        'comment' => $request->input("comment_" . $ques->id) ?? null,
                    ]);
                }
            }
            return redirect()->route('form.checking.type')->with('success', 'Form submitted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function tableType() {
        $form_cates = Form_category::with('formTypes')->get();
        return view('form.table.selectFormType', compact('form_cates'));
    }

    public function tableForm(Request $request, $formid) {
        $form = Form::where('form_id', $formid)->firstOrFail(); // get form

        // Get all user id that subordinate or same position of this auth user
        $posit_to_query = [Auth()->user()->userDetail->getPosition->id, ...Auth()->user()->userDetail->getPosition->descendants()->pluck('id')];
        $user_id_to_query = User_detail::where('org', Auth()->user()->userDetail->org)->whereIn('position', $posit_to_query)->pluck('user_id');

        // query form response
        $form_responses = Form_response::where('form_id', $form->id)
            ->whereIn('user_id', $user_id_to_query)
            ->whereNot('status', '2')
            ->whereHas('getForm', function ($query) {
                $query->where('org', Auth()->user()->userDetail->org);
            })->orderBy("created_at", "desc")->get();
        $formtype_check = optional($form->getType)->name ?? "";
        $formFormat = "";
        switch ($formtype_check) {
            case 'แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ':
                $formFormat = "TSM-HR-003";
                break;
            case 'แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ':
                $formFormat = "TSM-V-003";
                break;
            case 'แบบประเมินความสามารถ':
                $formFormat = "TSM-HR-002";
                break;
            case 'แบบฟอร์มการตรวจสุขภาพ':
                $formFormat = "TSM-HR-001";
                break;

            default:

                break;
        }
        return view('form.table.formFormat.' . $formFormat, compact('form', 'form_responses'));
    }

    public function tableNotHasForm($fcode) {
        // Get all user id that subordinate or same position of this auth user
        $posit_to_query = [Auth()->user()->userDetail->getPosition->id, ...Auth()->user()->userDetail->getPosition->descendants()->pluck('id')];
        $user_id_to_query = User_detail::where('org', Auth()->user()->userDetail->org)->whereIn('position', $posit_to_query)->pluck('user_id');

        // query record and return each form type table
        if ($fcode == "TSM-AI-004") {
            $phonenum_lists = Phone_number::where('org', Auth()->user()->userDetail->org)->whereIn('created_by', $user_id_to_query)->orderBy("created_at", "desc")->get();
            return view('form.table.formFormat.' . $fcode, compact('phonenum_lists'));
        } elseif ($fcode == "TSM-RP-002") {
            $dailyworks = tsm_rp_002_data::where('org', Auth()->user()->userDetail->org)->whereIn('created_by', $user_id_to_query)->orderBy("created_at", "desc")->get();
            return view('form.table.formFormat.' . $fcode , compact('dailyworks'));
        } elseif ($fcode == "TSM-AI-005") {
            $repairEmergs = tsm_ai_005_data::where('org', Auth()->user()->userDetail->org)->whereIn('created_by', $user_id_to_query)->orderBy("created_at", "desc")->get();
            return view('form.table.formFormat.' . $fcode, compact('repairEmergs'));
        } elseif ($fcode == "TSM-V-002") {
            $repairHistories = tsm_v_002_data::where('org', Auth()->user()->userDetail->org)->whereIn('create_by', $user_id_to_query)->orderBy("created_at", "desc")->get();
            return view('form.table.formFormat.' . $fcode, compact('repairHistories'));
        }
    }

    public function formResDetail(Request $request, $formresid) {
        $form_resp = Form_response::find($formresid);
        $formdata = Form::where('id', $form_resp->form_id)->firstOrFail();
        $userDetail = User_detail::where('user_id', $request->user()->id)->firstOrFail();
        $quest_groups = Quest_group::where('form_id', $formdata->id)->get();
        $header_data = json_decode($form_resp->header_data ?? "");
        $formtype_check = optional($formdata->getType)->name ?? "";
        $formFormat = "";
        switch ($formtype_check) {
            case 'แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ':
                $formFormat = "TSM-HR-003";
                break;
            case 'แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ':
                $formFormat = "TSM-V-003";
                break;
            case 'แบบประเมินความสามารถ':
                $formFormat = "TSM-HR-002";
                break;
            case 'แบบฟอร์มการตรวจสุขภาพ':
                $formFormat = "TSM-HR-001";
                break;

            default:

                break;
        }
        return view('form.checking.readonly.' . $formFormat, compact('formdata', 'userDetail', 'quest_groups', 'form_resp', 'header_data'));
    }

    public function formReport(Request $request, $formresid) {
        $form_resp = Form_response::find($formresid);
        $formdata = Form::where('id', $form_resp->form_id)->firstOrFail();
        $userDetail = User_detail::where('user_id', $request->user()->id)->firstOrFail();
        $quest_groups = Quest_group::where('form_id', $formdata->id)->get();
        $header_data = json_decode($form_resp->header_data ?? "");
        $formtype_check = optional($formdata->getType)->name ?? "";
        $formFormat = "";
        switch ($formtype_check) {
            case 'แบบฟอร์มการสอบสัมภาษณ์พนักงานขับรถ':
                $formFormat = "TSM-HR-003";
                break;
            case 'แบบฟอร์มการตรวจสอบสภาพและความพร้อมของรถ':
                $formFormat = "TSM-V-003";
                break;
            case 'แบบประเมินความสามารถ':
                $formFormat = "TSM-HR-002";
                break;
            case 'แบบฟอร์มการตรวจสุขภาพ':
                $formFormat = "TSM-HR-001";
                break;

            default:

                break;
        }
        return view('form.exports.' . $formFormat, compact('formdata', 'userDetail', 'quest_groups', 'form_resp', 'header_data'));
    }

    public function storePhonenum(Request $request) {
        try {
            Phone_number::create([
                "person_name" => $request->personName,
                "position" => $request->position ?? null,
                "office_num" => $request->officePhone ?? null,
                "home_num" => $request->homePhone ?? null,
                "cellphone" => $request->cellPhone ?? null,
                "created_by" => $request->user()->id ?? null,
                "org" => $request->user()->userDetail->org ?? null,
            ]);
            return redirect()->back()->with(['success' => "แก้ไขหมายเลขโทรศัพท์ฉุกเฉินสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถแก้ไขหมายเลขโทรศัพท์ฉุกเฉิน"]);
        }
    }

    public function updatePhonenum(Request $request, $phonenum_id) {
        try {
            Phone_number::where('id', $phonenum_id)->update([
                "person_name" => $request->personName,
                "position" => $request->position ?? null,
                "office_num" => $request->officePhone ?? null,
                "home_num" => $request->homePhone ?? null,
                "cellphone" => $request->cellPhone ?? null,
            ]);
            return redirect()->back()->with(['success' => "บันทึกหมายเลขโทรศัพท์ฉุกเฉินสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถบันทึกหมายเลขโทรศัพท์ฉุกเฉิน"]);
        }
    }

    public function deletePhonenum($id) {
        try {
            Phone_number::where('id', $id)->delete();
            return response()->json([
                'message' => 'Data deleted successfully : ' . $id
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyFormTable() {
        // Get all user id that subordinate or same position of this auth user
        $posit_to_query = [Auth()->user()->userDetail->getPosition->id, ...Auth()->user()->userDetail->getPosition->descendants()->pluck('id')];
        $user_id_to_query = User_detail::where('org', Auth()->user()->userDetail->org)->whereIn('position', $posit_to_query)->pluck('user_id');

        $form_responses = Form_response::whereIn('user_id', $user_id_to_query)->whereHas('getForm', function ($query) {
            $query->where('org', Auth()->user()->userDetail->org);
        })->where('status', "2")->get();
        return view('form.approveTable', compact('form_responses'));
    }

    public function approveForm($formresid, $formresstatus) {
        try {
            $form_res = Form_response::findOrFail($formresid);
            $form_res->status = $formresstatus ? 1 : 3;
            $form_res->save();
            return response()->json([
                'message' => 'Data deleted successfully.' . $formresid . ($formresstatus ? 'true' : 'false')
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function formType() {
        $form_cates = Form_category::all();
        $form_types = Form_type::all();
        return view('appData.formType.formTypeTable', compact('form_cates', 'form_types'));
    }

    public function formTypeStore(Request $request) {
        try {
            Form_type::create([
                "name" => $request->formTypeName,
                "category" => $request->formCate,
                "type_code" => $request->formTypeCode,
                "form_group" => $request->formGroup,
            ]);
            return redirect()->back()->with(['success' => "บันทึกประเภทแบบฟอร์มสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถบันทึกประเภทแบบฟอร์ม"]);
        }
    }

    public function formTypeUpdate(Request $request, $ftid) {
        try {
            Form_type::where('id', $ftid)->update([
                "name" => $request->formTypeName,
                "category" => $request->formCate,
                "type_code" => $request->formTypeCode,
                "form_group" => $request->formGroup,
            ]);
            return redirect()->back()->with(['success' => "แก้ไขประเภทแบบฟอร์มสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถแก้ไขประเภทแบบฟอร์ม"]);
        }
    }

    public function formTypeDelete($ftid) {
        try {
            Form_type::where('id', $ftid)->delete();
            return redirect()->back()->with(['success' => "ลบประเภทแบบฟอร์มสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถลบประเภทแบบฟอร์ม"]);
        }
    }

    public function storeDailyWork(Request $request) {
        // dd($request->all());
        try {
            tsm_rp_002_data::create([
                'work_num' => $request->workNum,
                'vehicle_plate' => $request->vehPlate,
                'employee_name' => $request->empName,
                'assign_date' => $request->assignDate,
                'customer_name' => $request->cusName,
                'receive_place' => $request->recPlace,
                'receive_date' => $request->recDate,
                'drop_place' => $request->sendPlace,
                'drop_date' => $request->sendDate,
                'product_volume' => $request->prodVolume,
                'status' => 0,
                'created_by' => $request->user()->id,
                'org' => $request->user()->userDetail->org,
            ]);
            return redirect()->back()->with(['success' => "เพิ่มการปฏิบัติงานประจำวันสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถเพิ่มการปฏิบัติงานประจำวัน"]);
        }
    }

    public function updateDailyWork(Request $request, $formid) {
        // dd($request->all(), $formid);
        try {
            tsm_rp_002_data::where('id', $formid)->update([
                'work_num' => $request->workNum,
                'vehicle_plate' => $request->vehPlate,
                'employee_name' => $request->empName,
                'assign_date' => $request->assignDate,
                'customer_name' => $request->cusName,
                'receive_place' => $request->recPlace,
                'receive_date' => $request->recDate,
                'drop_place' => $request->sendPlace,
                'drop_date' => $request->sendDate,
                'product_volume' => $request->prodVolume,
                'status' => $request->checkFinish ? 1 : 0,
            ]);
            return redirect()->back()->with(['success' => "อัพเดทการปฏิบัติงานประจำวันสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถอัพเดทการปฏิบัติงานประจำวัน"]);
        }
    }
    public function deleteDailyWork($formid) {
        // dd($request->all(), $formid);
        try {
            tsm_rp_002_data::where('id', $formid)->delete();
            return redirect()->back()->with(['success' => "ลบการปฏิบัติงานประจำวันสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถลบการปฏิบัติงานประจำวัน"]);
        }
    }

    public function storeRepairEmerg(Request $request) {
        try {
            tsm_ai_005_data::create([
                "driver_name" => $request->driverName,
                "phone" => $request->driverPhone,
                "car_plate" => $request->carPlate,
                "repair_list" => $request->repairName,
                "amount" => $request->amount,
                "repair_type" => $request->repairType,
                "repair_by" => $request->fixBy,
                'status' => 0,
                'created_by' => $request->user()->id,
                'org' => $request->user()->userDetail->org,
            ]);
            return redirect()->back()->with(['success' => "เพิ่มการตรวจสอบและซ่อมบำรุงอุปกรณ์สำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถเพิ่มการตรวจสอบและซ่อมบำรุงอุปกรณ์"]);
        }
    }

    public function updateRepairEmerg(Request $request, $formid) {
        // dd($request->all(), $formid);
        try {
            tsm_ai_005_data::where('id', $formid)->update([
                "driver_name" => $request->driverName,
                "phone" => $request->driverPhone,
                "car_plate" => $request->carPlate,
                "repair_list" => $request->repairName,
                "amount" => $request->amount,
                "repair_type" => $request->repairType,
                "repair_by" => $request->fixBy,
            ]);
            return redirect()->back()->with(['success' => "อัพเดทการตรวจสอบและซ่อมบำรุงอุปกรณ์สำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถอัพเดทการตรวจสอบและซ่อมบำรุงอุปกรณ์"]);
        }
    }
    public function deleteRepairEmerg($formid) {
        // dd($request->all(), $formid);
        try {
            tsm_ai_005_data::where('id', $formid)->delete();
            return redirect()->back()->with(['success' => "ลบการตรวจสอบและซ่อมบำรุงอุปกรณ์สำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถลบการตรวจสอบและซ่อมบำรุงอุปกรณ์"]);
        }
    }

    public function createRepairHis() {
        $cars = Car::where('owner_org', Auth()->user()->userDetail->org)->get();
        return view('form.recording.formformat.TSM-V-002', compact('cars'));
    }

    public function storeRepairHis(Request $request) {
        try {
            $carInfo = Car::find($request->carId);
            $tsmdata = [
                "driver_name" => $request->driverName,
                "car_id" => $request->carId,
                "car_plate" => $carInfo->plate_num,
                "car_type" => $request->carType,
                "car_model" => $request->carModel,
                "order_num" => $request->repairNum,
                "repair_type" => "",
                "mileage" => $request->mileage,
                "create_by" => $request->user()->id,
                "org" => $request->user()->userDetail->org,
            ];
            $formData = tsm_v_002_data::create($tsmdata);
            $total_cost = 0;
            foreach ($request->repairBy ?? [] as $index => $value) {
                Repair_history_data::create([
                    "order_num" => $formData->order_num,
                    "repair_type" => $request->repairType[$index],
                    "repair_by" => $request->repairBy[$index],
                    "spare_part" => $request->repairPart[$index],
                    "cost" => $request->repairCost[$index],
                ]);
                $total_cost += $request->repairCost[$index];
            }
            $formData->cost_amount = $total_cost;
            $formData->save();
            return redirect()->back()->with(['success' => "เพิ่มประวัติการบำรุงรักษาและซ่อมรถสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถเพิ่มประวัติการบำรุงรักษาและซ่อมรถ"]);
        }
    }

    public function deleteRepairHis($fid) {
        try {
            $formData = tsm_v_002_data::findOrFail($fid);
            Repair_history_data::where('order_num', $formData->order_num)->delete();
            $formData->delete();
            return redirect()->back()->with(['success' => "ลบประวัติการบำรุงรักษาและซ่อมรถสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => "ไม่สามารถลบประวัติการบำรุงรักษาและซ่อมรถ"]);
        }
    }

    public function detailRepairHis($fid) {
        $formData = tsm_v_002_data::findOrFail($fid);
        $historyData = Repair_history_data::where('order_num', $formData->order_num)->get();
        return view('form.recording.detail.TSM-V-002', compact('formData', 'historyData'));
    }

    public function createPlanForm() {
        $form_types = Form_type::where("form_group", "formPlan")->get();
        return view('form.manage.createPlanForm', compact('form_types'));
    }
    public function editPlanForm($formId) {
        $form_types = Form_type::where("form_group", "formPlan")->get();
        $form = Form::where('form_id', $formId)->firstOrFail();
        return view('form.manage.editPlanForm', compact('form_types', 'form'));
    }
    public function createPlanList($pid) {
        $formPlan = Form::findOrFail($pid);
        return view('form.manage.createPlanList', compact('formPlan'));
    }

    public function storePlanForm(Request $request) {
        // dd($request->all());
        try {
            $formType = Form_type::find($request->formType);
            $newForm = Form::create([
                'title' => $request->formName,
                'category' => $formType->category,
                'type' => $formType->id,
                'has_comment' => false,
                'has_score' => false,
                'has_approve' => false,
                'org' => $request->user()->userDetail->org,
                'form_id' => Str::uuid(),
                'created_by' => $request->user()->id,
            ]);

            foreach ($request->column ?? [] as $column) {
                FormColumn::create([
                    'title' => $column,
                    'group_name' => $request->columnGroupName,
                    'form_id' => $newForm->id
                ]);
            }

            return redirect()->route('form.planlist.create', ['pid' => $newForm->id]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back();
        }
    }

    public function storePlanList(Request $request) {
        try {
            $formPlan = Form::findOrFail($request->planId);
            $listData = json_decode($request->planListData ?? '');
            foreach ($listData ?? [] as $list) {
                $formList = FormList::create([
                    'title' => $list->title,
                    'comment' => $list->comment,
                    'form_id' => $formPlan->id
                ]);
                foreach ($list->columnCheck as $listCheck) {
                    FormListHasColumn::create([
                        'list_id' => $formList->id,
                        'column_id' => $listCheck->columnId,
                        'status' => $listCheck->isCheck
                    ]);
                }
            }
            return response()->json([
                'message' => 'PlanList has created successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
