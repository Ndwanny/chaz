<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->string('review_period', 50)->comment('e.g. Q1 2026, FY 2025/26');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('kpi_score', 5, 2)->nullable()->comment('Score out of 100');
            $table->enum('overall_rating', ['excellent', 'good', 'satisfactory', 'needs_improvement', 'unsatisfactory'])->nullable();
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('goals_next_period')->nullable();
            $table->text('employee_comments')->nullable();
            $table->text('reviewer_comments')->nullable();
            $table->enum('status', ['draft', 'submitted', 'reviewed', 'signed_off'])->default('draft');
            $table->timestamp('signed_off_at')->nullable();
            $table->timestamps();

            $table->foreign('reviewer_id')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
