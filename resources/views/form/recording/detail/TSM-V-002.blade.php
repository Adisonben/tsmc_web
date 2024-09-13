@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card" id="exportPaper">
                    <div class="card-body px-md-5">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <p class="text-center fs-5 fw-bold">ประวัติการบำรุงรักษาและซ่อมรถ</p>
                        <div class="row mb-3 gap-2">
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="driverName" class="text-nowrap m-0">ชื่อพนักงานขับรถ <span class="ms-2"><u>{{ $formData->driver_name }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="carPlate" class="text-nowrap m-0">ทะเบียนรถ  <span class="ms-2"><u>{{ $formData->car_plate }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="carModel" class="text-nowrap m-0">ยี่ห้อ/รุ่น  <span class="ms-2"><u>{{ $formData->car_model }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="carType" class="text-nowrap m-0">ประเภทรถ <span class="ms-2"><u>{{ $formData->car_type }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="repairNum" class="text-nowrap m-0">เลขที่ใบสั่งซ่อม <span class="ms-2"><u>{{ $formData->order_num }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="mileage" class="text-nowrap m-0">เลขไมล์  <span class="ms-2"><u>{{ $formData->mileage }}</u></span></p>
                            </div>
                            @php
                                $createdDate = new Carbon\Carbon($formData->created_at);
                            @endphp
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="mileage" class="text-nowrap m-0">วันที่บันทึก  <span class="ms-2"><u>{{ $createdDate->thaidate('j M Y') }}</u></span></p>
                            </div>
                            <div class="col-12 col-md-5 d-flex gap-2 align-items-center">
                                <p for="mileage" class="text-nowrap m-0">ราคาซ่อมรวม  <span class="ms-2"><u>{{ number_format($formData->cost_amount, 0, '.', ',') }}</u></span> บาท</p>
                            </div>
                        </div>
                        <hr>
                        <p class="fs-6 fw-bold">รายการซ่อม</p>
                        <div class="mb-3">
                            <ol class="list-group-numbered p-0 ps-md-3" id="repairListContainer">
                                @foreach ($historyData as $history)
                                    <li class="rounded list-group-item d-flex flex-wrap align-items-center px-2 repairList">
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <p for="repairBy" class="text-nowrap mb-0">ชื่อ/หน่วยงาน ผู้ซ่อม <span class="ms-2"><u>{{ $history->repair_by }}</u></span></p>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <p for="repairPart" class="text-nowrap mb-0">อะไหล่ที่ใช้ <span class="ms-2"><u>{{ $history->spare_part }}</u></span></p>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <p for="repairCost" class="text-nowrap mb-0">จำนวนเงิน <span class="ms-2"><u>{{ $history->cost }}</u> บาท</span></p>
                                        </div>
                                        <div class="flex-fill m-2 d-flex gap-2 align-items-center">
                                            <p for="repairCost" class="text-nowrap mb-0">ประเภท <span class="ms-2"><u>{{ $history->repair_type }}</u></span></p>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit" onclick="window.print()">Print</button>
                            <a href="/formtable/TSM-V-002" class="btn btn-secondary" >กลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .repairList {
            background-color: rgb(230, 230, 230);
            margin-bottom: 5px;
        }

        @media print {
            body, .btn {
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
