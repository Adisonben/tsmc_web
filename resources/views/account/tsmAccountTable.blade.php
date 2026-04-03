@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ผู้ใช้ TSM ทั้งหมด') }}</p>
                            <div>
                                <a href="{{ route('user.list.export') }}" class="btn btn-secondary btn-sm"
                                    data-bs-toggle="tooltip" data-bs-title="ออกรายงาน"><i class="bi bi-file-pdf"></i></a>
                            </div>
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
                                        <th scope="col">วันที่ลงทะเบียน</th>
                                        <th scope="col">บริษัท</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tsmUsers) == 0)
                                        <tr>
                                            <td colspan="8" class="text-center">ไม่มีข้อมูล</td>
                                        </tr>
                                    @else
                                        @foreach ($tsmUsers as $index => $user)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->full_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($user->created_at)->thaidate('j M Y') }}</td>
                                                <td>{{ count($user->getTSMOrg ?? []) }}</td>

                                                <td>
                                                    <a href="{{ route('users.edit', ['user' => $user->user_id]) }}"
                                                        class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                        data-bs-title="แก้ไข">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm delete-data-btn"
                                                        del-id="{{ $user->id }}" del-target="users"
                                                        data-bs-toggle="tooltip" data-bs-title="ลบ">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $tsmUsers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
