<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Phone_number;
use App\Models\tsm_ai_005_data;
use App\Models\tsm_rp_002_data;
use App\Models\tsm_v_002_data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportData($formCode) {
        if ($formCode == "TSM-AI-004") {
            $phonenum_lists = Phone_number::where('org', Auth()->user()->userDetail->org)->orderBy("created_at", "desc")->get();
            return view('form.exports.TSM-AI-004', compact('phonenum_lists'));
        } elseif ($formCode == "TSM-AI-005") {
            // $formDatas = tsm_ai_005_data::where('org', Auth()->user()->userDetail->org)->orderBy("created_at", "desc")->get();
            return view('form.exports.TSM-AI-005', compact('formDatas'));
        } elseif ($formCode == "TSM-RP-002") {
            return view('form.exports.TSM-RP-002');
        } elseif ($formCode == "TSM-V-002") {
            $cars = Car::where('owner_org', Auth()->user()->userDetail->org)->get();
            return view('form.exports.TSM-V-002', compact('cars'));
        } else {
            return redirect()->back()->with(['error' => "ไม่สามารถดำเนินการต่อได้"]);
        }

    }

    public function searchPhoneForm(Request $request) {
        if ($request->ajax()) {
            $phonenum_lists = Phone_number::where('person_name', 'like', '%'.$request->search.'%')
                ->orWhere('position', 'like', '%'.$request->search.'%')
                ->orWhere('office_num', 'like', '%'.$request->search.'%')
                ->orWhere('home_num', 'like', '%'.$request->search.'%')
                ->orWhere('cellphone', 'like', '%'.$request->search.'%')
                ->where('org', $request->user()->userDetail->org)
                ->orderBy("created_at", "desc")->get();
            return view('form.exports.tableComponent.TSM-AI-004', compact('phonenum_lists'));
        }
    }

    public function searchRepairEmerForm(Request $request) {
        if ($request->ajax()) {
            if ($request->search) {
                $formDatas = tsm_ai_005_data::where('driver_name', 'like', '%'.$request->search.'%')
                ->orWhere('phone', 'like', '%'.$request->search.'%')
                ->orWhere('car_plate', 'like', '%'.$request->search.'%')
                ->where('org', $request->user()->userDetail->org)
                ->orderBy("created_at", "desc")->get();
            }
            return view('form.exports.tableComponent.TSM-AI-005', compact('formDatas'));
        }
    }

    public function searchDailyWork(Request $request) {
        if ($request->ajax()) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            try {
                if ($request->search || $request->startDate || $request->endDate) {
                    $formDatas = tsm_rp_002_data::where('org', $request->user()->userDetail->org)
                        ->orderBy("updated_at", "desc");

                    // if ($request->search) {
                    //     $formDatas->where(function ($query) use ($request) {
                    //         $query->where('vehicle_plate', 'like', '%' . $request->search . '%')
                    //             ->orWhere('employee_name', 'like', '%' . $request->search . '%');
                    //     });
                    // }
                    if ($request->search) {
                        $formDatas->where('employee_name', 'like', '%' . $request->search . '%');
                    }

                    if ($request->startDate && $request->endDate) {
                        $formDatas->whereBetween('updated_at', [$request->startDate, $request->endDate]);
                    }

                    $formDatas = $formDatas->get();
                } else {
                    // Handle case where no search criteria is provided
                    $formDatas = [];
                }

                return view('form.exports.tableComponent.TSM-RP-002', compact('formDatas', "startDate", "endDate"));
            } catch (\Throwable $th) {
                return "";
            }
        }
    }

    public function exportDailyWork($fid) {
        $dailyWork = tsm_rp_002_data::findOrFail($fid);
        return view('form.exports.exportDilyWork', compact('dailyWork'));
    }

    public function searchRepairHistory(Request $request) {
        if ($request->ajax()) {
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            try {
                if ($request->carId || $request->startDate || $request->endDate) {
                    $formDatas = tsm_v_002_data::where('org', $request->user()->userDetail->org)
                        ->orderBy("updated_at", "desc");

                    // if ($request->search) {
                    //     $formDatas->where(function ($query) use ($request) {
                    //         $query->where('vehicle_plate', 'like', '%' . $request->search . '%')
                    //             ->orWhere('employee_name', 'like', '%' . $request->search . '%');
                    //     });
                    // }
                    if ($request->carId) {
                        $formDatas->where('car_id', $request->carId);
                    }

                    if ($request->startDate && $request->endDate) {
                        $formDatas->whereBetween('created_at', [$request->startDate, $request->endDate]);
                    }

                    $formDatas = $formDatas->get();
                } else {
                    // Handle case where no search criteria is provided
                    $formDatas = [];
                }
                $car_info = Car::find($request->carId);
                return view('form.exports.tableComponent.TSM-V-002', compact('formDatas', "startDate", "endDate", "car_info"));
            } catch (\Throwable $th) {
                return "";
            }
        }
    }
}
