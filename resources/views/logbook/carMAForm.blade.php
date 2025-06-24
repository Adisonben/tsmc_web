@extends('layouts.app')

@section('content')
    <div class="container py-4" x-data="formBuilder()">
        <form @submit.prevent="handleSubmit" class="vstack gap-4">
            <div class="text-center fs-4 fw-bold">
                ฟอร์มบันทึกการบำรุงรักษารถ
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
                            <label for="repairDate" class="form-label">วันที่ซ่อม</label>
                            <input type="date" class="form-control" id="repairDate" required>
                        </div>

                        <div class="col-md-6">
                            <label for="mileage" class="form-label">เลขไมล์ปัจจุบัน</label>
                            <input type="number" class="form-control" id="mileage" placeholder="เลขไมล์">
                        </div>

                        <div class="col-md-6">
                            <label for="repairType" class="form-label">ประเภทการซ่อม</label>
                            <select class="form-select" id="repairType" required>
                                <option value="">เลือกประเภทการซ่อม</option>
                                <option value="เครื่องยนต์">เครื่องยนต์</option>
                                <option value="เบรก">เบรก</option>
                                <option value="แอร์">แอร์</option>
                                <option value="ไฟฟ้า">ไฟฟ้า</option>
                                <option value="ช่วงล่าง">ช่วงล่าง</option>
                                <option value="อื่นๆ">อื่นๆ</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="symptoms" class="form-label">อาการที่พบ/รายละเอียดการซ่อม</label>
                            <textarea class="form-control" id="symptoms" rows="3" placeholder="อธิบายอาการและรายละเอียดการซ่อม..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- รายการอะไหล่ -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">รายการอะไหล่ที่ใช้</h5>
                        <small class="text-muted">เพิ่มรายการอะไหล่และค่าใช้จ่าย</small>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="addPartRow()">
                        <i class="fas fa-plus"></i> เพิ่มรายการ
                    </button>
                </div>
                <div class="card-body">
                    <div id="partsContainer">
                        <!-- รายการอะไหล่จะถูกเพิ่มที่นี่ -->
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">ชื่ออะไหล่</label>
                                <input type="text" class="form-control" placeholder="ชื่ออะไหล่" data-field="name">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">จำนวน</label>
                                <input type="number" class="form-control" placeholder="จำนวน" data-field="quantity"
                                    oninput="calculatePartTotal(${partCounter})">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ราคาต่อหน่วย</label>
                                <input type="number" class="form-control" placeholder="ราคา" data-field="price"
                                    oninput="calculatePartTotal(${partCounter})">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">รวม</label>
                                <input type="text" class="form-control readonly-input" readonly data-field="total"
                                    value="0">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">จัดการ</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm flex-fill"
                                        onclick="removePartRow(${partCounter})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <h5 class="total-amount">รวมค่าอะไหล่: ฿<span id="totalParts">0</span></h5>
                    </div>
                </div>
            </div>

            <!-- ข้อมูลเพิ่มเติม -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">ข้อมูลเพิ่มเติม</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="laborCost" class="form-label">ค่าแรง</label>
                            <input type="number" class="form-control" id="laborCost" placeholder="ค่าแรง"
                                oninput="updateTotalCost()">
                        </div>

                        <div class="col-md-6">
                            <label for="technician" class="form-label">ผู้ดำเนินการซ่อม</label>
                            <input type="text" class="form-control" id="technician" placeholder="ชื่อช่าง/ผู้ซ่อม">
                        </div>

                        <div class="col-12">
                            <label for="notes" class="form-label">หมายเหตุ</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="หมายเหตุเพิ่มเติม..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- สรุปและบันทึก -->
            <div class="card text-bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted">รวมค่าอะไหล่: ฿<span id="summaryParts">0</span></p>
                            <p class="mb-1 text-muted">ค่าแรง: ฿<span id="summaryLabor">0</span></p>
                            <h4 class="total-amount mb-0">รวมทั้งหมด: ฿<span id="grandTotal">0</span></h4>
                        </div>
                        <div class="d-flex flex-column gap-1">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>บันทึกข้อมูล
                            </button>
                            <a href="{{ route('car.ma.table') }}" class="btn btn-danger btn-lg">
                                <i class="fas fa-save me-2"></i>ยกเลิก
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('car.ma.table') }}">
                    <button type="button"
                        class="btn btn-danger p-2 d-flex align-items-center justify-content-center border-dashed">
                        ยกเลิก
                    </button>
                </a>
                <button type="submit" class="btn btn-success p-2 d-flex align-items-center justify-content-center"
                    {{ session('org_status') == 2 ? 'disabled' : '' }}>
                    <i class="bi bi-floppy me-1"></i> บันทึกฟอร์ม
                </button>
            </div> --}}
        </form>
    </div>
    <script>
        function formBuilder() {
            return {

            }
        }
    </script>
    <style>
        #carMATablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
