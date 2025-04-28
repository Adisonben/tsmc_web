<?php

namespace App\Http\Controllers;

use App\Models\GeolocationRecord;
use App\Models\User;
use App\Models\WorkRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkRecordController extends Controller
{
    public function showWorkRecordTable(Request $request) {
        $request->validate([
            'searchUser' => 'nullable|max:255|exists:users,id',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after:startDate',
        ], [
            'searchUser.exists' => 'ผู้ใช้ที่เลือกไม่มีอยู่ในระบบ',
            'startDate.date' => 'วันที่เริ่มต้นต้องเป็นวันที่ที่ถูกต้อง',
            'endDate.date' => 'วันที่สิ้นสุดต้องเป็นวันที่ที่ถูกต้อง',
            'endDate.after' => 'วันที่สิ้นสุดต้องอยู่หลังวันที่เริ่มต้น',
        ]);

        if (Auth()->user()->is_tsm) {
            $query = WorkRecord::whereHas('getUser.userDetail', function ($query) {
                $query->where('org', session('connected_org') ?? '');
            });
            $users = User::whereHas('userDetail', function ($query) {
                $query->where('org', session('connected_org') ?? '');
            })->get();
        } else {
            // $query = FormSubmissions::where('form_id', $form_data->id)->where('org', Auth::user()->userDetail->org ?? '');
            if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_see_all_docs',Auth::user()->userDetail->org) ?? false) || Auth::user()->username === 'tsmcadmin') {
                $query = WorkRecord::whereHas('getUser.userDetail', function ($query) {
                    $query->where('org', Auth::user()->userDetail->org ?? '');
                });
                $users = User::whereHas('userDetail', function ($query) {
                    $query->where('org', Auth::user()->userDetail->org ?? '');
                })->get();
            } else {
                $query = WorkRecord::where('user_id', Auth::user()->id);
                $users = [];
            }
        }

        if ($request->searchUser) {
            $query->where('user_id', $request->searchUser);
        }
        if ($request->startDate) {
            $query->where('start_at', '>=', $request->startDate . ' 00:00:00');
        }
        if ($request->endDate) {
            $query->where('end_at', '<=', $request->endDate . ' 23:59:59');
        }
        $workRecords = $query->orderBy('id', 'desc')->paginate(15);
        return view('workRecords.workRecordTable', compact('workRecords', 'users'));
    }

    public function showGeoMap($workId) {
        $workRecord = WorkRecord::findOrFail($workId);
        $geolocationRecords = GeolocationRecord::where('work_id', $workId)->get();
        return view('workRecords.geolocationMap', compact('workRecord', 'geolocationRecords'));
    }

    public function store(Request $request)
    {
        try {
            $currentDate = now();
            $work_id = null;
            if ($request->action == 'start') {
                $new_work = WorkRecord::create([
                    'user_id' => $request->user()->id,
                    'start_at' => $currentDate,
                ]);
                $work_id = $new_work->id;
                if ($request->latitude && $request->longitude) {
                    GeolocationRecord::create([
                        'work_id' => $new_work->id,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'temperature' => $request->temperature,
                        'windspeed' => $request->windspeed,
                        'weather_code' => $request->weathercode,
                        'type' => $request->action,
                        'recorded_at' => $request->recordtime,
                        'radius' => $request->radius,
                    ]);
                }

            } elseif ($request->action == 'checkin') {
                if ($request->work_id && WorkRecord::where('id', $request->work_id)->exists()) {
                    $work_id = $request->work_id;
                    GeolocationRecord::create([
                        'work_id' => $work_id,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'temperature' => $request->temperature,
                        'windspeed' => $request->windspeed,
                        'weather_code' => $request->weathercode,
                        'type' => $request->action,
                        'recorded_at' => $currentDate,
                        'radius' => $request->radius,
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid work ID',
                    ], 400);
                }
            } elseif ($request->action == 'stop') {
                if ($request->work_id && WorkRecord::where('id', $request->work_id)->exists()) {
                    $work_id = $request->work_id;
                    WorkRecord::where('id', $work_id)->update([
                        'end_at' => $currentDate,
                    ]);
                    if ($request->latitude && $request->longitude) {
                        GeolocationRecord::create([
                            'work_id' => $work_id,
                            'latitude' => $request->latitude,
                            'longitude' => $request->longitude,
                            'temperature' => $request->temperature,
                            'windspeed' => $request->windspeed,
                            'weather_code' => $request->weathercode,
                            'type' => $request->action,
                            'recorded_at' => $currentDate,
                            'radius' => $request->radius,
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid work ID',
                    ], 400);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid action',
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => $request->all(),
                'date' => $currentDate,
                'work_id' => $work_id,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store work record',
            ], 500);
        }
    }
}
