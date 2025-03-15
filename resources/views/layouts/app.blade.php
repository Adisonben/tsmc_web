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
                    <img src="/uploads/orglogoes/{{ Auth::user()->userDetail->getOrg->logo_img ?? '' }}" width="50" alt="">
                    <img src="/images/icons/tsmc_logo.png" width="50" alt="">
                    {{-- <img src="/images/icons/iddrives_logo.png" width="50" alt=""> --}}
                    <img src="/images/icons/tz_logo.png" width="50" alt="">
                    <img src="/images/icons/nt_logo.jpg" width="50" alt="" class="rounded-circle">
                    <!-- Button for sidebar toggle -->
                </div>
                <div class="sidebar-logo d-flex justify-content-between">
                    <a href="#">Welcome TSM</a>
                    <div class="text-white fs-4" id="nav-toggle-btn2" style="cursor: pointer;">
                        <i class="bi bi-list"></i>
                    </div>
                </div>
                <!-- Sidebar Navigation -->
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
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_post',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="postsPage">
                            <a href="{{ route('posts.index') }}" class="sidebar-link">
                                <i class="bi bi-clipboard"></i>
                                โพส/ประกาศ
                            </a>
                        </li>
                    @endif
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_check',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="formCheckpage">
                            <a href="{{ route('document.fill-out.selectform') }}" class="sidebar-link">
                                <i class="bi bi-clipboard"></i>
                                เอกสาร
                            </a>
                        </li>
                    @endif
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_access_table',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="formCheckTablePage">
                            <a href="{{ route('document.table.selectform') }}" class="sidebar-link">
                                <i class="bi bi-table"></i>
                                ทะเบียนเอกสาร
                            </a>
                        </li>
                    @endif
                    {{-- @if ( !(optional(Auth::user()->userDetail->getPosition)->name) ||
                            (optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_approve_table',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="formInsTablePage">
                            <a href="" class="sidebar-link">
                                <i class="bi bi-clipboard-check"></i>
                                เอกสารรอตรวจสอบ
                            </a>
                        </li>
                    @endif --}}
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_form',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
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
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_assign_driver',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="assignPage">
                            <a href="{{ route('vehicle.assignment.table') }}" class="sidebar-link">
                                <i class="bi bi-person-badge"></i>
                                จัดการผู้ประจำรถ
                            </a>
                        </li>
                    @endif
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_export',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                        <li class="sidebar-item" id="exportPage">
                            <a href="{{ route('document.export.filter') }}" class="sidebar-link">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                                ออกรายงาน
                            </a>
                        </li>
                    @endif

                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_org',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin' || Auth::user()->userDetail->position === null)
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
                                    <a href="{{ route('organizations.index') }}" class="sidebar-link">ข้อมูลองค์กร</a>
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
                    @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_manage_user',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin' || Auth::user()->userDetail->position === null)
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
                </ul>

                <div class="sidebar-footer">
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
                    <button type="button" class="btn btn-primary" id="modalBtn" data-bs-toggle="modal" hidden
                        data-bs-target="#exampleModal" @if (Auth::user()->username !== 'tsmcpreview') disabled @endif>
                        contact
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">ติดต่อสอบถามได้ที่</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <img src="/images/contact.jpg" class="w-50" alt="">
                                    </div>
                                    <div class="text-center my-2">
                                        <h3>หรือ</h3>
                                        <h2 class="mb-0"><i class="bi bi-telephone"></i> 099-295-2666</h2>
                                        <h2>คุณพีช</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button> --}}

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
                                            {{ __('Logout') }}
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBtn = document.getElementById('modalBtn');
            modalBtn.click();
        });
    </script>
</body>

</html>
