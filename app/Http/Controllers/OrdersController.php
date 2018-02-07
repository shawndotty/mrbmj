<?php

namespace App\Http\Controllers;

use App\Order;
use App\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $order = $client->orders()->create([
            'type'=> $request->orderType['id'],
            'pax' => $request->pax,
            'group_type' => $request->groupType,
            'pickup_at' => Carbon::createFromFormat('Y-m-d H:i:s', $request->pickupDate . ' ' . $request->pickupTime),
            'dropoff_at' => Carbon::createFromFormat('Y-m-d H:i:s', $request->dropoffDate . ' ' . $request->dropoffTime),
            'pickup_location' => $request->pickupLocation,
            'dropoff_location' => $request->dropoffLocation,
            'vehicle_option' => json_encode($request->vehicles),
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
