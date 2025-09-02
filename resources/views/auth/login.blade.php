@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h3 class="card-title text-left mb-3">Login</h3>

    <x-error-alert />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="text" class="form-control p_input @error('email') is-invalid @enderror" name="email"
                id="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password"
                class="form-control p_input @error('password') is-invalid @enderror" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group d-flex align-items-center justify-content-between">
            <div class="form-check">
                <label class="form-check-label" for="remember">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="form-check-input">Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-pass">Forgot password</a>
            @endif
        </div>

        <div class="text-center">
            <x-primary-button type="submit" class="btn-block enter-btn">Login</x-primary-button>
        </div>
    </form>
@endsection
