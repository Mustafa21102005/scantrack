@extends('layouts.auth')

@section('title', 'Attendance Marked')

@section('content')
    <div class="alert alert-success" role="alert">
        Attendance marked successfully!
    </div>

    <div class="text-center">
        <x-primary-button href="{{ route('dashboard') }}" class="btn-block enter-btn">Perfect!</x-primary-button>
    </div>
@endsection
