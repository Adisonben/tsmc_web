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
                                                        <li class="list-group-item"><a href="{{ route('form.table', ['formid' => $form->form_id]) }}" class="mb-1">{{ $form->title }}</a></li>
                                                    @endforeach
                                                @elseif ($cate->name == "การวิเคราะห์และประเมินผล")
                                                    @foreach ($cate->formTypes ?? [] as $ftype)
                                                        <li class="list-group-item"><a href="{{ route('phonenum.table') }}" class="mb-1">{{ $ftype->name }}</a></li>
                                                    @endforeach
                                                @endif
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
@endsection
