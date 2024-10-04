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
                                    <label for="driverName" class="col-form-label text-nowrap">ชื่อพนักงานขับรถ</label>
                                    <input type="text" id="driverName" name="driverName" class="form-control" value="" aria-describedby="ชื่อพนักงานขับรถ" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="position" class="col-form-label text-nowrap">ตำแหน่ง</label>
                                    <input type="text" id="position" name="position" class="form-control" value="" aria-describedby="ตำแหน่ง" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="checkDate" class="col-form-label text-nowrap">วันที่</label>
                                    <input type="text" id="checkDate" class="form-control" value="{{ date('d/m/Y') }}" aria-describedby="วันที่" readonly required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="location" class="col-form-label text-nowrap">สถานที่</label>
                                    <input type="text" id="location" name="location" class="form-control" value="" aria-describedby="สถานที่" required>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-md-3 mb-3">
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="trainerName" class="col-form-label text-nowrap">ชื่อผู้ฝึกสอน</label>
                                    <input type="text" id="trainerName" name="trainerName" class="form-control" value="{{ Auth::user()->full_name }}" aria-describedby="ชื่อผู้ฝึกสอน" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="carInfo" class="col-form-label text-nowrap">ยานยนต์</label>
                                    <input type="text" id="carInfo" name="carInfo" class="form-control" value="" aria-describedby="ยานยนต์" required>
                                </div>
                                <div class="col d-flex gap-2 align-items-center">
                                    <label for="number" class="col-form-label text-nowrap">เลขที่</label>
                                    <input type="text" id="number" name="number" class="form-control" value="" aria-describedby="เลขที่" required>
                                </div>
                            </div>
                            <p><span class="text-danger">*</span>ก่อนการขับรถผู้ฝึกสอนจะต้องอธิบายอุปกรณ์ควบคุมต่าง ๆ เครื่องยนต์และเกียร์ของรถ</p>
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
                                            <tr>
                                                <td colspan="4">
                                                    <div>{{ $group->title }}</div>
                                                    @if ($group->group_type == "image")
                                                        <div class="d-flex justify-content-center">
                                                            <img class="image-preview" src="/uploads/formImage/{{ $group->content }}" alt="ภาพ" height="250">
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
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
                                <a href="{{ route('form.checking.type') }}" class="btn btn-secondary" >กลับ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
