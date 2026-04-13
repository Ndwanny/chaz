<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('description', 255);
            $table->string('unit_of_measure', 50)->nullable();
            $table->decimal('quantity_requested', 10, 3);
            $table->decimal('quantity_approved', 10, 3)->nullable();
            $table->decimal('quantity_issued', 10, 3)->default(0);
            $table->decimal('unit_cost_estimate', 12, 2)->nullable();
            $table->string('notes', 255)->nullable();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisition_items');
    }
};
