<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add theme columns to admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->string('theme')->nullable()->default('sunset');
            $table->string('theme_color')->nullable()->default('blue');
        });

        // Add theme columns to companies table
        Schema::table('companies', function (Blueprint $table) {
            $table->string('theme')->nullable()->default('sunset');
            $table->string('theme_color')->nullable()->default('blue');
        });
    }

    public function down()
    {
        // Remove theme columns from admins table
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['theme', 'theme_color']);
        });

        // Remove theme columns from companies table
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['theme', 'theme_color']);
        });
    }
};
