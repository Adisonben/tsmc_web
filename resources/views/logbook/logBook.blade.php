@extends('layouts.app')

@section('content')
    <div class="">
        @if (session('store_entry_success'))
            <div class="alert alert-success w-50 mx-auto" role="alert">
                {{ session('store_entry_success') }}
            </div>
        @elseif (session('store_entry_error'))
            <div class="alert alert-danger w-50 mx-auto" role="alert">
                {{ session('store_entry_error') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="card border-0" id="exportPaper">
                <div class="card-body px-md-2">
                    {{-- <p class="text-center fs-5 mb-0 fw-bold">{{ Auth::user()->org_name }}</p> --}}
                    <p class="text-center fs-6 mb-0 fw-bold">แบบบันทึกผลการบำรุงรักษารถ (Log Book)</p>
                    @php
                        $start_date = new Carbon\Carbon($logbook->start_date);
                        $end_date = (new Carbon\Carbon($start_date))->addMonths(
                            optional($logbook->lastMonthSchedule)->month_value ?? 0,
                        );
                    @endphp

                    <div class="d-flex flex-wrap gap-x-1 justify-content-between mt-3 mb-1 px-2" style="font-size: 12px">
                        <div class="d-flex">
                            <p class="text-nowrap me-1 mb-0"> ผู้ประกอบการขนส่ง</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->org_name }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-1 mb-0">ชนิดรถ</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->vehicle_type }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-1 mb-0">หมายเลขทะเบียน</p>
                            <p class="fw-bold mb-0"><u>{{ $logbook->vehicle_plate }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-1 mb-0">เลขไมล์เริ่มต้น</p>
                            <p class="fw-bold mb-0"><u>{{ number_format($logbook->start_mileage) }}</u></p>
                        </div>
                        <div class="d-flex">
                            <p class="text-nowrap me-1 mb-0">ช่วงวันที่ดำเนินการ</p>
                            <p class="fw-bold mb-0"><u>{{ $start_date->thaidate('j M Y') }} -
                                    {{ $end_date->thaidate('j M Y') }}</u></p>
                        </div>
                    </div>

                    <div>
                        <p class="mb-0 text-danger" style="font-size: 10px">*เครื่องหมาย <i class="bi bi-check-lg"></i>|<i class="bi bi-check-lg"></i>|<i class="bi bi-check-lg"></i> หมายถึงการดำเนินการ ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่ ตามลำดับ โดยเครื่องหมาย <i class="bi bi-check-lg"></i> หมายถึงการดำเนินการแล้ว และ <i class="bi bi-x-lg"></i> หมายถึงไม่ได้ดำเนินการ</p>
                        <table class="table table-bordered border-dark">
                            {{-- Table header --}}
                            <thead class="text-center">
                                <tr class="table-dark">
                                    <th rowspan="4" style="font-size: 12px">รายการ</th>
                                    <th class="p-1 m-0" style="font-size: 10px">ทุกๆระยะทาง</th>
                                    @foreach ($logbook->kmSchedules as $kmsc)
                                        <th class="p-1 m-0" style="font-size: 10px">{{ number_format($kmsc->km_value) }} กม.
                                        </th>
                                    @endforeach
                                </tr>
                                <tr class="table-dark" style="font-size: 10px">
                                    <th class="p-1 m-0">หรือทุกๆระยะเวลา</th>
                                    @foreach ($logbook->monthSchedules as $mnsc)
                                        <th class="p-1 m-0">{{ $mnsc->month_value }} เดือน</th>
                                    @endforeach
                                </tr>
                                {{-- <tr class="table-dark" style="font-size: 12px">
                                    <th class="p-1 m-0">ดำเนินการเมื่อ</th>
                                    @for ($i = 0; $i < 4; $i++)
                                        <th class="p-0 m-0">
                                            <p class="m-0">
                                                {{ number_format($logbook->start_mileage + $logbook->kmSchedules[$i]->km_value) }}
                                                กม.</p>
                                            <p class="m-0" style="font-size: 10px">
                                                ({{ (new Carbon\Carbon($start_date))->addMonths($logbook->monthSchedules[$i]->month_value)->thaidate('j/m/y') }})
                                            </p>
                                        </th>
                                    @endfor
                                </tr> --}}
                                <tr class="table-dark">
                                    <th class="p-0 m-0" style="font-size: 10px">การดำเนินการ</th>
                                    <th class="p-0 m-0" style="font-size: 8px">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-0 m-0" style="font-size: 8px">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-0 m-0" style="font-size: 8px">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                    <th class="p-0 m-0" style="font-size: 8px">ตรวจสอบ/ปรับตั้ง/เปลี่ยนใหม่</th>
                                </tr>
                            </thead>

                            <tbody style="font-size: 10px">
                                @foreach ($ma_categories ?? [] as $index => $ma_cate)
                                    @php
                                        $first_item = $ma_cate->maItems->first();
                                        $column_data1 = $first_item->getLogBookEntryByLOgBookId($logbook->id, 1);
                                        $column_data2 = $first_item->getLogBookEntryByLOgBookId($logbook->id, 2);
                                        $column_data3 = $first_item->getLogBookEntryByLOgBookId($logbook->id, 3);
                                        $column_data4 = $first_item->getLogBookEntryByLOgBookId($logbook->id, 4);
                                    @endphp

                                    {{-- first col --}}
                                    <tr class="text-center">
                                        <td class="text-start" rowspan="{{ count($ma_cate->maItems ?? []) }}">
                                            {{ $index + 1 }}.
                                            {{ $ma_cate->name }}</td>
                                        <td class="px-1 py-0 m-0 text-start">{{ $first_item->name }}</td>
                                        <td class="px-1 py-0 m-0" style="font-size: 10px">
                                            @if ($column_data1)
                                                {!! $column_data1->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data1->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data1->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                @if ($column_data1->date ?? false)
                                                   <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data1->date))->thaidate('j/m/Y') }})</p>
                                                @endif
                                            @else
                                                <div class="entry" data-bs-toggle="modal" data-bs-column="1"
                                                    data-bs-item="{{ $first_item->id }}"
                                                    data-bs-schedule="{{ number_format($logbook->kmSchedules[0]->km_value) }} กม. / {{ $logbook->monthSchedules[0]->month_value }} เดือน"
                                                    data-bs-item_name="{{ $first_item->name }}"
                                                    data-bs-target="#checkLogBook"><i class="bi bi-pencil text-primary"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-1 py-0 m-0" style="font-size: 10px">
                                            @if ($column_data2)
                                                {!! $column_data2->action_check ? '<i class="bi bi-check-lg m-0"></i>' : '<i class="bi bi-x-lg m-0 b-0"></i>' !!} |
                                                {!! $column_data2->action_adjust ? '<i class="bi bi-check-lg m-0"></i>' : '<i class="bi bi-x-lg m-0 b-0"></i>' !!} |
                                                {!! $column_data2->action_replace ? '<i class="bi bi-check-lg m-0"></i>' : '<i class="bi bi-x-lg m-0 b-0"></i>' !!}
                                                @if ($column_data2->date ?? false)
                                                   <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data2->date))->thaidate('j/m/Y') }})</p>
                                                @endif
                                            @else
                                                <div class="entry" data-bs-toggle="modal" data-bs-column="2"
                                                    data-bs-item="{{ $first_item->id }}"
                                                    data-bs-schedule="{{ number_format($logbook->kmSchedules[1]->km_value) }} กม. / {{ $logbook->monthSchedules[1]->month_value }} เดือน"
                                                    data-bs-item_name="{{ $first_item->name }}"
                                                    data-bs-target="#checkLogBook"><i class="bi bi-pencil text-primary"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-1 py-0 m-0" style="font-size: 10px">
                                            @if ($column_data3)
                                                {!! $column_data3->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data3->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data3->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                @if ($column_data3->date ?? false)
                                                   <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data3->date))->thaidate('j/m/Y') }})</p>
                                                @endif
                                            @else
                                                <div class="entry" data-bs-toggle="modal" data-bs-column="3"
                                                    data-bs-item="{{ $first_item->id }}"
                                                    data-bs-schedule="{{ number_format($logbook->kmSchedules[2]->km_value) }} กม. / {{ $logbook->monthSchedules[2]->month_value }} เดือน"
                                                    data-bs-item_name="{{ $first_item->name }}"
                                                    data-bs-target="#checkLogBook"><i class="bi bi-pencil text-primary"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-1 py-0 m-0" style="font-size: 10px">
                                            @if ($column_data4)
                                                {!! $column_data4->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data4->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                {!! $column_data4->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                @if ($column_data4->date ?? false)
                                                   <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data4->date))->thaidate('j/m/Y') }})</p>
                                                @endif
                                            @else
                                                <div class="entry" data-bs-toggle="modal" data-bs-column="4"
                                                    data-bs-item="{{ $first_item->id }}"
                                                    data-bs-schedule="{{ number_format($logbook->kmSchedules[3]->km_value) }} กม. / {{ $logbook->monthSchedules[3]->month_value }} เดือน"
                                                    data-bs-item_name="{{ $first_item->name }}"
                                                    data-bs-target="#checkLogBook"><i
                                                        class="bi bi-pencil text-primary"></i>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- item column --}}
                                    @foreach ($ma_cate->maItems->skip(1) as $index => $ma_item)
                                        @php
                                            $column_data1 = $ma_item->getLogBookEntryByLOgBookId($logbook->id, 1);
                                            $column_data2 = $ma_item->getLogBookEntryByLOgBookId($logbook->id, 2);
                                            $column_data3 = $ma_item->getLogBookEntryByLOgBookId($logbook->id, 3);
                                            $column_data4 = $ma_item->getLogBookEntryByLOgBookId($logbook->id, 4);
                                        @endphp
                                        <tr class="text-center">
                                            <td class="px-1 py-0 m-0 text-start">{{ $ma_item->name }}</td>
                                            <td class="px-1 py-0 m-0" style="font-size: 10px">
                                                @if ($column_data1)
                                                    {!! $column_data1->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data1->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data1->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                    @if ($column_data1->date ?? false)
                                                    <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data1->date))->thaidate('j/m/Y') }})</p>
                                                    @endif
                                                @else
                                                    <div class="entry" data-bs-toggle="modal" data-bs-column="1"
                                                        data-bs-item="{{ $ma_item->id }}"
                                                        data-bs-schedule="{{ number_format($logbook->kmSchedules[0]->km_value) }} กม. / {{ $logbook->monthSchedules[0]->month_value }} เดือน"
                                                        data-bs-item_name="{{ $ma_item->name }}"
                                                        data-bs-target="#checkLogBook">
                                                        <i class="bi bi-pencil text-primary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-1 py-0 m-0" style="font-size: 10px">
                                                @if ($column_data2)
                                                    {!! $column_data2->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data2->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data2->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                    @if ($column_data2->date ?? false)
                                                        <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data2->date))->thaidate('j/m/Y') }})</p>
                                                    @endif
                                                @else
                                                    <div class="entry" data-bs-toggle="modal" data-bs-column="2"
                                                        data-bs-item="{{ $ma_item->id }}"
                                                        data-bs-schedule="{{ number_format($logbook->kmSchedules[0]->km_value) }} กม. / {{ $logbook->monthSchedules[0]->month_value }} เดือน"
                                                        data-bs-item_name="{{ $ma_item->name }}"
                                                        data-bs-target="#checkLogBook"><i
                                                            class="bi bi-pencil text-primary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-1 py-0 m-0" style="font-size: 10px">
                                                @if ($column_data3)
                                                    {!! $column_data3->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data3->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data3->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                    @if ($column_data3->date ?? false)
                                                        <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data3->date))->thaidate('j/m/Y') }})</p>
                                                    @endif
                                                @else
                                                    <div class="entry" data-bs-toggle="modal" data-bs-column="3"
                                                        data-bs-item="{{ $ma_item->id }}"
                                                        data-bs-schedule="{{ number_format($logbook->kmSchedules[0]->km_value) }} กม. / {{ $logbook->monthSchedules[0]->month_value }} เดือน"
                                                        data-bs-item_name="{{ $ma_item->name }}"
                                                        data-bs-target="#checkLogBook"><i
                                                            class="bi bi-pencil text-primary"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-1 py-0 m-0" style="font-size: 10px">
                                                @if ($column_data4)
                                                    {!! $column_data4->action_check ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data4->action_adjust ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!} |
                                                    {!! $column_data4->action_replace ? '<i class="bi bi-check-lg"></i>' : '<i class="bi bi-x-lg"></i>' !!}
                                                    @if ($column_data4->date ?? false)
                                                        <br><p class="m-0" style="font-size: 8px">({{ (new Carbon\Carbon($column_data4->date))->thaidate('j/m/Y') }})</p>
                                                    @endif
                                                @else
                                                    <div class="entry" data-bs-toggle="modal" data-bs-column="4"
                                                        data-bs-item="{{ $ma_item->id }}"
                                                        data-bs-schedule="{{ number_format($logbook->kmSchedules[0]->km_value) }} กม. / {{ $logbook->monthSchedules[0]->month_value }} เดือน"
                                                        data-bs-item_name="{{ $ma_item->name }}"
                                                        data-bs-target="#checkLogBook"><i
                                                            class="bi bi-pencil text-primary"></i>
                                                    </div>
                                                @endif
                                            </td>
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

                    <!-- Modal -->
                    <div class="modal fade" id="checkLogBook" tabindex="-1" aria-labelledby="checkLogBookLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="checkLogBookLabel">บันทึกผลการบำรุงรักษารถ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('logbook.store.entry', ['logbook_id' => $logbook->id]) }}"
                                    method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <p class="mb-0">การดำเนินการ: <u><span class="item-name ms-2"></span></u>
                                            </p>
                                            <p class="mb-0">ช่วงระยะทาง/ระยะเวลา: <u><span class="schedule ms-2"></span></u></p>
                                        </div>
                                        <div>
                                            <div class="mb-3">
                                                <label for="repair_date" class="form-label">วันที่ดำเนินการ</label>
                                                <input type="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="repair_date" name="repair_date">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="action[check]"
                                                    id="check" value="1" checked>
                                                <label class="form-check-label" for="check">ตรวจสอบ</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="adjust"
                                                    name="action[adjust]" value="1">
                                                <label class="form-check-label" for="adjust">ปรับตั้ง</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="change"
                                                    name="action[change]" value="1">
                                                <label class="form-check-label" for="change">เปลี่ยนใหม่</label>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="entryAll" name="entryAll">
                                            <label class="form-check-label" for="checkDefault">
                                                บันทึกทั้งคอลัมน์
                                            </label>
                                        </div>
                                        {{-- <p class="test-data"></p> --}}
                                        <input type="hidden" class="column_data" name="at_column">
                                        <input type="hidden" class="item_data" name="at_item">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mt-2">
                <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                <a href="{{ route('car.ma.table') }}" class="btn btn-secondary">กลับ</a>
            </div>
        </div>
    </div>
    <script>
        const checkLogBookModal = document.getElementById('checkLogBook')
        if (checkLogBookModal) {
            checkLogBookModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const column_at = button.getAttribute('data-bs-column')
                const item_id = button.getAttribute('data-bs-item')
                const schedule = button.getAttribute('data-bs-schedule')
                const item_name = button.getAttribute('data-bs-item_name')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const columnData = checkLogBookModal.querySelector('.modal-body .column_data')
                const itemData = checkLogBookModal.querySelector('.modal-body .item_data')
                const itemnameP = checkLogBookModal.querySelector('.modal-body .item-name')
                const scheduleP = checkLogBookModal.querySelector('.modal-body .schedule')

                itemnameP.textContent = item_name
                scheduleP.textContent = schedule
                columnData.value = column_at
                itemData.value = item_id
            })
        }
    </script>
    <style>
        #logbookTablePage {
            background-color: var(--main-color);
        }

        #exportPaper {
            background-color: white;
            padding: 0.4cm;
            width: 210mm;
        }

        @media print {
            body {
                visibility: hidden;
            }

            .entry {
                visibility: hidden;
                display: none;
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
