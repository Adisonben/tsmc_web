<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmissions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getFormByCategory($category_id)
    {
        $forms = Form::where('category', $category_id)->where('org', Auth::user()->userDetail->org ?? '')->get(['id', 'title', 'select_user', 'select_vehicle']);
        $respFormData = [];

        foreach ($forms as $form) {
            $respFields = [];
            foreach ($form->formFields as $key => $field) {
                if ($field->type === 'subform') {
                    $subFormFields = [];
                    foreach ($field->subform->subformfields as $subField) {
                        $subFormFields[] = [
                            'id' => $subField->id,
                            'label' => $subField->label,
                        ];
                    }

                    $respFields[] = [
                        'id' => $field->id,
                        'label' => $field->label,
                        'type' => $field->type,
                        'subformfields' => $subFormFields,
                    ];
                } else {
                    $respFields[] = [
                        'id' => $field->id,
                        'label' => $field->label,
                        'type' => $field->type,
                        'subformfields' => [],
                    ];
                }
            }

            $respFormData[] = [
                'id' => $form->id,
                'title' => $form->title,
                'fields' => $respFields,
                'select_user' => $form->select_user,
                'select_vehicle' => $form->select_vehicle,
            ];
        }

        return response()->json($respFormData);
    }

    public function getDocs(Request $request)
    {
        $query = FormSubmissions::where('form_id', $request->form_id)->where('org', Auth::user()->userDetail->org ?? '');

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $querySubmissions = $query->get();

        $responseData = [];

        foreach ($querySubmissions ?? [] as $key => $submission) {
            $subData = [];
            $subData['id'] = $submission->id;
            $subData['created_at'] = Carbon::parse($submission->created_at)->thaidate('j M Y');

            $vehicleData = [];
            $vehicleData['license_plate'] = $submission->getVehicle?->license_plate ?? '-';
            $vehicleData['brand'] = $submission->getVehicle?->brand ?? '-';
            $vehicleData['license_category'] = $submission->getVehicle?->license_category ?? '-';
            $vehicleData['registration_province'] = $submission->getVehicle?->registration_province ?? '-';
            $vehicleData['standard'] = $submission->getVehicle?->standard ?? '-';
            $vehicleData['type'] = $submission->getVehicle?->type ?? '-';
            $vehicleData['ins_company'] = $submission->getVehicle?->ins_company ?? '-';
            $vehicleData['ins_type'] = $submission->getVehicle?->ins_type ?? '-';

            $userData = [];
            // $userData['name'] = $submission->getUser?->full_name ?? '';
            // $userData['citizen_id'] = $submission->getUser?->citizen_id ?? '';
            $userData['fname'] = ($submission->getUser?->userDetail->getPrefix->name ?? '') . ($submission->getUser?->userDetail->fname ?? '');
            $userData['lname'] = $submission->getUser?->userDetail->lname ?? '-';
            $userData['citizen_id'] = $submission->getUser?->userDetail->citizen_id ?? '-';

            $subData['vehicle'] = $vehicleData;
            $subData['user'] = $userData;

            $subData['answerValue'] = $submission->getSubmissionValues->map(function ($value) {
                return [
                    'field_id' => $value->field_id,
                    'value' => $value->value,
                ];
            });

            $responseData[] = $subData;
        }

        return response()->json($responseData);
    }
}
