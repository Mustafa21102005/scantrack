<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('course_session_id')->index();
            $table->foreign('course_session_id')->references('id')->on('course_sessions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('status', ['present', 'absent'])->default('present');
            $table->timestamps();

            // to prevent duplicate scans
            $table->unique(['student_id', 'course_session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
