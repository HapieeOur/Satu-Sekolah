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
        Schema::create('internship_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_placement_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('title');
            $table->text('activity_description');
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('submitted'); // draft, submitted, revision_requested, approved
            $table->text('mentor_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['internship_placement_id', 'date'], 'uniq_placement_journal_date');
            $table->index(['status', 'date'], 'idx_journal_status_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_journals');
    }
};
