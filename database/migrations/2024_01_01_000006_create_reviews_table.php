<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('author_name');
            $table->tinyInteger('rating');
            $table->text('comment');
            $table->text('admin_response')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();

            $table->index(['tour_id', 'status']);
            $table->index(['user_id', 'tour_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
