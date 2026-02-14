@extends('layouts.app')

@section('title', 'Attendances')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Attendances</h3>
    </div>

    <x-success-alert />

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Attendances</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Session ID</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($attendances->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">No attendances found.</td>
                                    </tr>
                                @else
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->id }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $attendance->student->id) }}">
                                                    {{ $attendance->student->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('courses.show', $attendance->courseSession->course->id) }}">
                                                    {{ $attendance->courseSession->course->title }}
                                                </a>
                                            </td>
                                            <td>{{ $attendance->courseSession->id }}</td>
                                            <td>{{ ucfirst($attendance->status) }}</td>
                                            <td>{{ $attendance->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        {{ $attendances->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
