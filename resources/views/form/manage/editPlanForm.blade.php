@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขแบบแผน') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div>
                            {{-- @if ($error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif --}}
                            <form action="{{ route('form.plan.store') }}" method="post">
                                @csrf
                                <h5 class="text-center">ข้อมูลแผน</h5>

                                <div class="d-flex flex-wrap gap-3 mb-2">
                                    <div class="flex-fill">
                                        <label for="formName" class="form-label">ชื่อแบบแผน</label>
                                        <input type="text" class="form-control" maxlength="200" id="formName" name="formName" required value="{{ $form->title }}"
                                            placeholder="กรอกชื่อแบบแผน">
                                    </div>
                                    <div class="flex-fill">
                                        <label class="form-label">หมวดหมู่แบบแผน</label>
                                        <select class="form-select" aria-label="Default select example" name="formType" required>
                                            <option disabled>เลือกหมวดหมู่แบบแผน</option>
                                            @foreach ($form_types as $form_type)
                                                <option value="{{ $form_type->id }}" {{ $form_type->id == $form->type ? "selected" : '' }}>{{ $form_type->type_code ?? '' }} : {{ $form_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div>
                                        <label class="form-label">คุณสมบัติแผน</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="approveCheck" name="approveCheck">
                                                <label class="form-check-label" for="approveCheck">
                                                    การตรวจสอบ
                                                </label>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <hr>
                                <div class="flex-fill">
                                    <label for="formName" class="form-label">ชื่อหมวดหมู่คอลัมน์</label>
                                    <input type="text" class="form-control" maxlength="200" id="formName" name="columnGroupName" required value=""
                                        placeholder="กรอกชื่อหมวดหมู่คอลัมน์">
                                </div>
                                <div>
                                    <p>รายการคอลัมน์</p>
                                    <ol class="list-group-numbered columnContainer">
                                        <li class="list-group-item d-flex gap-2 mb-2">
                                            <input type="text" class="form-control" name="column[]" placeholder="กรอกชื่อคอลัมน์" required>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="delColumnBtn(this)"><i class="bi bi-x"></i></button>
                                        </li>
                                    </ol>
                                </div>
                                <button type="button" class="btn btn-success mb-3" onclick="addColumn(this)">เพิ่มคอลัมน์</button>
                                <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
                            </form>
                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="text-center">ตัวอย่างแบบแผน</h5>

                <div>
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2">รายการ</th>
                                <th colspan="4">(ชื่อหมวดหมู่คอลัมน์)</th>
                            </tr>
                            <tr>
                                <th scope="col">(คอลัมน์ 1)</th>
                                <th scope="col">(คอลัมน์ 2)</th>
                                <th scope="col">(คอลัมน์ 3)</th>
                                <th scope="col">(คอลัมน์ 4)</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function addColumn(element){
            console.log('addColumnBtn');
            $('.columnContainer').append(`
                <li class="list-group-item d-flex gap-2 mb-2">
                    <input type="text" class="form-control" name="column[]" placeholder="กรอกชื่อคอลัมน์" required>
                    <button type="button" class="btn btn-sm btn-danger" onclick="delColumnBtn(this)"><i class="bi bi-x"></i></button>
                </li>
            `);
        }

        function delColumnBtn(element) {
            console.log("removeBtn");
            const optionItem = element.closest('li');
            optionItem.remove();
        }
    </script>
    <style>
        li {
            counter-increment: list-item;
            list-style: none;
        }
    </style>
@endsection
