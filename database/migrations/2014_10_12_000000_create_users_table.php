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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('display_picture')->nullable();
            $table->string('user_name');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('new_password');
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->enum('user_type', ['user', 'admin'])->nullable();
            $table->integer('created_by')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
};
