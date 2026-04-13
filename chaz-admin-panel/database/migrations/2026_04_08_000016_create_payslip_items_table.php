<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payslip_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payslip_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('salary_component_id')->nullable();
            $table->string('name', 100);
            $table->enum('type', ['allowance', 'deduction', 'tax']);
            $table->decimal('amount', 12, 2);
            $table->string('notes', 255)->nullable();
            $table->timestamps();

            $table->foreign('salary_component_id')->references('id')->on('salary_components')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslip_items');
    }
};
