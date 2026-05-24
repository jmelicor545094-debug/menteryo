<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Cemetery Management System</title>
    <meta name="description" content="Secure login portal for the Cemetery Management System">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0a0a0f;
            overflow: hidden;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: linear-gradient(135deg, #0a0a0f 0%, #0d1117 25%, #0a0f1a 50%, #0f0a14 75%, #0a0a0f 100%);
        }
        .bg-canvas::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(ellipse 600px 600px at 20% 30%, rgba(139,92,246,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 500px 500px at 80% 70%, rgba(201,168,76,0.06) 0%, transparent 70%),
                radial-gradient(ellipse 400px 400px at 60% 20%, rgba(59,130,246,0.05) 0%, transparent 70%);
            animation: bgShift 20s ease-in-out infinite;
        }
        @keyframes bgShift {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -20px) rotate(1deg); }
            66% { transform: translate(-20px, 15px) rotate(-1deg); }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }
        .orb-1 {
            width: 300px; height: 300px;
            background: rgba(139,92,246,0.15);
            top: 10%; left: 5%;
            animation: float1 12s ease-in-out infinite;
        }
        .orb-2 {
            width: 250px; height: 250px;
            background: rgba(201,168,76,0.12);
            bottom: 15%; right: 10%;
            animation: float2 15s ease-in-out infinite;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: rgba(59,130,246,0.1);
            top: 50%; left: 40%;
            animation: float3 18s ease-in-out infinite;
        }
        @keyframes float1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(40px, -30px); }
        }
        @keyframes float2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, 20px); }
        }
        @keyframes float3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 40px); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* ===== MAIN LAYOUT ===== */
        .login-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ===== LEFT BRANDING ===== */
        .brand-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 80px;
            position: relative;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(201,168,76,0.1);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 100px;
            margin-bottom: 32px;
            animation: fadeUp 0.8s ease-out 0.2s both;
        }
        .brand-badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #c9a84c;
            box-shadow: 0 0 8px rgba(201,168,76,0.6);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.8); }
        }
        .brand-badge-text {
            font-size: 12px;
            font-weight: 500;
            color: #c9a84c;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 52px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.15;
            margin-bottom: 20px;
            animation: fadeUp 0.8s ease-out 0.4s both;
        }
        .brand-title .accent {
            background: linear-gradient(135deg, #c9a84c 0%, #e8d48b 50%, #c9a84c 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s ease-in-out infinite;
        }
        @keyframes shimmer {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 200% center; }
        }
        .brand-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            max-width: 420px;
            margin-bottom: 48px;
            animation: fadeUp 0.8s ease-out 0.6s both;
        }
        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            animation: fadeUp 0.8s ease-out 0.8s both;
        }
        .feature {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .feature:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(201,168,76,0.2);
            transform: translateX(6px);
        }
        .feature-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .feature-icon.purple { background: rgba(139,92,246,0.15); }
        .feature-icon.gold { background: rgba(201,168,76,0.15); }
        .feature-icon.blue { background: rgba(59,130,246,0.15); }
        .feature-icon.green { background: rgba(16,185,129,0.15); }
        .feature-label {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.6);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== RIGHT FORM PANEL ===== */
        .form-panel {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 44px 36px;
            position: relative;
            animation: cardAppear 0.8s ease-out 0.3s both;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.05) inset,
                0 20px 60px rgba(0,0,0,0.3),
                0 0 80px rgba(139,92,246,0.03);
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: -1px; left: 20%;
            width: 60%; height: 2px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.5), transparent);
            border-radius: 2px;
        }
        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(30px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .card-header {
            text-align: center;
            margin-bottom: 36px;
        }
        .card-icon {
            width: 56px; height: 56px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(201,168,76,0.2), rgba(201,168,76,0.05));
            border: 1px solid rgba(201,168,76,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }
        .card-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
        }

        /* Form */
        .form-group {
            margin-bottom: 22px;
        }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            opacity: 0.4;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .form-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            outline: none;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: rgba(201,168,76,0.5);
            background: rgba(255,255,255,0.06);
            box-shadow: 0 0 0 4px rgba(201,168,76,0.08), 0 0 20px rgba(201,168,76,0.05);
        }
        .form-input:focus ~ .input-icon {
            opacity: 0.8;
        }
        .form-input::placeholder {
            color: rgba(255,255,255,0.2);
        }
        .form-error {
            font-size: 12px;
            color: #f87171;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Remember & Forgot */
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
            color: rgba(255,255,255,0.4);
            cursor: pointer;
            transition: color 0.2s;
        }
        .remember-label:hover { color: rgba(255,255,255,0.6); }
        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #c9a84c;
            cursor: pointer;
            border-radius: 4px;
        }
        .forgot-link {
            font-size: 13px;
            color: #c9a84c;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }
        .forgot-link:hover {
            color: #e8d48b;
            text-shadow: 0 0 12px rgba(201,168,76,0.3);
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #c9a84c 0%, #b8943e 100%);
            color: #0a0a0f;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(201,168,76,0.35), 0 0 60px rgba(201,168,76,0.1);
        }
        .login-btn:hover::before {
            left: 100%;
        }
        .login-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 28px 0 20px;
        }
        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
        }
        .divider-text {
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            white-space: nowrap;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            font-size: 12px;
            color: rgba(255,255,255,0.25);
        }
        .login-footer span {
            color: #c9a84c;
            font-weight: 500;
        }

        /* Session Status */
        .session-status {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.2);
            color: #6ee7b7;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* ===== PARTICLES ===== */
        .particles {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            width: 2px; height: 2px;
            background: rgba(201,168,76,0.3);
            border-radius: 50%;
            animation: drift linear infinite;
        }
        @keyframes drift {
            from { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            to { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .brand-panel { padding: 40px; }
            .brand-title { font-size: 38px; }
        }
        @media (max-width: 768px) {
            .brand-panel { display: none; }
            .form-panel { width: 100%; }
        }
    </style>
</head>
<body>

    {{-- Background --}}
    <div class="bg-canvas"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="grid-overlay"></div>

    {{-- Particles --}}
    <div class="particles" id="particles"></div>

    <div class="login-wrapper">




        {{-- RIGHT FORM --}}
        <div class="form-panel">
            <div class="login-card">

                <div class="card-header">
                    <div class="card-icon">⚜</div>
                    <h2 class="card-title">Welcome Back</h2>
                    <p class="card-subtitle">Sign in to your account</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="session-status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <div class="input-wrapper">
                            <input id="email" type="email" name="email"
                                   value="{{ old('email') }}"
                                   class="form-input"
                                   placeholder="admin@cemetery.com"
                                   required autofocus autocomplete="username">
                            <span class="input-icon">✉</span>
                        </div>
                        @error('email')
                            <div class="form-error">⚠ {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrapper">
                            <input id="password" type="password" name="password"
                                   class="form-input"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                            <span class="input-icon">🔑</span>
                        </div>
                        @error('password')
                            <div class="form-error">⚠ {{ $message }}</div>
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

    </div>

    <script>
        // Generate floating particles
        const container = document.getElementById('particles');
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.classList.add('particle');
            p.style.left = Math.random() * 100 + '%';
            p.style.animationDuration = (12 + Math.random() * 20) + 's';
            p.style.animationDelay = (Math.random() * 15) + 's';
            p.style.width = p.style.height = (1 + Math.random() * 2) + 'px';
            if (Math.random() > 0.6) {
                p.style.background = 'rgba(139,92,246,0.25)';
            }
            container.appendChild(p);
        }
    </script>

</body>
</html>