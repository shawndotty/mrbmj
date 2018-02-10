<?php

namespace App\Http\Controllers;

use App\Order;
use App\Client;
use Carbon\Carbon;
use App\Vehicle;
use DB;
use Illuminate\Http\Request;
use App\VehicleSchedule;
use App\DriverSchedule;
use App\GuideSchedule;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::with(['client:id,first_name,last_name', 'drivers', 'guides', 'vehicles'])->get();
        // foreach ($orders as $order) {
        //    $order->client_name = $order->client->name;
        // }
        return $orders;
    }

    public function indexWithRange(Request $request){
        if (isset($request->start_at) && isset($request->end_at)) {
            $overlaps = [];
            $start = $request->start_at;
            $end = $request->end_at;
        
            $orders = Order::whereBetween('pickup_at', [$start, $end])
                             ->orWhereBetween('dropoff_at', [$start, $end])
                             ->orWhere([['pickup_at', '>', $start],['dropoff_at', '<', $end]])
                             ->orderBy('pickup_at', 'asc')
                             ->get();
            return $orders;
        } else {
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $client = Client::find($request->client['id']);
        $vehicleRequest = collect($request->vehicles);
        $vehicleOption = [
            'total' => $request->vehiclesNeeded,
            'needs' => collect([])
        ];
        $vehicleOptionGrouped = $vehicleRequest->groupBy('id');
        foreach ($vehicleOptionGrouped as $key => $vehicles) {
           $vehicleOption['needs']->push(
                [
                    'type'=>$key,
                    'name'=>collect($vehicles)->first()['name'],
                    'num' =>collect($vehicles)->count()
                ]
           );  
        }

        if ($request->needGuides) {
            $guideOption = [
                'total' => $request->guidesNeeded,
            ];
        }

        $order = $client->orders()->create([
            'type'=> $request->orderType['id'],
            'pax' => $request->pax,
            'group_type' => $request->groupType,
            'pickup_at' => Carbon::createFromFormat('Y-m-d H:i:s', $request->pickupDate . ' ' . $request->pickupTime),
            'dropoff_at' => Carbon::createFromFormat('Y-m-d H:i:s', $request->dropoffDate . ' ' . $request->dropoffTime),
            'pickup_location' => $request->pickupLocation,
            'dropoff_location' => $request->dropoffLocation,
            'vehicle_option' => $vehicleOption,
            'guide_option' => $guideOption,
            'itinerary'  => $request->itinerary,
            
            ]);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    public function assignVehicle(Request $request){
        $order = Order::find($request->orderId);
        $order->vehicles()->attach($request->vehicleId);

        $vs = new VehicleSchedule();
        $vs->vehicle_id = $request->vehicleId;
        $vs->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->pickup_at );
        $vs->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->dropoff_at );
        $vs->type = 1;
        $vs->order_id = $request->orderId;
        $vs->save();

        return $vs;
    }

    public function removeVehicle(Request $request){
        $order = Order::find($request->oId);
        $order->vehicles()->detach($request->vId);

        DB::table('vehicle_schedules')
        ->where('order_id', $request->oId)
        ->where('vehicle_id', $request->vId)
        ->delete();
        // $v = Vehicle::get($request->vId);
        // $v->vehicleSchedules()->where('order_id', $request->oId)->delete();
    }

    public function assignDriver(Request $request){
        $order = Order::find($request->oId);
        $order->drivers()->attach($request->dId);

        $ds = new DriverSchedule();
        $ds->driver_id = $request->dId;
        $ds->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->pickup_at );
        $ds->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->dropoff_at );
        $ds->type = 1;
        $ds->order_id = $request->oId;
        $ds->save();

        return $ds;
    }

    public function removeDriver(Request $request){
        $order = Order::find($request->oId);
        $order->drivers()->detach($request->dId);

        DB::table('driver_schedules')
        ->where('order_id', $request->oId)
        ->where('driver_id', $request->dId)
        ->delete();
        // $v = Vehicle::get($request->vId);
        // $v->vehicleSchedules()->where('order_id', $request->oId)->delete();
    }

    public function assignGuide(Request $request){
        $order = Order::find($request->oId);
        $order->guides()->attach($request->dId);

        $ds = new GuideSchedule();
        $ds->guide_id = $request->dId;
        $ds->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->pickup_at );
        $ds->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $order->dropoff_at );
        $ds->type = 1;
        $ds->order_id = $request->oId;
        $ds->save();

        return $ds;
    }

    public function removeGuide(Request $request){
        $order = Order::find($request->oId);
        $order->guides()->detach($request->dId);

        DB::table('guide_schedules')
        ->where('order_id', $request->oId)
        ->where('guide_id', $request->dId)
        ->delete();
        // $v = Vehicle::get($request->vId);
        // $v->vehicleSchedules()->where('order_id', $request->oId)->delete();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
