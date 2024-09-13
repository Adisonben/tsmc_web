<div class="row row-cols-3 mb-3">
    <div class="col">พนักงานขับรถ <u>{{ $formDatas[0]->driver_name ?? '-' }}</u></div>
    <div class="col">เบอร์โทรศัพท์ <u>{{ $formDatas[0]->phone ?? '-'}}</u></div>
    <div class="col">ทะเบียนรถ <u>{{ $formDatas[0]->car_plate ?? '-'}}</u></div>
</div>
{{-- <td>{{ $repairEmerg->driver_name }}</td>
<td>{{ $repairEmerg->car_plate }}</td> --}}
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th scope="col">รายการอุปกรณ์</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ประเภทการซ่อม</th>
            <th scope="col">ดำเนินการแก้ไขโดย</th>
            <th scope="col">ตรวจสอบหลังการแก้ไข</th>
        </tr>
    </thead>
    <tbody>
        @if (count($formDatas ?? []) > 0)
            @foreach ($formDatas as $index => $formData)
                <tr>
                    <td>{{ $formData->repair_list }}</td>
                    <td>{{ $formData->amount }}</td>
                    <td>{{ $formData->repair_type }}</td>
                    <td>{{ $formData->repair_by }}</td>
                    <td>
                        @if ($formData->status == 0)
                            <span>ยังไม่ได้ตรวจสอบ</span>
                        @elseif ($formData->status == 1)
                            <span style="color: green">ผ่าน</span>
                        @elseif ($formData->status == 2)
                            <span style="color: red">ไม่ผ่าน</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6">
                    <div class="text-center">ไม่พบเอกสาร</div>
                </td>
            </tr>
        @endif
    </tbody>
</table>
