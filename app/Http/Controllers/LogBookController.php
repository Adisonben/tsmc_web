<?php

namespace App\Http\Controllers;

use App\Models\MaCategory;
use App\Models\PartUse;
use App\Models\RepairHistory;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogBookController extends Controller
{
    //
    public function index() {
        if (Auth()->user()->is_tsm) {
            $org_id = session('connected_org');
        } else {
            $org_id = Auth::user()->userDetail->org;
        }
        $repair_his = RepairHistory::where('org_id', $org_id)->orderByDesc('created_at')->paginate(10);
        return view('logbook.carMATable', compact('repair_his'));
    }

    public function show($repair_id) {
        try {
            $repair = RepairHistory::findOrFail($repair_id);
            return view('logbook.carMADetail', compact('repair'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back();
        }
    }

    public function create(){
        $ma_categories = MaCategory::get(['id','name']);
        $vehicles = Vehicle::where('org_id', Auth()->user()->is_tsm ? session('connected_org') : Auth::user()->userDetail->org)
            ->get(['id', 'license_plate', 'brand']);
        return view('logbook.carMAForm', compact('ma_categories', 'vehicles'));
    }

    public function logbookTable() {
        return view('logbook.logBookTable');
    }

    public function logbookCreate() {
        return view('logbook.logBookForm');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'vehicle_id'   => ['required', 'exists:vehicles,id'],
            'repair_date'  => ['required'],
            'mileage'      => ['required', 'integer', 'min:0'],
            'item_id'      => ['required', 'integer', 'exists:ma_items,id'],
            'part_list'    => ['nullable', 'array'],
            'repair_cost'  => ['required', 'numeric', 'min:0'],
            'repair_op'    => ['required', 'string', 'max:255'],
            'note'         => ['nullable', 'string', 'max:1000'],
            'repair_detail'         => ['nullable', 'string', 'max:1000'],
        ], [
            'vehicle_id.required' => 'กรุณาเลือกทะเบียนรถ',
            'vehicle_id.exists' => 'ไม่พบข้อมูลทะเบียนรถที่เลือก',
            'repair_date.required' => 'กรุณาระบุวันที่ซ่อม',
            'mileage.required' => 'กรุณาระบุเลขไมล์',
            'mileage.integer' => 'เลขไมล์ต้องเป็นตัวเลขจำนวนเต็ม',
            'mileage.min' => 'เลขไมล์ต้องมีค่ามากกว่าหรือเท่ากับ 0',
            'item_id.required' => 'กรุณาเลือกประเภทงานซ่อม',
            'item_id.integer' => 'ประเภทงานซ่อมไม่ถูกต้อง',
            'item_id.exists' => 'ไม่พบข้อมูลประเภทงานซ่อมที่เลือก',
            'part_list.array' => 'รายการอะไหล่ต้องเป็นรูปแบบรายการ',
            'repair_cost.required' => 'กรุณาระบุค่าใช้จ่าย',
            'repair_cost.numeric' => 'ค่าใช้จ่ายต้องเป็นตัวเลข',
            'repair_cost.min' => 'ค่าใช้จ่ายต้องมีค่ามากกว่าหรือเท่ากับ 0',
            'repair_op.required' => 'กรุณาระบุผู้ดำเนินการซ่อม',
            'repair_op.string' => 'ผู้ดำเนินการซ่อมต้องเป็นข้อความ',
            'repair_op.max' => 'ผู้ดำเนินการซ่อมห้ามเกิน 255 ตัวอักษร',
            'note.string' => 'หมายเหตุต้องเป็นข้อความ',
            'note.max' => 'หมายเหตุยาวเกินไป',
            'repair_detail.string' => 'รายละเอียดการซ่อมต้องเป็นข้อความ',
            'repair_detail.max' => 'รายละเอียดการซ่อมยาวเกินไป',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            if (Auth()->user()->is_tsm) {
                $org_id = session('connected_org');
            } else {
                $org_id = Auth::user()->userDetail->org;
            }
            $repair_his = RepairHistory::create([
                'vehicle_id' => $vehicle->id,
                'vehicle_plate' => $vehicle->license_plate,
                'repair_date' => $request->repair_date,
                'repair_detail' => $request->repair_detail,
                'mileage' => $request->mileage,
                'ma_item_id' => $request->item_id,
                'repair_cost' => $request->repair_cost,
                'repair_operator' => $request->repair_op,
                'note' => $request->note,
                'create_by' => Auth::user()->id,
                'org_id' => $org_id,
            ]);

            try {
                if (count($request->part_list ?? []) > 0) {
                    foreach ($request->part_list as $part) {
                        PartUse::create([
                            'repair_id' => $repair_his->id,
                            'name' => $part['name'],
                            'quantity' => $part['quantity'],
                            'price' => $part['price'],
                            'total_cost' => $part['total'],
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                $repair_his->delete();
                return response()->json(['errors' => "บันทึกข้อมูลไม่สำเร็จ ข้อมูลอะไหล่ไม่สมบูรณ์", 'detail' => $th->getMessage()], 500);
            }

            return response()->json(['success' => "บันทึกข้อมูลสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['errors' => "บันทึกข้อมูลไม่สำเร็จ ข้อมูลไม่สมบูรณ์", 'detail' => $th->getMessage()], 500);
        }
    }
}
