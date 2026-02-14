<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollCoursesRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = User::query()->with('roles');

        // roles filter
        if (request()->filled('role')) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', request('role'));
            });
        }

        $users = $query->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole($validated['role']);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load(['teachingCourses', 'enrolledCourses', 'attendances.courseSession.course']);

        $attendances = $user->attendances->sortByDesc('created_at')->take(3);
        $totalAttendances = $user->attendances->count();
        $presentCount = $user->attendances->where('status', 'present')->count();

        $percentage = $totalAttendances > 0
            ? number_format(($presentCount / $totalAttendances) * 100, 2)
            : null;

        $courses = Course::all();

        return view('users.show', compact('user', 'attendances', 'percentage', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        // Reset verification if email changed
        if ($validated['email'] !== $user->email) {
            $validated['email_verified_at'] = null;
        }

        // Handle password only if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('lecturer') && $user->teachingCourses->isNotEmpty()) {
            return back()
                ->with('error', 'Cannot delete lecturer, the lecturer is currently teaching in a course.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Enroll the given student in multiple courses.
     *
     * Validates the request using EnrollCoursesRequest, then attaches the selected
     * course IDs to the student's enrolledCourses relationship.
     *
     * @param  \App\Http\Requests\EnrollCoursesRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enroll(EnrollCoursesRequest $request, User $user)
    {
        $courseIds = $request->validated()['course_ids'];

        $user->enrolledCourses()->syncWithoutDetaching($courseIds);

        return redirect()->back()->with('success', 'Student enrolled successfully.');
    }

    /**
     * Unenroll a student from a specific course.
     *
     * @param  \App\Models\User   $user    The student to unenroll.
     * @param  \App\Models\Course $course  The course to unenroll the student from.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unenroll(User $user, Course $course)
    {
        $user->enrolledCourses()->detach($course->id);

        return redirect()->back()->with('success', 'Student unenrolled successfully.');
    }
}
