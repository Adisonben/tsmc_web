@extends('layouts.app')

@section('content')
    <div class="container py-4" x-data="formBuilder()">
        <form @submit.prevent="handleSubmit" class="vstack gap-4">
            <div class="text-center fs-4 fw-bold">
                ฟอร์มสร้าง แบบบันทึกผลการบำรุงรักษารถ (Log Book)
            </div>

            <!-- ข้อมูลพื้นฐาน -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">ข้อมูลพื้นฐาน</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="vehicle" class="form-label">ทะเบียนรถ</label>
                            <select class="form-select" id="vehicle" required>
                                <option value="">เลือกทะเบียนรถ</option>
                                <option value="1">กข 1234 - Toyota Vios</option>
                                <option value="2">กค 5678 - Honda City</option>
                                <option value="3">กง 9012 - Nissan Almera</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="repairDate" class="form-label">ชนิดรถ</label>
                            <input type="text" class="form-control" id="repairDate" required>
                        </div>

                        <div class="col-md-6">
                            <label for="mileage" class="form-label">ผู้ประกอบการขนส่ง</label>
                            <input type="text" class="form-control" id="mileage" placeholder="ผู้ประกอบการขนส่ง">
                        </div>

                        <div class="col-md-6">
                            <label for="mileage" class="form-label">เลขไมล์เริ่มต้น</label>
                            <input type="number" class="form-control" id="mileage" placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label for="mileage" class="form-label">วันที่เริ่มนับรอบ Log Book</label>
                            <input type="date" class="form-control" id="mileage" placeholder="วันที่เริ่มนับรอบ">
                        </div>
                    </div>
                </div>
            </div>

            <!-- กำหนดเงื่อนไขกำหนดการ -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title mb-0">กำหนดเงื่อนไขกำหนดการ</h5>
                        <small class="text-muted">เลือกช่วงระยะทางและเวลาสำหรับการบำรุงรักษา (เลือกได้สูงสุด 4
                            ตัวเลือกแต่ละประเภท)</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="mb-2">ชุดระยะทาง (กิโลเมตร) - เลือกได้สูงสุด 4 ตัว</h5>
                        <div class="row row-cols-4">
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-5000">
                                    <label class="form-check-label" for="distance-5000">5,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-10000">
                                    <label class="form-check-label" for="distance-10000">10,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-15000">
                                    <label class="form-check-label" for="distance-15000">15,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-20000">
                                    <label class="form-check-label" for="distance-20000">20,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-25000">
                                    <label class="form-check-label" for="distance-25000">25,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-30000">
                                    <label class="form-check-label" for="distance-30000">30,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-40000">
                                    <label class="form-check-label" for="distance-40000">40,000 กม.</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="distance-50000">
                                    <label class="form-check-label" for="distance-50000">50,000 กม.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5 class="mb-2">ชุดระยะเวลา (เดือน) - เลือกได้สูงสุด 4 ตัว</h5>
                        <div class="row row-cols-4">
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-2">
                                    <label class="form-check-label" for="time-1">2 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-4">
                                    <label class="form-check-label" for="time-3">4 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-8">
                                    <label class="form-check-label" for="time-6">8 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-12">
                                    <label class="form-check-label" for="time-12">12 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-14">
                                    <label class="form-check-label" for="time-18">14 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-16">
                                    <label class="form-check-label" for="time-24">16 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-20">
                                    <label class="form-check-label" for="time-24">20 เดือน</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="time-24">
                                    <label class="form-check-label" for="time-24">24 เดือน</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- เลือกรายการตรวจสอบ -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">เลือกรายการตรวจสอบ</h5>
                    <small class="text-muted">เลือกรายการที่ต้องการให้ปรากฏใน Log Book</small>
                </div>
                <div class="card-body">
                    <!-- ระบบเครื่องยนต์ -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="">
                                ระบบเครื่องยนต์
                            </h5>
                        </div>
                        <div class="d-flex">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">น้ำมันเครื่อง</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">น้ำหล่อเย็น</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">กรองอากาศ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">แบตเตอรี่</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2">

                    <!-- ระบบเบรก -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="">
                                ระบบเบรก
                            </h5>
                        </div>
                        <div class="d-flex">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">น้ำมันเบรก</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">ผ้าเบรก</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">จานเบรก</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                                <label class="form-check-label" for="inlineCheckbox1">เบรกมือ</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('logbook.table') }}">
                    <button type="button"
                        class="btn btn-danger p-2 d-flex align-items-center justify-content-center border-dashed">
                        ยกเลิก
                    </button>
                </a>
                <button type="submit" class="btn btn-success p-2 d-flex align-items-center justify-content-center"
                    {{ session('org_status') == 2 ? 'disabled' : '' }}>
                    <i class="bi bi-floppy me-1"></i> สร้าง logbook
                </button>
            </div>
        </form>
    </div>
    <script>
        function formBuilder() {
            return {

            }
        }
    </script>
    <style>
        #logbookTablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
