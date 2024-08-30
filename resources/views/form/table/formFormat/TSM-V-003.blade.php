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
                                    <th scope="col">พนักงานขับรถ</th>
                                    <th scope="col">ทะเบียนรถ</th>
                                    <th scope="col">วันที่จัดทำ</th>
                                    <th scope="col">สถานะ</th>
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
                                        <td>{{ $header_data->car_plate }}</td>
                                        <td>{{ $form_response->updated_at }}</td>
                                        <td>
                                            @switch($form_response->status)
                                                @case(1)
                                                    <span class="badge text-bg-success">{{ $form_response->getStatus->name }}</span></td>
                                                    @break
                                                @case(2)
                                                    <span class="badge text-bg-secondary">{{ $form_response->getStatus->name }}</span></td>
                                                    @break
                                                @case(3)
                                                    <span class="badge text-bg-danger">{{ $form_response->getStatus->name }}</span></td>
                                                    @break
                                                @default

                                            @endswitch
                                        <td>
                                            <a href="{{ route('form.detail', ['formresid' => $form_response->id]) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="รายละเอียด">
                                                <i class="bi bi-card-list"></i>
                                            </a>
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
