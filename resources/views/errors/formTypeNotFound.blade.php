@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center text-danger fs-5">
                            <i class="bi bi-file-earmark-x"></i> ไม่พบฟอร์ม {{ $fcode }}
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('form.table.type') }}" class="btn btn-secondary">ย้อนกลับ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
