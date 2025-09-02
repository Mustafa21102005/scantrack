@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Create User</h4>

                <x-error-alert />

                <form class="forms-sample" method="POST" action="{{ route('users.store') }}">
                    @csrf

                    {{-- name --}}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" name="name" value="{{ old('name') }}" required>
                    </div>

                    {{-- email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            placeholder="Email" name="email" value="{{ old('email') }}" required>
                    </div>

                    {{-- password --}}
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            placeholder="Password" name="password" required>
                    </div>

                    {{-- password confirm --}}
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" placeholder="Confirm Password" name="password_confirmation" required>
                    </div>

                    {{-- role --}}
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                            required>
                            <option value="" selected disabled>Select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-primary-button type="submit">Create</x-primary-button>
                    <x-secondary-button href="{{ route('users.index') }}">Cancel</x-secondary-button>
                </form>
            </div>
        </div>
    </div>
@endsection
