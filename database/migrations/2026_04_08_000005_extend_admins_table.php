<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('role');
            $table->unsignedBigInteger('department_id')->nullable()->after('role_id');
            $table->string('staff_id', 20)->nullable()->unique()->after('department_id');
            $table->string('phone', 20)->nullable()->after('staff_id');
            $table->string('avatar', 255)->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->boolean('two_fa_enabled')->default(false)->after('is_active');
            $table->timestamp('last_password_change')->nullable()->after('two_fa_enabled');

            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });

        // Also add FK on departments.head_id now that admins exists
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('head_id')->references('id')->on('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_id']);
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn(['role_id', 'department_id', 'staff_id', 'phone', 'avatar', 'is_active', 'two_fa_enabled', 'last_password_change']);
        });
    }
};
