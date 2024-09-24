@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} ตรวจสอบและซ่อมบำรุงอุปกรณ์รับมือเหตุการณ์ฉุกเฉิน</p>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addMaintainEmer">เพิ่ม</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="addMaintainEmer" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="addMaintainEmerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addMaintainEmerLabel">
                                        แบบฟอร์มตรวจสอบและซ่อมบำรุงอุปกรณ์รับมือเหตุการณ์ฉุกเฉิน
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('form.store.repair.emergency') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <label for="driverName" class="col-sm-4 col-form-label">พนักงานขับรถชื่อ</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="driverName" name="driverName"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="driverPhone" class="col-sm-4 col-form-label">เบอร์</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="driverPhone"
                                                    name="driverPhone" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="carPlate" class="col-sm-4 col-form-label">ทะเบียนรถ</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="carPlate" name="carPlate"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="repairName"
                                                class="col-sm-4 col-form-label">รายการซ่อมอุปกรณ์</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="repairName" name="repairName"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="amount" class="col-sm-4 col-form-label">จำนวน</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="amount" name="amount">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="repairType" class="col-sm-4 col-form-label">ประเภทการซ่อม</label>
                                            <div class="col-sm-8">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="repairType"
                                                        id="addRadio1" value="ซ่อม">
                                                    <label class="form-check-label" for="addRadio1">ซ่อม</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="repairType"
                                                        id="addRadio2" value="เปลี่ยน">
                                                    <label class="form-check-label" for="addRadio2">เปลี่ยน</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="fixBy" class="col-sm-4 col-form-label">ดำเนินการแก้ไขโดย</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="fixBy" name="fixBy"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">ปิด</button>
                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                    </div>
                                </form>
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
                                        <th scope="col">พนักงานขับรถ</th>
                                        <th scope="col">ทะเบียนรถ</th>
                                        <th scope="col">รายการอุปกรณ์</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">ประเภทการซ่อม</th>
                                        <th scope="col">ดำเนินการแก้ไขโดย</th>
                                        <th scope="col">ตรวจสอบหลังการแก้ไข</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($repairEmergs ?? []) > 0)
                                        @foreach ($repairEmergs as $index => $repairEmerg)
                                            <tr>
                                                <td>{{ $repairEmerg->driver_name }}</td>
                                                <td>{{ $repairEmerg->car_plate }}</td>
                                                <td>{{ $repairEmerg->repair_list }}</td>
                                                <td>{{ $repairEmerg->amount }}</td>
                                                <td>{{ $repairEmerg->repair_type }}</td>
                                                <td>{{ $repairEmerg->repair_by }}</td>
                                                <td>
                                                    @if ($repairEmerg->status == 0)
                                                        <span class="badge text-bg-secondary">ยังไม่ได้ตรวจสอบ</span>
                                                    @elseif ($repairEmerg->status == 1)
                                                        <span class="badge text-bg-success">ผ่าน</span>
                                                    @elseif ($repairEmerg->status == 2)
                                                        <span class="badge text-bg-danger">ไม่ผ่าน</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($repairEmerg->status == 0)
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#editMaintainEmer{{ $repairEmerg->id }}">แก้ไข</button>
                                                        <a href="{{ route('form.delete.repair.emergency', ['fid' => $repairEmerg->id]) }}"
                                                            class="btn btn-danger btn-sm">ลบ</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!-- Modal -->
                                            <div class="modal fade" id="editMaintainEmer{{ $repairEmerg->id }}" data-bs-backdrop="static"
                                                data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="editMaintainEmerLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="editMaintainEmerLabel">
                                                                 แก้ไขการตรวจสอบและซ่อมบำรุงอุปกรณ์รับมือเหตุการณ์ฉุกเฉิน
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('form.update.repair.emergency', ['fid' => $repairEmerg->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <label for="driverName"
                                                                        class="col-sm-4 col-form-label">พนักงานขับรถชื่อ</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="{{ $repairEmerg->driver_name }}"
                                                                            id="driverName" name="driverName" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="driverPhone"
                                                                        class="col-sm-4 col-form-label">เบอร์</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="{{ $repairEmerg->phone }}"
                                                                            id="driverPhone" name="driverPhone" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="carPlate"
                                                                        class="col-sm-4 col-form-label">ทะเบียนรถ</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="{{ $repairEmerg->car_plate }}"
                                                                            id="carPlate" name="carPlate" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="repairName"
                                                                        class="col-sm-4 col-form-label">รายการซ่อมอุปกรณ์</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="{{ $repairEmerg->repair_list }}"
                                                                            id="repairName" name="repairName" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="amount"
                                                                        class="col-sm-4 col-form-label">จำนวน</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="number" class="form-control" value="{{ $repairEmerg->amount }}"
                                                                            id="amount" name="amount">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="repairType"
                                                                        class="col-sm-4 col-form-label">ประเภทการซ่อม</label>
                                                                    <div class="col-sm-8">
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="repairType" id="editRadio1"
                                                                                value="ซ่อม" {{ $repairEmerg->repair_type == "ซ่อม" ? "checked" : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="editRadio1">ซ่อม</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" {{ $repairEmerg->repair_type == "เปลี่ยน" ? "checked" : '' }}
                                                                                name="repairType" id="editRadio2"
                                                                                value="เปลี่ยน">
                                                                            <label class="form-check-label"
                                                                                for="editRadio2">เปลี่ยน</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="fixBy"
                                                                        class="col-sm-4 col-form-label">ดำเนินการแก้ไขโดย</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" class="form-control" value="{{ $repairEmerg->repair_by }}"
                                                                            id="fixBy" name="fixBy" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">บันทึก</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
