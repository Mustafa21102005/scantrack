<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $attendances = Attendance::paginate(10);
        } else {
            $attendances = Attendance::whereHas('courseSession.course', function ($query) {
                $query->where('lecturer_id', auth()->user()->id);
            })->paginate(10);
        }
        return view('attendances.index', compact('attendances'));
    }

    /**
     * Show the user's attendance records.
     */
    public function myAttendance()
    {
        $attendances = auth()->user()
            ->attendances()
            ->with(['courseSession.course']) // eager load relationships
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalAttendances = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();

        $percentage = $totalAttendances > 0
            ? number_format(($presentCount / $totalAttendances) * 100, 2)
            : null;

        return view('attendances.my_attendance', compact('attendances', 'percentage'));
    }
}
