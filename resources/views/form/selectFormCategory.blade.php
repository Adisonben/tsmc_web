@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('หมวดหมู่แบบฟอร์ม') }}</p>
                            @if (session('formTableError'))
                                <div class="alert alert-danger m-0 py-2" role="alert">
                                    {{ session('formTableError') }}
                                </div>
                            @endif
                            <div>

                            </div>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 gap-3">
                            @foreach ($form_cates as $cate)
                                <a href="{{ route('form.table', ['form_category' => $cate->name ]) }}" class="col p-0">
                                    <button type="button" class="btn btn-warning fs-5 w-100">
                                        {{ $cate->name }}
                                    </button>
                                </a>
                            @endforeach
                            <a href="{{ route('form.table', ['form_category' => 'sub-form']) }}" class="col p-0">
                                <button type="button" class="btn btn-warning fs-5 w-100">
                                    แบบฟอร์มย่อย
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #formManagePage {
            background-color: var(--main-color);
        }
    </style>
@endsection
