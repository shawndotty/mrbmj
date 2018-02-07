<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->integer('type');
            $table->integer('pax');
            $table->string('group_type');
            $table->datetime('pickup_at');
            $table->datetime('dropoff_at');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->json('vehicle_option')->nullable()->default(NULL);
            $table->longtext('itinerary')->nullable()->default(NULL);
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
        Schema::dropIfExists('orders');
    }
}
