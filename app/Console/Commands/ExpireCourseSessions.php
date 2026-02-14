<?php

namespace App\Console\Commands;

use App\Models\CourseSession;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireCourseSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark expired course sessions as inactive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = CourseSession::where('expires_at', '<', Carbon::now())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->info("Expired $expired course sessions.");
    }
}
