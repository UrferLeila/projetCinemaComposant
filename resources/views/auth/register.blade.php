@include('partials/stylesRegister')
</head>
<body>

<main class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <!-- Register Card -->
                <form method="POST" action="{{ route('register') }}" class="register-card">
                    @csrf

                    <!-- Title -->
                    <h2>Créer un compte</h2>
                    <p class="register-subtitle">Inscrivez-vous pour commencer</p>

                    <!-- Name -->
                    <div class="form-group">
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required class="form-control" placeholder=" ">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder=" ">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input id="password" type="password" name="password" required class="form-control" placeholder=" ">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" placeholder=" ">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        @error('password_confirmation')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a class="register-link" href="{{ route('login') }}">
                            {{ __('vous avez deja un compte ?') }}
                        </a>

                        <button type="submit" class="btn-register">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</main>

@include('partials/script')
</body>
</html>
