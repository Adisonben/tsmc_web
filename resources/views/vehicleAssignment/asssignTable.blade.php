@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">

                {{-- Cars table Card --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ข้อมูลผู้ประจำรถ') }}</p>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('vehicleSuccess'))
                            <div class="alert alert-success" role="alert">
                                {{ session('vehicleSuccess') }}
                            </div>
                        @elseif (session('vehicleError'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('vehicleError') }}
                            </div>
                        @endif

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ยานพาหนะ</th>
                                    <th scope="col">ชื่อผู้รับผิดชอบ</th>
                                    <th scope="col">วันที่มอบหมาย</th>
                                    <th scope="col">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($vehicles ?? []) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @else
                                    @foreach ($vehicles as $index => $vehicle)
                                        @php
                                            $createdDate = new Carbon\Carbon(
                                                optional($vehicle->getAssignment)->created_at ?? '',
                                            );
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $vehicle->license_plate }} : {{ $vehicle->brand }}</td>
                                            @if (optional($vehicle->getAssignment)->created_at ?? false)
                                                <td>{{ optional(optional($vehicle->getAssignment)->getUser)->full_name }}
                                                </td>
                                                <td>{{ $createdDate->thaidate('j M Y') }}</td>
                                            @else
                                                <td colspan="2" class="text-center bg-danger text-white">
                                                    -ไม่พบข้อมูลการมอบหมาย-</td>
                                            @endif
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignCarModal{{ $index }}">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="assignCarModal{{ $index }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="createCarModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="createCarModalLabel">เพิ่มข้อมูลผู้ประจำรถ {{ $vehicle->license_plate }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('vehicles.assignment.store', ['vehicle_id' => $vehicle->id]) }}" method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="driver_id" class="form-label">ผู้ประจำรถ</label>
                                                                <select class="form-select" id="driver_id" name="driver_id"
                                                                    aria-label="select driver id" required>
                                                                    <option value="" selected disabled>Open this
                                                                        select menu</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->user_id }}">
                                                                            {{ $user->getPrefix->name . $user->fname }}
                                                                            {{ $user->lname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> {{-- End Department Card --}}
            </div>
        </div>
    </div>
    <style>
        #assignPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
