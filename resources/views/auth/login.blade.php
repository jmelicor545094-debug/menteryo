<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Cemetery Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0e0e1a;
        }

        /* LEFT PANEL */
        .left-panel {
            flex: 1;
            background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f1b35 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.08) 0%, transparent 70%);
            top: -100px; left: -100px;
            border-radius: 50%;
            pointer-events: none;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(201,168,76,0.05) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            border-radius: 50%;
            pointer-events: none;
        }
        .left-logo {
            z-index: 1;
        }
        .left-logo-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: #c9a84c;
            letter-spacing: 0.5px;
        }
        .left-logo-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 4px;
        }
        .left-center {
            z-index: 1;
        }
        .left-big-text {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .left-big-text span { color: #c9a84c; }
        .left-desc {
            font-size: 14px;
            color: rgba(255,255,255,0.5);
            line-height: 1.7;
            max-width: 360px;
        }
        .left-features {
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .feature-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #c9a84c;
            flex-shrink: 0;
        }
        .feature-text {
            font-size: 13px;
            color: rgba(255,255,255,0.5);
        }

        /* RIGHT PANEL */
        .right-panel {
            width: 100%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }
        .login-box {
            width: 100%;
            max-width: 360px;
        }
        .login-heading {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 6px;
        }
        .login-sub {
            font-size: 13px;
            color: #7a7a8a;
            margin-bottom: 36px;
        }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e8e4dc;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a2e;
            background: #fafaf8;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #c9a84c;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        .form-input::placeholder { color: #b0adb8; }
        .form-error {
            font-size: 12px;
            color: #c0392b;
            margin-top: 5px;
        }

        /* REMEMBER & FORGOT */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }
        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #7a7a8a;
            cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            width: 15px; height: 15px;
            accent-color: #c9a84c;
            cursor: pointer;
        }
        .forgot-link {
            font-size: 13px;
            color: #c9a84c;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }

        /* LOGIN BUTTON */
        .login-btn {
            width: 100%;
            padding: 13px;
            background: #1a1a2e;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }
        .login-btn:hover {
            background: #c9a84c;
            color: #1a1a2e;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.3);
        }
        .login-btn:active { transform: translateY(0); }

        /* DIVIDER */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
        }
        .divider-line { flex: 1; height: 1px; background: #e8e4dc; }
        .divider-text { font-size: 11px; color: #b0adb8; text-transform: uppercase; letter-spacing: 0.8px; }

        /* FOOTER */
        .login-footer {
            margin-top: 32px;
            text-align: center;
            font-size: 12px;
            color: #b0adb8;
        }
        .login-footer span { color: #c9a84c; font-weight: 500; }

        /* SESSION STATUS */
        .session-status {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>



    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="login-box">

            <div class="login-heading">Welcome back</div>
            <div class="login-sub">Sign in to your account to continue</div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           class="form-input"
                           placeholder="admin@cemetery.com"
                           required autofocus autocomplete="username">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" type="password" name="password"
                           class="form-input"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember & Forgot --}}
                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="login-btn">Sign In</button>

                <div class="divider">
                    <div class="divider-line"></div>
                    <div class="divider-text">Cemetery Management System</div>
                    <div class="divider-line"></div>
                </div>

                <div class="login-footer">
                    Contact your administrator if you <span>don't have an account</span>.
                </div>
            </form>

        </div>
    </div>

</body>
</html>