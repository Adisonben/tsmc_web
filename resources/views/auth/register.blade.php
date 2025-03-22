@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-center mb-2">
                <img src="/images/icons/tsmc_logo.png" width="140" alt="">
            </div>
            <p class="text-center text-wrap fs-4 fw-bold">Transport <span style="color: orange">Safety</span> Manager <br> Communication</p>
            <div class="card">
                <div class="card-header text-center fs-5 fw-bold">ลงทะเบียน</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.new.user') }}">
                        @csrf
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="row mb-3">
                            <label for="org_name" class="col-md-4 col-form-label text-md-end">หน่วยงาน / บริษัท</label>

                            <div class="col-md-6">
                                <input id="org_name" type="text" class="form-control @error('org_name') is-invalid @enderror" name="org_name" value="{{ old('org_name') }}" required autocomplete="org_name" autofocus>

                                @error('org_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @php
                            $prefixes = App\Models\Prefix::all();
                        @endphp

                        <div class="row mb-3">
                            <label for="prefix_id" class="col-md-4 col-form-label text-md-end">คำนำหน้า</label>

                            <div class="col-md-6">
                                <select id="prefix_id" class="form-select" name="prefix_id" required>
                                    <option selected disabled>เลือกคำนำหน้า</option>
                                    @if ($prefixes)
                                        @foreach ($prefixes as $pref)
                                            <option value="{{ $pref->id }}">{{ $pref->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('prefix_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="fname" class="col-md-4 col-form-label text-md-end">ชื่อ</label>

                            <div class="col-md-6">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required autocomplete="first name" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lname" class="col-md-4 col-form-label text-md-end">นามสกุล</label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required autocomplete="last name" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end"></label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" name="terms" checked required>
                                    <label class="form-check-label" for="terms">
                                        ฉันยอมรับ <a href="{{ route('terms') }}" target="_blank" class="text-decoration-none">นโยบายความเป็นส่วนตัว</a>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div> --}}
                        <div class="d-flex flex-column justify-content-center align-items-center gap-2 mb-0">
                            <button type="submit" class="btn btn-primary">
                                ลงทะเบียน
                            </button>
                            <div class="d-flex gap-2">
                                <p class="mb-0">มีบัญชีอยู่แล้ว?</p>
                                <a href="{{ route('login') }}" class="text-decoration-none">เข้าสู่ระบบ</a>
                            </div>
                            {{-- <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('register') }}'">
                                {{ __('Register') }}
                            </button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
