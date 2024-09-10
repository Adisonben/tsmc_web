@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} บันทึกการปฏิบัติงานประจำวัน</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addDailyWork">
                                เพิ่ม
                            </button>
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
                                                <input type="date" class="form-control" id="assignDate" name="assignDate">
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
                                                <input type="date" class="form-control" id="recDate" name="recDate">
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="sendPlace" class="form-label">สถานที่ส่งสินค้า</label>
                                                <input type="text" class="form-control" maxlength="100" id="sendPlace" name="sendPlace" placeholder="กรอกสถานที่ส่งสินค้า">
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <label for="sendDate" class="form-label">วันที่ส่งสินค้า</label>
                                                <input type="date" class="form-control" id="sendDate" name="sendDate">
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
                                        <button type="button" class="btn btn-primary">บันทึก</button>
                                    </div>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
