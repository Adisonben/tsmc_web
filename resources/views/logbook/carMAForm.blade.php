@extends('layouts.app')

@section('content')
    <div class="container py-4" x-data="formBuilder(@js($ma_categories))">
        <form @submit.prevent="handleSubmit" class="vstack gap-4">
            @csrf
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
                        <div class="col-md-4">
                            <label for="vehicle" class="form-label">ทะเบียนรถ<span class="text-danger">*</span></label>
                            <select class="form-select" x-model="vehicle_id" id="vehicle" required>
                                @if (count($vehicles ?? []) > 0)
                                    <option value="" selected>กรุณาเลือกรถ</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} :
                                            {{ $vehicle->brand }}</option>
                                    @endforeach
                                @else
                                    <option value="">ไม่พบรถ</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="repairDate" class="form-label">วันที่ซ่อม<span class="text-danger">*</span></label>
                            <input type="date" x-model="repair_date" class="form-control" id="repairDate" required>
                        </div>

                        <div class="col-md-4">
                            <label for="mileage" class="form-label">เลขไมล์ปัจจุบัน<span
                                    class="text-danger">*</span></label>
                            <input type="number" x-model.number="mileage" class="form-control" id="mileage"
                                placeholder="เลขไมล์" required>
                        </div>

                        <div class="col-md-6">
                            <label for="repairType" class="form-label">หมวดหมู่การซ่อม<span
                                    class="text-danger">*</span></label>
                            <select class="form-select" x-model="selected_category_id" @change="filterItems()"
                                id="repairType">
                                <template x-for="ma_cate in ma_categories" :key="ma_cate.id">
                                    <option x-text="ma_cate.name" :value="ma_cate.id">หมวดหมู่การซ่อม</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="repairType" class="form-label">ประเภทการซ่อม<span
                                    class="text-danger">*</span></label>
                            <select class="form-select" x-model="selected_item_id" id="repairType" required>
                                <template x-for="item in ma_items" :key="item.id">
                                    <option x-text="item.name" :value="item.id">หมวดหมู่การซ่อม</option>
                                </template>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="symptoms" class="form-label">อาการที่พบ/รายละเอียดการซ่อม</label>
                            <textarea class="form-control" x-model="ma_detail" id="symptoms" rows="3"
                                placeholder="อธิบายอาการและรายละเอียดการซ่อม..."></textarea>
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
                    <button type="button" class="btn btn-success btn-sm" @click="addPartRow()">
                        <i class="fas fa-plus"></i> เพิ่มรายการ
                    </button>
                </div>
                <div class="card-body">
                    <div id="partsContainer">
                        <!-- รายการอะไหล่จะถูกเพิ่มที่นี่ -->
                        <template x-for="(part, index) in parts" :key="index">
                            <div class="row g-3 mb-2">
                                <div class="col-md-3">
                                    <label class="form-label">ชื่ออะไหล่</label>
                                    <input type="text" class="form-control" placeholder="ชื่ออะไหล่" x-model="part.name">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">จำนวน</label>
                                    <input type="number" class="form-control" placeholder="จำนวน"
                                        x-model.number="part.quantity" @input="calculateTotal(index)">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ราคาต่อหน่วย</label>
                                    <input type="number" class="form-control" placeholder="ราคา"
                                        x-model.number="part.price" @input="calculateTotal(index)">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">รวม</label>
                                    <input type="text" class="form-control readonly-input" readonly
                                        :value="part.total.toFixed(2)">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">จัดการ</label>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm flex-fill"
                                            @click="removePartRow(index)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="text-end mt-3">
                        <h5 class="total-amount">รวมค่าอะไหล่: ฿<span
                                x-text="parts.reduce((sum, p) => sum + p.total, 0).toFixed(2)"></span></h5>
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
                            <input type="number" class="form-control" id="laborCost" x-model.number="repair_cost"
                                placeholder="ค่าแรง">
                        </div>

                        <div class="col-md-6">
                            <label for="technician" class="form-label">ผู้ดำเนินการซ่อม<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="technician" x-model="repair_op"
                                placeholder="ชื่อช่าง/ร้านซ่อม" required>
                        </div>

                        <div class="col-12">
                            <label for="notes" class="form-label">หมายเหตุ</label>
                            <textarea class="form-control" id="notes" x-model="note" rows="3" placeholder="หมายเหตุเพิ่มเติม..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- สรุปและบันทึก -->
            <div class="card text-bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted">รวมค่าอะไหล่: ฿<span
                                    x-text="parts.reduce((sum, p) => sum + p.total, 0).toFixed(2)"></span></p>
                            <p class="mb-1 text-muted">ค่าแรง: ฿<span id="summaryLabor" x-text="repair_cost">0</span></p>
                            <h4 class="total-amount mb-0">รวมทั้งหมด: ฿<span x-text="total_cost">0</span></h4>
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
        function formBuilder(ma_categories) {
            return {
                // Basic info
                ma_categories: ma_categories ? ma_categories : [],
                selected_category_id: ma_categories[0] ? ma_categories[0].id : "",
                ma_items: [],
                selected_item_id: "",
                vehicle_id: "",
                repair_date: (new Date()).toISOString().slice(0, 10),
                mileage: 0,
                ma_detail: "",

                filterItems() {
                    const selectedCategory = this.ma_categories.find(cate => cate.id == this.selected_category_id);
                    this.ma_items = selectedCategory ? selectedCategory.maItems : [];
                    this.selected_item_id = this.ma_items[0].id;
                },

                // Part list
                parts: [{
                    name: '',
                    quantity: 0,
                    price: 0,
                    total: 0
                }],

                addPartRow() {
                    this.parts.push({
                        name: '',
                        quantity: 0,
                        price: 0,
                        total: 0
                    });
                },

                removePartRow(index) {
                    this.parts.splice(index, 1);
                },

                calculateTotal(index) {
                    const part = this.parts[index];
                    part.total = (part.quantity || 0) * (part.price || 0);
                },


                // More info
                repair_cost: 0,
                repair_op: "",
                note: "",

                get total_cost() {
                    return (this.parts.reduce((sum, p) => sum + p.total, 0) + Number(this.repair_cost)).toFixed(2);
                },

                handleSubmit() {
                    if (!this.vehicle_id) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "warning",
                            title: "กรุณาเลือกรถ",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        return
                    } else if (!this.selected_item_id) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "warning",
                            title: "กรุณาเลือกประเภทการซ่อม",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        return
                    } else {
                        const formData = {
                            vehicle_id: this.vehicle_id,
                            repair_date: this.repair_date,
                            mileage: this.mileage,
                            item_id: this.selected_item_id,
                            repair_detail: this.ma_detail,

                            part_list: this.parts.filter((part) => part.name !== ''),

                            repair_cost: this.repair_cost,
                            repair_op: this.repair_op,
                            note: this.note
                        };

                        fetch(`/logbook/car-ma/store`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: JSON.stringify(formData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Data: ', data);
                                if (data.errors) {
                                    Swal.fire({
                                        toast: true,
                                        position: "top-end",
                                        icon: "error",
                                        title: data.errors[Object.keys(data.errors)[0]][0],
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                } else {
                                    Swal.fire(data.success ? data.success :"บันทึกสำเร็จ", "", "success").then(() => {
                                        window.location.href = "{{ route('car.ma.table') }}";
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    toast: true,
                                    position: "top-end",
                                    icon: "error",
                                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                            });
                    }
                },

                init() {
                    this.filterItems();
                },
            }
        }
    </script>
    <style>
        #carMATablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
