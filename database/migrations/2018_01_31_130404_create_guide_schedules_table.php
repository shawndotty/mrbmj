<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuideSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guide_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->integer('guide_id');
            $table->integer('type');
            $table->integer('order_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('guide_schedules');
    }
}
