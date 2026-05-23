@extends('layouts.app')
@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="d-print-none mb-4">
                    <div class="card border-0 shadow-sm overflow-hidden"
                        style="border-radius: 1.25rem; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 text-primary d-flex align-items-center">
                                <i class="bi bi-funnel-fill me-2"></i> กรองข้อมูลผู้ใช้งาน
                            </h5>
                            <form action="{{ url()->current() }}" method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label
                                        class="form-label small fw-bold text-secondary text-uppercase tracking-wider">ค้นหา</label>
                                    <div class="input-group">
                                        <input type="text" name="search"
                                            class="form-control border-0 bg-light shadow-none"
                                            placeholder="ชื่อ หรือ Username..." value="{{ request('search') }}"
                                            style="height: 48px; border-radius: 12px 0 0 12px;">
                                        <span class="input-group-text border-0 bg-light"
                                            style="border-radius: 0 12px 12px 0;"><i
                                                class="bi bi-search text-muted"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label small fw-bold text-secondary text-uppercase tracking-wider">สาขา</label>
                                    <select name="branch" class="form-select border-0 bg-light shadow-none"
                                        style="height: 48px; border-radius: 12px;">
                                        <option value="">ทั้งหมด</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ request('branch') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label small fw-bold text-secondary text-uppercase tracking-wider">แผนก</label>
                                    <select name="department" class="form-select border-0 bg-light shadow-none"
                                        style="height: 48px; border-radius: 12px;">
                                        <option value="">ทั้งหมด</option>
                                        @foreach ($departments as $dept)
                                            <option value="{{ $dept->id }}"
                                                {{ request('department') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label small fw-bold text-secondary text-uppercase tracking-wider">ตำแหน่ง</label>
                                    <select name="position" class="form-select border-0 bg-light shadow-none"
                                        style="height: 48px; border-radius: 12px;">
                                        <option value="">ทั้งหมด</option>
                                        @foreach ($positions as $pos)
                                            <option value="{{ $pos->id }}"
                                                {{ request('position') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end gap-2">
                                    <button type="submit"
                                        class="btn btn-primary fw-bold px-4 shadow-sm w-100 transition-all hover-lift"
                                        style="height: 48px; border-radius: 12px;">
                                        <i class="bi bi-filter me-2"></i> กรอง
                                    </button>
                                    <a href="{{ url()->current() }}"
                                        class="btn btn-light fw-bold px-4 shadow-sm w-100 transition-all hover-lift border"
                                        style="height: 48px; border-radius: 12px;">
                                        ล้างค่า
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="d-md-flex justify-content-center overflow-x-auto">
                    <div id="exportPaper">
                        @if (Auth()->user()->userDetail->org)
                            <p class="text-center fs-5 mb-0 fw-bold">
                                {{ optional(Auth()->user()->userDetail->getOrg)->name }}</p>
                        @endif
                        <p class="text-center fs-5 fw-bold mb-0">รายงาน ทะเบียนบัญชีผู้ใช้ในระบบ TSMCPlus</p>
                        <p class="text-center">วันที่
                            {{ new Carbon\Carbon()->startOfWeek(Carbon\Carbon::MONDAY)->thaidate('j F Y') }} ถึง
                            {{ new Carbon\Carbon()->endOfWeek(Carbon\Carbon::SUNDAY)->thaidate('j F Y') }}</p>
                        <div id="dataTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">ชื่อ</th>
                                        <th scope="col">บริษัท</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">แผนก</th>
                                        <th scope="col">ตำแหน่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->pass_text ?? '-' }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            @if ($user->is_tsm)
                                                <td colspan="4" class="text-center"> เจ้าหน้าที่ TSM</td>
                                            @else
                                                <td>{{ optional($user->userDetail->getOrg)->name }}</td>
                                                <td>{{ optional($user->userDetail->getBrn)->name }}</td>
                                                <td>{{ optional($user->userDetail->getDpm)->name }}</td>
                                                <td>{{ optional($user->userDetail->getPosition)->name }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-end" style="font-size: 10px">print on TSMCPlus at
                            {{ new Carbon\Carbon()->format('d/m/Y G:i:s') }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-primary" onclick="window.print()">Print</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        #exportPaper {
            background-color: white;
            padding: 1cm;
            width: 297mm;
        }

        @media print {
            body {
                visibility: hidden;
            }

            #exportPaper {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
                color: black;
            }
        }

        #accountPage {
            background-color: var(--main-color);
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }
    </style>
@endsection
