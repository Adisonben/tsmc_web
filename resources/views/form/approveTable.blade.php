@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียนตรวจสอบเอกสาร') }}</p>
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
                                        <th scope="col">ชื่อแบบฟอร์ม</th>
                                        <th scope="col">ผู้จัดทำ</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">วันที่จัดทำ</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($form_responses ?? []) > 0)
                                        @foreach ($form_responses as $index => $formres)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $formres->getForm->title }}</td>
                                                <td>{{ $formres->getUser->full_name }}</td>
                                                <td>{{ $formres->getUser->userDetail->getPosition->name }}</td>
                                                <td>{{ $formres->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('form.detail', ['formresid' => $formres->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="รายละเอียด">
                                                        <i class="bi bi-card-list"></i>
                                                    </a>
                                                    <button class="btn btn-success btn-sm verify-form-btn" formres-id="{{ $formres->id }}" data-bs-toggle="tooltip" data-bs-title="อนุมัติเอกสาร"><i class="bi bi-check"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"><div class="text-center">ไม่พบเอกสารที่ต้องตรวจสอบ</div></td>
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
