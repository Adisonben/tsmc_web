@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('ทะเบียนเอกสาร - หมวดหมู่แบบฟอร์ม') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="row row-cols-1 row-cols-sm-3 row-cols-md-2">
                            @foreach ($form_cates as $cate)
                                <div class="col p-2">
                                    <div class="card p-0">
                                        <div class="card-header" style="background-color: #F8D247">
                                            {{ $cate->name }}
                                        </div>
                                        <div class="card-body">
                                            <ol class="list-group-numbered">
                                                @if (count($cate->getForms ?? []) > 0)
                                                    @foreach ($cate->getForms as $form)
                                                        {{-- <a href="">{{ $formType->name }}</a> --}}
                                                        @php
                                                            $posit_form = $position->hasFormType(optional($form->getType)->id, optional(Auth::user()->userDetail)->org) ?? $position->hasFormType(optional($form->getType)->id);
                                                        @endphp
                                                        @if ((Auth()->user()->userDetail->org == $form->org) && (optional($form->getType)->form_group == "formCheck") && $posit_form?->pivot?->status)
                                                            <li class="list-group-item"><a href="{{ route('form.table', ['formid' => $form->form_id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                        @elseif (optional($form->getType)->form_group == "formPlan" && optional($form->getType)->type_code !== "TSM-HR-006" && $posit_form?->pivot?->status)
                                                            <li class="list-group-item"><a href="{{ route('formplan.table', ['fid' => $form->form_id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                        @elseif (optional($form->getType)->form_group == "formPlan" && optional($form->getType)->type_code == "TSM-HR-006" && $posit_form?->pivot?->status)
                                                            <li class="list-group-item"><a href="{{ route('formplan.show', ['fid' => $form->id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @foreach ($cate->formTypes ?? [] as $ftype)
                                                    @php
                                                        $posit_form = $position->hasFormType($ftype->id, optional(Auth::user()->userDetail)->org) ?? $position->hasFormType($ftype->id);
                                                    @endphp
                                                    @if ($ftype->form_group == "formTable" && $posit_form?->pivot?->status)
                                                        <li class="list-group-item"><a href="{{ route('formtype.table', ['fcode' => $ftype->type_code]) }}" class="mb-1">{{ $ftype->name }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ol>
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
    </style>
@endsection
