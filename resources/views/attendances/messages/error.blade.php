@extends('layouts.auth')

@section('title', 'Attendance Failed')

@section('content')
    <div class="alert alert-danger" role="alert">
        This QR code is expired or invalid.
    </div>

    <div class="text-center">
        <x-primary-button href="{{ route('dashboard') }}" class="btn-block enter-btn">
            Understood
        </x-primary-button>
    </div>
@endsection
