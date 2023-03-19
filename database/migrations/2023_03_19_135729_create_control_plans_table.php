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
        Schema::create('control_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('number_feature_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('binary_feature_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('gauge_feature_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('work_instruction_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('control_plans');
    }
};
