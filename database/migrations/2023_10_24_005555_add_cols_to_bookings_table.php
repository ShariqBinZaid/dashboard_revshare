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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('bookable_type')->after('insurance_amount');
            $table->unsignedBigInteger('bookable_id')->after('bookable_type');
            $table->integer('adults')->nullable()->default(0)->after('bookable_id');
            $table->integer('childs')->nullable()->default(0)->after('adults');
            $table->integer('infants')->nullable()->default(0)->after('childs');
            $table->unsignedBigInteger('rental_availability_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
