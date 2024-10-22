@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทำแบบฟอร์ม - หมวดหมู่แบบฟอร์ม') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 gap-3">
                            @foreach ($form_cates as $cate)
                                <div class="card col p-0">
                                    <div class="card-header" style="background-color: #F8D247">
                                        {{ $cate->name }}
                                    </div>
                                    <div class="card-body">
                                        <ol class="list-group-numbered">
                                            @if (count($cate->getForms ?? []) > 0)
                                                @foreach ($cate->getForms as $form)
                                                    @php
                                                        $posit_form = $position->hasFormType(optional($form->getType)->id, optional(Auth::user()->userDetail)->org) ?? $position->hasFormType(optional($form->getType)->id);
                                                    @endphp
                                                    {{-- <a href="">{{ $formType->name }}</a> --}}
                                                    @if ((Auth()->user()->userDetail->org == $form->org) && (optional($form->getType)->form_group == "formCheck") && $posit_form?->pivot?->status)
                                                        <li class="list-group-item"><a href="{{ route('form.checking', ['formid' => $form->form_id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ol>
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
        #formCheckpage {
            background-color: var(--main-color);
        }
    </style>
@endsection
