@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียน') }} {{ $form->title }}</p>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">หมายเลขพนักงาน</th>
                                        <th scope="col">ชื่อพนักงาน</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">แผนก</th>
                                        <th scope="col">วันที่</th>
                                        <th scope="col">สถานะ</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($form_responses ?? []) > 0)
                                        @foreach ($form_responses as $index => $form_response)
                                            @php
                                                $header_data = json_decode($form_response->header_data ?? "");
                                            @endphp
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $header_data->empId }}</td>
                                                <td>{{ $header_data->empName }}</td>
                                                <td>{{ $header_data->position }}</td>
                                                <td>{{ $header_data->department }}</td>
                                                <td>{{ $form_response->updated_at }}</td>
                                                <td>
                                                    @switch($form_response->status)
                                                        @case(1)
                                                            <span class="badge text-bg-success">{{ $form_response->getStatus->name }}</span>
                                                            @break
                                                        @case(2)
                                                            <span class="badge text-bg-secondary">{{ $form_response->getStatus->name }}</span>
                                                            @break
                                                        @case(3)
                                                            <span class="badge text-bg-danger">{{ $form_response->getStatus->name }}</span>
                                                            @break
                                                        @default

                                                    @endswitch
                                                </td>
                                                <td>
                                                    <a href="{{ route('form.detail', ['formresid' => $form_response->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="รายละเอียด">
                                                        <i class="bi bi-card-list"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><div class="text-center">ไม่พบเอกสาร</div></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
