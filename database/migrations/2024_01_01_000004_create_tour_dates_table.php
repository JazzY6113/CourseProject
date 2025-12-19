<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tour_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('available_seats');
            $table->decimal('current_price', 10, 2);
            $table->boolean('is_guaranteed')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['start_date', 'available_seats']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_dates');
    }
};
