<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trip_logs', function (Blueprint $table) {
            $table->id();
            $table->string('trip_number', 30)->nullable()->unique();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->tinyInteger('passenger_count')->default(0);
            $table->text('purpose');
            $table->string('departure_location', 255);
            $table->string('destination', 255);
            $table->date('departure_date');
            $table->time('departure_time')->nullable();
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->integer('starting_odometer')->nullable();
            $table->integer('ending_odometer')->nullable();
            $table->integer('distance_km')->nullable();
            $table->decimal('fuel_used', 8, 2)->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'cancelled'])->default('planned');
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('authorized_by')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trip_logs');
    }
};
