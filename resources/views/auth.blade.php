<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Helpdesk Auth</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('auth.css') }}">
    <script src="{{ asset('auth.js') }}" defer></script>
</head>
<body>
    <main class="auth-page">
        <section class="auth-card register-mode" id="authCard">
            <!-- Blue Panel -->
            <div class="state-panel">
                <div class="state-content state-register">
                    <h2>Welcome Back!</h2>
                    <p>Already have an account?</p>
                    <button type="button" class="panel-btn" data-mode="login">Login</button>
                </div>

                <div class="state-content state-login">
                    <h2>Hello, Welcome!</h2>
                    <p>Don't have an account?</p>
                    <button type="button" class="panel-btn" data-mode="register">Register</button>
                </div>
            </div>

            <!-- White Form Side -->
            <div class="form-panel">
                <!-- Register -->
                <!-- Register -->
<section class="form-view form-register">
    <h1 class="form-title">Register</h1>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-message">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="registerForm" method="POST" action="{{ route('register.store') }}" novalidate>
        @csrf

        <div class="field">
            <label for="registerName">Full Name</label>
            <input 
                type="text" 
                id="registerName" 
                name="username"
                value="{{ old('username') }}"
                placeholder="Enter your name"
                required
            >
        </div>

        <div class="field">
            <label for="registerEmail">Email Address</label>
            <input 
                type="email" 
                id="registerEmail" 
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="field">
            <label for="registerPassword">Password</label>
            <input 
                type="password" 
                id="registerPassword" 
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="submit-btn">Create Account</button>
    </form>

    <div class="divider">
        <span>OR</span>
    </div>

    <a href="{{ route('google.redirect') }}" class="google-btn">
  <span class="google-icon">G</span>
  Continue with Google
</a>
</section>

                <!-- Login -->
               
            <!-- Login -->
<section class="form-view form-login">
    <h1 class="form-title">Login</h1>

    @if ($errors->has('login'))
        <div class="error-message">
            {{ $errors->first('login') }}
        </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login.store') }}" novalidate>
        @csrf

        <div class="field">
            <label for="loginEmail">Email Address</label>
            <input
                type="email"
                id="loginEmail"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="field">
            <div class="label-row">
                <label for="loginPassword">Password</label>
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>
            <input
                type="password"
                id="loginPassword"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="submit-btn">Login</button>
    </form>

    <div class="divider">
        <span>OR</span>
    </div>

    <a href="{{ route('google.redirect') }}" class="google-btn">
  <span class="google-icon">G</span>
  Continue with Google
</a>
</section>
</div>
</section>
    </main>
</body>
</html>