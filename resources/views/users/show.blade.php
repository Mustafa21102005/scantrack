@extends('layouts.app')

@section('title', 'User')

@section('content')
    <div class="page-header">
        <h3 class="page-title">{{ $user->name }} </h3>
        <x-primary-button href="{{ route('users.index') }}">Back to Users</x-primary-button>
    </div>

    <x-success-alert />

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Details</h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($user->hasRole('student'))
                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">Courses Enrolled In</h4>
                                @role('admin')
                                    <x-primary-button type="button" data-toggle="modal" data-target="#enrollModal">
                                        Enroll
                                    </x-primary-button>
                                @endrole
                            </div>

                            <table class="table">
                                <tbody>
                                    @if ($user->enrolledCourses->isEmpty())
                                        <tr>
                                            <td colspan="2">
                                                No courses enrolled in.
                                                @role('admin')
                                                    <x-primary-button type="button" data-toggle="modal"
                                                        data-target="#enrollModal">
                                                        Enroll
                                                    </x-primary-button>
                                                @endrole
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($user->enrolledCourses as $course)
                                            <tr>
                                                <td><a
                                                        href="{{ route('courses.show', $course->id) }}">{{ $course->code }}</a>
                                                </td>
                                                <td>{{ $course->title }}</td>
                                                @role('admin')
                                                    <td>
                                                        <form
                                                            action="{{ route('students.unenroll', [$user->id, $course->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-delete-button type="submit">Unenroll</x-delete-button>
                                                        </form>
                                                    </td>
                                                @endrole
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            <h4 class="card-title">Attendance</h4>
                            <table class="table">
                                <tbody>
                                    @if ($attendances->isEmpty())
                                        <tr>
                                            <td colspan="4">No attendance records found.</td>
                                        </tr>
                                    @else
                                        @foreach ($attendances as $attendance)
                                            <tr>
                                                <td><a
                                                        href="{{ route('courses.show', $attendance->courseSession->course->id) }}">
                                                        {{ $attendance->courseSession->course->code }}
                                                    </a>
                                                </td>
                                                <td>{{ ucfirst($attendance->status) }}</td>
                                                <td>{{ $attendance->created_at->format('d-m-Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4">Attendance Percentage: {{ $percentage }}%</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @elseif($user->hasRole('lecturer'))
                        <div class="mt-5">
                            <h4 class="card-title">Teaching in</h4>
                            <table class="table">
                                <tbody>
                                    @forelse($user->teachingCourses as $course)
                                        <tr>
                                            <td><a href="{{ route('courses.show', $course->id) }}">{{ $course->code }}</a>
                                            </td>
                                            <td>{{ $course->title }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2">No courses assigned. <x-primary-button
                                                    href="{{ route('courses.create', ['lecturer_id' => $user->id]) }}">Assign
                                                    Course
                                                </x-primary-button>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Enroll Modal --}}
    <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('students.enroll', $user->id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enrollModalLabel">Enroll in Courses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="courses">Select Courses</label>
                            <select name="course_ids[]" id="courses" class="form-control" multiple required>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        {{ $user->enrolledCourses->contains($course->id) ? 'disabled' : '' }}>
                                        {{ $course->code }} - {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Enroll</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
