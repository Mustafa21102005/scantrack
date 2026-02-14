@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <h3 class="card-title text-center mb-3">Verify Email</h3>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf

        <div class="form-group text-center">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            Before proceeding, please check your email for a verification link.
            If you did not receive the email click here to request another.

            <div class="form-group mt-2">
                <x-primary-button type="submit" class="btn-block enter-btn">
                    Resend Verification Email
                </x-primary-button>
            </div>
        </div>
    </form>
@endsection
