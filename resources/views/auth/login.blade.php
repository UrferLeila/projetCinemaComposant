@include('partials/stylesLogin')
</head>
<body>

<main class="min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #0a2636;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <!-- Login Card -->
                <form method="POST" action="{{ route('login') }}" class="login-card">

                    @csrf

                    <!-- Title -->
                    <h2 class="text-center mb-2 fw-bold">Connexion</h2>
                    <p class="login-subtitle text-center">Connectez-vous pour continuer</p>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-3 form-group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" placeholder=" ">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3 form-group">
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder=" ">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        @if (Route::has('password.request'))
                            <a class="login-link small" href="{{ route('register') }}">
                                {{ __('Pas de encore compte ?') }}
                            </a>
                        @endif

                        <button type="submit" class="btn-login">
                            {{ __('Log in') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</main>

<footer>
</footer>

@include('partials/script')
</body>
</html>
