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
        Schema::create('internship_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete(); // Mentor creator
            $table->foreignId('internship_company_id')->nullable()->constrained()->nullOnDelete(); // Optional filter by company
            $table->string('title');
            $table->text('description');
            $table->date('due_date');
            $table->string('attachment_path')->nullable();
            $table->timestamps();

            $table->index(['teacher_id', 'due_date'], 'idx_tasks_teacher_due');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_tasks');
    }
};
