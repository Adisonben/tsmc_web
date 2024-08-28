<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Form_category;
use App\Models\Form_type;
use App\Models\Option;
use App\Models\Option_type;
use App\Models\Quest_group;
use App\Models\Question;
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
            // $checkData = json_decode($request->input('checkData'), true); // [{"groupName":"awdada","groupSubText":["dawdawdawdawd"]}]
            // $formType = Form_type::find($request->formType);
            // $newForm = Form::create([
            //     'title' => $request->formName,
            //     'category' => $formType->category,
            //     'type' => $formType->id,
            //     'has_comment' => $request->commentCheck ? true : false,
            //     'has_score' => $request->scoreCheck ? true : false,
            //     'has_approve' => $request->approveCheck ? true : false,
            //     'org' => $request->user()->userDetail->org,
            //     'form_id' => Str::uuid(),
            // ]);

            // foreach ($checkData ?? [] as $group) {
            //     $newGroup = Quest_group::create([
            //         'form_id' => $newForm->id,
            //         'title' => $group['groupName'],
            //     ]);
            //     if (count($group['groupSubText'] ?? []) > 0) {
            //         foreach ($group['groupSubText'] as $ques) {
            //             Question::create([
            //                 'form_id' => $newForm->id,
            //                 'group_id'=> $newGroup->id,
            //                 'option_type' => $request->opt_type,
            //                 'title' => $ques
            //             ]);
            //         }
            //     }
            // }
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
        $form_type = Form_type::where('name', $formTypeName)->first();
        $form_lists = Form::where('type', $form_type->id)->get();
        return view('form.manage.formTables', compact('form_type', 'form_lists'));
    }
}
