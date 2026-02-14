@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Users</h3>
        <x-primary-button href="{{ route('users.create') }}">Create User</x-primary-button>
    </div>

    <x-success-alert />
    <x-error-alert />

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="card-title">Users</h4>

                        {{-- filter by role --}}
                        <form method="GET" action="{{ route('users.index') }}">
                            <div class="form-group" style="width: 200px;">
                                <label>Filter by Role:</label>
                                <select class="js-example-basic-single" style="width: 100%;" name="role"
                                    onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="lecturer" {{ request('role') === 'lecturer' ? 'selected' : '' }}>
                                        Lecturer
                                    </option>
                                    <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>
                                        Student
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Email Verified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td><img class="img-xs rounded-circle mr-1"
                                                src="{{ Avatar::create($user->name)->toBase64() }}">
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($user->email_verified_at != null)
                                                <picture>
                                                    ✅ Email Verified
                                                @else
                                                    ❌ Email Not Verified
                                            @endif
                                        </td>
                                        <td>
                                            <x-edit-button href="{{ route('users.edit', $user->id) }}">
                                                Edit
                                            </x-edit-button>
                                            @if (!$user->hasRole('admin'))
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-delete-button type="submit">Delete</x-delete-button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
