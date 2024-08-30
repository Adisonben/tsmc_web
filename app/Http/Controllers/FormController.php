<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Form_answer;
use App\Models\Form_category;
use App\Models\Form_response;
use App\Models\Form_type;
use App\Models\Option;
use App\Models\Option_type;
use App\Models\Phone_number;
use App\Models\Quest_group;
use App\Models\Question;
use App\Models\User_detail;
use Illuminate\Http\Request;
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
        $form_types = Form_type::all();
        $opt_types = Option_type::all();
        return view('form.manage.createForm', compact('form_types', 'opt_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $checkData = json_decode($request->input('checkData'), true); // [{"groupName":"awdada","groupSubText":["dawdawdawdawd"]}]
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
            ]);

            foreach ($checkData ?? [] as $group) {
                $newGroup = Quest_group::create([
                    'form_id' => $newForm->id,
                    'title' => $group['groupName'],
                ]);
                if (count($group['groupSubText'] ?? []) > 0) {
                    foreach ($group['groupSubText'] as $ques) {
                        Question::create([
                            'form_id' => $newForm->id,
                            'group_id'=> $newGroup->id,
                            'option_type' => $request->opt_type,
                            'title' => $ques
                        ]);
                    }
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

        $question_one = Question::where('form_id', $form_edit->id)->first();
        $sopt_type = $question_one->option_type;
        return view('form.manage.editForm', compact('form_types', 'opt_types', 'form_edit', 'sopt_type', 'quest_groups'));
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

            Quest_group::where('form_id', $id)->delete();
            Question::where('form_id', $id)->delete();

            foreach ($checkData ?? [] as $group) {
                $newGroup = Quest_group::create([
                    'form_id' => $updateForm->id,
                    'title' => $group['groupName'],
                ]);
                if (count($group['groupSubText'] ?? []) > 0) {
                    foreach ($group['groupSubText'] as $ques) {
                        Question::create([
                            'form_id' => $updateForm->id,
                            'group_id'=> $newGroup->id,
                            'option_type' => $request->opt_type,
                            'title' => $ques
                        ]);
                    }
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
        $form_type = Form_type::where('name', $formTypeName)->firstOrFail();
        $form_lists = Form::where('type', $form_type->id)->get();
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
        return view('form.checking.formFormat.TSM-HR-003', compact('formdata', 'userDetail', 'quest_groups'));
    }

    public function storeCheckedForm(Request $request) {
        try {
            $form = Form::where('id', $request->form_id)->firstOrFail();
            $questions = Question::where('form_id', $request->form_id)->get();
            $resp = Form_response::create([
                'user_id' => $request->interviewBy,
                'form_id' => $request->form_id,
                'times' => 0,
                'status' => $form->has_approve ? 2 : 1,
                'header_data' => json_encode([
                    'name' => $request->driverName,
                    'posit' => $request->driverPosit
                ]),
            ]);
            if ($questions) {
                foreach ($questions as $ques) {
                    Form_answer::create([
                        'user_id' => $request->interviewBy,
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
        $form = Form::where('form_id', $formid)->firstOrFail();
        $form_responses = Form_response::where('form_id', $form->id)->get();
        return view('form.table.formDataTable', compact('form', 'form_responses'));
    }

    public function tableNotHasForm() {
        $phonenum_lists = Phone_number::all();
        return view('form.table.phoneNumberTable', compact('phonenum_lists'));
    }

    public function formResDetail(Request $request, $formresid) {
        $form_resp = Form_response::find($formresid);
        $formdata = Form::where('id', $form_resp->form_id)->firstOrFail();
        $userDetail = User_detail::where('user_id', $request->user()->id)->firstOrFail();
        $quest_groups = Quest_group::where('form_id', $formdata->id)->get();
        $header_data = json_decode($form_resp->header_data ?? "");
        return view('form.checking.readonly.TSM-HR-003', compact('formdata', 'userDetail', 'quest_groups', 'form_resp', 'header_data'));
    }

    public function formReport(Request $request, $formresid) {
        $form_resp = Form_response::find($formresid);
        $formdata = Form::where('id', $form_resp->form_id)->firstOrFail();
        $userDetail = User_detail::where('user_id', $request->user()->id)->firstOrFail();
        $quest_groups = Quest_group::where('form_id', $formdata->id)->get();
        $header_data = json_decode($form_resp->header_data ?? "");
        return view('form.exports.TSM-HR-003', compact('formdata', 'userDetail', 'quest_groups', 'form_resp', 'header_data'));
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
}
