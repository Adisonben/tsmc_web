@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} บันทึกการปฏิบัติงานประจำวัน</p>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addDailyWork">
                                    เพิ่ม
                                </button>
                                <a href="{{ route('form.export', ['formCode' => "TSM-RP-002"]) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-title="ออกรายงาน"><i class="bi bi-file-pdf"></i></a>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addDailyWork" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มการปฏิบัติงานประจำวัน</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('form.store.dailywork') }}" method="post">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="workNum" class="form-label">หมายเลขงาน</label>
                                                    <input type="text" class="form-control" maxlength="100" id="workNum" name="workNum" placeholder="กรอกหมายเลขงาน">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="vehPlate" class="form-label">ทะเบียนรถ</label>
                                                    <input type="text" class="form-control" maxlength="100" id="vehPlate" name="vehPlate" placeholder="กรอกทะเบียนรถ">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="empName" class="form-label">ชื่อพนักงาน</label>
                                                    <input type="text" class="form-control" maxlength="100" id="empName" name="empName" placeholder="กรอกชื่อพนักงาน">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="assignDate" class="form-label">วันที่สั่งงาน</label>
                                                    <input type="datetime-local" class="form-control" id="assignDate" name="assignDate">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="cusName" class="form-label">ชื่อลูกค้า</label>
                                                    <input type="text" class="form-control" maxlength="100" id="cusName" name="cusName" placeholder="กรอกชื่อลูกค้า">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="recPlace" class="form-label">สถานที่รับสินค้า</label>
                                                    <input type="text" class="form-control" maxlength="100" id="recPlace" name="recPlace" placeholder="กรอกสถานที่รับสินค้า">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="recDate" class="form-label">วันที่รับสินค้า</label>
                                                    <input type="datetime-local" class="form-control" id="recDate" name="recDate">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="sendPlace" class="form-label">สถานที่ส่งสินค้า</label>
                                                    <input type="text" class="form-control" maxlength="100" id="sendPlace" name="sendPlace" placeholder="กรอกสถานที่ส่งสินค้า">
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="sendDate" class="form-label">วันที่ส่งสินค้า</label>
                                                    <input type="datetime-local" class="form-control" id="sendDate" name="sendDate">
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="prodVolume" class="form-label">ปริมาณสินค้า</label>
                                                    <input type="text" class="form-control" maxlength="100" id="prodVolume" name="prodVolume" placeholder="กรอกปริมาณสินค้า">
                                                </div>
                                            </div>
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

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">หมายเลขงาน</th>
                                        <th scope="col">ทะเบียนรถ</th>
                                        <th scope="col">พนักงาน</th>
                                        <th scope="col">ลูกค้า</th>
                                        <th scope="col">วันที่รับ</th>
                                        <th scope="col">วันที่ส่ง</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($dailyworks ?? []) > 0)
                                        @foreach ($dailyworks as $index => $dailywork)
                                            <tr>
                                                <td>{{ $dailywork->work_num }}</td>
                                                <td>{{ $dailywork->vehicle_plate }}</td>
                                                <td>{{ $dailywork->employee_name }}</td>
                                                <td>{{ $dailywork->customer_name }}</td>
                                                @php
                                                    $receiveDate = new Carbon\Carbon($dailywork->receive_date);
                                                    $dropDate = new Carbon\Carbon($dailywork->drop_date);
                                                    // dd($receiveDate->format('j M Y H:i:s'));
                                                @endphp
                                                <td>{{ $dailywork->receive_date ? $receiveDate->thaidate('j M Y \\เวลา H:i') : '-' }}</td>
                                                <td>{{ $dailywork->drop_date ? $dropDate->thaidate('j M Y \\เวลา H:i') : '-' }}</td>
                                                <td>
                                                    @if ($dailywork->status)
                                                        <span class="badge text-bg-success">ดำเนินการสำเร็จ</span>
                                                    @else
                                                        <span class="badge text-bg-warning">กำลังดำเนินการ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editDailywork{{ $dailywork->id }}">
                                                        @if ($dailywork->status)
                                                            รายละเอียด
                                                        @else
                                                            จัดการ
                                                        @endif
                                                    </button>
                                                    @if (!$dailywork->status)
                                                        <a href="{{ route('form.delete.dailywork', ['fid' => $dailywork->id]) }}" class="btn btn-danger btn-sm">ลบ</a>
                                                    @else
                                                        <a href="{{ route('form.export.dairy.work', ['fid' => $dailywork->id]) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-title="ออกรายงาน"><i class="bi bi-file-pdf"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editDailywork{{ $dailywork->id }}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">แก้ไขการปฏิบัติงานประจำวัน</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('form.update.dailywork', ['fid' => $dailywork->id]) }}" method="post">
                                                            @csrf

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="workNum" class="form-label">หมายเลขงาน</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->work_num }}" {{ $dailywork->status ? 'disabled' : '' }} id="workNum" name="workNum" placeholder="กรอกหมายเลขงาน">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="vehPlate" class="form-label">ทะเบียนรถ</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->vehicle_plate }}" {{ $dailywork->status ? 'disabled' : '' }} id="vehPlate" name="vehPlate" placeholder="กรอกทะเบียนรถ">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="empName" class="form-label">ชื่อพนักงาน</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->employee_name }}" {{ $dailywork->status ? 'disabled' : '' }} id="empName" name="empName" placeholder="กรอกชื่อพนักงาน">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="assignDate" class="form-label">วันที่สั่งงาน</label>
                                                                        <input type="datetime-local" class="form-control" id="assignDate" value="{{ $dailywork->assign_date }}" {{ $dailywork->status ? 'disabled' : '' }} name="assignDate">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="cusName" class="form-label">ชื่อลูกค้า</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->customer_name }}" {{ $dailywork->status ? 'disabled' : '' }} id="cusName" name="cusName" placeholder="กรอกชื่อลูกค้า">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="recPlace" class="form-label">สถานที่รับสินค้า</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->receive_place }}" {{ $dailywork->status ? 'disabled' : '' }} id="recPlace" name="recPlace" placeholder="กรอกสถานที่รับสินค้า">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="recDate" class="form-label">วันที่รับสินค้า</label>
                                                                        <input type="datetime-local" class="form-control" id="recDate" value="{{ $dailywork->receive_date }}" {{ $dailywork->status ? 'disabled' : '' }} name="recDate">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="sendPlace" class="form-label">สถานที่ส่งสินค้า</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->drop_place }}" {{ $dailywork->status ? 'disabled' : '' }} id="sendPlace" name="sendPlace" placeholder="กรอกสถานที่ส่งสินค้า">
                                                                    </div>
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                        <label for="sendDate" class="form-label">วันที่ส่งสินค้า</label>
                                                                        <input type="datetime-local" class="form-control" id="sendDate" value="{{ $dailywork->drop_date }}" {{ $dailywork->status ? 'disabled' : '' }} name="sendDate">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <label for="prodVolume" class="form-label">ปริมาณสินค้า</label>
                                                                        <input type="text" class="form-control" maxlength="100" value="{{ $dailywork->product_volume }}" {{ $dailywork->status ? 'disabled' : '' }} id="prodVolume" name="prodVolume" placeholder="กรอกปริมาณสินค้า">
                                                                    </div>
                                                                    @if ($dailywork->status)
                                                                        <div class="col-12 mb-3">
                                                                            @php
                                                                                $receiveDate = new Carbon\Carbon($dailywork->receive_date);
                                                                                $dropDate = new Carbon\Carbon($dailywork->drop_date);

                                                                                $difference = $receiveDate->diffAsCarbonInterval($dropDate); // y m d h i s d invert days
                                                                            @endphp
                                                                            <p>เวลาที่ใช้ : {{ $difference->d ? $difference->d . " วัน " : '' }}{{ $difference->h ? $difference->h . " ชม. " : '' }}</p>
                                                                        </div>
                                                                    @else
                                                                        <div class="col-12 mb-3">
                                                                            <input class="form-check-input" type="checkbox" value="1" name="checkFinish" id="checkFinish" {{ $dailywork->status ? 'disabled' : '' }} {{ $dailywork->status ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="checkFinish">
                                                                                ดำเนินการเสร็จสิ้น
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                @if (!$dailywork->status)
                                                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><div class="text-center">ไม่พบเอกสาร</div></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
