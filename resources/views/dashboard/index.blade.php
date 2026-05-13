@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
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

        <!-- KPI Cards Row -->
        <div class="row mb-4 g-3">
            <!-- User Login Today -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-primary border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                ผู้เข้าใช้งานวันนี้</h6>
                            <i class="bi bi-person-check fs-4 text-primary"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $loginsToday }}</h2>
                        <div class="mt-auto">
                            <a href="{{ route('loginHistory') }}" class="btn btn-sm btn-outline-primary w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Workforce -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-success border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                พนักงานที่ทำงานอยู่</h6>
                            <i class="bi bi-people fs-4 text-success"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $activeWorkers }} <span class="text-muted fs-6">/
                                {{ $totalUsers }}</span></h2>
                        <div class="mt-auto">
                            @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('work_record_table', Auth::user()->userDetail->org) ?? false))
                                <a href="{{ route('work-records.table') }}" class="btn btn-sm btn-outline-success w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fleet Utilization -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-info border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">รถที่กำลังใช้งาน
                            </h6>
                            <i class="bi bi-car-front fs-4 text-info"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $activeVehicles }} <span class="text-muted fs-6">/
                                {{ $totalVehicles }}</span></h2>
                        <div class="mt-auto">
                            @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_manage_org', Auth::user()->userDetail->org) ?? false))
                                <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-outline-info w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Repairs -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-secondary border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">การซ่อมบำรุง</h6>
                            <i class="bi bi-tools fs-4 text-secondary"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $completedRepairs }} <span class="text-muted fs-6">ในเดือนนี้</span></h2>
                        <!-- <small class="text-muted mb-2">ในเดือนนี้</small> -->
                        <div class="mt-auto">
                            @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('car_ma', Auth::user()->userDetail->org) ?? false))
                                <a href="{{ route('car.ma.table') }}" class="btn btn-sm btn-outline-secondary w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming/Missed Maintenance -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-warning border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">
                                Log Book สมบูรณ์</h6>
                            <i class="bi bi-journal-check fs-4 text-warning"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $successLogBooks }} <span class="text-muted fs-6">/
                                {{ $totalLogBooks }}</span> <span class="text-muted fs-6">รายการ</span></h2>
                        <!-- <small class="text-muted mb-2">รายการ</small> -->
                        <div class="mt-auto">
                            @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('car_ma', Auth::user()->userDetail->org) ?? false))
                                <a href="{{ route('logbook.table') }}" class="btn btn-sm btn-outline-warning w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Forms -->
            <div class="col-12 col-md-4 col-lg-2">
                <div class="card h-100 shadow-sm border-0 border-start border-danger border-4">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-muted fw-bold text-uppercase mb-0" style="font-size: 0.8rem;">เอกสารวันนี้</h6>
                            <i class="bi bi-file-earmark-text fs-4 text-danger"></i>
                        </div>
                        <h2 class="fw-bold mb-1" style="font-size: 2.2rem;">{{ $formsToday }}</h2>
                        <div class="mt-auto">
                            @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_access_table', Auth::user()->userDetail->org) ?? false))
                                <a href="{{ route('document.table.selectform') }}" class="btn btn-sm btn-outline-danger w-100 py-0" style="font-size: 0.7rem;">ดูทั้งหมด</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Charts Row -->
        <div class="row mb-4 g-3">
            <!-- Check-ins Chart -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-graph-up me-2"></i>การลงเวลาทำงาน 7 วันล่าสุด</h6>
                        @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('work_record_table', Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('work-records.table') }}" class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <canvas id="checkinsChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Forms by Category -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart me-2"></i>เอกสารแยกตามหมวดหมู่</h6>
                        @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_access_table', Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('document.table.selectform') }}" class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($formsByCategory as $stat)
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
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

        <!-- Recent Activity Row -->
        <div class="row g-3">
            <!-- Recent Work Records -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-geo-alt me-2"></i>ประวัติการลงเวลาล่าสุด</h6>
                        @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('work_record_table', Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('work-records.table') }}" class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
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
                    <div class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-check me-2"></i>ประวัติการทำเอกสารล่าสุด</h6>
                        @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_access_table', Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('document.table.selectform') }}" class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
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
                                    <p class="mb-1 small text-muted">โดย: {{ $submission->getUser->fullName ?? 'Unknown' }}</p>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">ไม่พบประวัติการทำเอกสารล่าสุด</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Posts -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom pt-3 pb-2 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0"><i class="bi bi-megaphone me-2"></i>ประกาศล่าสุด</h6>
                        @if(Auth::user()->is_tsm || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_post', Auth::user()->userDetail->org) ?? false))
                            <a href="{{ route('posts.index') }}" class="btn btn-sm btn-link text-decoration-none">ดูทั้งหมด</a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($recentPosts as $post)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-truncate" style="max-width: 70%;">
                                            {{ $post->getUser->fullName ?? 'Unknown' }}</h6>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($post->created_at)->format('d M') }}</small>
                                    </div>
                                    <p class="mb-1 small text-muted text-truncate">
                                        {{ Str::limit(strip_tags($post->content), 50) }}
                                    </p>
                                </div>
                            @empty
                                <div class="list-group-item text-muted">ไม่พบประกาศล่าสุด</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkinsData = @json($checkinsData);

            if (checkinsData && checkinsData.labels) {
                const ctx = document.getElementById('checkinsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: checkinsData.labels,
                        datasets: [{
                            label: 'การลงเวลา',
                            data: checkinsData.data,
                            backgroundColor: 'rgba(13, 110, 253, 0.2)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0 }
                            }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    </script>
@endpush