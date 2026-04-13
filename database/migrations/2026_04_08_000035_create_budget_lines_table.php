<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budget_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained()->cascadeOnDelete();
            $table->string('account_code', 50)->nullable();
            $table->string('description', 255);
            $table->decimal('budgeted_amount', 14, 2);
            $table->decimal('spent_amount', 14, 2)->default(0);
            $table->decimal('q1_budget', 12, 2)->nullable();
            $table->decimal('q2_budget', 12, 2)->nullable();
            $table->decimal('q3_budget', 12, 2)->nullable();
            $table->decimal('q4_budget', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_lines');
    }
};
