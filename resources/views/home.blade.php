@extends('layouts.app')
@push('scripts')
    @vite(['resources/js/post.js'])
@endpush
@section('content')
    <div class="">
        <div class="container px-3 px-md-5">
            <div class="h3 mt-4 mb-5 text-center fw-bold">
                Transport <span class="text-warning">Safety</span> Manager Communication
            </div>

            {{-- Card --}}
            <div class="d-flex justify-content-center mb-5">
                <div class="card rounded-4 shadow-sm mb-3" style="width: 600px;">
                    <div class="card-body">
                        <div class="row g-0">
                            <!-- รูปภาพ (คอลัมน์ซ้าย) -->
                            <div class="col-md-4 justify-content-center d-flex align-items-center mb-4">
                                @if ((Auth::user()->userDetail->icon ?? false) && file_exists(public_path('uploads/userImages/' . Auth::user()->userDetail->icon)))
                                    <img src="/uploads/userImages/{{ Auth::user()->userDetail->icon }}"
                                    alt="..." style="width: 100px; height: 100px;" class="object-fit-fill">
                                @else
                                    <img src="/images/icons/tsmc_logo.png" alt="..." style="width: 100px; height: 100px;" class="object-fit-fill">
                                @endif
                            </div>

                            <!-- ข้อมูลผู้ใช้ (คอลัมน์ขวา) -->
                            <div class="col-md-8 info-column">
                                <h3 class="card-title mb-2 text-center text-md-start">{{ Auth::user()->full_name }}</h3>
                                <div class="row">
                                    <p class="mb-0 col-6"><strong>หมายเลขประชาชน:</strong></p>
                                    <p class="mb-0 col-6">{{ Auth::user()->userDetail->citizen_id ?? "-" }}</p>
                                    <p class="mb-0 col-6"><strong>ตำแหน่ง:</strong></p>
                                    <p class="mb-0 col-6">{{ Auth::user()->userDetail->getPosition->name ?? "-" }}</p>
                                    <p class="mb-0 col-6"><strong>ฝ่าย:</strong></p>
                                    <p class="mb-0 col-6">{{ Auth::user()->userDetail->getDpm->name ?? "-" }}</p>
                                    <p class="mb-0 col-6"><strong>สาขา:</strong></p>
                                    <p class="mb-0 col-6">{{ Auth::user()->userDetail->getBrn->name ?? "-" }}</p>
                                    <p class="mb-0 col-6"><strong>หน่วยงาน:</strong></p>
                                    <p class="mb-0 col-6">{{ Auth::user()->userDetail->getOrg->name ?? "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center my-4">
                <div class="flex-grow-1 border-top border-dark"></div>
                <span class="mx-3 text-muted fs-5">เมนูลัดสำหรับคุณ</span>
                <div class="flex-grow-1 border-top border-dark"></div>
            </div>


            <div class="d-flex flex-wrap justify-content-center mb-5 gap-2 gap-md-4">
                @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_post',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem; background-color: #F8C8DC;">
                        <a href="{{ route('posts.index') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-pencil-square fs-1"></i>
                                <h5 class="card-title">โพส / ประกาศ</h5>
                            </div>
                        </a>
                    </div>
                @endif

                @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_check',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #A7C7E7;">
                        <a href="{{ route('document.fill-out.selectform') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-ui-checks fs-1"></i>
                                <h5 class="card-title">กรอกแบบฟอร์ม</h5>
                            </div>
                        </a>
                    </div>
                @endif


                @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_access_table',
                                Auth::user()->userDetail->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #B5EAD7;">
                        <a href="{{ route('document.table.selectform') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-table fs-1"></i>
                                <h5 class="card-title">ทะเบียนเอกสาร</h5>
                            </div>
                        </a>
                    </div>
                @endif


                @if ((optional(Auth::user()->userDetail->getPosition)->hasPermissionName(
                                'can_export',
                                optional(Auth::user()->userDetail)->org) ?? false) ||
                            Auth::user()->username === 'tsmcadmin')
                    <div class="card shortcut-card" style="width: 10rem;  background-color: #FFF5BA;">
                        <a href="{{ route('document.export.filter') }}">
                            <div class="card-body text-center text-dark">
                                <i class="bi bi-file-earmark-text fs-1"></i>
                                <h5 class="card-title">ออกรายงาน</h5>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        #document-frame {
          width: 100%;
          height: 60vh; /* Set height to 60% of viewport height */
        }
        #homepage {
            background-color: var(--main-color);
        }

        .shortcut-card {
            transition: all 0.3s ease;
        }

        .shortcut-card:hover {
            /* transform: translateY(-5px); */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .shortcut-card:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
