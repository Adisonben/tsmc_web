<?php

namespace App\Http\Controllers;

use App\Models\MaCategory;
use App\Models\MaItem;
use App\Models\PartUse;
use App\Models\RepairHistory;
use App\Models\Vehicle;
use App\Models\LogBook;
use App\Models\LogBookEntry;
use App\Models\LogBookKmSchedule;
use App\Models\LogBookMonthSchedule;
use App\Models\Organization;
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
    public function logbookShow($logbook_id) {
        try {
            if (Auth()->user()->is_tsm) {
                $org_id = session('connected_org');
            } else {
                $org_id = Auth::user()->userDetail->org;
            }
            $logbook = LogBook::where('org_id', $org_id)->where('id', $logbook_id)->firstOrFail();
            $ma_categories = MaCategory::get(['id','name']);
            return view('logbook.logBook', compact('logbook', 'ma_categories'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back();
        }
    }

    public function create(){
        if (Auth()->user()->is_tsm) {
            $org_id = session('connected_org');
        } else {
            $org_id = Auth::user()->userDetail->org;
        }
        $ma_categories = MaCategory::get(['id','name']);
        $vehicles = Vehicle::where('org_id', $org_id)
            ->get(['id', 'license_plate', 'brand']);
        return view('logbook.carMAForm', compact('ma_categories', 'vehicles'));
    }

    public function logbookTable() {
        $log_books = LogBook::where('org_id', Auth()->user()->is_tsm ? session('connected_org') : Auth::user()->userDetail->org)->paginate(10);
        return view('logbook.logBookTable', compact('log_books'));
    }

    public function logbookCreate() {
        // $ma_categories = MaCategory::get(['id','name']);
        if (Auth()->user()->is_tsm) {
            $org_id = session('connected_org');
        } else {
            $org_id = Auth::user()->userDetail->org;
        }
        $vehicles = Vehicle::where('org_id', $org_id)
            ->get(['id', 'license_plate', 'brand', 'type']);
        $org = Organization::find($org_id);
        $org_name = $org->name ?? '';
        return view('logbook.logBookForm', compact('vehicles', 'org_name'));
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
            return response()->json(['errors' => "บันทึกข้อมูลไม่สำเร็จ ข้อมูลไม่สมบูรณ์"], 500);
        }
    }

    public function logbookStore(Request $request) {
        $validator = Validator::make($request->all(), [
            'vehicle_id'        => ['required', 'exists:vehicles,id'],
            'vehicle_type'      => ['required', 'string', 'max:255'],
            'org_name'          => ['required', 'string', 'max:255'],
            'start_mileage'     => ['required', 'integer', 'min:0'],
            'start_date'        => ['required', 'date'],
            'selectedDistances' => ['required', 'array', 'size:4'],
            'selectedPeriodes'  => ['required', 'array', 'size:4'],
        ], [
            'vehicle_id.required'        => 'กรุณาเลือกทะเบียนรถ',
            'vehicle_id.exists'          => 'ไม่พบข้อมูลทะเบียนรถที่เลือก',
            'vehicle_type.required'      => 'กรุณาระบุประเภทรถ',
            'vehicle_type.string'        => 'ประเภทรถต้องเป็นข้อความ',
            'vehicle_type.max'           => 'ประเภทรถห้ามเกิน 255 ตัวอักษร',
            'org_name.required'          => 'กรุณาระบุชื่อองค์กร',
            'org_name.string'            => 'ชื่อองค์กรต้องเป็นข้อความ',
            'org_name.max'               => 'ชื่อองค์กรห้ามเกิน 255 ตัวอักษร',
            'start_mileage.required'     => 'กรุณาระบุเลขไมล์เริ่มต้น',
            'start_mileage.integer'      => 'เลขไมล์เริ่มต้นต้องเป็นตัวเลขจำนวนเต็ม',
            'start_mileage.min'          => 'เลขไมล์เริ่มต้นต้องมีค่ามากกว่าหรือเท่ากับ 0',
            'start_date.required'        => 'กรุณาระบุวันที่เริ่มต้น',
            'start_date.date'            => 'วันที่เริ่มต้นไม่ถูกต้อง',
            'selectedDistances.required' => 'กรุณาเลือกระยะทาง',
            'selectedDistances.array'    => 'ระยะทางต้องเป็นรูปแบบรายการ',
            'selectedDistances.size'     => 'ต้องเลือกระยะทาง 4 รายการ',
            'selectedPeriodes.required'  => 'กรุณาเลือกช่วงเวลา',
            'selectedPeriodes.array'     => 'ช่วงเวลาต้องเป็นรูปแบบรายการ',
            'selectedPeriodes.size'      => 'ต้องเลือกช่วงเวลา 4 รายการ',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            if (Auth()->user()->is_tsm) {
                $org_id = session('connected_org');
            } else {
                $org_id = Auth::user()->userDetail->org;
            }
            $vehicle = Vehicle::findOrFail($request->vehicle_id);
            $new_logbook = LogBook::create([
                'vehicle_id' => $request->vehicle_id,
                'start_mileage' => $request->start_mileage,
                'vehicle_plate' => $vehicle->license_category . "-" . $vehicle->license_plate,
                'vehicle_type' => $request->vehicle_type,
                'org_name' => $request->org_name,
                'org_id' => $org_id,
                'create_by' => Auth::user()->id,
                'start_date' => $request->start_date,
            ]);

            foreach ($request->selectedDistances ?? [] as $key => $distance) {
                LogBookKmSchedule::create([
                    'log_book_id' => $new_logbook->id,
                    'km_value' => $distance
                ]);
            }
            foreach ($request->selectedPeriodes ?? [] as $key => $period) {
                LogBookMonthSchedule::create([
                    'log_book_id' => $new_logbook->id,
                    'month_value' => $period
                ]);
            }

            return response()->json(['success' => "บันทึกข้อมูลสำเร็จ"]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['errors' => "บันทึกข้อมูลไม่สำเร็จ ข้อมูลไม่สมบูรณ์"], 500);
        }
    }

    public function logbookStoreEntry(Request $request, $logbook_id) {
        // dd($request->all(), array_key_exists('entryAll', $request->all()));
        try {
            if (array_key_exists('entryAll', $request->all())) {
                $items = MaItem::orderByDesc('created_at')->pluck('id');
                foreach ($items as $item_id) {
                    if (LogBookEntry::where('log_book_id', $logbook_id)->where('ma_item_id', $item_id)->where('schedule_column', $request->at_column)->doesntExist()) {
                        LogBookEntry::create([
                            'log_book_id' => $logbook_id,
                            'ma_item_id' => $item_id,
                            'date' => $request->repair_date ?? null,
                            'schedule_column' => $request->at_column,
                            'action_check' => array_key_exists('check', $request->action),
                            'action_adjust' => array_key_exists('adjust', $request->action),
                            'action_replace' => array_key_exists('change', $request->action),
                        ]);
                    }
                }
            } else {
                LogBookEntry::create([
                    'log_book_id' => $logbook_id,
                    'ma_item_id' => $request->at_item,
                    'date' => $request->repair_date ?? null,
                    'schedule_column' => $request->at_column,
                    'action_check' => array_key_exists('check', $request->action),
                    'action_adjust' => array_key_exists('adjust', $request->action),
                    'action_replace' => array_key_exists('change', $request->action),
                ]);
            }
            return redirect()->back()->with('store_entry_success', 'บันทึกสำเร็จ');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('store_entry_error', 'บันทึกไม่สำเร็จ' . $th->getMessage());
        }
    }
}
