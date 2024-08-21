@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('เพิ่มคำนำหน้า') }}</p>
                            <a href="/prefixes" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="/prefixes" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="prefixName" class="form-label">ชื่อคำนำหน้า</label>
                                <input type="text" maxlength="50" class="form-control" id="prefixName" name="prefixName" placeholder="กรุณากรอกคำนำหน้าที่ต้องการเพิ่ม" required>
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
