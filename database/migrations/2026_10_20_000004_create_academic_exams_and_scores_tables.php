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
        Schema::create('academic_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('exam_date');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->unsignedSmallInteger('passing_score')->default(75);
            $table->string('status')->default('scheduled'); // scheduled, completed
            $table->timestamps();

            $table->index(['classroom_id', 'exam_date'], 'idx_academic_exams_classroom_date');
            $table->index(['teacher_id', 'classroom_id'], 'idx_academic_exams_teacher_classroom');
        });

        Schema::create('academic_exam_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_exam_id')->constrained('academic_exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('is_remedial')->default(false);
            $table->text('notes')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->timestamps();

            $table->unique(['academic_exam_id', 'student_id'], 'uniq_academic_exam_student_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_exam_scores');
        Schema::dropIfExists('academic_exams');
    }
};
