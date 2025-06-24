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
                        <div>
                            <form action="{{ route('work-records.table') }}" method="GET" class="d-flex mb-3">
                                @csrf
                                <select name="searchUser" class="form-control me-2">
                                    <option value="">-- พนักงานทั้งหมด --</option>
                                    {{-- @foreach ($users ?? [] as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('searchUser') == $user->id ? 'selected' : '' }}>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                <input type="date" name="startDate" class="form-control me-2"
                                    value="{{ request('startDate') }}">
                                <input type="date" name="endDate" class="form-control me-2"
                                    value="{{ request('endDate') }}">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                            </form>
                        </div>

                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ทะเบียนรถ</th>
                                    <th scope="col">ประเภทการซ่อม</th>
                                    <th scope="col">วันที่ซ่อม</th>
                                    <th scope="col">ค่าใช้จ่าย</th>
                                    <th scope="col">ผู้ดำเนินการ</th>
                                    <th scope="col">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if (count($workRecords ?? []) > 0)
                                    @foreach ($workRecords as $index => $workRecord)
                                        @php
                                            $startDate = new Carbon\Carbon($workRecord->start_at);
                                            $endDate = new Carbon\Carbon($workRecord->end_at);

                                            $duration = $startDate->diff($endDate);
                                            $humanReadableDuration = '';

                                            if ($duration->m > 0) {
                                                $humanReadableDuration .= $duration->m . ' เดือน ';
                                            }
                                            if ($duration->d > 0) {
                                                $humanReadableDuration .= $duration->d . ' วัน ';
                                            }
                                            if ($duration->h > 0) {
                                                $humanReadableDuration .= $duration->h . ' ชั่วโมง ';
                                            }
                                            if ($duration->i > 0) {
                                                $humanReadableDuration .= $duration->i . ' นาที';
                                            }
                                            if ($startDate->diffInMinutes($endDate) < 1) {
                                                $humanReadableDuration = 'น้อยกว่า 1 นาที';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ ($workRecords->currentPage() - 1) * 10 + ($index + 1) }}</td>
                                            <td>{{ $workRecord->getUser->full_name }}</td>
                                            <td>{{ $startDate->thaidate('j M Y \\เวลา H:i:s') }}</td>
                                            <td>{{ $endDate->thaidate('j M Y \\เวลา H:i:s') }}</td>
                                            <td>{{ $humanReadableDuration }}</td>
                                            <td>
                                                <a href="{{ route('work-records.geomap', ['workId' => $workRecord->id]) }}"
                                                    class="btn btn-sm btn-info"><i class="bi bi-geo-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif --}}
                            </tbody>
                        </table>
                        {{-- {{ $workRecords->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #logbookTablePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
