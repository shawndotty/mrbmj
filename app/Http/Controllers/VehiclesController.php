<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::with('vehicleSchedules')->get();
        return $vehicles;
    }

    public function indexWithOrderSchedules()
    {
        $vehicles = Vehicle::with(['vehicleSchedules'=>function($query){
            return $query->where('type', 3);
        }])->get();

        return $vehicles;
    }

    public function indexWtihSchedules(Request $request){
        if (isset($request->start_at) && isset($request->end_at)) {
            $start = $request->start_at;
            $end = $request->end_at;
            $scheduleType = $request->types;


            // $startDate = Carbon::parse($start)->toDateString();
            // $endDate = Carbon::parse($end)->toDateString();

            $vehicles = Vehicle::with(['vehicleSchedules'=>function($query) use($start, $end, $scheduleType){
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

            return $vehicles;

        } else {
            return Vehicle::all();
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
        $newVehicle = new Vehicle();
        $newVehicle->name = $request->vehicle_code;
        $newVehicle->vehicle_type = $request->vehicle_type;
        $newVehicle->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
