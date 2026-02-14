@extends('layouts.app')

@section('title', 'Course')

@section('content')
    <div class="page-header">
        <h3 class="page-title">{{ $course->title }} Course</h3>
        @role('admin')
            <x-primary-button href="{{ route('courses.index') }}">Back to Courses</x-primary-button>
        @endrole
        @role('lecturer|student')
            <x-primary-button href="{{ route('courses.me') }}">Back to My Courses</x-primary-button>
        @endrole
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Course Details</h4>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $course->id }}</td>
                            </tr>
                            <tr>
                                <th>Code</th>
                                <td>{{ $course->code }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $course->title }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td style="white-space: pre-wrap; word-wrap: break-word;">{{ $course->description }}</td>
                            </tr>
                            <tr>
                                <th>Lecturer</th>
                                <td>
                                    @role('admin')
                                        <a
                                            href="{{ route('users.show', $course->lecturer->id) }}">{{ $course->lecturer->name }}</a>
                                    @else
                                        {{ $course->lecturer->name }}
                                    @endrole
                                </td>
                            </tr>
                            @role('admin|lecturer')
                                <tr>
                                    <th>Students</th>
                                    <td>
                                        @if ($course->students->isEmpty())
                                            No students enrolled.
                                        @else
                                            @foreach ($course->students as $student)
                                                @role('admin')
                                                    <a href="{{ route('users.show', $student->id) }}">{{ $student->name }}</a>
                                                @else
                                                    {{ $student->name }}
                                                @endrole
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endrole
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
