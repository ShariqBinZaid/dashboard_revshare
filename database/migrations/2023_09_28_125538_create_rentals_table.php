<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->bigInteger('rental_addons_id')->unsigned();
            // $table->foreign('rental_addons_id')->references('id')->on('rentals')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->string('price_type')->nullable();
            $table->string('locations')->nullable();
            $table->string('desc')->nullable();
            $table->string('comments')->nullable();
            $table->string('datetime')->nullable();
            $table->string('capacity')->nullable();
            $table->enum('skills', ['beginner', 'intermediate', 'advanced', 'pro'])->nullable();
            $table->string('cancel_days')->nullable();
            $table->string('cancel_percent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
};
