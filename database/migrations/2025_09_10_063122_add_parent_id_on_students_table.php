<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role enum('admin', 'teacher', 'expert', 'parent')");

        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role enum('admin', 'teacher', 'expert')");

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
};
