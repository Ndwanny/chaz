<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 30)->unique();          // CHAZ-XXXXXXXXXXXX
            $table->string('lenco_reference', 80)->nullable();  // Lenco internal ref
            $table->string('collection_id', 80)->nullable();    // Lenco collection ID

            // Donor
            $table->string('first_name', 80);
            $table->string('last_name',  80);
            $table->string('email',     120);
            $table->string('phone',      30)->nullable();
            $table->text('message')->nullable();

            // Payment
            $table->decimal('amount', 12, 2);
            $table->string('currency', 5)->default('ZMW');
            $table->string('fund',    100);
            $table->string('payment_method', 20);               // mobile_money | card
            $table->string('mobile_network', 20)->nullable();   // mtn | airtel | zamtel

            // Status
            $table->string('status', 20)->default('pending');   // pending | successful | failed | cancelled
            $table->text('reason_for_failure')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
