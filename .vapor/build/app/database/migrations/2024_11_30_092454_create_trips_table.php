<?php

use App\Enums\TripStatus;
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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->nullable()->unique();

            $table->text('notes')->nullable();

            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->cascadeOnDelete();
            $table->foreignId('path_id')->nullable()->constrained('paths')->cascadeOnDelete();

            $table->enum('status', array_column(TripStatus::cases(), 'value'))->default(TripStatus::SCHEDULED->value);

            $table->timestamp('start_at_day')->nullable();
            $table->time('start_at_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
