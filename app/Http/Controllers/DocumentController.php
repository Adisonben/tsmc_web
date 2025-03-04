<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Form_category;
use App\Models\FormSubmissionHistory;
use App\Models\FormSubmissions;
use App\Models\FormSubmissionValue;
use App\Models\User_detail;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function selectForm() {
        $categories = Form_category::all();
        return view('form.checking.selectForm', compact('categories'));
    }
    public function selectTableForm() {
        $categories = Form_category::all();
        return view('form.table.selectForm', compact('categories'));
    }

    public function fillOutForm($form_id) {
        $form_data = Form::where('form_id', $form_id)->firstOrFail();
        $users = User_detail::where('org', Auth::user()->userDetail->org ?? '')->get(['user_id', 'fname', 'lname']);
        $vehicles = Vehicle::where('org_id', Auth::user()->userDetail->org ?? '')->get(['id', 'license_plate', 'brand']);
        return view('form.checking.fillOutForm', compact('form_data', 'users', 'vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $form_id)
    {
        $validator = Validator::make($request->all(), [
            'selected_user_id' => 'nullable|exists:users,id',
            'selected_vehicle_id' => 'nullable|exists:vehicles,id',
            'fieldsAns' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "แบบฟอร์มเกิดข้อผิดพลาด"], 400);
        }

        try {
            $form = Form::where('form_id', $form_id)->firstOrFail();

            $form_submission = FormSubmissions::create([
                'submission_id' => Str::uuid(),
                'form_id' => $form->id,
                'user_id' => $request->selected_user_id ?? null,
                'vehicle_id' => $request->selected_vehicle_id ?? null,
                'submitted_by' => Auth::user()->id,
                'org' => optional(Auth::user()->userDetail)->org ?? null,
            ]);

            foreach ($request->fieldsAns as $field) {
                FormSubmissionValue::create([
                    'submission_id' => $form_submission->id,
                    'field_id' => $field['field_id'],
                    'value' => $field['answer'],
                    'submitted_by' => Auth::user()->id,
                ]);
            }

            FormSubmissionHistory::create([
                'submission_id' => $form_submission->id,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'ส่งแบบฟอร์มสำเร็จ!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['errors' => 'เกิดข้อผิดพลาดขณะบันทึกแบบฟอร์ม']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $submission = FormSubmissions::where('submission_id', $id)->firstOrFail();
        $form_data = Form::where('id', $submission->form_id)->firstOrFail();
        $is_show = true;
        return view('form.checking.continueDocument', compact('submission', 'form_data', 'is_show'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $submission = FormSubmissions::where('submission_id', $id)->firstOrFail();
        $form_data = Form::where('id', $submission->form_id)->firstOrFail();
        $is_show = false;
        return view('form.checking.continueDocument', compact('submission', 'form_data', 'is_show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $form_submission = FormSubmissions::findOrFail($id);

            foreach ($request->fieldsAns as $field) {
                if (FormSubmissionValue::where('submission_id', $form_submission->id)->where('field_id', $field['field_id'])->exists()) {
                    FormSubmissionValue::where('submission_id', $form_submission->id)->where('field_id', $field['field_id'])->update([
                        'value' => $field['answer'],
                        'submitted_by' => Auth::user()->id,
                    ]);
                } else {
                    FormSubmissionValue::create([
                        'submission_id' => $form_submission->id,
                        'field_id' => $field['field_id'],
                        'value' => $field['answer'],
                        'submitted_by' => Auth::user()->id,
                    ]);
                }
            }

            FormSubmissionHistory::create([
                'submission_id' => $form_submission->id,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'บันทึกแบบฟอร์มสำเร็จ!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['errors' => 'เกิดข้อผิดพลาดขณะบันทึกแบบฟอร์ม']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showDocTable($form_id) {
        $form_data = Form::where('form_id', $form_id)->firstOrFail();
        $query = FormSubmissions::where('form_id', $form_data->id);

        if (!optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_see_all_docs',Auth::user()->userDetail->org) ?? true) {
            $query->where(function ($query) {
                $query->where('submitted_by', Auth::user()->id)->orWhere('user_id', Auth::user()->id);
            });
        }

        $submissions = $query->orderByDesc('created_at')->get();
        return view('form.table.formDataTable', compact('submissions', 'form_data'));
    }

    public function filterDocument() {
        $form_cates = Form_category::all();
        $vehicles = Vehicle::where('org_id', Auth::user()->userDetail->org ?? '')->get(['id', 'license_plate', 'brand']);
        $users = User_detail::where('org', Auth::user()->userDetail->org ?? '')->get(['user_id', 'fname', 'lname']);
        return view('exportDocument.filterData', compact('form_cates', 'vehicles', 'users'));
    }
}
