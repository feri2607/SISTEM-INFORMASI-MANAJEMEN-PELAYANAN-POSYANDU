<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'slug')) {
                $table->string('slug')->nullable()->unique();
            }
            if (!Schema::hasColumn('announcements', 'excerpt')) {
                $table->text('excerpt')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'content')) {
                $table->longText('content')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'priority')) {
                $table->string('priority')->default('normal');
            }
            if (!Schema::hasColumn('announcements', 'status')) {
                $table->string('status')->default('draft');
            }
            if (!Schema::hasColumn('announcements', 'publish_at')) {
                $table->timestamp('publish_at')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'expire_at')) {
                $table->timestamp('expire_at')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'views')) {
                $table->integer('views')->default(0);
            }
            if (!Schema::hasColumn('announcements', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('announcements', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (!Schema::hasColumn('announcements', 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }

            // foreign keys are optional for migration safety in sqlite dev env
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn([
                'title', 'slug', 'excerpt', 'content', 'category_id', 'user_id',
                'priority', 'status', 'publish_at', 'expire_at', 'views', 'is_featured',
                'meta_title', 'meta_description', 'meta_keywords'
            ]);
        });
    }
};
