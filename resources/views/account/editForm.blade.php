@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขบัญชีผู้ใช้') }}</p>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>

                    <div class="card-body px-md-5">
                        @livewire('editr-user-form', ['edit_id' => $edit_id])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
