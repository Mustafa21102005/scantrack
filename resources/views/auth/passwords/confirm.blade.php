@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
    <h3 class="card-title text-center mb-3">Confirm Password</h3>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" class="form-control p_input @error('password') is-invalid @enderror" name="password"
                id="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group text-center">
            <x-primary-button type="submit" class="btn-block enter-btn">
                Confirm Password
            </x-primary-button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="btn btn-link">
                    Forgot Your Password?
                </a>
            @endif
        </div>
    </form>
@endsection
