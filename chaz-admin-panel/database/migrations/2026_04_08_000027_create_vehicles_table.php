<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 30)->unique();
            $table->string('make', 100);
            $table->string('model', 100);
            $table->year('year')->nullable();
            $table->string('color', 50)->nullable();
            $table->string('body_type', 100)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('fuel_type', ['petrol', 'diesel', 'electric', 'hybrid'])->default('diesel');
            $table->string('engine_capacity', 20)->nullable();
            $table->string('chassis_number', 100)->nullable()->unique();
            $table->string('engine_number', 100)->nullable();
            $table->tinyInteger('seating_capacity')->nullable();
            $table->integer('current_mileage')->default(0);
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->decimal('current_value', 12, 2)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('province', 100)->nullable();
            $table->enum('status', ['active', 'maintenance', 'retired', 'disposed'])->default('active');
            $table->string('photo', 255)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('vehicle_categories')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
