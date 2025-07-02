@extends('layouts.app')

@section('content')
    <div class="container py-4" x-data="formBuilder(@js($vehicles), '{{ $org_name }}')">
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
                            <select class="form-select" x-model="vehicle_id" id="vehicle" @change="selectedVehicle()" required>
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

                        <div class="col-md-6">
                            <label for="vehicle_type" class="form-label">ชนิดรถ</label>
                            <input type="text" class="form-control" x-model="vehicle_type" id="vehicle_type" placeholder="กรุณาเลือกรถ" readonly required>
                        </div>

                        <div class="col-md-6">
                            <label for="org_name" class="form-label">ผู้ประกอบการขนส่ง</label>
                            <input type="text" class="form-control" x-model="org_name" id="org_name" placeholder="ผู้ประกอบการขนส่ง">
                        </div>

                        <div class="col-md-6">
                            <label for="start_mileage" class="form-label">เลขไมล์เริ่มต้น</label>
                            <input type="number" class="form-control" x-model="start_mileage" id="start_mileage" placeholder="0">
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="form-label">วันที่เริ่มนับรอบ Log Book</label>
                            <input type="date" class="form-control" x-model="start_date" id="start_date" placeholder="วันที่เริ่มนับรอบ">
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
                        <h5 class="mb-2">ชุดระยะทาง (กิโลเมตร) - เลือกให้ครบ 4 ระยะ</h5>
                        <div class="row row-cols-4">
                            <template x-for="dist in distance_list" :key="dist">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            :value="dist"
                                            :id=`distance-${dist}`
                                            :disabled="selectedDistances.length >= 4 ? !selectedDistances.includes(dist) : false"
                                            @change="toggleDistance(dist)"
                                        >
                                        <label class="form-check-label" :for=`distance-${dist}` x-text="`${dist.toLocaleString()} กม.`"></label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="mb-2">
                        <h5 class="mb-2">ชุดระยะเวลา (เดือน) - เลือกให้ครบ 4 ระยะ</h5>
                        <div class="row row-cols-4">
                            <template x-for="period in period_list" :key="period">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            :value="period"
                                            :id=`period-${period}`
                                            :disabled="selectedPeriodes.length >= 4 ? !selectedPeriodes.includes(period) : false"
                                            @change="togglePeriod(period)"
                                        >
                                        <label class="form-check-label" :for=`period-${period}` x-text="`${period} เดือน`"></label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- เลือกรายการตรวจสอบ -->
            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">เลือกรายการตรวจสอบ</h5>
                    <small class="text-muted">เลือกรายการที่ต้องการให้ปรากฏใน Log Book</small>
                </div>
                <div class="card-body">
                    @foreach ($ma_categories as $cate)
                        <div class="mb-2">
                            <div class="d-flex align-items-center">
                                <h5 class="">
                                    {{ $cate->name }}
                                </h5>
                            </div>
                            <div class="d-flex flex-wrap">
                                @foreach ($cate->maItems ?? [] as $index => $item)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox{{$index}}" checked>
                                        <label class="form-check-label" for="inlineCheckbox{{$index}}">{{ $item->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="my-2">
                        </div>
                    @endforeach
                </div>
            </div> --}}

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
        function formBuilder(vehicles, user_org_name) {
            return {
                // Basic Infoemation
                vehicle_id: "",
                vehicle_type: "",
                org_name: user_org_name ? user_org_name : "",
                start_mileage: 0,
                start_date: (new Date()).toISOString().slice(0, 10),

                selectedVehicle() {
                    vehicle = vehicles.find(vehicle => vehicle.id == this.vehicle_id)
                    this.vehicle_type = vehicle ? (vehicle.type ? vehicle.type : "") : "";
                },


                // schedule conditions
                distance_list: [5000, 10000, 15000, 20000, 25000, 30000, 40000, 50000],
                period_list: [2, 4, 8, 12, 14, 16, 20, 24],
                selectedDistances: [],
                selectedPeriodes: [],
                toggleDistance(value) {
                    if (this.selectedDistances.includes(value)) {
                        this.selectedDistances = this.selectedDistances.filter(v => v !== value);
                    } else {
                        if (this.selectedDistances.length < 4) {
                            this.selectedDistances.push(value);
                        } else {
                            // alert('เลือกได้สูงสุด 4 ตัว');
                        }
                    }
                },
                togglePeriod(value) {
                    if (this.selectedPeriodes.includes(value)) {
                        this.selectedPeriodes = this.selectedPeriodes.filter(v => v !== value);
                    } else {
                        if (this.selectedPeriodes.length < 4) {
                            this.selectedPeriodes.push(value);
                        } else {
                            // alert('เลือกได้สูงสุด 4 ตัว');
                        }
                    }
                },

                handleSubmit() {
                    if (this.selectedDistances.length !== 4) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "warning",
                            title: "กรุณาเลือกชุดระยะทางให้ครบ",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        return
                    } else if (this.selectedPeriodes.length !== 4) {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "warning",
                            title: "กรุณาเลือกชุดระยะเวลาให้ครบ",
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
                            vehicle_type: this.vehicle_type,
                            org_name: this.org_name,
                            start_mileage: this.start_mileage,
                            start_date: this.start_date,

                            selectedDistances: this.selectedDistances,
                            selectedPeriodes: this.selectedPeriodes
                        };

                        fetch(`/logbook/store`, {
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
                                        window.location.href = "{{ route('logbook.table') }}";
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
            }
        }
    </script>
    <style>
        #logbookTablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
