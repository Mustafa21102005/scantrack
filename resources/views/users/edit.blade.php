@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit User</h4>

                <x-error-alert />

                <form class="forms-sample" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- name --}}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- password --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" name="password">
                        <small class="text-muted">Leave empty to keep the current password</small>
                    </div>

                    <x-primary-button type="submit">Update</x-primary-button>
                    <x-secondary-button href="{{ route('users.index') }}">Cancel</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
@endsection
