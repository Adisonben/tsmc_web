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

                            <div class="mb-3 d-flex gap-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                      <label for="driver" class="col-form-label">พนักงานขับรถ</label>
                                    </div>
                                    <div class="col-auto">
                                      <input type="text" id="driver" class="form-control" value="{{ Auth::user()->full_name }}" aria-describedby="พนักงานขับรถ" readonly>
                                      <input type="hidden" name="driver" value="{{ Auth::user()->id }}">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                      <label for="car_plate" class="col-form-label">ทะเบียนรถ</label>
                                    </div>
                                    <div class="col-auto">
                                      <input type="text" id="car_plate" name="car_plate" class="form-control" value="" aria-describedby="ทะเบียนรถ">
                                    </div>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                      <label for="checkDate" class="col-form-label">วันที่</label>
                                    </div>
                                    <div class="col-auto">
                                        <input type="text" id="checkDate" class="form-control" value="{{ date('d/m/Y') }}" aria-describedby="วันที่สอบ" readonly required>
                                    </div>
                                </div>
                            </div>

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
