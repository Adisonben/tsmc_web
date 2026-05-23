@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center mb-2">
                    <img src="/images/icons/tsmcp_logo.png" width="140" alt="">
                </div>
                <p class="text-center text-wrap fs-4 fw-bold">Transport <span style="color: orange">Safety</span> Manager <br>
                    Communication</p>
                <div class="card" id="loadingCard">
                    <div class="card-body">
                        <div class="spinner-container">
                            <div class="spinner"></div>
                        </div>

                        <div class="status-text pulse">
                            <strong>กำลังเข้าสู่ระบบ<span class="dots">...</span></strong>
                        </div>

                        <div class="sub-text">
                            กรุณารอสักครู่<br>
                            ระบบกำลังตรวจสอบข้อมูลการเข้าสู่ระบบของคุณ<br>
                            ผ่าน LINE Account
                        </div>
                    </div>
                </div>
                <div class="card" id="loginFormCard" hidden>
                    <div class="card-header text-center fs-5 fw-bold">{{ __('messages.please_login') }}</div>

                    <div class="card-body">
                        <form id="loginForm">
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

                            <div class="d-flex flex-column justify-content-center align-items-center gap-2 mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/versions/2.22.3/sdk.js"></script>
    <script>
        let lineUserId = null;
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const usernaem = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                await fetch(`/line-auth/${lineUserId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            username: usernaem,
                            password: password
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // console.log('Log saved: ', data);
                        if (data.status === 'error') {
                            throw new Error("Data error: ", data.message);
                        }

                        console.log('Login successful');
                        window.location.href = '/'; // Redirect to home page after successful login
                    })
                    .catch(error => {
                        // console.error('Error saving.', error);
                        console.log('Error during login');
                        Swal.fire({
                            title: 'เข้าสู่ระบบไม่สำเร็จ',
                            text: `กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่านอีกครั้ง หรือติดต่อผู้ดูแลระบบ`,
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    });
            } catch (error) {
                // Optionally show error to user
                console.error(error);
            }
        });

        window.initLiff = async function(liffId) {
            try {
                await liff.init({
                    liffId
                });

                if (!liff.isLoggedIn()) {
                    console.log("Not logged in, redirecting to login...");
                    liff.login();
                } else {
                    const profile = await liff.getProfile();
                    // console.log("Profile:", profile, );
                    return profile;
                }
            } catch (error) {
                console.error("LIFF init error.");
            }
        };

        async function liffLogin(line_profile) {
            try {
                lineUserId = line_profile.userId; // Store the LINE user ID for later use
                const response = await fetch(`/line-check-user/${line_profile.userId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error(`${response.status}`);
                }
                const data = await response.json();
                window.location.href = '/';
            } catch (error) {
                document.getElementById("loadingCard").hidden = true;
                document.getElementById("loginFormCard").hidden = false;
                console.error("Error during Line Auth:", error);
                Swal.fire({
                    title: 'เข้าสู่ระบบด้วย Line ไม่สำเร็จ',
                    text: `กรุณาเข้าสู่ระบบเพื่อผูกบัญชี LINE ของคุณกับบัญชีระบบ`,
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
            }
        }

        window.initLiff("2007965184-joxK122q").then(function(line_profile) {
            liffLogin(line_profile);
        });
    </script>
    <style>
        .card-body {
            padding: 2rem;
            text-align: center;
        }

        .spinner-container {
            margin: 2rem 0;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #e3e3e3;
            border-top: 4px solid #00B900;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .status-text {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .sub-text {
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        .dots {
            animation: dots 2s infinite;
        }

        @keyframes dots {

            0%,
            20% {
                color: transparent;
                text-shadow: .25em 0 0 transparent, .5em 0 0 transparent;
            }

            40% {
                color: #00B900;
                text-shadow: .25em 0 0 transparent, .5em 0 0 transparent;
            }

            60% {
                text-shadow: .25em 0 0 #00B900, .5em 0 0 transparent;
            }

            80%,
            100% {
                text-shadow: .25em 0 0 #00B900, .5em 0 0 #00B900;
            }
        }
    </style>
@endsection
