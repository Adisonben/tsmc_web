
<div class="row row-cols-3 mb-3">
    <div class="col">พนักงานชับรถ <u>{{ $formDatas[0]->employee_name ?? '-' }}</u></div>
    @if ($startDate && $endDate)
        @php
            $start_date = new Carbon\Carbon($startDate);
            $end_date = new Carbon\Carbon($endDate);
        @endphp
        <div class="col">ตั้งแต่วันที่ <u>{{ $start_date->thaidate('j M Y') }}</u></div>
        <div class="col">ถึงวันที่ <u>{{ $end_date->thaidate('j M Y') }}</u></div>
    @endif
</div>
<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th scope="col">หมายเลขงาน</th>
            <th scope="col">วันที่สั่งงาน</th>
            <th scope="col">ทะเบียนรถ</th>
            {{-- <th scope="col">พนักงานขับรถ</th> --}}
            <th scope="col">ปริมาณสินค้า</th>
            <th scope="col">ชื่อลูกค้า</th>
            <th scope="col">จุดรับสินค้า</th>
            <th scope="col">วันที่รับ</th>
            <th scope="col">จุดส่งสินค้า</th>
            <th scope="col">วันที่ส่ง</th>
            <th scope="col">ชั่วโมง</th>
        </tr>
    </thead>
    <tbody>
        @if (count($formDatas ?? []) > 0)
            @foreach ($formDatas as $index => $formData)
                <tr>
                    <td>{{ $formData->work_num }}</td>
                    <td>{{ $formData->assign_date }}</td>
                    <td>{{ $formData->vehicle_plate }}</td>
                    {{-- <td>{{ $formData->employee_name }}</td> --}}
                    <td>{{ $formData->product_volume }}</td>
                    <td>{{ $formData->customer_name }}</td>
                    <td>{{ $formData->receive_place }}</td>
                    @php
                        $receiveDate = new Carbon\Carbon($formData->receive_date);
                        $dropDate = new Carbon\Carbon($formData->drop_date);
                        // dd($receiveDate->format('j M Y H:i:s'));
                        $difference = $receiveDate->diffAsCarbonInterval($dropDate); // y m d h i s d invert days
                    @endphp
                    <td>{{ $receiveDate->thaidate('j M Y \\เวลา H:i') }}</td>
                    <td>{{ $formData->drop_place }}</td>
                    <td>{{ $dropDate->thaidate('j M Y \\เวลา H:i') }}</td>
                    <td>
                        {{ $difference->d ? $difference->d . " วัน " : '' }}{{ $difference->h ? $difference->h . " ชม. " : '' }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6"><div class="text-center">ไม่พบเอกสาร</div></td>
            </tr>
        @endif
    </tbody>
</table>
