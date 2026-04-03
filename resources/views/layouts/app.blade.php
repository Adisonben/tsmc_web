<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('images/icons/tsmc_logo.png') }}" type="image/icon type">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://unpkg.com/alpinejs" defer></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    @stack('scripts')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar" style="z-index: 9999">
            <div class="sticky-top">
                <div class="sidebar-logo">
                    <img src="/images/icons/tsmc_logo.png" width="40" alt="TSMC" style="border-radius:12px;object-fit:contain;filter:drop-shadow(0 2px 8px rgba(251,191,36,0.4))">
                    <div>
                        <a href="/home">TSMC</a>
                        <span class="sidebar-logo-sub">Transport Safety</span>
                    </div>
                    <button class="sidebar-toggle-btn" id="nav-toggle-btn2" title="ซ่อนเมนู">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </div>
                <!-- Sidebar Navigation -->
                @if (Auth::user()->is_tsm)
                    <ul class="sidebar-nav">
                        <li class="sidebar-item" id="homepage">
                            <a href="/home" class="sidebar-link">
                                <i class="bi bi-house"></i>
                                <span>หน้าหลัก</span>
                            </a>
                        </li>
                        {{-- @php
                            dd(Auth::user()->userDetail->getPosition->hasPermissionName('can_post', optional(Auth::user()->userDetail)->org));
                        @endphp --}}
                        @if (session('connected_org'))
                            <li class="sidebar-item" id="postsPage">
                                <a href="{{ route('posts.index') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    <span>โพส/ประกาศ</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="formCheckpage">
                                <a href="{{ route('document.fill-out.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    <span>ทำเอกสาร 5 หมวด</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="formCheckTablePage">
                                <a href="{{ route('document.table.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    <span>ทะเบียนเอกสาร</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="workRecordTablePage">
                                <a href="{{ route('work-records.table') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    <span>ทะเบียนเวลาทำงาน</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="carMATablePage">
                                <a href="{{ route('car.ma.table') }}" class="sidebar-link">
                                    <i class="bi bi-car-front"></i>
                                    <span>บันทึกการบำรุงรักษารถ</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="elearningPage">
                                <a href="{{ route('elearning') }}" class="sidebar-link">
                                    <i class="bi bi-book"></i>
                                    <span>ความรู้ออนไลน์</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="" class="sidebar-link">
                                    <i class="bi bi-book"></i>
                                    <span>QMS (Coming Soon)</span>
                                </a>
                            </li>
                            <li class="sidebar-header">
                                แบบฟอร์ม
                            </li>
                            {{-- <li class="sidebar-item" id="formManagePage">
                                <a href="{{ route('form.select-form-category') }}" class="sidebar-link">
                                    <i class="bi bi-gear"></i>
                                    <span>จัดการแบบฟอร์ม</span>
                                </a>
                            </li>
                            <li class="sidebar-item" id="assignPage">
                                <a href="{{ route('vehicle.assignment.table') }}" class="sidebar-link">
                                    <i class="bi bi-person-badge"></i>
                                    <span>จัดการผู้ประจำรถ</span>
                                </a>
                            </li> --}}
                            <li class="sidebar-item" id="reportDataPage">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#report" aria-expanded="false" aria-controls="report">
                                    <i class="bi bi-building"></i>
                                    <span>ออกรายงาน</span>
                                </a>
                                <ul id="report" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#sidebar">
                                    <li class="sidebar-item" id="exportPage">
                                        <a href="{{ route('document.export.filter') }}" class="sidebar-link">
                                            ค้นและออกรายงาน
                                        </a>
                                    </li>

                                    <li class="sidebar-item" id="logbookTablePage">
                                        <a href="{{ route('logbook.table') }}" class="sidebar-link">
                                            log book
                                        </a>
                                    </li>
                                    <li class="sidebar-item" id="performanceReportPage">
                                        <a href="{{ route('performance.report', ['quarter' => Carbon\Carbon::now()->quarterOfYear()]) }}"
                                            class="sidebar-link">
                                            รายงานผลส่งกรมฯ
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="sidebar-item" id="accountPage">
                                <a href="{{ route('users.index') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    <span>บัญชีผู้ใช้ทั้งหมด</span>
                                </a>
                            </li> --}}
                            <li class="sidebar-item" id="manageDataPage">
                                <a href="{{ route('manage.data') }}" class="sidebar-link">
                                    <i class="bi bi-database"></i>
                                    <span>จัดการข้อมูล</span>
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-header">
                            สำหรับ TSM
                        </li>
                        <li class="sidebar-item" id="MyOrgListPage">
                            <a href="{{ route('tsm.manage-org') }}" class="sidebar-link">
                                <i class="bi bi-building"></i>
                                <span>จัดการบริษัทที่รับผิดชอบ</span>
                            </a>
                        </li>
                    </ul>
                @else
                    <ul class="sidebar-nav">
                        <li class="sidebar-item" id="homepage">
                            <a href="/home" class="sidebar-link">
                                <i class="bi bi-house"></i>
                                <span>หน้าหลัก</span>
                            </a>
                        </li>
                        {{-- @php
                            dd(Auth::user()->userDetail->getPosition->hasPermissionName('can_post', optional(Auth::user()->userDetail)->org));
                        @endphp --}}
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_post', Auth::user()->userDetail->org) ??
                                false)
                            <li class="sidebar-item" id="postsPage">
                                <a href="{{ route('posts.index') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    <span>โพส/ประกาศ</span>
                                </a>
                            </li>
                        @endif
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_check', Auth::user()->userDetail->org) ??
                                false)
                            <li class="sidebar-item" id="formCheckpage">
                                <a href="{{ route('document.fill-out.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    <span>ทำเอกสาร 5 หมวด</span>
                                </a>
                            </li>
                        @endif
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_access_table',
                                Auth::user()->userDetail->org) ?? false)
                            <li class="sidebar-item" id="formCheckTablePage">
                                <a href="{{ route('document.table.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    <span>ทะเบียนเอกสาร</span>
                                </a>
                            </li>
                        @endif
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'work_record_table',
                                Auth::user()->userDetail->org) ?? false)
                            <li class="sidebar-item" id="workRecordTablePage">
                                <a href="{{ route('work-records.table') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    <span>ทะเบียนเวลาทำงาน</span>
                                </a>
                            </li>
                        @endif
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('car_ma', Auth::user()->userDetail->org) ??
                                false)
                            <li class="sidebar-item" id="carMATablePage">
                                <a href="{{ route('car.ma.table') }}" class="sidebar-link">
                                    <i class="bi bi-car-front"></i>
                                    <span>บันทึกการบำรุงรักษารถ</span>
                                </a>
                            </li>
                        @endif
                        <li class="sidebar-item" id="elearningPage">
                            <a href="{{ route('elearning') }}" class="sidebar-link">
                                <i class="bi bi-book"></i>
                                <span>ความรู้ออนไลน์</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="" class="sidebar-link">
                                <i class="bi bi-book"></i>
                                <span>QMS (Coming Soon)</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item" id="carMATablePage">
                            <a href="{{ route('car.ma.table') }}" class="sidebar-link">
                                <i class="bi bi-car-front"></i>
                                บันทึกการบำรุงรักษารถ
                            </a>
                        </li> --}}
                        {{-- @if (!optional(Auth::user()->userDetail->getPosition)->name || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_approve_table', optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                            <li class="sidebar-item" id="formInsTablePage">
                                <a href="" class="sidebar-link">
                                    <i class="bi bi-clipboard-check"></i>
                                    เอกสารรอตรวจสอบ
                                </a>
                            </li>
                        @endif --}}
                        <li class="sidebar-header">
                            จัดการข้อมูล
                        </li>
                        {{-- @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_form',
                                optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                            <li class="sidebar-item" id="formManagePage">
                                <a href="{{ route('form.select-form-category') }}" class="sidebar-link">
                                    <i class="bi bi-gear"></i>
                                    <span>จัดการแบบฟอร์ม</span>
                                </a>
                            </li>
                        @endif
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_assign_driver',
                                optional(Auth::user()->userDetail)->org) ?? false)
                            <li class="sidebar-item" id="assignPage">
                                <a href="{{ route('vehicle.assignment.table') }}" class="sidebar-link">
                                    <i class="bi bi-person-badge"></i>
                                    <span>จัดการผู้ประจำรถ</span>
                                </a>
                            </li>
                        @endif --}}
                        @if (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_export',
                                optional(Auth::user()->userDetail)->org) ?? false)
                            <li class="sidebar-item" id="reportDataPage">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#report" aria-expanded="false" aria-controls="report">
                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                    <span>ออกรายงาน</span>
                                </a>
                                <ul id="report" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#sidebar">
                                    <li class="sidebar-item" id="exportPage">
                                        <a href="{{ route('document.export.filter') }}" class="sidebar-link">
                                            ค้นและออกรายงาน
                                        </a>
                                    </li>
                                    <li class="sidebar-item" id="logbookTablePage">
                                        <a href="{{ route('logbook.table') }}" class="sidebar-link">
                                            log book
                                        </a>
                                    </li>
                                    <li class="sidebar-item" id="performanceReportPage">
                                        <a href="{{ route('performance.report', ['quarter' => Carbon\Carbon::now()->quarterOfYear()]) }}"
                                            class="sidebar-link">
                                            รายงานผลส่งกรมฯ
                                        </a>
                                    </li>
                                    <li class="sidebar-item" id="performanceReportPage">
                                        <a href="{{ route('submission.count', ['quarter' => Carbon\Carbon::now()->quarterOfYear()]) }}"
                                            class="sidebar-link">
                                            จำนวนการทำเอกสาร 5 หมวด
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_org',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                                Auth::user()->username === 'tsmcadmin' ||
                                Auth::user()->userDetail->position === null)
                            <li class="sidebar-item" id="manageDataPage">
                                <a href="{{ route('manage.data') }}" class="sidebar-link">
                                    <i class="bi bi-database"></i>
                                    <span>จัดการข้อมูลระบบ</span>
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-item d-md-none">
                            <a href="{{ route('usermanual') }}" class="sidebar-link">
                                <i class="bi bi-book"></i>
                                <span>คู่มือการใช้งาน</span>
                            </a>
                        </li>
                    </ul>
                @endif

                <div class="sidebar-footer d-md-none">
                    <a class="sidebar-footer" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form1').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>ออกจากระบบ</span>
                    </a>

                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <div id="app" class="main">
            <nav id="main-nav" class="navbar navbar-expand-md shadow-none">
                <div class="d-flex align-items-center justify-content-between w-100 px-2 px-sm-4">
                    <!-- Button for sidebar toggle -->
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn p-1" id="nav-toggle-btn" type="button" style="color: rgba(255,255,255,0.5);">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <a class="navbar-brand d-none d-sm-block" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    @auth
                        @php
                            $breadcrumbItems = \App\Helpers\FunctionHelpers::getBreadcrumbItems();
                        @endphp
                        <nav aria-label="breadcrumb" class="d-none d-md-block ms-3">
                            <ol class="breadcrumb mb-0" style="background: transparent;">
                                @foreach($breadcrumbItems as $index => $item)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--main-color);">{{ $item['label'] }}</li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $item['url'] }}" style="color: rgba(255,255,255,0.6); text-decoration: none;">
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @endauth

                    <!-- Button trigger modal -->
                    @if (Auth::user()->is_tsm)
                        @if (Auth::user()->expire_at ?? false)
                            @php
                                $expire_date = new Carbon\Carbon(Auth::user()->expire_at);
                                $diffDay = (int) ceil(Carbon\Carbon::now()->diffInDays($expire_date));
                            @endphp
                            @if ($diffDay > 10)
                                <button type="button" class="btn btn-primary">
                                    <i class="bi bi-clock"></i> {{ $diffDay }} วัน
                                </button>
                            @elseif ($diffDay <= 10 && $diffDay > 0)
                                <button type="button" class="btn btn-warning border-danger" data-bs-toggle="modal"
                                    data-bs-target="#warningModal">
                                    <i class="bi bi-clock"></i> {{ $diffDay }} วัน
                                </button>
                                @if (!session('is_modal_active'))
                                    <button type="button" class="btn btn-primary" id="modalBtn"
                                        data-bs-toggle="modal" hidden data-bs-target="#warningModal">
                                        contact
                                    </button>
                                @endif
                            @else
                                <button type="button" class="btn btn-danger">
                                    <i class="bi bi-clock"></i> หมดอายุ
                                </button>
                                <button type="button" class="btn btn-primary" id="modalBtn" data-bs-toggle="modal"
                                    hidden data-bs-target="#exampleModal">
                                    contact
                                </button>
                            @endif
                        @endif
                    @else
                        @if (Auth::user()->userDetail->getOrg->expire_at ?? false)
                            @php
                                $expire_date = new Carbon\Carbon(Auth::user()->userDetail->getOrg->expire_at);
                                $diffDay = (int) ceil(Carbon\Carbon::now()->diffInDays($expire_date));
                            @endphp
                            @if ($diffDay > 10)
                                <button type="button" class="btn btn-primary">
                                    <i class="bi bi-clock"></i> {{ $diffDay }} วัน
                                </button>
                            @elseif ($diffDay <= 10 && $diffDay > 0)
                                <button type="button" class="btn btn-warning border-danger" data-bs-toggle="modal"
                                    data-bs-target="#warningModal">
                                    <i class="bi bi-clock"></i> {{ $diffDay }} วัน
                                </button>
                                @if (!session('is_modal_active'))
                                    <button type="button" class="btn btn-primary" id="modalBtn"
                                        data-bs-toggle="modal" hidden data-bs-target="#warningModal">
                                        contact
                                    </button>
                                @endif
                            @else
                                <button type="button" class="btn btn-danger">
                                    <i class="bi bi-clock"></i> หมดอายุ
                                </button>
                                <button type="button" class="btn btn-primary" id="modalBtn" data-bs-toggle="modal"
                                    hidden data-bs-target="#exampleModal">
                                    contact
                                </button>
                            @endif
                        @endif
                    @endif

                    @if (session('redeemSuccess'))
                        <div class="alert alert-success m-0 p-2 ms-2" role="alert">
                            {{ session('redeemSuccess') }}
                        </div>
                    @elseif (session('redeemError'))
                        <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                            {{ session('redeemError') }}
                        </div>
                    @elseif ($errors->any())
                        <div class="alert alert-danger m-0 p-2 ms-2" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <!-- Warning Modal -->
                    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel"
                        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="warningModalLabel">ติดต่อสอบถามได้ที่</h1>
                                </div> --}}
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        การใช้งานของคุณใกล้หมดอายุแล้ว
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-info" role="alert">
                                        <p class="mb-0">
                                            ระยะเวลาการใช้งานระบบ Transport Safety Manager (TSM) ของคุณใกล้สิ้นสุดลงแล้ว
                                            กรุณาติดต่อเจ้าหน้าที่ของเราเพื่อใช้งานต่อไป
                                        </p>
                                    </div>

                                    <div class="text-center mb-2">
                                        <h5 class="fw-bold mb-3">ติดต่อเพื่อต่ออายุได้ง่ายๆ</h5>
                                        <div class="qr-code mb-2">
                                            <img src="/images/contact.jpg" width="120"
                                                alt="QR Code สำหรับต่ออายุการใช้งาน" class="img-fluid" />
                                        </div>
                                        <p class="text-muted">สแกน QR Code เพื่อติดต่อสอบถามและต่ออายุการใช้งาน</p>
                                    </div>

                                    <div>
                                        @if (Auth::user()->is_tsm)
                                            <form action="{{ route('renewal_codes.user.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code1" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon1">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('renewal_codes.org.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code2" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon2">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>

                                    @php
                                        session()->put('is_modal_active', true);
                                    @endphp
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expire Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">ติดต่อสอบถามได้ที่</h1>
                                </div> --}}
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        การใช้งานของคุณหมดอายุแล้ว
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-warning" role="alert">
                                        <p class="mb-0">
                                            ระยะเวลาการใช้งานระบบ Transport Safety Manager (TSM) ของคุณได้สิ้นสุดลงแล้ว
                                            กรุณาติดต่อเจ้าหน้าที่ของเราเพื่อใช้งานต่อไป
                                        </p>
                                    </div>

                                    <div class="text-center mb-3">
                                        <h5 class="fw-bold mb-3">ติดต่อเพื่อต่ออายุได้ง่ายๆ</h5>
                                        <div class="qr-code mb-2">
                                            <img src="/images/contact.jpg" width="120"
                                                alt="QR Code สำหรับต่ออายุการใช้งาน" class="img-fluid" />
                                        </div>
                                        <p class="text-muted">สแกน QR Code เพื่อติดต่อสอบถามและต่ออายุการใช้งาน</p>
                                    </div>

                                    <div>
                                        @if (Auth::user()->is_tsm)
                                            <form action="{{ route('renewal_codes.user.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code3" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon3">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('renewal_codes.org.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code4" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon4">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-secondary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form2').submit();">
                                        <i class="bi bi-box-arrow-left"></i>
                                        ออกจากระบบ
                                    </a>

                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Of Navbar -->
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <a class="nav-link" href="{{ route('login') }}" style="color: var(--text-secondary);">{{ __('Login') }}</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}" style="color: var(--text-secondary);">{{ __('Register') }}</a>
                            @endif
                        @else
                            @php
                                $user = Auth::user()->with('userDetail')->first();
                                $initials = mb_substr(Auth::user()->full_name ?? 'U', 0, 1);
                            @endphp
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center gap-2 p-1 pe-2" id="navbarDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="border: 1px solid var(--border-subtle); border-radius: 14px;">
                                    <div class="nav-avatar">{{ $initials }}</div>
                                    <span class="d-none d-sm-inline" style="font-size:0.85rem;color:#fff;font-weight:500;">{{ Auth::user()->full_name }}</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.show', ['user' => Auth::user()->user_id ?? '-']) }}">
                                        <i class="bi bi-person me-2"></i> บัญชีของฉัน
                                    </a>
                                    <a class="dropdown-item" href="{{ route('loginHistory') }}">
                                        <i class="bi bi-clock-history me-2"></i> ประวัติการเข้าใช้ระบบ
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('usermanual') }}">
                                        <i class="bi bi-book me-2"></i> คู่มือการใช้งาน
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                document.getElementById('logout-form3').submit();"
                                        style="color: #F87171;">
                                        <i class="bi bi-box-arrow-left me-2"></i> {{ __('ออกจากระบบ') }}
                                    </a>

                                    <form id="logout-form3" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
                @auth
                    @php
                        $breadcrumbItems = \App\Helpers\FunctionHelpers::getBreadcrumbItems();
                    @endphp
                    <nav aria-label="breadcrumb" class="d-block d-md-none w-100 px-2 mt-2">
                        <ol class="breadcrumb mb-0" style="background: transparent; font-size: 0.85rem;">
                            @foreach($breadcrumbItems as $index => $item)
                                @if($loop->last)
                                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--main-color);">{{ $item['label'] }}</li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $item['url'] }}" style="color: rgba(255,255,255,0.6); text-decoration: none;">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                @endauth
            </nav>

            <main class="py-4">
                @yield('content')
            </main>

            <footer class="mt-auto w-100 p-2" id="main-footer">
                <div class="d-flex flex-wrap justify-content-around align-items-center">
                    {{-- <div>
                        <img src="/images/icons/tsmc_logo.png" width="40" alt="">
                        <img src="/images/icons/iddrives_logo.png" width="40" alt="">
                    </div> --}}
                    <div>
                        Powered by <a href="https://iddrives.co.th/" target="_BLANK">Iddrives.Co.,Ltd.</a>
                    </div>
                    <div>
                        version {{ config('app.version', '2.0') }}
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Org status close modal --}}
    @if (!Auth::user()->is_tsm && !Auth::user()->username === 'tsmcadmin')
        <button type="button" class="btn btn-primary" id="orgStatusBtn" data-bs-toggle="modal" hidden
            data-bs-target="#closeOrgModal" {{ Auth::user()->userDetail->getOrg->status == 0 ? '' : 'disabled' }}>
            statusalert
        </button>
    @endif
    <div class="modal fade" id="closeOrgModal" tabindex="-1" aria-labelledby="closeOrgModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="closeOrgModalLabel">ติดต่อสอบถามได้ที่</h1>
                                </div> --}}
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        บริษัทของคุณถูกปิดการใช้งาน
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <p class="mb-0">
                            บริษัทของคุณถูกปิดการใช้งานแล้ว กรุณาติดต่อเจ้าหน้าที่ของเราเพื่อใช้งานต่อไป
                        </p>
                    </div>

                    <div class="text-center mb-3">
                        <h5 class="fw-bold mb-3">ติดต่อเพื่อต่ออายุได้ง่ายๆ</h5>
                        <div class="qr-code mb-2">
                            <img src="/images/contact.jpg" width="120" alt="QR Code สำหรับต่ออายุการใช้งาน"
                                class="img-fluid" />
                        </div>
                        <p class="text-muted">สแกน QR Code เพื่อติดต่อสอบถามและต่ออายุการใช้งาน</p>
                    </div>
                </div>
                <div class="modal-footer ">
                    <a class="btn btn-secondary" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form4').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        ออกจากระบบ
                    </a>

                    <form id="logout-form4" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBtn = document.getElementById('modalBtn');
            if (modalBtn) {
                modalBtn.click();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const orgStatusBtn = document.getElementById('orgStatusBtn');
            if (orgStatusBtn) {
                orgStatusBtn.click();
            }
        });

        // Active menu highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            
            // Route to menu ID mapping
            const routeMenuMap = {
                '/home': 'homepage',
                '/manage-data': 'manageDataPage',
                '/posts': 'postsPage',
                '/posts/create': 'postsPage',
                '/document/fill-out/select-form': 'formCheckpage',
                '/document/table/select-form': 'formCheckTablePage',
                '/work-records/table': 'workRecordTablePage',
                '/logbook/car-ma-table': 'carMATablePage',
                '/logbook/car-ma-form': 'carMATablePage',
                '/logbook/table': 'logbookTablePage',
                '/logbook/create': 'logbookTablePage',
                '/e-learning': 'elearningPage',
                '/document/export/filter': 'reportDataPage',
                '/performance-report': 'reportDataPage',
                '/submission-count': 'reportDataPage',
                '/users': 'manageDataPage',
                '/organizations': 'manageDataPage',
                '/positions': 'manageDataPage',
                '/vehicles': 'manageDataPage',
                '/vehicle-assignment/table': 'manageDataPage',
                '/position-permission/manage': 'manageDataPage',
                '/forms': 'manageDataPage',
                '/import-data': 'manageDataPage',
                '/prefixes': 'manageDataPage',
                '/renewal-codes': 'manageDataPage',
                '/tsms': 'manageDataPage',
                '/tsm/manage-org': 'MyOrgListPage',
                '/user-manual': 'accountPage',
                '/login-history': 'accountPage'
            };

            // Find matching menu item
            let activeMenuId = null;
            
            // Check exact match first
            if (routeMenuMap[currentPath]) {
                activeMenuId = routeMenuMap[currentPath];
            } else {
                // Check if current path starts with any route
                for (const [route, menuId] of Object.entries(routeMenuMap)) {
                    if (currentPath.startsWith(route)) {
                        activeMenuId = menuId;
                        break;
                    }
                }
            }

            // Apply active class
            if (activeMenuId) {
                const menuItem = document.getElementById(activeMenuId);
                if (menuItem) {
                    menuItem.classList.add('active');
                    
                    // If menu item is inside a collapsed dropdown, expand it
                    const parentCollapse = menuItem.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        const toggleButton = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
                        if (toggleButton) {
                            toggleButton.classList.remove('collapsed');
                            toggleButton.setAttribute('aria-expanded', 'true');
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
