@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('คู่มือการใช้งานระบบ') }}</p>
                            <div class="text-center">
                                <a href="{{ asset('TSM_User_Manual.pdf') }}" class="btn btn-info" target="_blank"><i class="bi bi-file-earmark-pdf"></i> เอกสารคู่มือ</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- <div class="text-center">
                            <iframe src="{{ asset('TSM_User_Manual.pdf') }}" width="100%" height="600px" allowfullscreen></iframe>
                        </div> --}}
                        <div class="pdf-container">
                            {{-- <iframe src="{{ asset('TSM_User_Manual.pdf') }}" frameborder="0" allowfullscreen></iframe> --}}
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/wX76IHs2C1Y?si=QVCZtmiccdpEMu82"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .pdf-container {
            width: 100%;
            height: 600px; /* Full height on PC */
        }

        .pdf-container iframe {
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            .pdf-container {
                height: 80vh; /* Smaller height on mobile */
            }
        }
    </style>
@endsection
