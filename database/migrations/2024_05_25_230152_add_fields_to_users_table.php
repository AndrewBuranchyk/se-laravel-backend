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
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'department_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->mediumInteger('department_id');
                });
            }
            if (!Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'department_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('department_id');
                });
            }
            if (Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('role');
                });
            }
        }
    }
};
