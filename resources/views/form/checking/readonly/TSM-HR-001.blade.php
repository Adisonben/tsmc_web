@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5 d-flex justify-content-center">
                <div id="exportPaper">
                    <p class="text-center fs-5 mb-0 fw-bold">{{ $userDetail->getOrg->name }}</p>
                    <p class="text-center fs-5 fw-bold">{{ $formdata->title }}</p>
                    <form action="{{ route('form.checked.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="form_id" value="{{ $formdata->id }}">

                        <div class="d-flex flex-wrap gap-2 gap-md-4 mb-3">
                            <div class="align-items-center">
                                <p class="mb-0">ชื่อพนักงาน : <span class="fw-bold"><u>{{ $header_data->empName }}</u></span></p>
                            </div>
                            <div class="align-items-center">
                                <p class="mb-0">ตำแหน่ง : <span class="fw-bold"><u>{{ $header_data->position }}</u></span></p>
                            </div>
                            <div class="align-items-center">
                                <p class="mb-0">หมายเลขพนักงาน : <span class="fw-bold"><u>{{ $header_data->empId }}</u></span></p>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2 gap-sm-4 mb-3">
                            <div class="align-items-center">
                                <p class="mb-0">แผนก : <span class="fw-bold"><u>{{ $header_data->department }}</u></span></p>
                            </div>
                            <div class="align-items-center">
                                <p class="mb-0">วันเกิด : <span class="fw-bold"><u>{{ $header_data->dob }}</u></span></p>
                            </div>
                            <div class="align-items-center">
                                <p class="mb-0">วันที่ : <span class="fw-bold"><u>{{ $form_resp->updated_at }}</u></span></p>
                            </div>
                        </div>

                        <div>
                            <table class="table table-hover table-bordered mb-0">
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
                                                    @if ($quest->option_type == "text")
                                                        <p class="mb-0">{{ $answer->answer }}</p>
                                                    @elseif ($quest->option_type == "custom")
                                                        @if ($answer->getAnswerOption ?? false)
                                                            <p class="mb-0 {{ $answer->getAnswerOption->score ? 'text-success' : 'text-danger' }}">{{ $answer->getAnswerOption->opt_text }}</p>
                                                        @endif
                                                    @else
                                                        @if ($answer->getAnswerOption ?? false)
                                                            <p class="mb-0 {{ $answer->getAnswerOption->score ? 'text-success' : 'text-danger' }}">{{ $answer->getAnswerOption->opt_text }}</p>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $answer->comment ?? '' }}</td>
                                                {{-- <td></td> --}}
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            <footer class="text-end">
                                <p style="font-size: 10px">Printed on : TSMC Trainingzenter at {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                            </footer>
                        </div>
                    </form>
                </div>
                <div class="my-3 d-flex justify-content-center">
                    {{-- <a href="{{ route('form.report', ['formresid' => $form_resp->id]) }}" target="_Blank" class="btn btn-primary">Print</a> --}}
                    <button class="btn btn-info" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
                    {{-- <button class="btn btn-success" onclick="printAsPDF()">Print</button> --}}
                </div>
            </div>
        </div>
    </div>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 210mm;
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
