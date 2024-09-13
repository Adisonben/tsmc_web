<table class="table table-hover table-bordered mb-0">
    <thead>
        <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">ชื่อบุคคล</th>
            <th scope="col">ตำแหน่ง</th>
            <th scope="col">เบอร์สำนักงาน</th>
            <th scope="col">เบอร์บ้าน</th>
            <th scope="col">เบอร์มือถือ</th>
            <th scope="col">วันที่บันทึก</th>
        </tr>
    </thead>
    <tbody>
        @if (count($phonenum_lists ?? []) > 0)
            @foreach ($phonenum_lists as $index => $phonenum_list)
                @php
                    $createdDate = new Carbon\Carbon($phonenum_list->updated_at);
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $phonenum_list->person_name }}</td>
                    <td>{{ $phonenum_list->position ?? '-' }}</td>
                    <td>{{ $phonenum_list->office_num ?? '-' }}</td>
                    <td>{{ $phonenum_list->home_num ?? '-' }}</td>
                    <td>{{ $phonenum_list->cellphone ?? '-' }}</td>
                    <td>{{ $createdDate->thaidate('j M Y') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6"><div class="text-center">ไม่พบข้อมูล</div></td>
            </tr>
        @endif
    </tbody>
</table>
