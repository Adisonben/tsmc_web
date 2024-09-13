@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <hr>
                <p class="text-center">ตัวอย่างเอกสาร</p>
                <hr>
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        <p class="text-center fs-5 mb-0 fw-bold">{{ Auth()->user()->userDetail->getOrg->name }}</p>
                        @php
                            $daily_date = new Carbon\Carbon($dailyWork->updated_at);
                            $assign_date = new Carbon\Carbon($dailyWork->assign_date);
                            $receive_date = new Carbon\Carbon($dailyWork->receive_date);
                            $drop_date = new Carbon\Carbon($dailyWork->drop_date);
                            $difference = $receive_date->diffAsCarbonInterval($drop_date);
                        @endphp
                        <p class="text-center fs-5 fw-bold">รายงานบันทึกการปฏิบัติงานของพนักงานขับรถ ประจำวันที่ <u>{{ $daily_date->thaidate('j F Y') }}</u></p>
                        <div class="d-flex justify-content-center gap-4">
                            <p>พนักงานขับรถชื่อ <u>{{ $dailyWork->employee_name }}</u></p>
                            <p>ทะเบียนรถ <u>{{ $dailyWork->vehicle_plate }}</u></p>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-1">1.หมายเลขงาน <u>{{ $dailyWork->work_num }}</u></div>
                            <div class="col-6 mb-1">2.วันที่สั่งงาน <u>{{ $assign_date->thaidate('j F Y \\เวลา H:i:s') }}</u></div>
                            <div class="col-6 mb-1">3.ชื่อลูกค้า <u>{{ $dailyWork->customer_name }}</u></div>
                            <div class="col-6 mb-1">4.ใช้เวลาทั้งสิ้น <u>{{ $difference->d ? $difference->d . " วัน " : '' }}{{ $difference->h ? $difference->h . " ชม. " : '' }}{{ $difference->i ? $difference->i . " นาที " : '' }}</u></div>
                            <div class="col-6 mb-1">5.สถานที่รับสินค้า <u>{{ $dailyWork->receive_place }}</u></div>
                            <div class="col-6 mb-1">6.วันที่รับสินค้า <u>{{ $receive_date->thaidate('j F Y \\เวลา H:i:s') }}</u></div>
                            <div class="col-6 mb-1">7.สถานที่ส่งสินค้า <u>{{ $dailyWork->drop_place }}</u></div>
                            <div class="col-6 mb-1">8.วันที่ส่งสินค้า <u>{{ $drop_date->thaidate('j F Y \\เวลา H:i:s') }}</u></div>
                        </div>
                        <div class="text-end" style="font-size: 10px">print on TSMC at {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</div>
                    </div>
                </div>
                <div class="my-2 d-flex justify-content-center">
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 210mm;
        }

        @media print {
            body {
                visibility: hidden;
            }
            #exportPaper {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                color: black;
            }
        }
    </style>
@endsection
