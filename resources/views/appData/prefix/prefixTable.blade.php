@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('คำนำหน้า') }}</p>
                            <a href="/prefixes/create" class="btn btn-success btn-sm">สร้าง</a>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prefixes as $index => $prefix)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $prefix->name }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm update-prefix-btn" edit-id="{{ $prefix->id }}" edit-value="{{ $prefix->name }}" data-bs-toggle="tooltip" data-bs-title="แก้ไข"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $prefix->id }}" del-target="prefixes" data-bs-toggle="tooltip" data-bs-title="ลบ" {{ $prefix->created_by ? '' : 'disabled' }}><i class="bi bi-trash"></i></button>
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
