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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('semester'); // ganjil, genap
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->string('day_of_week'); // senin, selasa, rabu, kamis, jumat, sabtu
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            // Indexes for fast schedule lookups and conflict queries
            $table->index(['academic_year_id', 'semester', 'classroom_id', 'day_of_week'], 'idx_sched_class');
            $table->index(['academic_year_id', 'semester', 'teacher_id', 'day_of_week'], 'idx_sched_teacher');
            $table->index(['academic_year_id', 'semester', 'room_id', 'day_of_week'], 'idx_sched_room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
