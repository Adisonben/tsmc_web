<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="images/icons/tsmc_logo.png" type="image/icon type">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">Welcome</a>
                </div>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="/home" class="sidebar-link">
                            <i class="bi bi-house"></i>
                            หน้าหลัก
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-clipboard"></i>
                            แบบฟอร์มเอกสาร
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-table"></i>
                            ทะเบียนเอกสาร
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-clipboard-check"></i>
                            อนุมัติเอกสาร
                        </a>
                    </li>
                    <li class="sidebar-header">
                        ผู้ใช้
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('users.show', ['user' => Auth::user()->user_id]) }}" class="sidebar-link">
                            <i class="bi bi-person"></i>
                            บัญชีของฉัน
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('users.index') }}" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            บัญชีผู้ใช้
                        </a>
                    </li>
                    <li class="sidebar-header">
                        ผู้ดูแลระบบ
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#org"
                            aria-expanded="false" aria-controls="org">
                            <i class="bi bi-building"></i>
                            องค์กร
                        </a>
                        <ul id="org" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('organizations.index') }}" class="sidebar-link">ข้อมูลองค์กร</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('cars.index') }}" class="sidebar-link">ข้อมูลรถ</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('positions.index') }}" class="sidebar-link">ตำแหน่ง</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">การอนุญาต</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#sys"
                            aria-expanded="false" aria-controls="sys">
                            <i class="bi bi-database-gear"></i>
                            ระบบ
                        </a>
                        <ul id="sys" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="{{ route('prefixes.index') }}" class="sidebar-link">คำนำหน้า</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('driver-license-types.index') }}" class="sidebar-link">ประเภทใบขับขี่</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{ route('car-types.index') }}" class="sidebar-link">ประเภทรถ</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-header">
                        ทั่วไป
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
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
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->full_name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
        </div>
    </div>
</body>
</html>
