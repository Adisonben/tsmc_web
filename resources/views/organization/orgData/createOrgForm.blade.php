@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('เพิ่มหน่วยงาน') }}</p>
                            <a href="/organizations" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->has('orgLogo'))
                            <div class="alert alert-danger">
                                {{ $errors->first('orgLogo') }}
                            </div>
                        @endif
                        <form action="{{ route('organizations.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="orgName" class="form-label">ชื่อหน่วยงาน</label>
                                <input type="text" maxlength="150" class="form-control" id="orgName" name="orgName" placeholder="กรุณากรอกชื่อหน่วยงาน" required>
                            </div>

                            <div class="mb-3">
                                <label for="orgTheme" class="form-label">ธีมสี</label>
                                <input type="color" class="form-control form-control-color" id="orgTheme" name="orgTheme" value="#F8D247" title="Choose your color" required>
                            </div>

                            <div class="mb-3">
                                <label for="orgLogo" class="form-label">โลโก้หน่วยงาน (ขนาดไม่เกิน 2 MB)</label>
                                <input class="form-control" type="file" id="orgLogo" name="orgLogo">
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">บันทึก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
