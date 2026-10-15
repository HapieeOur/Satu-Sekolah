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
        Schema::create('internship_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_placement_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('status'); // hadir, terlambat, izin, sakit, alpa

            // Check-in (Masuk)
            $table->time('check_in_time')->nullable();
            $table->decimal('check_in_latitude', 10, 7)->nullable();
            $table->decimal('check_in_longitude', 10, 7)->nullable();
            $table->string('check_in_photo_path')->nullable();
            $table->unsignedInteger('check_in_distance_meters')->nullable();
            $table->boolean('check_in_within_radius')->default(true);

            // Check-out (Pulang)
            $table->time('check_out_time')->nullable();
            $table->decimal('check_out_latitude', 10, 7)->nullable();
            $table->decimal('check_out_longitude', 10, 7)->nullable();
            $table->string('check_out_photo_path')->nullable();
            $table->unsignedInteger('check_out_distance_meters')->nullable();
            $table->boolean('check_out_within_radius')->default(true);

            // Verification & Status
            $table->string('verification_status')->default('verified'); // verified, pending, rejected, corrected
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();

            // Manual correction audit trail
            $table->boolean('is_manual_correction')->default(false);
            $table->foreignId('corrected_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('correction_reason')->nullable();
            $table->timestamp('corrected_at')->nullable();

            $table->timestamps();

            $table->unique(['internship_placement_id', 'date'], 'uniq_placement_attendance_date');
            $table->index(['date', 'verification_status'], 'idx_intern_att_date_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_attendances');
    }
};
