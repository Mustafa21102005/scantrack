@extends('layouts.app')

@section('title', 'My Courses')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            My Courses
        </h3>
    </div>

    <div class="row">
        @if ($courses->isEmpty())
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p>No courses found.</p>
                    </div>
                </div>
            </div>
        @endif
        @foreach ($courses as $course)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a>
                        </h5>
                        <p class="card-text">{{ Str::limit($course->description, 50) }}</p>
                        @role('student')
                            Lecturer:
                            <p>{{ $course->lecturer->name }}</p>
                        @endrole
                        @role('lecturer')
                            Students:
                            <p>
                                @forelse($course->students as $student)
                                    {{ $loop->first ? '' : ', ' }}{{ $student->name }}
                                @empty
                                    No students available
                                @endforelse
                            </p>
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
