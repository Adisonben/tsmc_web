@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ $form_type->name }}</p>
                            <a href="{{ route('forms.create') }}" class="btn btn-success btn-sm">สร้าง</a>
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
                                    <th scope="col">ชื่อแบบฟอร์ม</th>
                                    {{-- <th scope="col">หน่วยงาน</th>
                                    <th scope="col">สาขา</th>
                                    <th scope="col">แผนก</th>
                                    <th scope="col">ตำแหน่ง</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form_lists as $index => $form)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $form->title }}</td>
                                        <td>
                                            @if ($form->getType->form_group == "formPlan")
                                                <a href="{{ route('form.plan.edit', ['formId' => $form->form_id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="แก้ไข">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('forms.edit', ['form' => $form->form_id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="แก้ไข">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm delete-data-btn" del-id="{{ $form->id }}" del-target="form" data-bs-toggle="tooltip" data-bs-title="ลบ">
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
@endsection
