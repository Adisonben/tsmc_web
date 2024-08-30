@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-body px-md-5">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                Form submit unsuccessfully!
                            </div>
                            <script>
                                console.log("{{ session('error') }}")
                            </script>
                        @endif
                        <p class="text-center fs-5 mb-0 fw-bold">{{ $userDetail->getOrg->name }}</p>
                        <p class="text-center fs-5 fw-bold">{{ $formdata->title }}</p>
                        <form action="{{ route('form.checked.store') }}" method="post">
                            @csrf

                            <input type="hidden" name="form_id" value="{{ $formdata->id }}">

                            <div class="row row-cols-1 row-cols-md-4 mb-3">
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="empName" class="col-form-label text-nowrap">ชื่อพนักงาน</label>
                                    <input type="text" id="empName" name="empName" class="form-control" value="{{ Auth::user()->full_name }}" aria-describedby="ชื่อพนักงาน" readonly required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="position" class="col-form-label text-nowrap">ตำแหน่ง</label>
                                    <input type="text" id="position" name="position" class="form-control" value="{{ optional(Auth::user()->userDetail->getPosition)->name }}" aria-describedby="ตำแหน่ง" readonly required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="empId" class="col-form-label text-nowrap">หมายเลขพนักงาน</label>
                                    <input type="text" id="empId" name="empId" class="form-control" value="TSMC-TZ-001" aria-describedby="หมายเลขพนักงาน" required>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-md-3 mb-3">
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="department" class="col-form-label text-nowrap">แผนก</label>
                                    <input type="text" id="department" name="department" class="form-control" value="{{ optional(Auth::user()->userDetail->getDpm)->name }}" aria-describedby="ชื่อผู้ฝึกสอน" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="dob" class="col-form-label text-nowrap">วันเกิด</label>
                                    <input type="date" id="dob" name="dob" class="form-control" aria-describedby="วันที่" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="checkDate" class="col-form-label text-nowrap">วันที่</label>
                                    <input type="text" id="checkDate" class="form-control" value="{{ date('d/m/Y') }}" aria-describedby="วันที่" readonly required>
                                </div>
                            </div>
                            <p><span class="text-danger">*</span>กรุณาตอบคำถามข้างล่างโดยการเลือกตัวเลือกที่กำหนดไว้ให้</p>
                            <div>
                                <table class="table table-hover table-bordered">
                                    <thead class="text-center table-secondary">
                                        <tr>
                                            <th>เกณฑ์การพิจารณา</th>
                                            <th>ผลการตรวจสอบ</th>
                                            @if ($formdata->has_comment ?? false)
                                                <th>Comment</th>
                                            @endif
                                            {{-- <th>ผลคะแนน</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quest_groups as $group)
                                            <tr><td colspan="4">{{ $group->title }}</td></tr>
                                            @foreach ($group->questions as $index => $quest)
                                                <tr>
                                                    <td><p class="mb-0 ps-4">{{ $index + 1 }}. {{ $quest->title }}</p></td>
                                                    <td>
                                                        @foreach (optional($quest->getOption)->getOptionList ?? [] as $option)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="questid_{{ $quest->id }}" id="optionCheckFor{{ $quest->id . $option->id }}" value="{{ $option->id }}" required>
                                                                <label class="form-check-label" for="optionCheckFor{{ $quest->id . $option->id }}">{{ $option->opt_text }}</label>
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                    @if ($formdata->has_comment ?? false)
                                                        <td><input class="form-control" type="text" name="comment_{{ $quest->id }}" maxlength="200"></td>
                                                    @endif
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <button class="btn btn-success" type="submit">บันทึก</button>
                                <button class="btn btn-secondary" type="submit">กลับ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
