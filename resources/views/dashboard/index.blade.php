@extends('layouts.app')

@section('content')
    <style>
        .kpi-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
        }

        .kpi-report-item {
            transition: background-color 0.2s ease, padding-left 0.2s ease;
            border-radius: 8px;
            padding: 8px;
        }

        .kpi-report-item:hover {
            background-color: rgba(25, 135, 84, 0.05) !important;
            padding-left: 12px !important;
        }
    </style>
    <div class="container-fluid p-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </h2>
                <div>
                    <!-- Add filter dropdowns if needed -->
                    <span class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('l j F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Alert Notification & KPI Cards Row -->
        @php
            $totalForms = $performanceReportsThisMonth->count();
            $exportedFormsCount = $performanceReportsThisMonth->where('total_exports_count', '>=', 1)->count();
            $unacceptedFormsCount = $performanceReportsThisMonth->where('monthly_exports_count', '>=', 1)->count();
            $hasAcceptedAll = $exportedFormsCount > 0 && $unacceptedFormsCount == 0;
        @endphp

        <div class="row mb-4 g-3 align-items-stretch">
            <!-- KPI Cards Grid (Left Column) -->
            <div class="col-12 col-lg-8">
                <div class="row g-3">
                    <!-- User Login Today -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-primary bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        ผู้เข้าใช้งานวันนี้</h6>
                                    <i class="bi bi-person-check fs-4 text-primary"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $loginsToday }}</h2>
                                <div class="mt-auto">
                                    <a href="{{ route('loginHistory') }}" class="btn btn-sm btn-outline-primary w-100 py-0"
                                        style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Workforce -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-success bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        พนักงานที่ทำงานอยู่</h6>
                                    <i class="bi bi-people fs-4 text-success"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $activeWorkers }} <span
                                        class="text-muted fs-6">/
                                        {{ $totalUsers }}</span></h2>
                                <div class="mt-auto">
                                    @if (Auth::user()->is_tsm ||
                                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                                'work_record_table',
                                                Auth::user()->userDetail->org) ?? false))
                                        <a href="{{ route('work-records.table') }}"
                                            class="btn btn-sm btn-outline-success w-100 py-0"
                                            style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fleet Utilization -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-info bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        รถที่กำลังใช้งาน
                                    </h6>
                                    <i class="bi bi-car-front fs-4 text-info"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $activeVehicles }} <span
                                        class="text-muted fs-6">/
                                        {{ $totalVehicles }}</span></h2>
                                <div class="mt-auto">
                                    @if (Auth::user()->is_tsm ||
                                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                                'can_manage_org',
                                                Auth::user()->userDetail->org) ?? false))
                                        <a href="{{ route('vehicles.index') }}"
                                            class="btn btn-sm btn-outline-info w-100 py-0"
                                            style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Repairs -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-secondary bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        การซ่อมบำรุง</h6>
                                    <i class="bi bi-tools fs-4 text-secondary"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $completedRepairs }} <span
                                        class="text-muted fs-6">ในเดือนนี้</span></h2>
                                <div class="mt-auto">
                                    @if (Auth::user()->is_tsm ||
                                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('car_ma', Auth::user()->userDetail->org) ??
                                                false))
                                        <a href="{{ route('car.ma.table') }}"
                                            class="btn btn-sm btn-outline-secondary w-100 py-0"
                                            style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming/Missed Maintenance -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-warning bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        Log Book สมบูรณ์</h6>
                                    <i class="bi bi-journal-check fs-4 text-warning"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $successLogBooks }} <span
                                        class="text-muted fs-6">/
                                        {{ $totalLogBooks }}</span> <span class="text-muted fs-6">รายการ</span></h2>
                                <div class="mt-auto">
                                    @if (Auth::user()->is_tsm ||
                                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('car_ma', Auth::user()->userDetail->org) ??
                                                false))
                                        <a href="{{ route('logbook.table') }}"
                                            class="btn btn-sm btn-outline-warning w-100 py-0"
                                            style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Forms -->
                    <div class="col-12 col-md-4">
                        <div class="card h-100 shadow-sm border border-dark bg-danger bg-opacity-10 kpi-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                        เอกสารวันนี้</h6>
                                    <i class="bi bi-file-earmark-text fs-4 text-danger"></i>
                                </div>
                                <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $formsToday }}</h2>
                                <div class="mt-auto">
                                    @if (Auth::user()->is_tsm ||
                                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                                'can_access_table',
                                                Auth::user()->userDetail->org) ?? false))
                                        <a href="{{ route('document.table.selectform') }}"
                                            class="btn btn-sm btn-outline-danger w-100 py-0"
                                            style="font-size: 0.7rem;">ดูทั้งหมด</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Notification (Right Column) -->
            <div class="col-12 col-lg-4">
                @if ($hasAcceptedAll)
                    <div class="alert alert-success border-0 border-start border-success border-4 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 m-0"
                        role="alert">
                        <i class="bi bi-check-circle-fill fs-1 mb-3 text-success"></i>
                        <div>
                            <h5 class="fw-bold mb-2">เรียนผู้ประกอบการ</h5>
                            <p class="mb-0 fs-5 text-dark">
                                ท่านได้ตรวจสอบและยืนยันรายงานผลการปฏิบัติงานทั้งหมดในเดือนนี้เรียบร้อยแล้ว
                                <b>ขอขอบพระคุณยิ่ง</b>
                            </p>
                        </div>
                    </div>
                @elseif ($totalForms == 0 || $exportedFormsCount == 0)
                    <div class="alert alert-warning border-0 border-start border-warning border-4 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 m-0"
                        role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-1 mb-3 text-warning"></i>
                        <div>
                            <h5 class="fw-bold mb-2">เรียนผู้ประกอบการ</h5>
                            <p class="mb-0 fs-5 text-dark">TSM
                                ยังไม่ได้จัดส่งรายงานผลการปฏิบัติงานให้ท่าน กรุณาติดต่อเจ้าหน้าที่ TSM
                                เพื่อส่งรายงานให้ท่านตรวจสอบในระบบ <a href="https://tsmthai.com" target="_blank"
                                    class="alert-link fw-bold text-decoration-underline text-success">tsmthai.com</a>
                                <br> ด้วยความขอบพระคุณยิ่ง
                            </p>
                        </div>
                    </div>
                @elseif($exportedFormsCount == $totalForms)
                    <div class="alert alert-success border-0 border-start border-success border-4 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 m-0"
                        role="alert">
                        <i class="bi bi-check-circle-fill fs-1 mb-3 text-success"></i>
                        <div>
                            <h5 class="fw-bold mb-2">เรียนผู้ประกอบการ</h5>
                            <p class="mb-0 fs-5 text-dark">เจ้าหน้าที่ TSM
                                ได้จัดส่งรายงานผลการปฏิบัติงานทั้งหมดให้ท่านเรียบร้อยแล้ว <b>ท่านกรุณาตรวจสอบรายงานในระบบ <a
                                        href="https://tsmthai.com" target="_blank"
                                        class="alert-link fw-bold text-decoration-underline text-success">tsmthai.com</a>
                                    <br> ด้วยความขอบพระคุณยิ่ง</b></p>
                            <form action="{{ route('dashboard.accept-performance-reports') }}" method="POST"
                                class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm rounded-pill">
                                    <i class="bi bi-check-all me-1"></i> ตรวจสอบแล้ว
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info border-0 border-start border-info border-4 shadow-sm h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 m-0"
                        role="alert">
                        <i class="bi bi-info-circle-fill fs-1 mb-3 text-info"></i>
                        <div>
                            <h5 class="fw-bold mb-2">เรียนผู้ประกอบการ</h5>
                            <p class="mb-0 fs-5 text-dark">เจ้าหน้าที่ TSM
                                ได้จัดส่งรายงานผลการปฏิบัติงานบางส่วนให้ท่านเรียบร้อยแล้ว <b>ท่านกรุณาตรวจสอบรายงานในระบบ <a
                                        href="https://tsmthai.com" target="_blank"
                                        class="alert-link fw-bold text-decoration-underline text-info">tsmthai.com</a>
                                    <br> ด้วยความขอบพระคุณยิ่ง</b>
                            </p>
                            <form action="{{ route('dashboard.accept-performance-reports') }}" method="POST"
                                class="mt-3">
                                @csrf
                                <button type="submit"
                                    class="btn btn-info text-white fw-bold px-4 py-2 shadow-sm rounded-pill">
                                    <i class="bi bi-check-all me-1"></i> ตรวจสอบแล้ว
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Analytics Charts Row -->
        <div class="row mb-4 g-3">
            <!-- Performance Report Exports This Quarter -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">
                            <i class="bi bi-bar-chart-line me-2"></i>การออกรายงานส่งกรมฯ ไตรมาสที่ {{ $quarter }}
                            (ภาคบังคับ)
                        </h6>
                        <a href="{{ route('performance.report', ['quarter' => $quarter]) }}"
                            class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="w-100" style="position: relative; height: 320px;">
                            <canvas id="quarterlyPerformanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Report Exports This Month -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-excel me-2"></i>การออกรายงานส่งกรมฯ เดือนนี้
                            (ภาคสมัคใจ)
                        </h6>
                        <a href="{{ route('performance.report') }}"
                            class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($performanceReportsThisMonth as $form)
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 kpi-report-item"
                                    style="cursor: pointer;" data-title="{{ $form->title }}"
                                    data-exports="{{ json_encode($form->exportPerformanceReports->map(fn($e) => ['date' => \Carbon\Carbon::parse($e->created_at)->translatedFormat('j M Y H:i น.'), 'accepted' => (bool) $e->accepted])) }}">
                                    <div>
                                        <i class="bi bi-file-earmark-excel me-1 text-success"></i>
                                        {{ $form->title }}
                                    </div>
                                    @if ($form->total_exports_count >= 1 && $form->monthly_exports_count == 0)
                                        <span class="text-success fs-5" title="ตรวจสอบแล้ว">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6">{{ $form->monthly_exports_count }}</span>
                                    @endif
                                </li>
                            @empty
                                <li class="list-group-item text-muted px-0 border-0">ไม่มีข้อมูลการออกรายงานในเดือนนี้</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Row -->
        <div class="row g-3">
            <!-- Recent Work Records -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div
                        class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2"></i>ประวัติการลงเวลาล่าสุด</h6>
                        @if (Auth::user()->is_tsm ||
                                (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                    'work_record_table',
                                    Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('work-records.table') }}"
                                class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentWorkRecords as $record)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $record->getUser->fullName ?? 'Unknown User' }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($record->created_at)->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 small text-muted">ลงเวลา:
                                        {{ \Carbon\Carbon::parse($record->created_at)->format('H:i') }} น.
                                    </p>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">ไม่พบประวัติการลงเวลาล่าสุด</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div
                        class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-check me-2"></i>ประวัติการทำเอกสารล่าสุด
                        </h6>
                        @if (Auth::user()->is_tsm ||
                                (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                    'can_access_table',
                                    Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('document.table.selectform') }}"
                                class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentSubmissions as $submission)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-truncate" style="max-width: 70%;">
                                            {{ $submission->getForm->title ?? 'Form' }}
                                        </h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($submission->created_at)->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 small text-muted">โดย:
                                        {{ $submission->getUser->fullName ?? 'Unknown' }}</p>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">ไม่พบประวัติการทำเอกสารล่าสุด</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Forms by Category -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div
                        class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2"></i>เอกสารแยกตามหมวดหมู่</h6>
                        @if (Auth::user()->is_tsm ||
                                (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                    'can_access_table',
                                    Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('document.table.selectform') }}"
                                class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($formsByCategory as $stat)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    {{ $stat->getForm->title ?? 'Unknown Form' }}
                                    <span class="badge bg-primary fs-6">{{ $stat->count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted px-0 border-0">ไม่มีประวัติการส่งเอกสารล่าสุด</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Dates Modal -->
    <div class="modal fade" id="exportDatesModal" tabindex="-1" aria-labelledby="exportDatesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header bg-success text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="exportDatesModalLabel">
                        <i class="bi bi-calendar-event me-2"></i> ประวัติการออกรายงาน
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="fw-bold mb-3 text-secondary" id="modalFormTitle"></h6>
                    <ul class="list-group list-group-flush" id="modalExportList"
                        style="max-height: 300px; overflow-y: auto;">
                        <!-- Items will be injected dynamically -->
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill"
                        data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quarterly Performance Chart
            const quarterlyPerformanceData = {
                labels: @json($performanceReportsThisMonth->pluck('title')),
                exports: @json($performanceReportsThisMonth->map(fn($form) => $form->countExportByQuarter($quarter))),
                vehicles: @json($performanceReportsThisMonth->map(fn($form) => $form->countVehicleFromSubmissionByQuarter($quarter)))
            };

            if (quarterlyPerformanceData && quarterlyPerformanceData.labels.length > 0) {
                const ctx = document.getElementById('quarterlyPerformanceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: quarterlyPerformanceData.labels.map(label => {
                            return label.length > 25 ? label.substring(0, 25) + '...' : label;
                        }),
                        datasets: [{
                                label: 'จำนวนที่ออกรายงาน (ครั้ง)',
                                data: quarterlyPerformanceData.exports,
                                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                                borderColor: 'rgba(13, 110, 253, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'จำนวนรถ (คัน)',
                                data: quarterlyPerformanceData.vehicles,
                                backgroundColor: 'rgba(13, 202, 240, 0.7)',
                                borderColor: 'rgba(13, 202, 240, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    boxWidth: 12,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            }
                        }
                    }
                });
            }

            // Export Dates Modal Handling
            const reportItems = document.querySelectorAll('.kpi-report-item');
            const exportDatesModal = new bootstrap.Modal(document.getElementById('exportDatesModal'));
            const modalFormTitle = document.getElementById('modalFormTitle');
            const modalExportList = document.getElementById('modalExportList');

            reportItems.forEach(item => {
                item.addEventListener('click', function() {
                    const title = this.getAttribute('data-title');
                    const exports = JSON.parse(this.getAttribute('data-exports') || '[]');

                    modalFormTitle.textContent = title;
                    modalExportList.innerHTML = '';

                    if (exports.length === 0) {
                        modalExportList.innerHTML =
                            '<li class="list-group-item text-muted border-0 px-0">ไม่มีข้อมูลการออกรายงานในเดือนนี้</li>';
                    } else {
                        exports.forEach((record, index) => {
                            const statusBadge = record.accepted ?
                                '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>ตรวจสอบแล้ว</span>' :
                                '<span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>ยังไม่ตรวจสอบ</span>';

                            modalExportList.innerHTML += `
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2 border-bottom">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark fw-bold" style="font-size: 0.9rem;">ครั้งที่ ${exports.length - index}</span>
                                        <small class="text-muted"><i class="bi bi-calendar-check me-1"></i>${record.date}</small>
                                    </div>
                                    <div>${statusBadge}</div>
                                </li>
                            `;
                        });
                    }

                    exportDatesModal.show();
                });
            });
        });
    </script>
@endpush
