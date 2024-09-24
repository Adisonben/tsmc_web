@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ประเภทแบบฟอร์ม') }}</p>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createFormType">สร้าง</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="createFormType" data-bs-backdrop="static" tabindex="-1"
                            aria-labelledby="createFormTypeLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createFormTypeLabel">เพิ่มประเภทแบบฟอร์ม</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('form.types.store') }}" method="post">
                                        @csrf

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="formTypeName" class="form-label">ชื่อประเภทแบบฟอร์ม</label>
                                                <input type="text" class="form-control" id="formTypeName"
                                                    name="formTypeName" maxlength="200" placeholder="กรอกชื่อประเภทแบบฟอร์ม"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formTypeCode" class="form-label">รหัสประเภทแบบฟอร์ม</label>
                                                <input type="text" class="form-control" id="formTypeCode"
                                                    name="formTypeCode" maxlength="50" placeholder="กรอกรหัสประเภทแบบฟอร์ม"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formCate" class="form-label">หมวดหมู่</label>
                                                <select class="form-select" id="formCate" name="formCate"
                                                    aria-label="Default select example" required>
                                                    <option selected>เลือกหมวดหมู่</option>
                                                    @foreach ($form_cates as $form_cate)
                                                        <option value="{{ $form_cate->id }}">{{ $form_cate->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formGroup" class="form-label">กลุ่ม</label>
                                                <select class="form-select" id="formGroup" name="formGroup"
                                                    aria-label="Default select example" required>
                                                    <option selected>เลือกกลุ่ม</option>
                                                    <option value="formCheck">แบบฟอร์ม</option>
                                                    <option value="formTable">ตาราง</option>
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

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">รหัส</th>
                                    <th scope="col">ชื่อประเภท</th>
                                    <th scope="col">หมวดหมู่</th>
                                    <th scope="col">กลุ่ม</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form_types as $index => $form_type)
                                    <tr>
                                        {{-- <th scope="row">{{ $index + 1 }}</th> --}}
                                        <td>{{ $form_type->type_code ?? "-" }}</td>
                                        <td>{{ $form_type->name }}</td>
                                        <td>{{ optional($form_type->formCategory)->name }}</td>
                                        <td>{{ $form_type->form_group ? ($form_type->form_group == "formCheck" ? "แบบฟอร์ม" : "ตาราง") : '-' }}</td>
                                        <td>
                                            {{-- <button class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                data-bs-title="แก้ไข" data-bs-toggle="modal"
                                                data-bs-target="#updateFormType{{ $index }}"><i class="bi bi-pencil-square"></i></button> --}}
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateFormType{{ $form_type->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="{{ route('form.types.delete', ['ftid' => $form_type->id]) }}"
                                                type="button" class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                data-bs-title="ลบ"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="updateFormType{{ $form_type->id }}" tabindex="-1"
                                        aria-labelledby="updateFormTypeLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="updateFormTypeLabel">แก้ไขประเภทแบบฟอร์ม</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('form.types.update', ['ftid' => $form_type->id]) }}" method="post">
                                                    @csrf

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="formTypeName" class="form-label">ชื่อประเภทแบบฟอร์ม</label>
                                                            <input type="text" class="form-control" id="formTypeName" value="{{ $form_type->name }}"
                                                                name="formTypeName" maxlength="200" placeholder="กรอกชื่อประเภทแบบฟอร์ม"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formTypeCode" class="form-label">รหัสประเภทแบบฟอร์ม</label>
                                                            <input type="text" class="form-control" id="formTypeCode" value="{{ $form_type->type_code }}"
                                                                name="formTypeCode" maxlength="50" placeholder="กรอกรหัสประเภทแบบฟอร์ม"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formCate" class="form-label">หมวดหมู่</label>
                                                            <select class="form-select" id="formCate" name="formCate"
                                                                aria-label="Default select example" required>
                                                                <option selected>เลือกหมวดหมู่</option>
                                                                @foreach ($form_cates as $form_cate)
                                                                    <option value="{{ $form_cate->id }}" {{ $form_cate->id == $form_type->category ? "selected" : '' }}>{{ $form_cate->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formGroup" class="form-label">กลุ่ม</label>
                                                            <select class="form-select" id="formGroup" name="formGroup"
                                                                aria-label="Default select example" required>
                                                                <option selected>เลือกกลุ่ม</option>
                                                                <option value="formCheck" {{ $form_type->form_group == "forrmCheck" ? "selected" : '' }}>แบบฟอร์ม</option>
                                                                <option value="formTable" {{ $form_type->form_group == "formTable" ? "selected" : '' }}>ตาราง</option>
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
                </div>
            </div>
        </div>
    </div>
@endsection
