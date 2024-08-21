@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ประเภทรถ') }}</p>
                            <button class="btn btn-success btn-sm create-cartype-btn">สร้าง</button>
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
                                @foreach ($car_types as $index => $ctype)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $ctype->name }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm update-cartype-btn" edit-id="{{ $ctype->id }}" edit-value="{{ $ctype->name }}" data-bs-toggle="tooltip" data-bs-title="แก้ไข"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $ctype->id }}" del-target="car-types" data-bs-toggle="tooltip" data-bs-title="ลบ"><i class="bi bi-trash"></i></button>
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
