@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-success-alert />
    <x-error-alert />

    <div class="col-12">
        <h4 class="mb-3">System Overview</h4>
    </div>

    @role('admin')
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem;">👨‍🏫</div>
                        <h3 class="mb-0">{{ $lecturerCount }}</h3>
                        <h6 class="text-muted font-weight-normal">Total Lecturers</h6>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem;">🧑‍🎓</div>
                        <h3 class="mb-0">{{ $studentCount }}</h3>
                        <h6 class="text-muted font-weight-normal">Total Students</h6>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">🧑‍💼</div>
                            <h3 class="mb-0">{{ $adminCount }}</h3>
                            <h6 class="text-muted font-weight-normal">Total Admins</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">📚</div>
                            <h3 class="mb-0">{{ $courseCount }}</h3>
                            <h6 class="text-muted font-weight-normal">Total Courses</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('lecturer')
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div style="font-size: 3rem;">🧑‍🎓</div>
                        <h3 class="mb-0">{{ $myStudentCount }}</h3>
                        <h6 class="text-muted font-weight-normal">Total Students</h6>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">📚</div>
                            <h3 class="mb-0">{{ $myCourseCount }}</h3>
                            <h6 class="text-muted font-weight-normal">Total Courses</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('student')
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">📚</div>
                            <h3 class="mb-0">{{ $myEnrolledCourseCount }}</h3>
                            <h6 class="text-muted font-weight-normal">Total Courses</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">🏫</div>
                            <h3 class="mb-0" style="color: {{ $attendancepercentage < 80 ? 'red' : 'green' }};">
                                %{{ $attendancepercentage }}
                            </h3>
                            <h6 class="text-muted font-weight-normal">Attendance Percentage</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">✔️</div>
                            <h3 class="mb-0">
                                {{ $presentCount }}
                            </h3>
                            <h6 class="text-muted font-weight-normal">Total Times Present</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <div style="font-size: 3rem;">❌</div>
                            <h3 class="mb-0">
                                {{ $absentCount }}
                            </h3>
                            <h6 class="text-muted font-weight-normal">Total Times Absent</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('admin')
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Courses with the Most Students</h4>
            </div>

            @foreach ($topCourses as $index => $course)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card text-center">
                        <div class="card-body">
                            @php
                                $numberEmojis = ['1️⃣', '2️⃣', '3️⃣'];
                                $number = $numberEmojis[$index] ?? $index + 1;
                            @endphp
                            <h6>{{ $number }} {{ $course->title }}</h6>
                            <h3>{{ $course->students_count }}</h3>
                            <p class="text-muted">Students Enrolled</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Top 3 Students with Highest Attendance</h4>
            </div>

            @foreach ($topStudents as $index => $student)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card text-center">
                        <div class="card-body">
                            @php
                                $rankEmojis = ['🥇', '🥈', '🥉'];
                                $rank = $rankEmojis[$index] ?? $index + 1;

                            @endphp
                            <h6>{{ $rank }} {{ $student->name }}</h6>
                            <h3>{{ $student->attendance_percentage }}%</h3>
                            <p class="text-muted">Attendance Percentage</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endrole

    @role('lecturer|student')
        <div class="row">

            <div class="col-12">
                <h4 class="mb-3">
                    @role('student')
                        Overall Attendance in Your Courses
                    @endrole
                    @role('lecturer')
                        Students' Attendance in Your Courses
                    @endrole

                </h4>
            </div>

            @foreach ($coursesData as $index => $course)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $course['title'] }} - Attendance</h4>
                            <canvas id="attendanceChart{{ $index }}"></canvas>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endrole

    @role('lecturer')
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Top 3 Students in Your Courses</h4>
            </div>

            @foreach ($topStudentsForLecturer as $index => $student)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card text-center">
                        <div class="card-body">
                            @php
                                $rankEmojis = ['🥇', '🥈', '🥉'];
                                $rank = $rankEmojis[$index] ?? $index + 1;
                            @endphp
                            <h6>{{ $rank }} {{ $student->name }}</h6>
                            <h3>{{ $student->attendance_percentage }}%</h3>
                            <p class="text-muted">Attendance Percentage</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endrole
@endsection

@section('js')
    <script>
        @foreach ($coursesData as $index => $course)
            var canvas{{ $index }} = document.getElementById('attendanceChart{{ $index }}');

            @if ($course['present'] + $course['absent'] > 0)
                // Render chart if data exists
                new Chart(canvas{{ $index }}.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Present', 'Absent'],
                        datasets: [{
                            label: 'Students',
                            data: [{{ $course['present'] }}, {{ $course['absent'] }}],
                            backgroundColor: ['#28a745', '#dc3545']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            @else
                // Replace only the canvas with a message
                canvas{{ $index }}.outerHTML =
                    '<p class="text-center text-muted mt-4">No attendance data available for this course.</p>';
            @endif
        @endforeach
    </script>
@endsection
