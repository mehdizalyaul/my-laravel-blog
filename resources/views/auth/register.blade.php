@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <div class="container register-container">
            <h1 class="display-4 text-center">Créez un compte</h1>
            <p class="lead text-center">Veuillez entrer vos informations pour vous inscrire.</p>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" class="form-control form-control-sm custom-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                    @error('name')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control form-control-sm custom-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                    @error('email')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" class="form-control form-control-sm custom-input" type="password" name="password" required autocomplete="new-password" />
                    @error('password')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" class="form-control form-control-sm custom-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                    @error('password_confirmation')
                        <div class="mt-2 text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Already registered?') }}</a>
                    <button type="submit" class="btn btn-primary ms-4">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom CSS for register only -->
    <style>
        .register-container {
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
