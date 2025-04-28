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
        <aside id="sidebar">
            <div class="sticky-top">
                <div class="px-3 pt-2">
                    {{-- @php
                    dd(Auth::user()->userDetail->getOrg);
                    @endphp --}}
                    <img src="/uploads/orglogoes/{{ Auth::user()->userDetail->getOrg->logo_img ?? '' }}" width="50"
                        alt="">
                    <img src="/images/icons/tsmc_logo.png" width="50" alt="">
                    {{-- <img src="/images/icons/iddrives_logo.png" width="50" alt=""> --}}
                    <img src="/images/icons/tz_logo.png" width="50" alt="">
                    <img src="/images/icons/nt_logo.jpg" width="50" alt="" class="rounded-circle">
                    <!-- Button for sidebar toggle -->
                </div>
                <div class="sidebar-logo d-flex justify-content-between">
                    <a href="#">Welcome</a>
                    <div class="text-white fs-4" id="nav-toggle-btn2" style="cursor: pointer;">
                        <i class="bi bi-list"></i>
                    </div>
                </div>
                <!-- Sidebar Navigation -->
                @if (Auth::user()->is_tsm)
                    <ul class="sidebar-nav">
                        <li class="sidebar-item" id="homepage">
                            <a href="/home" class="sidebar-link">
                                <i class="bi bi-house"></i>
                                หน้าหลัก
                            </a>
                        </li>
                        {{-- @php
                            dd(Auth::user()->userDetail->getPosition->hasPermissionName('can_post', optional(Auth::user()->userDetail)->org));
                        @endphp --}}
                        @if (session('connected_org'))
                            <li class="sidebar-item" id="formCheckTablePage">
                                <a href="{{ route('document.table.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    ทะเบียนเอกสาร
                                </a>
                            </li>
                            <li class="sidebar-header">
                                แบบฟอร์ม
                            </li>
                            <li class="sidebar-item" id="formManagePage">
                                <a href="{{ route('form.select-form-category') }}" class="sidebar-link">
                                    <i class="bi bi-gear"></i>
                                    จัดการแบบฟอร์ม
                                </a>
                            </li>
                            <li class="sidebar-item" id="assignPage">
                                <a href="{{ route('vehicle.assignment.table') }}" class="sidebar-link">
                                    <i class="bi bi-person-badge"></i>
                                    จัดการผู้ประจำรถ
                                </a>
                            </li>
                            <li class="sidebar-item" id="exportPage">
                                <a href="{{ route('document.export.filter') }}" class="sidebar-link">
                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                    ออกรายงาน
                                </a>
                            </li>

                            <li class="sidebar-header">
                                ข้อมูลระบบ
                            </li>
                            <li class="sidebar-item" id="orgDataPage">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#org" aria-expanded="false" aria-controls="org">
                                    <i class="bi bi-building"></i>
                                    องค์กร
                                </a>
                                <ul id="org" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="{{ route('organizations.index') }}"
                                            class="sidebar-link">ข้อมูลองค์กร</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('vehicles.index') }}" class="sidebar-link">ข้อมูลรถ</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('positions.index') }}" class="sidebar-link">ตำแหน่ง</a>
                                    </li>
                                    @if (session('org_status') !== 2)
                                        <li class="sidebar-item">
                                            <a href="{{ route('posit.perm') }}" class="sidebar-link">การอนุญาต</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <li class="sidebar-item" id="accountPage">
                                <a href="{{ route('users.index') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    บัญชีผู้ใช้ทั้งหมด
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-header">
                            ทั่วไป
                        </li>
                        <li class="sidebar-item" id="loginHistoryPage">
                            <a href="{{ route('loginHistory') }}" class="sidebar-link">
                                <i class="bi bi-clock-history"></i>
                                ประวัติการเข้าใช้ระบบ
                            </a>
                        </li>

                        <li class="sidebar-header">
                            สำหรับ TSM
                        </li>
                        <li class="sidebar-item" id="profilePage">
                            <a href="{{ route('users.show', ['user' => Auth::user()->user_id ?? '-']) }}"
                                class="sidebar-link">
                                <i class="bi bi-person"></i>
                                บัญชีของฉัน
                            </a>
                        </li>
                        <li class="sidebar-item" id="MyOrgListPage">
                            <a href="{{ route('tsm.manage-org') }}" class="sidebar-link">
                                <i class="bi bi-building"></i>
                                จัดการองค์กรที่รับผิดชอบ
                            </a>
                        </li>
                    </ul>
                @else
                    <ul class="sidebar-nav">
                        <li class="sidebar-item" id="homepage">
                            <a href="/home" class="sidebar-link">
                                <i class="bi bi-house"></i>
                                หน้าหลัก
                            </a>
                        </li>
                        {{-- @php
                            dd(Auth::user()->userDetail->getPosition->hasPermissionName('can_post', optional(Auth::user()->userDetail)->org));
                        @endphp --}}
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_post', Auth::user()->userDetail->org) ??
                                false))
                            <li class="sidebar-item" id="postsPage">
                                <a href="{{ route('posts.index') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    โพส/ประกาศ
                                </a>
                            </li>
                        @endif
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_check', Auth::user()->userDetail->org) ??
                                false))
                            <li class="sidebar-item" id="formCheckpage">
                                <a href="{{ route('document.fill-out.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-clipboard"></i>
                                    เอกสาร
                                </a>
                            </li>
                        @endif
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_access_table',
                                Auth::user()->userDetail->org) ?? false))
                            <li class="sidebar-item" id="formCheckTablePage">
                                <a href="{{ route('document.table.selectform') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    ทะเบียนเอกสาร
                                </a>
                            </li>
                        @endif
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'work_record_table',
                                Auth::user()->userDetail->org) ?? false))
                            <li class="sidebar-item" id="workRecordTablePage">
                                <a href="{{ route('work-records.table') }}" class="sidebar-link">
                                    <i class="bi bi-table"></i>
                                    ทะเบียนเวลาทำงาน
                                </a>
                            </li>
                        @endif
                        {{-- @if (!optional(Auth::user()->userDetail->getPosition)->name || (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_approve_table', optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                            <li class="sidebar-item" id="formInsTablePage">
                                <a href="" class="sidebar-link">
                                    <i class="bi bi-clipboard-check"></i>
                                    เอกสารรอตรวจสอบ
                                </a>
                            </li>
                        @endif --}}
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_form',
                                optional(Auth::user()->userDetail)->org) ?? false) || Auth::user()->username === 'tsmcadmin')
                            <li class="sidebar-header">
                                แบบฟอร์ม
                            </li>
                            <li class="sidebar-item" id="formManagePage">
                                <a href="{{ route('form.select-form-category') }}" class="sidebar-link">
                                    <i class="bi bi-gear"></i>
                                    จัดการแบบฟอร์ม
                                </a>
                            </li>
                        @endif
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_assign_driver',
                                optional(Auth::user()->userDetail)->org) ?? false))
                            <li class="sidebar-item" id="assignPage">
                                <a href="{{ route('vehicle.assignment.table') }}" class="sidebar-link">
                                    <i class="bi bi-person-badge"></i>
                                    จัดการผู้ประจำรถ
                                </a>
                            </li>
                        @endif
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_export',
                                optional(Auth::user()->userDetail)->org) ?? false))
                            <li class="sidebar-item" id="exportPage">
                                <a href="{{ route('document.export.filter') }}" class="sidebar-link">
                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                    ออกรายงาน
                                </a>
                            </li>
                        @endif

                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_org',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                                Auth::user()->username === 'tsmcadmin' ||
                                Auth::user()->userDetail->position === null)
                            <li class="sidebar-header">
                                ข้อมูลระบบ
                            </li>
                            <li class="sidebar-item" id="orgDataPage">
                                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#org" aria-expanded="false" aria-controls="org">
                                    <i class="bi bi-building"></i>
                                    องค์กร
                                </a>
                                <ul id="org" class="sidebar-dropdown list-unstyled collapse"
                                    data-bs-parent="#sidebar">
                                    <li class="sidebar-item">
                                        <a href="{{ route('organizations.index') }}"
                                            class="sidebar-link">ข้อมูลองค์กร</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('vehicles.index') }}" class="sidebar-link">ข้อมูลรถ</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('positions.index') }}" class="sidebar-link">ตำแหน่ง</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('posit.perm') }}" class="sidebar-link">การอนุญาต</a>
                                    </li>
                                </ul>
                            </li>
                            @if (Auth::user()->username === 'tsmcadmin')
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#sys" aria-expanded="false" aria-controls="sys">
                                        <i class="bi bi-database-gear"></i>
                                        ระบบ
                                    </a>
                                    <ul id="sys" class="sidebar-dropdown list-unstyled collapse"
                                        data-bs-parent="#sidebar">
                                        <li class="sidebar-item">
                                            <a href="{{ route('prefixes.index') }}" class="sidebar-link">คำนำหน้า</a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="{{ route('renewal_codes.index') }}"
                                                class="sidebar-link">รหัสต่ออายุ</a>
                                        </li>
                                        {{-- <li class="sidebar-item">
                                            <a href="{{ route('form.types') }}" class="sidebar-link">ประเภทฟอร์ม</a>
                                        </li> --}}
                                    </ul>
                                </li>
                            @endif
                        @endif

                        <li class="sidebar-header">
                            ผู้ใช้
                        </li>
                        <li class="sidebar-item" id="profilePage">
                            <a href="{{ route('users.show', ['user' => Auth::user()->user_id ?? '-']) }}"
                                class="sidebar-link">
                                <i class="bi bi-person"></i>
                                บัญชีของฉัน
                            </a>
                        </li>
                        @if (
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_user',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                                Auth::user()->username === 'tsmcadmin' ||
                                Auth::user()->userDetail->position === null)
                            <li class="sidebar-item" id="accountPage">
                                <a href="{{ route('users.index') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    บัญชีผู้ใช้ทั้งหมด
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->username === 'tsmcadmin')
                            <li class="sidebar-item" id="accountTSMPage">
                                <a href="{{ route('tsms.index') }}" class="sidebar-link">
                                    <i class="bi bi-people"></i>
                                    บัญชีผู้ใช้ TSM ทั้งหมด
                                </a>
                            </li>
                        @endif

                        <li class="sidebar-header">
                            ทั่วไป
                        </li>
                        <li class="sidebar-item" id="loginHistoryPage">
                            <a href="{{ route('loginHistory') }}" class="sidebar-link">
                                <i class="bi bi-clock-history"></i>
                                ประวัติการเข้าใช้ระบบ
                            </a>
                        </li>
                    </ul>
                @endif

                <div class="sidebar-footer d-md-none">
                    <a class="sidebar-footer" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        ออกจากระบบ
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <div id="app" class="main">
            <nav id="main-nav" class="navbar navbar-expand-md navbar-light shadow-sm">
                <div class="d-flex align-items-center justify-content-between w-100 mx-sm-4">
                    <!-- Button for sidebar toggle -->
                    <button class="btn" id="nav-toggle-btn" type="button" data-bs-theme="light">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

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
                                                        id="code" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon2">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('renewal_codes.org.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code" placeholder="กรอก code" required>
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
                                    <div class="alert alert-info" role="alert">
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
                                                        id="code" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon2">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('renewal_codes.org.redeem') }}" method="post">
                                                @csrf
                                                <label for="code" class="form-label">หรือกรอก Code
                                                    เพื่อต่ออายุการใช้งาน</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="code"
                                                        id="code" placeholder="กรอก code" required>
                                                    <button class="btn btn-primary" type="submit"
                                                        id="button-addon2">ต่ออายุ</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-secondary" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-left"></i>
                                        ออกจากระบบ
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    @php
                                        $user = Auth::user()->with('userDetail')->first();
                                    @endphp
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" v-pre>
                                        {{ Auth::user()->full_name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                            {{ __('ออกจากระบบ') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
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
                        หน่วยงานของคุณถูกปิดการใช้งาน
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        <p class="mb-0">
                            หน่วยงานของคุณถูกปิดการใช้งานแล้ว กรุณาติดต่อเจ้าหน้าที่ของเราเพื่อใช้งานต่อไป
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
                                                    document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        ออกจากระบบ
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            modalBtn.click();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const orgStatusBtn = document.getElementById('orgStatusBtn');
            orgStatusBtn.click();
        });
    </script>
</body>

</html>
