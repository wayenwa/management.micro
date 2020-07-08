<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_timings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('mon')->default(1);
            $table->boolean('tue')->default(1);
            $table->boolean('wed')->default(1);
            $table->boolean('thu')->default(1);
            $table->boolean('fri')->default(1);
            $table->boolean('sat')->default(1);
            $table->boolean('sun')->default(1);
            $table->time('from');
            $table->time('to');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('schedule_timings');
    }
}
