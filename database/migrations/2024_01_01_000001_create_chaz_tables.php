<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Admin users
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('editor'); // superadmin | editor
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // News / Articles
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tag')->default('General');
            $table->string('author')->default('CHAZ Communications');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Jobs
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department');
            $table->string('location');
            $table->string('type')->default('Full-time');
            $table->text('description');
            $table->json('duties');
            $table->json('qualifications');
            $table->date('deadline');
            $table->date('posted_at');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // Tenders
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->date('issued_at');
            $table->date('deadline');
            $table->enum('status', ['open', 'closed', 'awarded'])->default('open');
            $table->string('document')->nullable();
            $table->timestamps();
        });

        // Sub-Recipient Adverts
        Schema::create('sub_recipient_adverts', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('title');
            $table->string('grant');
            $table->string('funder')->default('Global Fund');
            $table->string('type');
            $table->text('description');
            $table->json('eligibility_criteria');
            $table->json('successful_applicants')->nullable();
            $table->string('issued');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->string('document')->nullable();
            $table->timestamps();
        });

        // Members
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['hospital', 'centre', 'cbo']);
            $table->string('province');
            $table->string('denomination');
            $table->string('district')->nullable();
            $table->string('contact')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Downloads (Publications, Annual Reports, Newsletters)
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['publication', 'annual_report', 'newsletter']);
            $table->string('type')->nullable();      // e.g. "Policy Brief", "Programme Report"
            $table->string('year', 4)->nullable();
            $table->string('issue')->nullable();     // e.g. "Vol. 18, Issue 1"
            $table->string('file_path')->nullable();
            $table->string('file_size')->nullable();
            $table->integer('pages')->nullable();
            $table->text('description')->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        // Contact messages
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Site settings
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('downloads');
        Schema::dropIfExists('members');
        Schema::dropIfExists('sub_recipient_adverts');
        Schema::dropIfExists('tenders');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('news');
        Schema::dropIfExists('admins');
    }
};
