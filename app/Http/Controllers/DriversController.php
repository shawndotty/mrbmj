<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return all Drivers
        return Driver::all();
    }

    public function indexWtihSchedules(Request $request){
        if (isset($request->start_at) && isset($request->end_at)) {
            $start = $request->start_at;
            $end = $request->end_at;
            $scheduleType = $request->types;


            // $startDate = Carbon::parse($start)->toDateString();
            // $endDate = Carbon::parse($end)->toDateString();

            $drivers = Driver::with(['driverSchedules'=>function($query) use($start, $end, $scheduleType){
                return $query
                            // ->whereIn('type', [1,2])
                            ->whereIn('type', $scheduleType)
                            ->where(function($query) use($start, $end){
                                return $query->whereBetween('start_at', [$start, $end])
                                             ->orWhereBetween('end_at', [$start, $end])
                                             ->orWhere([['start_at', '>', $start],['end_at', '<', $end]]);
                            })
                            // ->whereBetween('start_at', [$start, $end])
                            // ->orWhereBetween('end_at', [$start, $end])
                            // ->orWhere([['start_at', '>', $start],['end_at', '<', $end]])

                            ;
                            }])->get();

            return $drivers;

        } else {
            return Driver::all();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
