@extends('layouts.auth')

@section('title', 'Attendance Marked')

@section('content')
    <div class="alert alert-info" role="alert">
        Your attendance has already been marked for this session. ℹ️
    </div>

    <div class="text-center">
        <x-primary-button href="{{ route('dashboard') }}" class="btn-block enter-btn">
            Understood
        </x-primary-button>
    </div>
@endsection
