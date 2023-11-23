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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_name');
            $table->dropColumn('lati');
            $table->dropColumn('longi');
            $table->dropColumn('new_password');
            $table->string('location')->nullable()->after('dob');
            $table->string('lat')->nullable()->after('location');
            $table->string('lng')->nullable()->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
