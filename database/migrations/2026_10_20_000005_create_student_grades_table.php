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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // tugas, ulangan_harian, uts, uas, akhir
            $table->string('title'); // e.g. "Tugas 1", "UH 1", "UTS", "UAS", "Nilai Akhir"
            $table->decimal('score', 5, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(
                ['classroom_id', 'subject_id', 'student_id', 'type', 'title'],
                'uniq_classroom_subj_stu_type_title'
            );
            $table->index(['classroom_id', 'subject_id'], 'idx_grades_classroom_subject');
            $table->index(['student_id', 'subject_id'], 'idx_grades_student_subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
