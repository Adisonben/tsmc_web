@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card" id="printPaper">
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

                            <div class="row g-3 align-items-center mb-4">
                                <div class="col-12 col-md-6">
                                  <p class="mb-0">ชื่อพนักงานขับรถ : <span class="fw-bold"><u>{{ $header_data->name }}</u></span></p>
                                </div>
                                <div class="col-12 col-md-6">
                                  <p class="mb-0">ตำแหน่ง : <span class="fw-bold"><u>{{ $header_data->posit }}</u></span></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="mb-0">ผู้สอบสัมภาษณ์ : <span class="fw-bold"><u>{{ $form_resp->getUser->full_name }}</u></span></p>
                                </div>
                                <div class="col-12 col-md-6">
                                  <p class="mb-0">วันที่สอบ : <span class="fw-bold"><u>{{ $form_resp->updated_at }}</u></span></p>
                                </div>
                            </div>

                            <div>
                                <table class="table table-hover table-bordered">
                                    <thead class="text-center table-secondary">
                                        <tr>
                                            <th>เกณฑ์การพิจารณา</th>
                                            <th>ผลการตรวจสอบ</th>
                                            <th>Comment</th>
                                            {{-- <th>ผลคะแนน</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quest_groups as $group)
                                            <tr><td colspan="4">{{ $group->title }}</td></tr>
                                            @foreach ($group->questions as $index => $quest)
                                                @php
                                                    $answer = App\Models\Form_answer::where('resp_id', $form_resp->id)->where('quest_id', $quest->id)->first(['answer', 'comment']);
                                                    // dd($form_resp->id, $quest->id, $answer->answer);
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}. {{ $quest->title }}</td>
                                                    <td>
                                                        @foreach (optional($quest->getOption)->getOptionList ?? [] as $option)
                                                            @if ($option->id == $answer->answer)
                                                                <p class="{{ $option->score ? 'text-success' : 'text-danger' }}">{{ $option->opt_text }}</p>
                                                            @endif
                                                            {{-- <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="questid_{{ $quest->id }}" id="optionCheckFor{{ $quest->id . $option->id }}" {{ $option->id == $answer->answer ? 'checked' : '' }}  value="{{ $option->id }}" required disabled>
                                                                <label class="form-check-label" for="optionCheckFor{{ $quest->id . $option->id }}">{{ $option->opt_text }}</label>
                                                            </div> --}}
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $answer->comment ?? '' }}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="my-3 d-flex justify-content-center">
                    <a href="{{ route('form.report', ['formresid' => $form_resp->id]) }}" target="_Blank" class="btn btn-primary">Print</a>
                    {{-- <button class="btn btn-success" onclick="printAsPDF()">Print</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
