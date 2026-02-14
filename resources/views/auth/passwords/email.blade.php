@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <h3 class="card-title text-center mb-3">Reset Password</h3>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" class="form-control p_input @error('email') is-invalid @enderror" name="email"
                id="email" value="{{ old('email') }}" required autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group text-center">
            <x-primary-button type="submit" class="btn-block enter-btn">
                Send Password Reset Link
            </x-primary-button>
            <a href="{{ route('login') }}">
                <i class="mdi mdi-arrow-left">Back to Login</i>
            </a>
        </div>
    </form>
@endsection
