@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียนเอกสาร - หมวดหมู่เอกสาร') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 gap-3">
                            @foreach ($categories as $cate)
                                <div class="card col p-0">
                                    <div class="card-header" style="background-color: #F8D247">
                                        {{ $cate->name }}
                                    </div>
                                    <div class="card-body">
                                        <ol class="list-group-numbered">
                                            @if (count($cate->getForms ?? []) > 0)
                                                @foreach ($cate->getForms ?? [] as $form)
                                                    @if ($form->hasThisPosition(Auth::user()->userDetail->position))
                                                        <li class="list-group-item"><a href="{{ route('document.table', ['form_id' => $form->form_id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            @endforeach
                        </div> --}}
                        <div class="row">
                            @php
                                $header_colors = ["#007bff", "#28a745", "#fd7e14", "#6f42c1", "#e83e8c"];
                                $cate_icons = ['bi-truck', 'bi-person', 'bi-sign-merge-left', 'bi-box-seam', 'bi-exclamation-triangle']
                            @endphp
                            @foreach ($categories as $index => $cate)
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header fs-5 text-white" style="background-color: {{ $header_colors[$index % 5] }};">
                                            <i class="bi {{ $cate_icons[$index % 5] }} fs-4 me-2"></i> {{ $cate->name }}
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                @if (count($cate->getForms ?? []) > 0)
                                                    @foreach ($cate->getForms ?? [] as $form)
                                                        @if ($form->hasThisPosition(Auth::user()->userDetail->position) || Auth()->user()->is_tsm)
                                                            <a href="{{ route('document.table', ['form_id' => $form->form_id]) }}">
                                                                <div class=" rounded p-2 mb-2 hover-bg-primary fs-5 text-dark"
                                                                    {{-- style="color: {{ $form->is_default ? 'red' : "black" }}" --}}
                                                                >
                                                                    <i class="bi bi-card-checklist"></i> {{ $form->title }}
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #formCheckTablePage {
            background-color: var(--main-color);
        }

        .hover-bg-primary:hover {
            background-color: #ddf2fc; !important;
        }

        .hover-bg-primary {
            border: 1px solid #b8b8b8; !important;
        }
    </style>
@endsection
