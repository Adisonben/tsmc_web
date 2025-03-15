@extends('layouts.app')

@section('content')
    <div x-data="exportData()">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">ออกรายงานเอกสาร</p>
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

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-4">
                            <div class="">
                                <label for="cateSelect" class="form-label">หมวดหมู่</label>
                                <select class="form-select" id="cateSelect" x-model="filter_form_cate" @change="fetchForms()">
                                    <option value="" selected disabled>เลือกหมวดหมู่</option>
                                    @foreach ($form_cates as $form_cate)
                                        <option value="{{ $form_cate->id }}">{{ $form_cate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="formSelect" class="form-label">แบบฟอร์ม</label>
                                <select class="form-select" id="formSelect" x-model="filter_form_id" @change="getFilteredForm()">
                                    <option selected value="" disabled>เลือกแบบฟอร์ม</option>
                                    <template x-for="form in form_datas" :key="form.id">
                                        <option x-text="form.title" :value="form.id"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="">
                                <label for="vehicleSelect" class="form-label">ยานพาหนะ</label>
                                <select class="form-select" id="vehicleSelect" x-model="filter_vehicle_id">
                                    <option selected value="">ยานพาหนะทั้งหมด</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="userSelect" class="form-label">พนักงาน</label>
                                <select class="form-select" id="userSelect" x-model="filter_user_id">
                                    <option selected value="" >พนักงานทั้งหมด</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->fname }} {{ $user->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-auto">
                              <label for="startDate" class="col-form-label">ตั้งแต่วันที่</label>
                            </div>
                            <div class="col-auto">
                              <input type="date" id="startDate" class="form-control" x-model="filter_start_date">
                            </div>
                            <div class="col-auto">
                              <label for="endDate" class="col-form-label">ถึงวันที่</label>
                            </div>
                            <div class="col-auto">
                              <input type="date" id="endDate" class="form-control" x-model="filter_end_date">
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="startDate" class="col-form-label">แสดงข้อมูลทั่วไป</label>
                            </div>
                            <div class="col-auto d-flex flex-wrap gap-4">
                                <template x-for="field in default_fields" :key="field.name">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" :id="field.name" x-model="field.is_checked">
                                        <label class="form-check-label" :for="field.name" x-text="field.label"></label>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="startDate" class="col-form-label">แสดงข้อมูลรถ</label>
                            </div>
                            <div class="col-auto d-flex flex-wrap gap-4">
                                <template x-for="field in vehicle_fields" :key="field.name">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" :id="field.name" x-model="field.is_checked">
                                        <label class="form-check-label" :for="field.name" x-text="field.label"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="startDate" class="col-form-label">แสดงข้อมูลพนักงาน</label>
                            </div>
                            <div class="col-auto d-flex flex-wrap gap-4">
                                <template x-for="field in user_fields" :key="field.name">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" :id="field.name" x-model="field.is_checked">
                                        <label class="form-check-label" :for="field.name" x-text="field.label"></label>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="window.print()"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
                        <button class="btn btn-primary" @click="exportToExcel()"><i class="bi bi-file-earmark-excel"></i> Excel</button>
                        <button class="btn btn-success" id="searchBtn" @click="fetchDocs()"><i class="bi bi-search"></i> ค้นหา</button>
                    </div>
                </div>


                <hr>
                <p class="text-center">ตัวอย่างเอกสาร</p>
                <hr>

                {{-- Table --}}
                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        <p class="text-center fs-5 mb-0 fw-bold">{{ Auth()->user()->userDetail->getOrg->name ?? "-" }}</p>
                        <p class="text-center fs-5 mb-0 fw-bold">รายงานบันทึกประวัติ</p>
                        <p class="text-center fs-5" x-text="form_filtered_data.title"></p>
                        <div id="dataTable" class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-nowrap" rowspan="2" >ลำดับ</th>
                                        <template x-for="field in default_fields" :key="field.name">
                                            <template x-if="field.is_checked">
                                                <th rowspan="2" x-text="field.label"></th>
                                            </template>
                                        </template>
                                        <template x-for="field in vehicle_fields" :key="field.name">
                                            <template x-if="field.is_checked">
                                                <th rowspan="2" x-text="field.label"></th>
                                            </template>
                                        </template>
                                        <template x-for="field in user_fields" :key="field.name">
                                            <template x-if="field.is_checked">
                                                <th rowspan="2" x-text="field.label"></th>
                                            </template>
                                        </template>
                                        <template x-for="field in form_fields" :key="field.id">
                                            <th x-text="field.label" :rowspan="field.type === 'subform' ? '1' : '2'" :colspan="field.subformfields.length > 0 ? field.subformfields.length : '1'"></th>
                                        </template>
                                    </tr>
                                    <tr>
                                        <template x-for="subfield in form_subfields" :key="subfield.id">
                                            <th x-text="subfield.label" rowspan="1"></th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-if="doc_datas.length !== 0" >
                                        <template x-for="(doc, index) in doc_datas" :key="doc.id">
                                            <tr>
                                                <td x-text="index + 1"></td>
                                                <template x-for="field in default_fields" :key="field.name">
                                                    <template x-if="field.is_checked">
                                                        <th x-text="doc[field.name]"></th>
                                                    </template>
                                                </template>
                                                <template x-for="field in vehicle_fields" :key="field.name">
                                                    <template x-if="field.is_checked">
                                                        <th x-text="doc.vehicle[field.name]"></th>
                                                    </template>
                                                </template>
                                                <template x-for="field in user_fields" :key="field.name">
                                                    <template x-if="field.is_checked">
                                                        <th x-text="doc.user[field.name]"></th>
                                                    </template>
                                                </template>
                                                {{-- <td x-text="doc.created_at"></td> --}}
                                                {{-- <td x-text="doc.vehicle.license_plate"></td>
                                                <td x-text="doc.user.name"></td> --}}
                                                <template x-for="answer in doc.answerValue" :key="answer.field_id">
                                                    <td x-text="answer.value ? answer.value : '-'"></td>
                                                </template>
                                            </tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-end" style="font-size: 10px">print on TSMC at {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        function exportData() {
            return {
                doc_datas: [],
                form_datas: [],

                filter_form_cate: '',
                filter_form_id: '',
                filter_vehicle_id: '',
                filter_user_id: '',
                filter_start_date: '',
                filter_end_date: '',

                form_filtered_data: [],
                form_fields: [],
                form_subfields: [],
                all_field_count: 0,

                default_fields: [
                    {
                        label: 'วันที่',
                        name: 'created_at',
                        is_checked: true,
                    },
                ],

                vehicle_fields: [
                    {
                        label: 'หมวดทะเบียนรถ',
                        name: 'license_category',
                        is_checked: false,
                    },
                    {
                        label: 'เลขทะเบียนรถ',
                        name: 'license_plate',
                        is_checked: false,
                    },
                    {
                        label: 'จังหวัดที่จดทะเบียน',
                        name: 'registration_province',
                        is_checked: false,
                    },
                    {
                        label: 'ยี่ห้อรถ',
                        name: 'brand',
                        is_checked: false,
                    },
                    {
                        label: 'ลักษณะ/มาตรฐาน',
                        name: 'standard',
                        is_checked: false,
                    },
                    {
                        label: 'ประเภทรถ',
                        name: 'type',
                        is_checked: false,
                    },
                    {
                        label: 'บริษัทประกันภัย',
                        name: 'ins_company',
                        is_checked: false,
                    },
                    {
                        label: 'ประเภทประกันภัย',
                        name: 'ins_type',
                        is_checked: false,
                    },
                ],

                user_fields: [
                    {
                        label: 'ชื่อพนักงาน',
                        name: 'fname',
                        is_checked: false,
                    },
                    {
                        label: 'นามสกุลพนักงาน',
                        name: 'lname',
                        is_checked: false,
                    },
                    {
                        label: 'เลขประจำตัวประชาชน',
                        name: 'citizen_id',
                        is_checked: false,
                    },
                ],

                setVehicle_fields($status) {
                    this.vehicle_fields.forEach((field) => {
                        field.is_checked = $status ?? false;
                    });
                },

                setUser_fields($status) {
                    this.user_fields.forEach((field) => {
                        field.is_checked = $status ?? false;
                    });
                },

                getFilteredForm() {
                    this.form_filtered_data = this.form_datas.find((form) => {
                        return form.id == this.filter_form_id;
                    });
                    this.setUser_fields(this.form_filtered_data.select_user == 1 ? true : false);
                    this.setVehicle_fields(this.form_filtered_data.select_vehicle == 1 ? true : false);
                    // if (this.form_filtered_data.select_user ?? false) {
                    //     this.enableUser_fields();
                    // }
                    // if (this.form_filtered_data.select_vehicle ?? false) {
                    //     this.enableVehicle_fields();
                    // }
                    this.form_fields = this.form_filtered_data.fields;
                    // const subfield = this.form_filtered_data.fields.find((field) => {
                    //     return field.type === 'subform';
                    // });
                    // this.form_subfields = subfield ? subfield.subformfields : [];
                    const subfield2 = this.form_filtered_data.fields.filter((field) => {
                        return field.type === 'subform';
                    });
                    const form_subfields2 = subfield2.map((field) => {
                        return field.subformfields;
                    });
                    this.form_subfields = form_subfields2.map(obj => Object.values(obj)).flat();
                    // console.log(this.form_subfields, form_subfields2.map(obj => Object.values(obj)).flat());
                    this.all_field_count = this.form_fields.length + this.form_subfields.length;
                },

                fetchForms() {
                    $.ajax({
                        url: '/api/form/getFormByCate/' + this.filter_form_cate,
                        type: 'GET',
                        success: (res) => {
                            console.log(res);
                            if (res.length == 0) {
                                this.form_datas = [];
                                this.filter_form_id = '';
                                this.form_filtered_data = [];
                                return;
                            }
                            this.form_datas = res;
                        },
                        error: (err) => {
                            this.form_datas = [];
                            this.filter_form_id = '';
                            console.log(err);
                        }
                    });
                },

                fetchDocs() {
                    let params = new URLSearchParams({
                        form_id: this.filter_form_id,
                        vehicle_id: this.filter_vehicle_id || '',
                        user_id: this.filter_user_id || '',
                        start_date: this.filter_start_date || '',
                        end_date: this.filter_end_date || ''
                    });

                    $.ajax({
                        url: `/api/document/getDocs?${params.toString()}`,
                        type: 'GET',
                        success: (res) => {
                            // console.log(res)
                            if (res.length == 0) {
                                this.doc_datas = [];
                                Swal.fire({
                                    toast: true,
                                    position: "top-end",
                                    icon: "warning",
                                    title: "ไม่พบข้อมูล",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                return;
                            }

                            this.doc_datas = res;
                        },
                        error: (err) => {
                            // this.doc_datas = [];
                            console.log(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'กรุณาลองใหม่อีกครั้ง'
                            });
                        }
                    });
                },

                exportToExcel() {
                    // let table = document.querySelector("table"); // Get the table element
                    // let wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"}); // Convert table to Excel workbook
                    // XLSX.writeFile(wb, "exported_table.xlsx"); // Save as Excel file
                    // console.log(all_fields)
                    const query = new URLSearchParams({
                        form_id: this.filter_form_id,
                        start_date: this.filter_start_date,
                        end_date: this.filter_end_date,
                        vehicle_id: this.filter_vehicle_id || '',
                        user_id: this.filter_user_id || '',
                        default_fields: JSON.stringify(this.default_fields),
                        vehicle_fields: JSON.stringify(this.vehicle_fields),
                        user_fields: JSON.stringify(this.user_fields),
                        form_fields: JSON.stringify(this.form_fields),
                    }).toString();

                    // Redirect to export route with filters
                    // window.location.href = `/export-document?${query}`;
                    window.open(`/export-document?${query}`, '_blank');

                }
            }
        }
    </script>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 100%;
        }

        @media print {
            body {
                visibility: hidden;
            }
            #exportPaper {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                color: black;
            }
        }
    </style>
@endsection
