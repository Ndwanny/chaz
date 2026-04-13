<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable()->unique()->comment('Links to admin panel user account');
            $table->string('staff_number', 30)->unique();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('other_names', 100)->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth')->nullable();
            $table->string('national_id', 50)->nullable();
            $table->string('nrc_number', 50)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('designation', 150)->nullable()->comment('Job title');
            $table->enum('employment_type', ['permanent', 'contract', 'probation', 'casual'])->default('permanent');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->unsignedBigInteger('salary_grade_id')->nullable();
            $table->decimal('basic_salary', 12, 2)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account', 50)->nullable();
            $table->string('bank_branch', 100)->nullable();
            $table->string('napsa_number', 50)->nullable();
            $table->string('tpin', 50)->nullable();
            $table->string('medical_aid_provider', 100)->nullable();
            $table->string('medical_aid_number', 50)->nullable();
            $table->string('emergency_contact_name', 150)->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->string('emergency_contact_relationship', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('province', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('photo', 255)->nullable();
            $table->enum('status', ['active', 'on_leave', 'suspended', 'terminated', 'resigned', 'retired'])->default('active');
            $table->date('hired_at')->nullable();
            $table->date('terminated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('admin_id')->references('id')->on('admins')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
