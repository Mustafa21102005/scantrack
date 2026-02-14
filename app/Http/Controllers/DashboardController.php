<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $lecturerCount = User::role('lecturer')->count();
        $adminCount    = User::role('admin')->count();
        $courseCount   = Course::count();
        $studentCount  = User::role('student')->count();

        // Common variables
        $myCourseCount = 0;
        $myStudentCount = 0;
        $coursesData = [];

        // =========================
        // Lecturer-specific stats
        // =========================
        $topStudentsForLecturer = collect(); // default empty

        if ($user->hasRole('lecturer')) {
            $courses = $user->teachingCourses()->with('students')->get();

            foreach ($courses as $course) {
                $presentCount = Attendance::where('status', 'present')
                    ->whereHas('courseSession', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    })
                    ->count();

                $absentCount = Attendance::where('status', 'absent')
                    ->whereHas('courseSession', function ($q) use ($course) {
                        $q->where('course_id', $course->id);
                    })
                    ->count();

                $coursesData[] = [
                    'title' => $course->title,
                    'present' => $presentCount,
                    'absent' => $absentCount,
                ];
            }

            $myCourseCount = $courses->count();
            $myStudentCount = $courses->sum(function ($course) {
                return $course->students->count();
            });

            // Top students in lecturer's courses
            $studentIds = $courses->flatMap(function ($course) {
                return $course->students->pluck('id');
            })->unique();

            $topStudentsForLecturer = User::whereIn('id', $studentIds)
                ->withCount(['attendances as present_count' => function ($q) {
                    $q->where('status', 'present');
                }])
                ->withCount('attendances as total_attendance')
                ->get()
                ->map(function ($student) {
                    $percentage = $student->total_attendance > 0
                        ? ($student->present_count / $student->total_attendance) * 100
                        : 0;
                    $student->attendance_percentage = round($percentage, 2);
                    return $student;
                })
                ->sortByDesc('attendance_percentage')
                ->take(3)
                ->values(); // reindex keys 0,1,2
        }

        // =========================
        // Student-specific stats
        // =========================
        $myEnrolledCourseCount = 0;
        $attendancepercentage  = 0;
        $presentCount = 0;
        $absentCount = 0;

        if ($user->hasRole('student')) {
            $courses = $user->enrolledCourses()->get();
            $myEnrolledCourseCount = $courses->count();

            foreach ($courses as $course) {
                $presentCountCourse = Attendance::where('student_id', $user->id)
                    ->whereHas('courseSession', function ($query) use ($course) {
                        $query->where('course_id', $course->id);
                    })
                    ->where('status', 'present')
                    ->count();

                $absentCountCourse = Attendance::where('student_id', $user->id)
                    ->whereHas('courseSession', function ($query) use ($course) {
                        $query->where('course_id', $course->id);
                    })
                    ->where('status', 'absent')
                    ->count();

                $coursesData[] = [
                    'title' => $course->title,
                    'present' => $presentCountCourse,
                    'absent' => $absentCountCourse,
                ];
            }

            // Overall attendance for student
            $totalAttendanceRecords = $user->attendances()->count();
            $presentCount = $user->attendances()->where('status', 'present')->count();
            $absentCount  = $user->attendances()->where('status', 'absent')->count();

            if ($totalAttendanceRecords > 0) {
                $attendancepercentage = round(($presentCount / $totalAttendanceRecords) * 100, 2);
            }
        }

        // =========================
        // Admin-specific stats
        // =========================
        $topCourses = collect();
        $topStudents = collect();

        if ($user->hasRole('admin')) {
            $topCourses = Course::withCount('students')
                ->orderBy('students_count', 'desc')
                ->take(3)
                ->get();

            $topStudents = User::role('student')
                ->withCount(['attendances as present_count' => function ($q) {
                    $q->where('status', 'present');
                }])
                ->withCount('attendances as total_attendance')
                ->get()
                ->map(function ($student) {
                    $percentage = $student->total_attendance > 0
                        ? ($student->present_count / $student->total_attendance) * 100
                        : 0;
                    $student->attendance_percentage = round($percentage, 2);
                    return $student;
                })
                ->sortByDesc('attendance_percentage')
                ->take(3)
                ->values(); // reindex keys
        }

        return view('dashboard', compact(
            'lecturerCount',
            'adminCount',
            'courseCount',
            'studentCount',
            'myCourseCount',
            'myStudentCount',
            'myEnrolledCourseCount',
            'attendancepercentage',
            'presentCount',
            'absentCount',
            'coursesData',
            'topCourses',
            'topStudents',
            'topStudentsForLecturer'
        ));
    }
}
