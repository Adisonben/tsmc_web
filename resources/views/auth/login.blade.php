@extends('layouts.guest')

@section('content')
<div class="login-split">

    {{-- ══ LEFT: Promotional Panel (hidden on mobile, 70% on desktop) ══ --}}
    <div class="login-promo">
        <div class="login-promo-bg"></div>
        <div class="login-promo-overlay"></div>

        <div class="login-promo-content">
            {{-- Top logos --}}
            <div class="login-promo-header">
                <div class="login-promo-logos">
                    <img src="/images/icons/tsmc_logo.png" alt="TSMC" style="width:44px;height:52px;object-fit:contain;filter:drop-shadow(0 2px 8px rgba(251,191,36,0.4))">
                    <div class="login-promo-divider"></div>
                    <div>
                        <p class="login-promo-title">TSMC <span class="accent">x</span> <span class="sub">depa</span></p>
                        <p class="login-promo-subtitle">Transport Safety Management Center</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="login-badge login-badge-yellow">ISO 29110</span>
                    <span class="login-badge login-badge-green">dSURE</span>
                </div>
            </div>

            {{-- Center text --}}
            <div class="login-promo-center">
                <p class="login-promo-label">TRANSPORT SAFETY MANAGEMENT CENTER</p>
                <h1 class="login-promo-heading">
                    <span class="text-light">"ความปลอดภัยไม่ใช่ต้นทุน</span><br>
                    <span class="text-accent">แต่คือการลงทุนที่คุ้มค่าที่สุด"</span>
                </h1>
                <p class="login-promo-quote">Safety is not a cost — it is the best investment.</p>

                <ul class="login-feature-list">
                    <li class="login-feature-item">
                        <div class="login-feature-icon" style="background:rgba(52,211,153,0.15)">
                            <i class="bi bi-check-circle" style="color:#34D399"></i>
                        </div>
                        <p class="login-feature-text">กดเลือก ไม่ต้องพิมพ์ — กรอกฟอร์ม 92 ข้อภายใน 2 นาที</p>
                    </li>
                    <li class="login-feature-item">
                        <div class="login-feature-icon" style="background:rgba(96,165,250,0.15)">
                            <i class="bi bi-bar-chart" style="color:#60A5FA"></i>
                        </div>
                        <p class="login-feature-text">วิเคราะห์ 5 ด้าน อัตโนมัติ — คะแนนคำนวณจาก data จริง</p>
                    </li>
                    <li class="login-feature-item">
                        <div class="login-feature-icon" style="background:rgba(251,191,36,0.15)">
                            <i class="bi bi-send" style="color:#FBBF24"></i>
                        </div>
                        <p class="login-feature-text">ส่งรายงานกรมขนส่งฯ ได้ทันที — ภาคสมัครใจ + ภาคบังคับ</p>
                    </li>
                    <li class="login-feature-item">
                        <div class="login-feature-icon" style="background:rgba(167,139,250,0.15)">
                            <i class="bi bi-shield-check" style="color:#A78BFA"></i>
                        </div>
                        <p class="login-feature-text">ตรงตามประกาศกรมฯ พ.ศ. 2564 — หน้าที่ TSM ครบ 5 ด้าน</p>
                    </li>
                </ul>
            </div>

            {{-- Bottom stats --}}
            <div>
                <div class="login-stats-grid">
                    <div class="login-stat-card">
                        <p class="login-stat-number">17</p>
                        <p class="login-stat-label">แบบฟอร์ม</p>
                        <p class="login-stat-sub">ครบตามกฎหมาย</p>
                    </div>
                    <div class="login-stat-card">
                        <p class="login-stat-number">5</p>
                        <p class="login-stat-label">ด้านความปลอดภัย</p>
                        <p class="login-stat-sub">วิเคราะห์อัตโนมัติ</p>
                    </div>
                    <div class="login-stat-card">
                        <p class="login-stat-number">4</p>
                        <p class="login-stat-label">บทบาทผู้ใช้</p>
                        <p class="login-stat-sub">TSM/Owner/Driver/อื่นๆ</p>
                    </div>
                </div>
                <div class="login-depa-banner">
                    <img src="/images/icons/tz_logo.png" alt="depa" style="width:32px;height:32px;border-radius:8px;object-fit:contain">
                    <div>
                        <p class="depa-title">มาตรฐาน ISO 29110 + dSURE โดย depa</p>
                        <p class="depa-sub">สำนักงานส่งเสริมเศรษฐกิจดิจิทัล · บัญชีบริการดิจิทัล</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ RIGHT: Login Form (full on mobile, 30% on desktop) ══ --}}
    <div class="login-form-panel">
        <div class="login-form-inner">
            {{-- Logo --}}
            <div class="login-form-logo">
                <i class="bi bi-shield-check"></i>
            </div>

            <h2 class="login-form-title">ยินดีต้อนรับกลับมา</h2>
            <p class="login-form-subtitle">กรุณาเข้าสู่ระบบเพื่อดำเนินการต่อ</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login-form-group">
                    <label for="username">{{ __('Username') }}</label>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="ชื่อผู้ใช้">
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="login-form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div class="login-form-options">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>จดจำฉัน</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-submit-btn">เข้าสู่ระบบ</button>
            </form>

            <div class="login-divider">
                <div class="login-divider-line"></div>
                <span class="login-divider-text">หรือ</span>
                <div class="login-divider-line"></div>
            </div>

            <p class="login-register-text">
                {{ __('messages.please_register') }}
                <a href="{{ route('register') }}">ลงทะเบียนบัญชีบริษัท</a>
                หรือ
                <a href="{{ route('tsm.register') }}">ลงทะเบียนบัญชี TSM</a>
            </p>
        </div>
    </div>

</div>
@endsection
