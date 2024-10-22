@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
                @if (session('error'))
                    <div class="alert alert-danger text-center" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            <div class="px-3 px-md-5 d-flex justify-content-center">
                <div id="exportPaper">
                    <p class="text-center fs-5 mb-0 fw-bold">{{ $formPlan?->getUser?->getOrg?->name }}</p>
                    <p class="text-center fs-5 fw-bold">{{ $formPlan?->getForm?->title }}</p>
                    @php
                        $header = json_decode($formPlan->header_data);
                        $createdDate = new Carbon\Carbon($formPlan?->created_at);
                        $form_columns = $formPlan?->getForm?->getColumns;
                        $form_lists = $formPlan?->getForm?->getLists;
                        $column_count = count($form_columns ?? []);
                        $group_name = count($form_columns ?? []) > 0 ? $form_columns[0]->group_name : '';
                    @endphp
                    <div class="d-flex gap-4 flex-wrap align-items-center mb-4">
                        <div class="">
                            <p class="mb-0">ชื่อพนักงานขับรถ : <span class="fw-bold"><u>{{ $header->driverName }}</u></span>
                            </p>
                        </div>
                        <div class="">
                            <p class="mb-0">ทะเบียนรถ : <span class="fw-bold"><u>{{ $header->carPlate }}</u></span></p>
                        </div>
                        <div class="">
                            <p class="mb-0">วันที่ : <span class="fw-bold"><u>{{ $createdDate->thaidate('j M Y') }} ถึง -
                                    </u></span></p>
                        </div>
                    </div>

                    <div>
                        <table class="table table-bordered mb-0">
                            <thead class="text-center table-secondary">
                                <tr>
                                    <th rowspan="2">รายการ</th>
                                    <th colspan="{{ $column_count }}">{{ $group_name }}</th>
                                    {{-- <th>ผลคะแนน</th> --}}
                                </tr>
                                <tr>
                                    @foreach ($form_columns ?? [] as $column)
                                        <th>{{ $column->title }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form_lists as $list)
                                    <tr>
                                        <td>{{ $list->title }}</td>
                                        @foreach ($form_columns ?? [] as $form_column)
                                            @if ($list->hasColumn($form_column->id))
                                                @php
                                                    $listColumnRecord = $list->hasColumnRecord($form_column->id);
                                                @endphp
                                                @if ($listColumnRecord ?? false)
                                                    @php
                                                        $createdDate = new Carbon\Carbon($listColumnRecord->created_at);
                                                    @endphp
                                                    <td>
                                                        <p class="text-success">{{ $createdDate->thaidate('j/m/Y') }}</p>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#checkListColumn{{ $list->id . $form_column->id }}"><i
                                                                    class="bi bi-asterisk"></i></button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="checkListColumn{{ $list->id . $form_column->id }}" tabindex="-1"
                                                                aria-labelledby="checkListColumnLabel{{ $list->id . $form_column->id }}" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="checkListColumnLabel{{ $list->id . $form_column->id }}">
                                                                                บันทึกการดำเนินการ</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form action="{{ route('formplan.check') }}" method="get">
                                                                            @csrf

                                                                            <input type="hidden" name="formplan_id" value="{{ $formPlan->id }}">
                                                                            <input type="hidden" name="column_id" value="{{ $form_column->id }}">
                                                                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                                                                            <div class="modal-body">
                                                                                <div>
                                                                                    <p class="mb-0"><b>รายการ : </b> <u>{{ $list->title }}</u></p>
                                                                                    <p><b>{{ $group_name }} : </b> <u>{{ $form_column->title }}</u></p>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="mb-3 d-flex gap-2">
                                                                                        <label for="finishDate" class="form-label text-nowrap">วันที่ดำเนินการ</label>
                                                                                        <input type="text" class="form-control" id="finishDate" value="{{ Carbon\Carbon::now()->locale('th')->thaidate('j F Y') }}" disabled>
                                                                                    </div>
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
                                                    </td>
                                                @endif
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row px-3 mt-2">
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้จัดทำ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้ตรวจสอบ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                            <div class="col-4 text-center border border-dark-subtle py-2">
                                <p>ผู้อนุมัติ</p>
                                <p class="mb-2">................................................................................</p>
                                <p>(...................................................................)</p>
                                <p class="mb-0 text-start">วันที่ : </p>
                            </div>
                        </div>
                        <footer class="text-end">
                            <p style="font-size: 10px">Printed on : TSMC at
                                {{ (new Carbon\Carbon())->format('d/m/Y G:i:s') }}</p>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="my-3 d-flex justify-content-center">
                {{-- <a href="{{ route('form.report', ['formresid' => $form_resp->id]) }}" target="_Blank" class="btn btn-primary">Print</a> --}}
                <button class="btn btn-info" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
                {{-- <button class="btn btn-success" onclick="printAsPDF()">Print</button> --}}
            </div>
        </div>
    </div>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 297mm;
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
