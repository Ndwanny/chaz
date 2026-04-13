<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_insurance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->string('policy_number', 100);
            $table->string('insurer', 200);
            $table->enum('type', ['third_party', 'comprehensive', 'fleet'])->default('comprehensive');
            $table->date('start_date');
            $table->date('expiry_date');
            $table->decimal('premium', 12, 2)->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('document', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_insurance');
    }
};
