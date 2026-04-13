<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fuel_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->date('log_date');
            $table->integer('odometer_reading')->nullable();
            $table->decimal('litres', 8, 2);
            $table->decimal('unit_cost', 8, 2)->comment('Cost per litre in ZMW');
            $table->decimal('total_cost', 10, 2);
            $table->string('fuel_station', 255)->nullable();
            $table->string('receipt_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_logs');
    }
};
