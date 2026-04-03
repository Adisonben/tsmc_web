@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('แก้ไขบัญชีของฉัน') }}</p>
                            <a href="{{ route('users.show', ['user' => $edit_id]) }}" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>
                    <div class="card-body px-md-5">
                        @livewire('edit-user-by-own-form', ['edit_id' => $edit_id])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
