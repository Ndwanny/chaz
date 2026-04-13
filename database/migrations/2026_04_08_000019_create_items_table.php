<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 200);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('unit_of_measure', 50)->default('pcs');
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->integer('reorder_level')->default(0);
            $table->decimal('current_stock', 10, 3)->default(0);
            $table->decimal('unit_cost', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('item_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
