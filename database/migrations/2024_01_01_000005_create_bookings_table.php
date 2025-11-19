<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_date_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_status_id')->constrained()->onDelete('cascade');
            $table->timestamp('booking_date')->useCurrent();
            $table->tinyInteger('guests_count');
            $table->decimal('total_price', 10, 2);
            $table->string('contact_phone', 255);
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
