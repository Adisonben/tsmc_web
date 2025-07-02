<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\RenewalCode;
use App\Models\RenewalCodeUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenewalCodeController extends Controller
{
    public function index()
    {
        // แสดงรายการโค้ดทั้งหมด
        $codes = RenewalCode::orderBy('created_at', 'desc')->get();
        return view('appData.renewalCodes.codeTable', compact('codes'));
    }

    public function store(Request $request)
    {
        // สร้างโค้ดใหม่
        $request->validate([
            'code' => 'required|unique:renewal_codes,code',
            'max_uses' => 'required|integer|min:0|max:100',
            'expires_at' => 'nullable|date',
        ], [
            'code.required' => 'กรุณากรอกโค้ด',
            'code.unique' => 'โค้ดนี้มีอยู่แล้ว',
            'max_uses.required' => 'กรุณากรอกจำนวนการใช้สูงสุด',
            'max_uses.integer' => 'จำนวนการใช้สูงสุดต้องเป็นตัวเลข',
            'max_uses.min' => 'จำนวนการใช้สูงสุดต้องมากกว่าหรือเท่ากับ 0',
            'max_uses.max' => 'จำนวนการใช้สูงสุดต้องน้อยกว่าหรือเท่ากับ 100',
            'expires_at.date' => 'วันที่หมดอายุไม่ถูกต้อง',
        ]);

        try {
            RenewalCode::create($request->all());
            return redirect()->route('renewal_codes.index')->with('success', 'สร้างโค้ดสำเร็จ.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('renewal_codes.index')->with('error', 'เกิดข้อผิดพลาดในการสร้างโค้ด');
        }
    }

    // public function update(Request $request, $renewalCodeId)
    // {
    //     // แก้ไขโค้ด
    //     $renewalCode = RenewalCode::findOrFail($renewalCodeId);

    //     // อัปเดตโค้ด
    //     $request->validate([
    //         'code' => 'required|unique:renewal_codes,code,' . $renewalCode->id,
    //         'max_uses' => 'required|integer|min:0|max:100',
    //         'expires_at' => 'nullable|date',
    //     ]);

    //     $renewalCode->update($request->all());

    //     return redirect()->route('renewal_codes.index')->with('success', 'Renewal code updated successfully.');
    // }

    // public function destroy($renewalCodeId)
    // {
    //     // ลบโค้ด
    //     $renewalCode = RenewalCode::findOrFail($renewalCodeId);

    //     // ลบโค้ด
    //     $renewalCode->delete();

    //     return redirect()->route('renewal_codes.index')->with('success', 'Renewal code deleted successfully.');
    // }

    public function userRedeem(Request $request)
    {
        // ใช้โค้ด
        $request->validate([
            'code' => 'required|exists:renewal_codes,code',
        ], [
            'code.required' => 'กรุณากรอกโค้ด',
            'code.exists' => 'โค้ดนี้ไม่ถูกต้อง',
        ]);

        try {
            $inputCode = strtoupper($request->code);

            $renewalCode = RenewalCode::where('code', $inputCode)->first();

            if ($renewalCode->isExpired()) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้หมดอายุแล้ว.');
            }

            if ($renewalCode->isUsedUp()) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้ถูกใช้จนหมดแล้ว.');
            }

            $user = User::find($request->user()->id);

            if (!$user) {
                return redirect()->back()->with('redeemError', 'ไม่พบผู้ใช้งาน.');
            }

            if ($renewalCode->isUseByUser($user->id)) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้ถูกใช้ไปแล้ว.');
            }

            $expire_date = new Carbon(Auth::user()->expire_at);
            $diffDay = (int) ceil(Carbon::now()->diffInDays($expire_date));

            if ($diffDay && $diffDay > 0) {
                $user->update([
                    'expire_at' => $user->expire_at ? Carbon::parse($user->expire_at)->addDays(30) : now()->addDays(30),
                ]);
            } else {
                $user->update([
                    'expire_at' => now()->addDays(30),
                ]);
            }

            // บันทึกการใช้โค้ด
            RenewalCodeUsage::create([
                'renewal_code_id' => $renewalCode->id,
                'type' => 'user', // หรือ 'organization'
                'target' => $user->id, // หรือ organization_id
            ]);

            return redirect()->back()->with('redeemSuccess', 'ใช้โค้ดสำเร็จ.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('redeemError', 'เกิดข้อผิดพลาดในการใช้โค้ด');
        }
    }

    public function orgRedeem(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:renewal_codes,code',
        ], [
            'code.required' => 'กรุณากรอกโค้ด',
            'code.exists' => 'โค้ดนี้ไม่ถูกต้อง',
        ]);
        try {
            $inputCode = strtoupper($request->code);
            $renewalCode = RenewalCode::where('code', $inputCode)->first();

            if ($renewalCode->isExpired()) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้หมดอายุแล้ว.');
            }

            if ($renewalCode->isUsedUp()) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้ถูกใช้จนหมดแล้ว.');
            }

            $org = Organization::find($request->user()->userDetail->org);

            if (!$org) {
                return redirect()->back()->with('redeemError', 'ไม่พบองค์กร.');
            }
            if ($renewalCode->isUseByOrg($org->id)) {
                return redirect()->back()->with('redeemError', 'โค้ดนี้ถูกใช้ไปแล้ว.');
            }

            $expire_date = new Carbon($org->expire_at);
            $diffDay = (int) ceil(Carbon::now()->diffInDays($expire_date));

            if ($diffDay && $diffDay > 0) {
                $org->update([
                    'expire_at' => $org->expire_at ? Carbon::parse($org->expire_at)->addDays(30) : now()->addDays(30),
                ]);
            } else {
                $org->update([
                    'expire_at' => now()->addDays(30),
                ]);
            }

            // บันทึกการใช้โค้ด
            RenewalCodeUsage::create([
                'renewal_code_id' => $renewalCode->id,
                'type' => 'org',
                'target' => $org->id,
            ]);

            return redirect()->back()->with('redeemSuccess', 'ใช้โค้ดสำเร็จ.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('redeemError', 'เกิดข้อผิดพลาดในการใช้โค้ด');
        }
    }
}
