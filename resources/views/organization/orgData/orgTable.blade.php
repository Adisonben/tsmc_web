@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลองค์กร') }}</p>
                            <a href="/organizations/create" class="btn btn-success btn-sm">สร้าง</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Theme</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orgs as $index => $org)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            @if ($org->logo_img ?? false)
                                                <img src="/uploads/orglogoes/{{ $org->logo_img }}" width="35" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $org->name }}</td>
                                        <td style="background-color: {{ $org->theme_color }}">{{ $org->theme_color }}</td>
                                        <td>
                                            <a href="{{ route('organizations.edit', ['organization' => $org->org_id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="แก้ไข"><i class="bi bi-pencil-square"></i></a>
                                            @if (Auth()->user()->userDetail->fname === "admin")
                                                <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $org->id }}" del-target="organizations" data-bs-toggle="tooltip" data-bs-title="ลบ"><i class="bi bi-trash"></i></button>
                                            @endif
                                            <a href="{{ route('organizations.show', ['organization' => $org->org_id]) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-title="รายละเอียด"><i class="bi bi-list"></i></a>
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
