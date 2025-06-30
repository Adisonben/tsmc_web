@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="card" id="exportPaper">
                <div class="card-body px-md-2">
                    {{-- <p class="text-center fs-5 mb-0 fw-bold">{{ Auth::user()->org_name }}</p> --}}
                    <p class="text-center fs-6 mb-0 fw-bold">แบบบันทึกผลการบารุงรักษารถ (Log Book)</p>
                    @php
                        $start_date = new Carbon\Carbon($logbook->start_date);
                        $end_date = (new Carbon\Carbon($start_date))->addMonths(optional($logbook->lastMonthSchedule)->month_value ?? 0);
                    @endphp

                    <div class="d-flex flex-wrap gap-x-1 justify-content-between my-2 px-4">
                        <div class="d-flex">
                            <p class="text-nowrap me-2 mb-0"> ผู้ประกอบการขนส่ง</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->org_name }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-2 mb-0">ชนิดรถ</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->vehicle_type }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-2 mb-0">หมายเลขทะเบียน</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->vehicle_plate }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-2 mb-0">เลขไมล์เริ่มต้น</p>
                            <p class="fw-bold mb-0"><u>{{ number_format($logbook->start_mileage) }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-2 mb-0">ช่วงวันที่ดำเนินการ</p>
                            <p class="fw-bold mb-0"><u>{{ $start_date->thaidate('j M Y') }} - {{ $end_date->thaidate('j M Y') }}</u></p>
                        </div>
                    </div>

                    <div>
                        <table class="table table-bordered border-dark">
                            <thead class="text-center">
                                <tr class="table-dark">
                                    <th rowspan="4">รายการ</th>
                                    <th class="p-1 m-0" style="font-size: 10px">ทุกๆระยะทาง</th>
                                    @foreach ($logbook->kmSchedules as $kmsc)
                                        <th class="p-1 m-0" style="font-size: 10px">{{ number_format($kmsc->km_value) }} กม.</th>
                                    @endforeach
                                </tr>
                                <tr class="table-dark" style="font-size: 10px">
                                    <th class="p-1 m-0">หรือทุกๆระยะเวลา</th>
                                    @foreach ($logbook->monthSchedules as $mnsc)
                                        <th class="p-1 m-0">{{ $mnsc->month_value }} เดือน</th>
                                    @endforeach
                                </tr>
                                <tr class="table-dark" style="font-size: 10px">
                                    <th class="p-1 m-0">ดำเนินการเมื่อ</th>
                                    <th class="p-1 m-0">{{$start_date->thaidate('j/m/y')}}</th>
                                    <th class="p-1 m-0">{{$start_date->thaidate('j/m/y')}}</th>
                                    <th class="p-1 m-0">{{$start_date->thaidate('j/m/y')}}</th>
                                    <th class="p-1 m-0">{{$start_date->thaidate('j/m/y')}}</th>
                                </tr>
                                <tr class="table-dark" style="font-size: 10px">
                                    <th class="p-1 m-0">การดำเนินการ</th>
                                    <th class="p-1 m-0">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-1 m-0">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-1 m-0">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-1 m-0">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 12px">
                                @foreach ($ma_categories ?? [] as $index => $ma_cate)
                                    @php
                                        $first_item = $ma_cate->maItems->first();
                                    @endphp
                                    <tr class="text-center">
                                        <td rowspan="{{ count($ma_cate->maItems ?? []) }}">{{ $index + 1 }}. {{ $ma_cate->name }}</td>
                                        <td class="px-1 py-0 m-0">{{ $first_item->name }}</td>
                                        <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                        <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                        <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                        <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                    </tr>
                                    @foreach ($ma_cate->maItems->skip(1) as $ma_item)
                                        <tr class="text-center">
                                            <td class="px-1 py-0 m-0">{{ $ma_item->name }}</td>
                                            <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                            <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                            <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                            <td class="px-1 py-0 m-0"><i class="bi bi-pencil text-primary"></i></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr class="text-center">
                                    <td colspan="2"> ลงชื่อ ผู้ควบคุมการบำรุงรักษารถ</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="col-12 d-flex">
                        <p class="text-nowrap me-2">หมายเหตุ</p>
                        <p class="fw-bold"><u>{{ $repair->note ?? "-" }}</u></p>
                    </div> --}}
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
            padding: 0.5cm;
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
