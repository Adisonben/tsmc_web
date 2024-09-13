
<div class="row row-cols-3 mb-3">
    @if ($car_info)
        <div class="col">ทะเบียนรถ <u>{{ $car_info->plate_num }}</u></div>
        <div class="col">ยี่ห้อ/รุ่น <u>{{ $car_info->model }}</u></div>
        <div class="col">ประเภทรถ <u>{{ $car_info->getType->name }}</u></div>
    @endif
    @if ($startDate && $endDate)
        @php
            $start_date = new Carbon\Carbon($startDate);
            $end_date = new Carbon\Carbon($endDate);
        @endphp
        <div class="col">ระหว่างวันที่ <u>{{ $start_date->thaidate('j M Y') }}</u></div>
        <div class="col">ถึงวันที่ <u>{{ $end_date->thaidate('j M Y') }}</u></div>
    @endif
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">วันที่บันทึก</th>
            <th scope="col">พนักงานขับรถ</th>
            <th scope="col">เลขที่ใบสั่งซ่อม</th>
            <th scope="col">เลขไมล์</th>
            <th scope="col">รายการซ่อม <br> (ประเภท/ผู้ซ่อม/อะไหล่/ค่าซ่อม)</th>
            <th scope="col">ราคาค่าซ่อมรวม</th>
        </tr>
    </thead>
    <tbody>
        @if (count($formDatas ?? []) > 0)
            @php
                $total_cost = 0;
            @endphp
            @foreach ($formDatas as $index => $repairHistorie)
                @php
                    $createdDate = new Carbon\Carbon($repairHistorie->created_at);
                    $total_cost += $repairHistorie->cost_amount;
                @endphp
                <tr>
                    <td>{{ $createdDate->thaidate('j M Y') }}</td>
                    <td>{{ $repairHistorie->driver_name }}</td>
                    <td>{{ $repairHistorie->order_num }}</td>
                    <td>{{ $repairHistorie->mileage }}</td>
                    <td>
                        <ol class="list-group-numbered p-0 m-0">
                            @foreach ($repairHistorie->getRepairList ?? [] as $repairHis)
                                <li class="list-group-item">{{ $repairHis->repair_type }}/{{ $repairHis->repair_by }}/{{ $repairHis->spare_part }}/{{ $repairHis->cost . "บาท" }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ number_format($repairHistorie->cost_amount, 0, '.', ',') }} บาท</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-end">รวมเป็นเงินทั้งสิ้น</td>
                <td>{{ number_format($total_cost, 0, '.', ',') }} บาท</td>
            </tr>
        @else
            <tr>
                <td colspan="6"><div class="text-center">ไม่พบเอกสาร</div></td>
            </tr>
        @endif
    </tbody>
</table>
