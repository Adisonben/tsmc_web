@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('หมวดหมู่แบบฟอร์ม') }}</p>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 gap-3">
                            @foreach ($form_cates as $cate)
                                <div class="card col p-0">
                                    <div class="card-header" style="background-color: #F8D247">
                                        {{ $cate->name }}
                                    </div>
                                    <div class="card-body">
                                        @if (count($cate->formTypes ?? []) > 0)
                                            <ol class="list-group-numbered">
                                                @foreach ($cate->formTypes as $formType)
                                                        @if ($formType->form_group == "formCheck" || $formType->form_group == "formPlan")
                                                            <li class="list-group-item">
                                                                <a href="{{ route('forms.tables', ['formtype' => $formType->name]) }}" class="mb-1">{{ $formType->name }}</a>
                                                            </li>
                                                        @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
