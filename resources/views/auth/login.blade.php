@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="container login-container">
            <h1 class="display-4 text-center">Connectez-vous à votre compte</h1>
            <p class="lead text-center">Veuillez entrer vos informations pour vous connecter.</p>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-4">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control form-control-sm custom-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    @error('email')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" class="form-control form-control-sm custom-input" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                </div>

                <!-- Submit and Links -->
                <div class="d-flex justify-content-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary ms-4">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>

            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg mt-3">Voir les Articles</a>
        </div>
    </div>

    <!-- Custom CSS for login only -->
    <style>
        .login-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .custom-input {
            height: 35px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
        }

        .form-label {
            font-size: 14px !important;
        }

        .container-fluid {
            padding-left: 20px !important;
            padding-right: 20px !important;
        }
    </style>
@endsection
