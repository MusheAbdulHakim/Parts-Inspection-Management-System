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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->double('target')->nullable();
            $table->double('upper_limit')->nullable();
            $table->double('lower_limit')->nullable();
            $table->boolean('bool')->nullable();
            $table->longText('control_method')->nullable();
            $table->foreignId('calibration_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('control_tool_id')->nullable();
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
        Schema::dropIfExists('features');
    }
};
