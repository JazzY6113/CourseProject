<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('short_description', 255);
            $table->text('full_description');
            $table->decimal('price', 10, 2);
            $table->dateTime('booking_deadline');
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('duration_days');
            $table->tinyInteger('max_group_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
