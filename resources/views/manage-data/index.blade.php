@extends('layouts.app')

@section('content')
@php
    // Get organization based on user type
    $currentOrg = Auth::user()->is_tsm && session('connected_org') 
        ? \App\Models\Organization::find(session('connected_org'))
        : Auth::user()?->userDetail?->getOrg;
@endphp
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <h2 class="mb-4 text-white fw-bold">จัดการข้อมูล</h2>

            {{-- Overview Stats --}}
            <div class="row g-3 mb-4">
                <div class="col-4">
                    <div class="manage-data-stat-card">
                        <p class="stat-number">{{ $currentOrg?->vehicles?->count() ?? 0 }}</p>
                        <p class="stat-label">รถ</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="manage-data-stat-card">
                        <p class="stat-number">{{ $currentOrg?->users?->count() ?? 0 }}</p>
                        <p class="stat-label">ผู้ใช้</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="manage-data-stat-card">
                        <p class="stat-number">{{ $currentOrg?->positions?->count() ?? 0 }}</p>
                        <p class="stat-label">ตำแหน่ง</p>
                    </div>
                </div>
            </div>

            {{-- Category 1: ข้อมูลตั้งต้น --}}
            <div class="manage-data-category mb-4">
                <div class="manage-data-category-header">
                    <div>
                        <h5 class="category-title">ข้อมูลตั้งต้น</h5>
                        <p class="category-desc">ข้อมูลพื้นฐานที่ต้องมีก่อนใช้ระบบ</p>
                    </div>
                </div>
                <div class="manage-data-grid">
                    {{-- ข้อมูลบริษัท --}}
                    <a href="{{ route('organizations.index') }}" class="manage-data-card">
                        <div class="card-icon" style="background: rgba(52, 211, 153, 0.15);">
                            <i class="bi bi-building" style="color: #34D399;"></i>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title">ข้อมูลบริษัท</h6>
                            <p class="card-desc">ชื่อ ที่อยู่ เลขทะเบียน</p>
                        </div>
                        <i class="bi bi-chevron-right card-arrow"></i>
                    </a>

                    {{-- สาขา/ฝ่าย --}}
                    <a href="{{ route('organizations.show', ['organization' => $currentOrg?->org_id ?? '-']) }}" class="manage-data-card">
                        <div class="card-icon" style="background: rgba(167, 139, 250, 0.15);">
                            <i class="bi bi-diagram-3" style="color: #A78BFA;"></i>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title">สาขา/ฝ่าย</h6>
                            <p class="card-desc">จัดการสาขาและฝ่าย</p>
                        </div>
                        <i class="bi bi-chevron-right card-arrow"></i>
                    </a>

                    {{-- ข้อมูลรถ --}}
                    <a href="{{ route('vehicles.index') }}" class="manage-data-card">
                        <div class="card-icon" style="background: rgba(96, 165, 250, 0.15);">
                            <i class="bi bi-car-front" style="color: #60A5FA;"></i>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title">ข้อมูลรถ</h6>
                            <p class="card-desc">{{ $currentOrg?->vehicles?->count() ?? 0 }} คัน</p>
                        </div>
                        <i class="bi bi-chevron-right card-arrow"></i>
                    </a>

                    {{-- ผู้ใช้ทั้งหมด --}}
                    @if (Auth::user()->is_tsm || 
                        (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_manage_user', optional(Auth::user()->userDetail)->org) ?? false) ||
                        Auth::user()->username === 'tsmcadmin' ||
                        Auth::user()->userDetail->position === null)
                        <a href="{{ route('users.index') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(251, 191, 36, 0.15);">
                                <i class="bi bi-people" style="color: #FBBF24;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">ผู้ใช้ทั้งหมด</h6>
                                <p class="card-desc">{{ $currentOrg?->users?->count() ?? 0 }} คน</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    @endif

                    {{-- ผูกผู้ประจำรถ --}}
                    @if (Auth::user()->is_tsm || 
                        (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_assign_driver', optional(Auth::user()->userDetail)->org) ?? false))
                        <a href="{{ route('vehicle.assignment.table') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(251, 191, 36, 0.15);">
                                <i class="bi bi-person-badge" style="color: #FBBF24;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">จัดการผู้ประจำรถ</h6>
                                <p class="card-desc">จับคู่คนขับ → รถ</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    @endif

                    {{-- นำเข้าข้อมูล --}}
                    <a href="{{ route('importdata.index') }}" class="manage-data-card">
                        <div class="card-icon" style="background: rgba(96, 165, 250, 0.15);">
                            <i class="bi bi-file-earmark-arrow-up" style="color: #60A5FA;"></i>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title">นำเข้าข้อมูล</h6>
                            <p class="card-desc">Import Excel/CSV</p>
                        </div>
                        <i class="bi bi-chevron-right card-arrow"></i>
                    </a>
                </div>
            </div>

            {{-- Category 2: การตั้งค่าระบบ --}}
            <div class="manage-data-category mb-4">
                <div class="manage-data-category-header">
                    <div>
                        <h5 class="category-title">การตั้งค่าระบบ</h5>
                        <p class="category-desc">ปรับแต่งระบบให้เหมาะกับองค์กร</p>
                    </div>
                </div>
                <div class="manage-data-grid">
                    {{-- ตำแหน่ง --}}
                    <a href="{{ route('positions.index') }}" class="manage-data-card">
                        <div class="card-icon" style="background: rgba(52, 211, 153, 0.15);">
                            <i class="bi bi-diagram-3" style="color: #34D399;"></i>
                        </div>
                        <div class="card-content">
                            <h6 class="card-title">ตำแหน่ง</h6>
                            <p class="card-desc">{{ $currentOrg?->positions?->count() ?? 0 }} ตำแหน่ง</p>
                        </div>
                        <i class="bi bi-chevron-right card-arrow"></i>
                    </a>

                    {{-- สิทธิ์การเข้าถึง --}}
                    @if (Auth::user()->is_tsm || session('org_status') !== 2)
                        <a href="{{ route('posit.perm') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(167, 139, 250, 0.15);">
                                <i class="bi bi-shield-check" style="color: #A78BFA;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">สิทธิ์การเข้าถึง</h6>
                                <p class="card-desc">จัดการสิทธิ์ตามตำแหน่ง</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    @endif

                    {{-- จัดการผู้ประจำรถ --}}
                    @if (Auth::user()->is_tsm || 
                        (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_assign_driver', optional(Auth::user()->userDetail)->org) ?? false))
                        <a href="{{ route('vehicle.assignment.table') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(251, 191, 36, 0.15);">
                                <i class="bi bi-person-badge" style="color: #FBBF24;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">จัดการผู้ประจำรถ</h6>
                                <p class="card-desc">ตั้งค่าคนขับประจำรถ</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    @endif

                    {{-- จัดการแบบฟอร์ม --}}
                    @if (Auth::user()->is_tsm || 
                        (optional(Auth::user()->userDetail->getPosition)->hasPermissionName('can_manage_form', optional(Auth::user()->userDetail)->org) ?? false) || 
                        Auth::user()->username === 'tsmcadmin')
                        <a href="{{ route('form.select-form-category') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(251, 191, 36, 0.15);">
                                <i class="bi bi-gear" style="color: #FBBF24;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">จัดการแบบฟอร์ม</h6>
                                <p class="card-desc">เปิด-ปิดแบบฟอร์ม</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Category 3: ระบบ (tsmcadmin only) --}}
            @if (Auth::user()->username === 'tsmcadmin')
                <div class="manage-data-category mb-4">
                    <div class="manage-data-category-header">
                        <div>
                            <h5 class="category-title">ระบบ</h5>
                            <p class="category-desc">ตั้งค่าระดับระบบ (Admin เท่านั้น)</p>
                        </div>
                    </div>
                    <div class="manage-data-grid">
                        {{-- คำนำหน้า --}}
                        <a href="{{ route('prefixes.index') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(248, 113, 113, 0.15);">
                                <i class="bi bi-tag" style="color: #F87171;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">คำนำหน้า</h6>
                                <p class="card-desc">จัดการคำนำหน้าชื่อ</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>

                        {{-- รหัสต่ออายุ --}}
                        <a href="{{ route('renewal_codes.index') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(96, 165, 250, 0.15);">
                                <i class="bi bi-key" style="color: #60A5FA;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">รหัสต่ออายุ</h6>
                                <p class="card-desc">จัดการรหัสต่ออายุระบบ</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>

                        {{-- บัญชีผู้ใช้ TSM ทั้งหมด --}}
                        <a href="{{ route('tsms.index') }}" class="manage-data-card">
                            <div class="card-icon" style="background: rgba(251, 191, 36, 0.15);">
                                <i class="bi bi-people" style="color: #FBBF24;"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="card-title">บัญชีผู้ใช้ TSM</h6>
                                <p class="card-desc">จัดการบัญชี TSM ทั้งหมด</p>
                            </div>
                            <i class="bi bi-chevron-right card-arrow"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
