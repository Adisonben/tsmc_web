@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('สร้างแบบฟอร์ม') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form action="" method="post">
                                @csrf
                                    <h5 class="text-center">ข้อมูลฟอร์ม</h5>

                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">ชื่อแบบฟอร์ม</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>

                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">หมวดหมู่แบบฟอร์ม</label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>เลือกหมวดหมู่แบบฟอร์ม</option>
                                                @foreach ($form_types as $form_type)
                                                    <option value="{{ $form_type->id }}">{{ $form_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">ประเภทตัวเลือก</label>
                                            <select class="form-select" aria-label="Default select example">
                                                <option selected>เลือกประเภทตัวเลือก</option>
                                                @foreach ($opt_types as $opt_type)
                                                    <option value="{{ $opt_type->id }}">{{ $opt_type->name }}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                        <div>
                                            <label for="exampleFormControlInput1" class="form-label">คุณสมบัติฟอร์ม</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                      แสดง Comment
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                      แสดงคะแนน
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                      การตรวจสอบ
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <h5 class="text-center">รายการตรวจประเมิน</h5>

                                    <div class="card my-3">
                                        <div class="card-body">
                                            <input type="email" class="form-control mb-3 list-group-item" id="exampleFormControlInput1" placeholder="ชื่อหมวดหมู่">
                                            <ol class="list-group-numbered">
                                                <li class="list-group-item d-flex gap-3">
                                                    <input type="email" class="form-control list-group-item" id="exampleFormControlInput1" placeholder="รายการตรวจประเมิน 1">
                                                </li>
                                                <li class="list-group-item d-flex gap-3">
                                                    <input type="email" class="form-control list-group-item" id="exampleFormControlInput1" placeholder="รายการตรวจประเมิน 2">
                                                </li>
                                                <li class="list-group-item d-flex gap-3">
                                                    <input type="email" class="form-control list-group-item" id="exampleFormControlInput1" placeholder="รายการตรวจประเมิน 3">
                                                </li>
                                                <li class="list-group-item d-flex gap-3">
                                                    <input type="email" class="form-control list-group-item" id="exampleFormControlInput1" placeholder="รายการตรวจประเมิน 4">
                                                </li>
                                                <li class="list-group-item d-flex gap-3">
                                                    <input type="email" class="form-control list-group-item" id="exampleFormControlInput1" placeholder="รายการตรวจประเมิน 5">
                                                </li>
                                              </ol>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-sm btn-success">เพิ่มรายการตรวจประเมิน</button>
                                            <button type="button" class="btn btn-sm btn-danger">ลบหมวดหมู่</button>
                                        </div>
                                    </div>

                                <button type="button" class="btn btn-success mb-3">เพิ่มหมวดหมู่</button>
                                <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
