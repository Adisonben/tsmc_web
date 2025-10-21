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

            <div class="d-flex align-items-center my-4">
                <div class="flex-grow-1 border-top border-dark"></div>
                <span class="mx-3 text-muted fs-5">รายการบริษัทที่คุณรับผิดชอบ</span>
                <div class="flex-grow-1 border-top border-dark"></div>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @elseif ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            {{-- Card --}}
            <div class="d-flex flex-wrap justify-content-center mb-5 gap-2 gap-md-4 w-75 mx-auto">
                @foreach ($tsm_has_orgs as $tsm_has_org)
                    <div class="card py-2"
                        style="width: 18rem; {{ session('connected_org') == $tsm_has_org->org_id ? 'background-color: rgb(118, 255, 118);' : '' }}">
                        <div class="d-flex justify-content-center">
                            @if (optional($tsm_has_org->getOrg)->logo_img)
                                <img src="/uploads/orglogoes/{{ optional($tsm_has_org->getOrg)->logo_img }}" height="100"
                                    class="card-img-top object-fit-contain" alt="org logo">
                            @else
                                <img src="/images/icons/tsmc_logo.png" height="100"
                                    class="card-img-top object-fit-contain" alt="org logo">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">{{ optional($tsm_has_org->getOrg)->name }}</h5>
                            @if (session('connected_org') == $tsm_has_org->org_id)
                                <button class="btn btn-success w-100" disabled>เชื่อมต่อแล้ว</button>
                            @else
                                <a href="{{ route('tsm.org.connect', ['org_id' => $tsm_has_org->org_id]) }}"
                                    class="btn btn-primary w-100">เชื่อมต่อ</a>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if ($default_org ?? false)
                    <div class="card py-2"
                        style="width: 18rem; {{ session('connected_org') == $default_org->id ? 'background-color: rgb(65, 249, 255);' : 'background-color: rgb(182, 182, 182);' }}">
                        <div class="d-flex justify-content-center">
                            @if ($default_org->logo_img)
                                <img src="/uploads/orglogoes/{{ $default_org->logo_img }}" height="100"
                                    class="card-img-top object-fit-contain" alt="org logo">
                            @else
                                <img src="/images/icons/tsmc_logo.png" height="100"
                                    class="card-img-top object-fit-contain" alt="org logo">
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column align-items-center">
                            <h5 class="card-title">{{ $default_org->name }} (ตัวอย่าง)</h5>
                            @if (session('connected_org') == $default_org->id)
                                <button class="btn btn-success w-100" disabled>เชื่อมต่อแล้ว</button>
                            @else
                                <a href="{{ route('tsm.org.connect', ['org_id' => $default_org->id]) }}"
                                    class="btn btn-primary w-100">เชื่อมต่อ</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        #document-frame {
            width: 100%;
            height: 60vh;
            /* Set height to 60% of viewport height */
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
