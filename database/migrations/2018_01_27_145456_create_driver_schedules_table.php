<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->integer('driver_id');
            $table->integer('type');
            $table->integer('order_id')->nullable()->default(NULL);
            $table->longtext('note')->nullable()->default(NULL);
            $table->json('option')->nullable()->default(NULL);
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
        Schema::dropIfExists('driver_schedules');
    }
}
