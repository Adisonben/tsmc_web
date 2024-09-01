@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ผู้ใช้ทั้งหมด') }}</p>
                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">สร้าง</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">หน่วยงาน</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">แผนก</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ optional($user->userDetail->getOrg)->name }}</td>
                                            <td>{{ optional($user->userDetail->getBrn)->name }}</td>
                                            <td>{{ optional($user->userDetail->getDpm)->name }}</td>
                                            <td>{{ optional($user->userDetail->getPosition)->name }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', ['user' => $user->user_id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="แก้ไข">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $user->id }}" del-target="users" data-bs-toggle="tooltip" data-bs-title="ลบ">
                                                    <i class="bi bi-trash"></i>
                                                </button>
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
    </div>
@endsection
