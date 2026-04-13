<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('portal_password')->nullable()->after('photo');
            $table->timestamp('portal_last_login')->nullable()->after('portal_password');
            $table->boolean('portal_active')->default(true)->after('portal_last_login');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['portal_password', 'portal_last_login', 'portal_active']);
        });
    }
};
