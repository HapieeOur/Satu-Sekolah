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
        Schema::create('academic_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->dateTime('due_date');
            $table->string('attachment_path')->nullable();
            $table->timestamps();

            $table->index(['classroom_id', 'due_date'], 'idx_academic_tasks_classroom_due');
            $table->index(['teacher_id', 'classroom_id'], 'idx_academic_tasks_teacher_classroom');
        });

        Schema::create('academic_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_task_id')->constrained('academic_tasks')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('submission_file_path')->nullable();
            $table->text('student_notes')->nullable();
            $table->dateTime('submitted_at');
            $table->unsignedTinyInteger('grade')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->string('status')->default('submitted'); // submitted, late, graded
            $table->timestamps();

            $table->unique(['academic_task_id', 'student_id'], 'uniq_academic_task_student_sub');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_task_submissions');
        Schema::dropIfExists('academic_tasks');
    }
};
