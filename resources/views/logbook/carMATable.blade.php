@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียนบันทึกการบำรุงรักษารถ') }}</p>
                            @if (session('wrSuccess'))
                                <div class="alert alert-success m-0 p-2 ms-2" role="alert">
                                    {{ session('wrSuccess') }}
                                </div>
                            @elseif (session('wrError'))
                                <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                                    {{ session('wrError') }}
                                </div>
                            @elseif ($errors->any())
                                <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <a href="{{ route('car.ma.form') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> เพิ่ม</a>
                        </div>
                    </div>

                    <div class="card-body overflow-auto">
                        {{-- <div>
                            <form action="{{ route('work-records.table') }}" method="GET" class="d-flex mb-3">
                                @csrf
                                <select name="searchUser" class="form-control me-2">
                                    <option value="">-- พนักงานทั้งหมด --</option>
                                    @foreach ($users ?? [] as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('searchUser') == $user->id ? 'selected' : '' }}>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="date" name="startDate" class="form-control me-2"
                                    value="{{ request('startDate') }}">
                                <input type="date" name="endDate" class="form-control me-2"
                                    value="{{ request('endDate') }}">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                            </form>
                        </div> --}}

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ทะเบียนรถ</th>
                                    <th scope="col">ประเภทการซ่อม</th>
                                    <th scope="col">วันที่ซ่อม</th>
                                    <th scope="col">ค่าใช้จ่ายทั้งหมด</th>
                                    <th scope="col">ผู้ดำเนินการ</th>
                                    <th scope="col">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($repair_his ?? []) > 0)
                                    @foreach ($repair_his as $index => $repair)
                                        @php
                                            $repair_date = new Carbon\Carbon($repair->repair_date);
                                        @endphp
                                        <tr>
                                            <td>{{ ($repair_his->currentPage() - 1) * 10 + ($index + 1) }}</td>
                                            <td>{{ $repair->vehicle_plate }} : {{ optional($repair->getVehicle)->brand ?? "-" }}</td>
                                            <td>{{ optional($repair->getMaItem)->name ?? "-" }}</td>
                                            <td>{{ $repair_date->thaidate('j M Y') }}</td>
                                            <td class="fw-bold">{{ number_format($repair->repair_cost + ($repair->partsTotalSum() ?? 0)) }}</td>
                                            <td>{{ $repair->repair_operator }}</td>
                                            <td>
                                                <a href="{{ route('car.ma.detail', ['repair_id' => $repair->id]) }}"
                                                    class="btn btn-sm btn-info"><i class="bi bi-card-list"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $repair_his->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #carMATablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
