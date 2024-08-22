@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Cars table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ตำแหน่ง') }}</p>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createCarModal">
                                เพิ่ม
                            </button>
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
                                <form action="{{ route('cars.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="platNum" class="form-label">หมายเลขทะเบียนรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="platNum"
                                                name="platNum" placeholder="กรุณากรอกหมายเลขทะเบียนรถ" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="model" class="form-label">ยี่ห้อรถ</label>
                                            <input type="text" class="form-control" maxlength="150" id="model"
                                                name="model" placeholder="กรุณากรอกยี่ห้อรถ" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="carType" class="form-label">ประเภทรถ</label>
                                            <select class="form-select" aria-label="Default select example" id="carType"
                                                name="carType" required>
                                                <option selected value="-">ไม่ทราบ</option>
                                                @foreach ($car_types as $car_type)
                                                    <option value="{{ $car_type->id }}">{{ $car_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="carGear" class="form-label">ระบบเกียร์</label>
                                            <select class="form-select" aria-label="Default select example" id="carGear"
                                                name="carGear" required>
                                                <option value="ธรรมดา">ธรรมดา</option>
                                                <option value="ออโต้">ออโต้</option>
                                            </select>
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


                    <div class="card-body">
                        @if (session('carSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('carSuccess') }}
                            </div>
                        @elseif (session('carError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('carError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">หมายเลขทะเบียน</th>
                                    <th scope="col">ยี่ห้อรถ</th>
                                    <th scope="col">ประเภทรถ</th>
                                    <th scope="col">ระบบเกียร์</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cars as $index => $car)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $car->plate_num }}</td>
                                        <td>{{ $car->model }}</td>
                                        <td>{{ $car->car_type }}</td>
                                        <td>{{ $car->gear_type }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateCarModal{{ $index }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                                del-id="{{ $car->id }}" del-target="cars" data-bs-toggle="tooltip"
                                                data-bs-title="ลบ"><i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Update Modal -->
                                    <div class="modal fade" id="updateCarModal{{ $index }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateCarModalLabel{{ $index }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateCarModalLabel{{ $index }}">แก้ไขตำแหน่ง
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('cars.update.post', ['car' => $car->id]) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="platNum" class="form-label">หมายเลขทะเบียนรถ</label>
                                                            <input type="text" class="form-control" maxlength="150" id="platNum" value="{{ $car->plate_num }}"
                                                                name="platNum" placeholder="กรุณากรอกหมายเลขทะเบียนรถ" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="model" class="form-label">ยี่ห้อรถ</label>
                                                            <input type="text" class="form-control" maxlength="150" id="model" value="{{ $car->model }}"
                                                                name="model" placeholder="กรุณากรอกยี่ห้อรถ" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="carType" class="form-label">ประเภทรถ</label>
                                                            <select class="form-select" aria-label="Default select example" id="carType"
                                                                name="carType" required>
                                                                    <option selected value="-">ไม่ทราบ</option>
                                                                @foreach ($car_types as $car_type)
                                                                    <option value="{{ $car_type->id }}" {{ $car->car_type == $car_type->id ? 'selected' : '' }}>{{ $car_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="carGear" class="form-label">ระบบเกียร์</label>
                                                            <select class="form-select" aria-label="Default select example" id="carGear"
                                                                name="carGear" required>
                                                                <option value="ธรรมดา" {{ $car->gear_type === "ธรรมดา" ? 'selected' : '' }}>ธรรมดา</option>
                                                                <option value="ออโต้" {{ $car->gear_type === "ออโต้" ? 'selected' : '' }}>ออโต้</option>
                                                            </select>
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
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
            </div>
        </div>
    </div>
@endsection
