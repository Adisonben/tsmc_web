@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียนบันทึกผลการบำรุงรักษารถ (Log Book)') }}</p>
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
                            <a href="{{ route('logbook.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> เพิ่ม</a>
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
                                    <th scope="col">ชนิดรถ</th>
                                    <th scope="col">เลขไมล์เริ่มต้น</th>
                                    <th scope="col">วันที่เริ่มนับรอบ</th>
                                    <th scope="col">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($log_books ?? []) > 0)
                                    @foreach ($log_books as $index => $log_book)
                                        @php
                                            $startDate = new Carbon\Carbon($log_book->start_date);
                                        @endphp
                                        <tr>
                                            <td>{{ ($log_books->currentPage() - 1) * 10 + ($index + 1) }}</td>
                                            <td>{{ $log_book->vehicle_plate }}</td>
                                            <td>{{ $log_book->vehicle_type }}</td>
                                            <td>{{ number_format($log_book->start_mileage ?? 0) }}</td>
                                            <td>{{ $startDate->thaidate('j M Y') }}</td>
                                            <td>
                                                <a href="{{ route('logbook.show', ['logbook_id' => $log_book->id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-card-list"></i>
                                                </a>
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
                        {{ $log_books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
