<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // For SQLite, we need to recreate the table with the updated enum
        if (env('DB_CONNECTION') === 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                // SQLite doesn't support modifying enum directly, so we drop and recreate
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'user', 'warga'])->default('user')->after('remember_token');
            });
        } else {
            // For other databases like MySQL/PostgreSQL
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'user', 'warga'])->default('user')->change();
            });
        }
    }

    public function down(): void
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'user'])->default('user')->after('remember_token');
            });
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'user'])->default('user')->change();
            });
        }
    }
};
