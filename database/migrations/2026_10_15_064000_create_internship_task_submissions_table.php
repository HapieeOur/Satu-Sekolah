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
        Schema::create('internship_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('submission_file_path')->nullable();
            $table->text('student_notes')->nullable();
            $table->timestamp('submitted_at');
            $table->string('status')->default('submitted'); // submitted, graded, revision
            $table->unsignedTinyInteger('grade')->nullable(); // 0 - 100
            $table->text('mentor_feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();

            $table->unique(['internship_task_id', 'student_id'], 'uniq_task_student_submission');
            $table->index(['internship_task_id', 'status'], 'idx_task_sub_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_task_submissions');
    }
};
