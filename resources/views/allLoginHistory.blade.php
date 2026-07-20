@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="bi bi-funnel-fill me-2"></i>กรองข้อมูล</h5>
                        <form action="{{ route('allLoginHistory') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">ชื่อผู้ใช้ (Username)</label>
                                <input type="text" name="username" class="form-control" placeholder="Username..."
                                    value="{{ request('username') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">บริษัท</label>
                                <select name="org" class="form-select">
                                    <option value="">ทั้งหมด</option>
                                    @foreach ($organizations as $org)
                                        <option value="{{ $org->id }}" {{ request('org') == $org->id ? 'selected' : '' }}>
                                            {{ $org->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">วันที่เริ่ม</label>
                                <input type="date" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">ถึงวันที่</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-filter"></i> กรอง
                                </button>
                                <a href="{{ route('allLoginHistory') }}" class="btn btn-light w-100 border">ล้างค่า</a>
                            </div>
                        </form>
                        @if (!request()->filled('date_from') && !request()->filled('date_to'))
                            <div class="form-text mt-2">* ยังไม่ได้เลือกช่วงวันที่ ระบบแสดงข้อมูลย้อนหลัง 30 วัน</div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-0 fs-4">{{ __('ประวัติการเข้าใช้ระบบทั้งหมด') }}</p>
                            <a href="{{ route('allLoginHistory.export', request()->query()) }}"
                                class="btn btn-secondary btn-sm" target="_blank" data-bs-toggle="tooltip"
                                data-bs-title="พิมพ์รายงาน"><i class="bi bi-printer"></i></a>
                        </div>
                    </div>

                    <div class="card-body overflow-auto">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">ชื่อ</th>
                                    <th scope="col">บริษัท</th>
                                    <th scope="col">วันที่</th>
                                    <th scope="col">Ip</th>
                                    <th scope="col">Agent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($histories && $histories->count() > 0)
                                    @foreach ($histories as $index => $history)
                                        @php
                                            $createdDate = new Carbon\Carbon($history->created_at);
                                        @endphp
                                        <tr>
                                            <td>{{ (($histories->currentPage() - 1) * 10) + ($index + 1) }}</td>
                                            <td>{{ $history->getUser->username ?? '-' }}</td>
                                            <td>{{ $history->getUser->full_name ?? '-' }}</td>
                                            <td>{{ $history->getUser->org_name ?? '-' }}</td>
                                            <td>{{ $createdDate->thaidate('j F Y \\เวลา H:i:s') }}</td>
                                            <td>{{ $history->ip_address }}</td>
                                            <td>{{ $history->agent }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #loginHistoryPage {
            background-color: var(--main-color);
        }
    </style>
@endsection
