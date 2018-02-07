<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    	factory(App\User::class)->create();
        factory(App\Client::class, 40)->create();
        factory(App\Driver::class, 20)->create();
        factory(App\Guide::class, 20)->create();
        factory(App\Vehicle::class, 30)->create();
        factory(App\Order::class, 80)->create();
        factory(App\Invoice::class, 160)->create();
        factory(App\DriverSchedule::class, 50)->create();
        factory(App\GuideSchedule::class, 50)->create();
        factory(App\VehicleSchedule::class, 50)->create();


        // Seed driver_order table

        $orders = App\Order::all();
        $drivers = App\Driver::all();
        $guides = App\Guide::all();
        $vehicles = App\Vehicle::all();

        $this->seedManyToMany($drivers, $orders);
        $this->seedManyToMany($guides, $orders);
        $this->seedManyToMany($vehicles, $orders);
    }

    public function seedManyToMany($items, $orders) {
        foreach ($items as $item) {
           $item->orders()->attach($orders->random(rand(1,4))->pluck('id')->toArray());
        }
    }
}
