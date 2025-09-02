@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h3 class="card-title text-center mb-3">Reset Password</h3>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control p_input @error('email') is-invalid @enderror" name="email"
                id="email" value="{{ $email ?? old('email') }}" required autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password *</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password *</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <div class="form-group text-center">
            <x-primary-button type="submit" class="btn-block enter-btn">
                Reset Password
            </x-primary-button>
        </div>
    </form>
@endsection
