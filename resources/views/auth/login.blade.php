@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center mb-2">
                    <img src="/images/icons/tsmcp_logo.png" width="140" alt="">
                </div>
                <p class="text-center text-wrap fs-4 fw-bold">Transport <span style="color: #ff7a2d">Safety</span> Manager
                    <br>
                    Communication <span style="color: #ff7a2d">Plus</span>
                </p>
                <div class="card">
                    <div class="card-header text-center fs-5 fw-bold">{{ __('messages.please_login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="username"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="d-flex flex-column justify-content-center align-items-center gap-2 mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <div class="d-flex gap-2 flex-wrap">
                                    <p class="mb-0">{{ __('messages.please_register') }}</p>
                                    <a href="{{ route('register') }}">ลงทะเบียนบัญชีบริษัท</a>
                                    <p class="mb-0">หรือ</p>
                                    <a href="{{ route('tsm.register') }}">ลงทะเบียนบัญชี TSM</a>
                                    <p class="mb-0">เพื่อเข้าใช้งานระบบ</p>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
