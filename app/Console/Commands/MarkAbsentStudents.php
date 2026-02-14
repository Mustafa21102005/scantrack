<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\CourseSession;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsentStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark absent students for expired course sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find all sessions that have ended
        $sessions = CourseSession::where('expires_at', '<', Carbon::now())->get();

        foreach ($sessions as $session) {
            $course = $session->course;

            if (!$course) {
                $this->warn("No course found for session ID: {$session->id}");
                continue;
            }

            // Get all enrolled students as a collection
            $enrolledStudents = $course->students()->get();

            // Get student IDs who already have attendance for this session
            $presentIds = Attendance::where('course_session_id', $session->id)
                ->pluck('student_id')
                ->toArray();

            // Get students who have NOT recorded attendance
            $absentStudents = $enrolledStudents->whereNotIn('id', $presentIds);

            foreach ($absentStudents as $student) {
                Attendance::firstOrCreate([
                    'student_id' => $student->id,
                    'course_session_id' => $session->id,
                ], [
                    'status' => 'absent',
                ]);
            }

            // Debug output
            $this->info("Session ID: {$session->id}");
            $this->info("Enrolled: " . implode(',', $enrolledStudents->pluck('id')->toArray()));
            $this->info("Present: " . implode(',', $presentIds));
            $this->info("Absent: " . implode(',', $absentStudents->pluck('id')->toArray()));
            $this->info("Marked " . count($absentStudents) . " students absent.");
        }

        return Command::SUCCESS;
    }
}
