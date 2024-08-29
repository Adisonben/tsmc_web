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

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ผู้จัดทำ</th>
                                    <th scope="col">ชื่อพนักงาน</th>
                                    <th scope="col">ตำแหน่ง</th>
                                    <th scope="col">วันที่จัดทำ</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form_responses as $index => $form_response)
                                    @php
                                        $header_data = json_decode($form_response->header_data ?? "");
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ optional($form_response->getUser)->full_name ?? '-' }}</td>
                                        <td>{{ $header_data->name }}</td>
                                        <td>{{ $header_data->posit }}</td>
                                        <td>{{ $form_response->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('form.detail', ['formresid' => $form_response->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="แก้ไข">
                                                <i class="bi bi-card-list"></i>
                                            </a>
                                            {{-- <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $user->id }}" del-target="users" data-bs-toggle="tooltip" data-bs-title="ลบ">
                                                <i class="bi bi-trash"></i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
