@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Cars table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลรถ') }}</p>
                            <div>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#createCarModal">
                                    <i class="bi bi-plus"></i> เพิ่ม
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#importCarModal">
                                    <i class="bi bi-arrow-down"></i> นำเข้าข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Create Modal -->
                    <div class="modal fade" id="createCarModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="createCarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="createCarModalLabel">เพิ่มข้อมูลรถ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('vehicles.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="license_category" class="form-label">หมวดทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="license_category"
                                                name="license_category" placeholder="เช่น กก, 10-99" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="license_plate" class="form-label">หมายเลขทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="license_plate"
                                                name="license_plate" placeholder="เช่น กข-1111, 98-9559" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registration_province"
                                                class="form-label">จังหวัดที่จดทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150"
                                                id="registration_province" name="registration_province"
                                                placeholder="กรุณากรอก จังหวัดที่จดทะเบียนรถ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="brand" class="form-label">ยี่ห้อรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="brand"
                                                name="brand" placeholder="เช่น Benz, ISUZU" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="standard" class="form-label">ลักษณะ/มาตรฐาน (หากไม่มีกรอก -)</label>
                                            <input type="text" class="form-control" maxlength="150" id="standard"
                                                name="standard" placeholder="เช่น 2ข, 3ก" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="type" class="form-label">ประเภทรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="type"
                                                name="type" placeholder="เช่น รถ 6 ล้อ, รถบรรทุกวัสดุอันตราย" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ins_company" class="form-label">บริษัทประกันภัย</label>
                                            <input type="text" class="form-control" maxlength="150" id="ins_company"
                                                name="ins_company" placeholder="กรุณากรอก บริษัทประกันภัย รถ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ins_type" class="form-label">ประเภทประกันภัย</label>
                                            <input type="text" class="form-control" maxlength="150" id="ins_type"
                                                name="ins_type" placeholder="เช่น ชั้น1" required>
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

                    <!-- Import Modal -->
                    <div class="modal fade" id="importCarModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="importCarModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="importCarModalLabel">นำเข้าข้อมูลรถ</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="border-l-4 border-blue-500 p-4 mb-4 rounded" style="background-color: rgb(160, 255, 255)">
                                        <div>
                                            <h5 class="flex items-center text-blue-800 mb-2">
                                                <i class="bi bi-exclamation-circle"></i>
                                                คำแนะนำการนำเข้าข้อมูล
                                            </h5>
                                            <p class="text-blue-700 mb-2">กรุณาจัดทำข้อมูลให้ตรงตาม template ที่กำหนด
                                                เพื่อป้องกันความผิดพลาดในการนำเข้าข้อมูล</p>
                                            <ul>
                                                <li>- ข้อมูลจะต้องอยู่ในรูปแบบไฟล์ Excel (.xlsx หรือ .xls)</li>
                                                <li>- ข้อมูลจะต้องมีหัวตารางตรงตาม template</li>
                                                <li>- ห้ามลบหรือเพิ่มคอลัมน์ในไฟล์ template</li>
                                                <li>- ห้ามมีช่องว่างในข้อมูลที่จำเป็นต้องกรอก</li>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <p class="mb-0">ดาวน์โหลด Template สำหรับกรอกข้อมูล</p>
                                            <a href="#" class="btn btn-primary text-white px-4 py-2 rounded inline-flex items-center">
                                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                                ดาวน์โหลด Excel Template
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="button" class="btn btn-primary">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body overflow-auto">
                        @if (session('vehicleSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('vehicleSuccess') }}
                            </div>
                        @elseif (session('vehicleError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('vehicleError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">หมวดทะเบียน</th>
                                    <th scope="col">หมายเลขทะเบียน</th>
                                    <th scope="col">จังหวัดที่จดทะเบียน</th>
                                    <th scope="col">ยี่ห้อรถ</th>
                                    <th scope="col">ประเภทรถ</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($vehicles ?? []) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @else
                                    @foreach ($vehicles as $index => $vehicle)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $vehicle->license_category }}</td>
                                            <td>{{ $vehicle->license_plate }}</td>
                                            <td>{{ $vehicle->registration_province }}</td>
                                            <td>{{ $vehicle->brand }}</td>
                                            <td>{{ $vehicle->type }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateCarModal{{ $index }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                                    del-id="{{ $vehicle->id }}" del-target="vehicles"
                                                    data-bs-toggle="tooltip" data-bs-title="ลบ"><i
                                                        class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Update Modal -->
                                        <div class="modal fade" id="updateCarModal{{ $index }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="updateCarModalLabel{{ $index }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="updateCarModalLabel{{ $index }}">แก้ไขตำแหน่ง
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('vehicle.update', ['id' => $vehicle->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="license_category"
                                                                    class="form-label">หมวดทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->license_category }}"
                                                                    maxlength="150" id="license_category"
                                                                    name="license_category"
                                                                    placeholder="กรุณากรอก หมวดทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="license_plate"
                                                                    class="form-label">หมายเลขทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->license_plate }}" maxlength="150"
                                                                    id="license_plate" name="license_plate"
                                                                    placeholder="กรุณากรอก หมายเลขทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="registration_province"
                                                                    class="form-label">จังหวัดที่จดทะเบียนรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->registration_province }}"
                                                                    maxlength="150" id="registration_province"
                                                                    name="registration_province"
                                                                    placeholder="กรุณากรอก จังหวัดที่จดทะเบียนรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="brand" class="form-label">ยี่ห้อรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->brand }}" maxlength="150"
                                                                    id="brand" name="brand"
                                                                    placeholder="กรุณากรอก ยี่ห้อ รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="standard"
                                                                    class="form-label">ลักษณะ/มาตรฐาน</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->standard }}" maxlength="150"
                                                                    id="standard" name="standard"
                                                                    placeholder="กรุณากรอก ลักษณะ/มาตรฐาน รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="type" class="form-label">ประเภทรถ</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->type }}" maxlength="150"
                                                                    id="type" name="type"
                                                                    placeholder="กรุณากรอก ประเภทรถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="ins_company"
                                                                    class="form-label">บริษัทประกันภัย</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->ins_company }}" maxlength="150"
                                                                    id="ins_company" name="ins_company"
                                                                    placeholder="กรุณากรอก บริษัทประกันภัย รถ" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="ins_type"
                                                                    class="form-label">ประเภทประกันภัย</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $vehicle->ins_type }}" maxlength="150"
                                                                    id="ins_type" name="ins_type"
                                                                    placeholder="กรุณากรอก ประเภทประกันภัย รถ" required>
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
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
            </div>
        </div>
    </div>
@endsection
