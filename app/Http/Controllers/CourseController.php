<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lecturers = User::role('lecturer')->get();

        return view('courses.create', compact('lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validated();

        $lastCourse = Course::latest('id')->first();
        $number = $lastCourse ? $lastCourse->id + 1 : 1;
        $validated['code'] = 'COURSE_' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $lecturers = User::role('lecturer')->get();

        return view('courses.edit', compact('course', 'lecturers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->students->isNotEmpty()) {
            return back()->with('error', 'Cannot delete course, there are students enrolled in.');
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Show the courses enrolled in or teaching in by the current user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function my_courses()
    {
        $user = Auth::user();

        $courses = collect();

        // for students
        if ($user->hasRole('student')) {
            $courses = $user->enrolledCourses;
        }

        // for lecturers
        if ($user->hasRole('lecturer')) {
            $courses = $user->teachingCourses;
        }

        return view('courses.my_courses', compact('courses'));
    }
}
