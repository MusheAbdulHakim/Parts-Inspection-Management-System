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
        Schema::table('calibrations', function (Blueprint $table) {
            $table->dropColumn(['to_','from_']);
            $table->integer('interval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->dropColumn(['interval']);
        });
    }
};
