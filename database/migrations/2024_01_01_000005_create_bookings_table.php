<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tour_date_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_status_id')->constrained()->onDelete('cascade');
            $table->integer('adults_count')->default(1);
            $table->integer('children_count')->default(0);
            $table->decimal('total_price', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->text('special_requests')->nullable();
            $table->text('participants_info')->nullable();
            $table->timestamp('booking_date')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
