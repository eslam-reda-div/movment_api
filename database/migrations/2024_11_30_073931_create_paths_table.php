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
        Schema::create('paths', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->nullable()->unique();

            $table->string('name')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('domain_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');

            $table->foreignId('from')->nullable()->constrained('destinations')->onDelete('cascade');

            $table->json('stops')->nullable();

            $table->foreignId('to')->nullable()->constrained('destinations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paths');
    }
};
