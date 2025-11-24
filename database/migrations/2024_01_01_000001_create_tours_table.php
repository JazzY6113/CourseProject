<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->text('full_description');
            $table->decimal('base_price', 10, 2);
            $table->integer('duration_days');
            $table->integer('max_group_size');
            $table->integer('min_group_size')->default(1);
            $table->text('included')->nullable();
            $table->text('not_included')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hot')->default(false);
            $table->integer('booking_deadline_days')->default(7);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tours');
    }
};
