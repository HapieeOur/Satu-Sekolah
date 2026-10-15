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
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('status'); // hadir, terlambat, izin, sakit, alpa
            $table->time('check_in_time')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->index(['classroom_id', 'date'], 'idx_att_class_date');
            $table->index(['schedule_id', 'date'], 'idx_att_sched_date');
            $table->index(['student_id', 'date'], 'idx_att_student_date');
            $table->unique(['student_id', 'date', 'schedule_id'], 'uniq_student_session_date');
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
