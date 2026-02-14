@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Courses</h3>
        <x-primary-button href="{{ route('courses.create') }}">Create Course</x-primary-button>
    </div>

    <x-success-alert />
    <x-error-alert />

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Courses</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Lecturer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($courses->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No courses available.</td>
                                    </tr>
                                @else
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->id }}</td>
                                            <td><a href="{{ route('courses.show', $course->id) }}">{{ $course->code }}</a>
                                            </td>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ Str::limit($course->description, 50) }}</td>
                                            <td><a
                                                    href="{{ route('users.show', $course->lecturer->id) }}">{{ $course->lecturer->name }}</a>
                                            </td>
                                            <td>
                                                <x-edit-button href="{{ route('courses.edit', $course->id) }}">
                                                    Edit
                                                </x-edit-button>
                                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-delete-button type="submit">Delete</x-delete-button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
