<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('tour_id')->constrained()->onDelete('cascade');
            $table->string('author_name')->nullable(); // Для неавторизованных пользователей
            $table->tinyInteger('rating'); // 1-5 звезд
            $table->text('comment'); // Текст отзыва
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Статус модерации
            $table->timestamps();

            // Индексы для оптимизации
            $table->index('status');
            $table->index('tour_id');
            $table->index(['tour_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
