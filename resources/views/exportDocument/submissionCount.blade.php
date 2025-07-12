@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('รายงานการกรอกแบบฟอร์ม') }}</p>
                            @if (session('wrSuccess'))
                                <div class="alert alert-success m-0 p-2 ms-2" role="alert">
                                    {{ session('wrSuccess') }}
                                </div>
                            @elseif (session('wrError'))
                                <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                                    {{ session('wrError') }}
                                </div>
                            @elseif ($errors->any())
                                <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="d-flex align-items-center">
                                @php
                                    $currentdate = Carbon\Carbon::now();
                                @endphp
                                <p class="text-nowrap me-2 mb-0">เลือกไตรมาส</p>
                                <select name="quarter" class="form-control me-2 border-2 border-primary">
                                    <option value="1" {{ $quarter == 1 ? 'selected' : '' }}>ไตรมาสที่ 1 ปี
                                        {{ $currentdate->thaidate('Y') }}</option>
                                    <option value="2" {{ $quarter == 2 ? 'selected' : '' }}>ไตรมาสที่ 2 ปี
                                        {{ $currentdate->thaidate('Y') }}</option>
                                    <option value="3" {{ $quarter == 3 ? 'selected' : '' }}>ไตรมาสที่ 3 ปี
                                        {{ $currentdate->thaidate('Y') }}</option>
                                    <option value="4" {{ $quarter == 4 ? 'selected' : '' }}>ไตรมาสที่ 4 ปี
                                        {{ $currentdate->thaidate('Y') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body overflow-auto">
                        <table class="table table-bordered border-secondary">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col" style="background-color: #E7D3EF">รายการ</th>
                                    <th scope="col" style="background-color: #E7D3EF">จำนวนที่บันทึก (ครั้ง)</th>
                                    <th scope="col" style="background-color: #E7D3EF">จำนวนรถ, คน, เส้นทาง</th>
                                    {{-- <th scope="col" style="background-color: #E7D3EF">ดำเนินการ</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($categories ?? []) > 0)
                                    @foreach ($categories as $index => $cate)
                                        @if (count($cate->getForms ?? []) > 0)
                                            <tr>
                                                <td colspan="4" style="background-color: #dbdbdb">{{ $cate->name }}</td>
                                            </tr>
                                            @foreach ($cate->getForms ?? [] as $index => $form)
                                                <tr>
                                                    <td style="background-color: #b3fffb">{{ $index + 1 }}. {{ $form->title }}</td>
                                                    <td class="text-center" style="background-color: #b3fffb">{{ $form->countFromSubmissionByQuarter($quarter, $form->id) }}</td>
                                                    <td class="text-center" style="background-color: #b3fffb">{{ $form->countVehicleFromSubmissionByQuarter($quarter) }}</td>
                                                    {{-- <td class="text-center">
                                                        <a href="{{ route('export.performance.report', ['form_id' => $form->id, 'quarter' => $quarter]) }}" class="btn btn-success">ดาวน์โหลด</a>
                                                    </td> --}}
                                                </tr>
                                                @foreach ($form->formFields ?? [] as $field)
                                                    <tr>
                                                        <td>{{ $field->label }}</td>
                                                        <td class="text-center">
                                                            @if ($field->type == 'subform')
                                                                {{ $form->countFromSubmissionFieldByQuarterAndFieldId($quarter, $form->id, $field->id, true, $field->subform_id) }}
                                                            @else
                                                                {{ $form->countFromSubmissionFieldByQuarterAndFieldId($quarter, $form->id, $field->id) }}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">-</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- {{ $workRecords->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectQuarter = document.querySelector('select[name="quarter"]');
            selectQuarter.addEventListener('change', function () {
                const selectedValue = this.value;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('quarter', selectedValue);
                window.location.href = currentUrl.toString();
            });
        });
    </script>
    <style>
        #performanceReportPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
