@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="card mb-4" id="exportPaper">
                <div class="card-body px-md-5">
                    <p class="text-center fs-5 mb-0 fw-bold">{{ Auth::user()->org_name }}</p>
                    <p class="text-center fs-5 mb-0 fw-bold">บันทึกการบำรุงรักษารถ</p>
                    @php
                        $repair_date = new Carbon\Carbon($repair->repair_date);
                        $currentdate = Carbon\Carbon::now();
                    @endphp

                    <div class="row mt-3 mb-2">
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">หมายเลขทะเบียน</p>
                            <p class="fw-bold text-end mb-0"><u>{{ (optional($repair->getVehicle) ? optional($repair->getVehicle)->license_category . "-" : "") . $repair->vehicle_plate }}</u></p>
                        </div>
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">ยี่ห้อรถ</p>
                            <p class="fw-bold text-end mb-0"><u>{{ optional($repair->getVehicle)->brand ?? "-" }}</u></p>
                        </div>
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">ชนิดรถ</p>
                            <p class="fw-bold text-end mb-0"><u>{{ optional($repair->getVehicle)->type }}</u></p>
                        </div>
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">เลขไมล์เริ่มต้น</p>
                            <p class="fw-bold mb-0"><u>{{ number_format($repair->mileage ?? 0) }}</u></p>
                        </div>
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">วันที่ดำเนินการ</p>
                            <p class="fw-bold mb-0"><u>{{ $repair_date->thaidate('j M Y') }}</u></p>
                        </div>
                        <div class="col-6 d-flex">
                            <p class="text-nowrap me-2 mb-0">ผู้ดำเนินการซ่อม</p>
                            <p class="fw-bold mb-0"><u>{{ $repair->repair_operator ?? "-" }}</u></p>
                        </div>
                        <div class="col-12 d-flex">
                            <p class="text-nowrap me-2">อาการที่พบ/รายละเอียดการซ่อม</p>
                            <p class="fw-bold"><u>{{ $repair->repair_detail ?? "-" }}</u></p>
                        </div>
                    </div>

                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-dark">
                                    <th>รายการค่าใช้จ่าย</th>
                                    <th>จำนวน</th>
                                    <th>ราคาต่อหน่วย</th>
                                    <th>ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($repair->getParts ?? [] as $part)
                                    <tr>
                                        <td>{{ $part->name }}</td>
                                        <td>{{ $part->quantity }}</td>
                                        <td>{{ number_format($part->price ?? 0) }}</td>
                                        <td>{{ number_format($part->total_cost ?? 0) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">ค่าแรง</td>
                                    <td>{{ number_format($repair->repair_cost ?? 0) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">รวม</td>
                                    <td>{{ number_format($repair->repair_cost + ($repair->partsTotalSum() ?? 0)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 d-flex">
                        <p class="text-nowrap me-2">หมายเหตุ</p>
                        <p class="fw-bold"><u>{{ $repair->note ?? "-" }}</u></p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                <a href="{{ route('car.ma.table') }}" class="btn btn-secondary">กลับ</a>
            </div>
        </div>
    </div>
    <style>
        #formCheckpage {
            background-color: var(--main-color);
        }

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

            table thead tr th {
                color: black !important;
            }
        }
    </style>
@endsection
