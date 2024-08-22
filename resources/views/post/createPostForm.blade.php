@extends('layouts.app')

@section('content')
    <div class="">
        <div class="row justify-content-center">
            <div class="px-3 px-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fs-4">{{ __('โพสข้อความ / ประกาศ') }}</p>
                            <a href="/home" class="btn btn-secondary btn-sm">ย้อนกลับ</a>
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
                                <label for="orgName" class="form-label">ข้อความ</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="orgTheme" class="form-label">ไฟล์เอกสาร</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>

                            <div class="mb-3">
                                <label for="orgLogo" class="form-label">ไฟล์ภาพ (ขนาดไฟล์ละไม่เกิน 2 MB)</label>
                                <input class="form-control" type="file" id="orgLogo" name="orgLogo">
                            </div>

                            <div class="mb-3">
                                <label for="postPerm" class="form-label">สิทธื์การเข้าถึง</label>
                                <select class="form-select" id="postPerm" aria-label="Default select example">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                  </select>
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">โพสต์</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
