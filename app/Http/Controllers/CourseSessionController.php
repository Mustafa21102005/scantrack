<?php

namespace App\Http\Controllers;

use App\Models\CourseSession;
use App\Http\Requests\StoreCourseSessionRequest;
use App\Http\Requests\UpdateCourseSessionRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CourseSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $qrCodes = auth()->user()->teachingCourses->flatMap(function ($course) {
            return $course->sessions;
        });

        return view('qr-codes.index', compact('qrCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = auth()->user()->teachingCourses;

        return view('qr-codes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseSessionRequest $request)
    {
        $validated = $request->validated();

        // Ensure QR token is unique
        do {
            $validated['qr_token'] = Str::random(32);
        } while (CourseSession::where('qr_token', $validated['qr_token'])->exists());

        // Set default values
        $validated['is_active'] = true;
        $validated['expires_at'] = $validated['expires_at'] ?? now()->addMinutes(10);

        // Create the session
        CourseSession::create($validated);

        return redirect()->route('qr-codes.index')->with('success', 'QR Code session created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseSession $qrCode)
    {
        return view('qr-codes.edit', compact('qrCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseSessionRequest $request, CourseSession $qrCode)
    {
        // Prevent editing expired/inactive sessions
        if (!$qrCode->is_active) {
            return back()->withErrors([
                'error' => 'Cannot edit an expired QR Code session.'
            ]);
        }

        $qrCode->update($request->validated());

        return redirect()->route('qr-codes.index')->with('success', 'QR Code session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSession $qrCode)
    {
        $qrCode->delete();

        return redirect()->route('qr-codes.index')->with('success', 'QR Code session deleted successfully.');
    }

    /**
     * Expire the specified QR Code session.
     *
     * @param CourseSession $qrCode The QR Code session to expire
     * @return \Illuminate\Http\RedirectResponse
     */
    public function expire(CourseSession $qrCode)
    {
        if (!$qrCode->is_active) {
            return redirect()->back()->with('error', 'QR Code is already inactive.');
        }

        $qrCode->is_active = false;
        $qrCode->expires_at = now();
        $qrCode->save();

        return redirect()->back()->with('success', 'QR Code expired successfully.');
    }

    /**
     * Scan a QR code and mark attendance if valid
     *
     * @param string $token QR token
     * @return \Illuminate\Http\Response
     */
    public function scan($token)
    {
        $session = CourseSession::with('course')
            ->where('qr_token', $token)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->first();

        if (!$session) {
            return view('attendances.messages.error'); // Expired or invalid
        }

        if (!Auth::check()) {
            Session::put('qr_scan_token', $token);
            return redirect()->route('login')->withErrors(['error' => 'Please login to mark attendance.']);
        }

        $user = Auth::user();

        // Check if student is enrolled in the course
        $isEnrolled = $user->enrolledCourses()->where('course_id', $session->course_id)->exists();

        if (!$isEnrolled) {
            return redirect()->route('dashboard')->withErrors(['error' => 'You are not enrolled in this course.']);
        }

        // Check if already scanned
        $alreadyMarked = Attendance::where('student_id', $user->id)
            ->where('course_session_id', $session->id)
            ->exists();

        if ($alreadyMarked) {
            return view('attendances.messages.already-marked');
        }

        // Mark attendance
        Attendance::create([
            'student_id' => $user->id,
            'course_session_id' => $session->id,
            'status' => 'present',
        ]);

        return view('attendances.messages.success');
    }
}
