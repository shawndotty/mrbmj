<?php

namespace App\Http\Controllers;

use App\VehicleSchedule;
use Carbon\Carbon;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // remember to validate
        $vs = new VehicleSchedule();

        $vs->vehicle_id = $request->item['id'];
        $vs->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->startDate . ' ' . $request->startTime);
        $vs->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->endDate . ' ' . $request->endTime);
        $vs->type = $request->scheduleType['id'];
        $vs->note = $request->note;

        $vs->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleSchedule  $vehicleSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleSchedule $vehicleSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleSchedule  $vehicleSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleSchedule $vehicleSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleSchedule  $vehicleSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleSchedule $vehicleSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleSchedule  $vehicleSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleSchedule $vehicleSchedule)
    {
        //
    }


    public function checkAvailableSchedules(Request $request) {
        // 1. get all with right type
        $availables = [
            'totalAvailable' => null,
            'partAvailable' => [],
        ];

        $start = $request->start_at;
        $end = $request->end_at;
        $startDate = Carbon::parse($start)->toDateString();
        $endDate = Carbon::parse($end)->toDateString();
        $vehicle_type = $request->vehicle_type;


        $vacancyVehicles = Vehicle::doesntHave('vehicleSchedules')->where('vehicle_type', $vehicle_type)->get();

        $availables['totalAvailable'] = $vacancyVehicles;

       

        $needToCheckVehicles = Vehicle::has('vehicleSchedules')->where('vehicle_type', $vehicle_type)->get();

        $needToCheckVehicles->load(['vehicleSchedules'=>function($query) use($start, $end){
             return $query 
                          ->whereBetween('start_at', [$start, $end])
                          ->orWhereBetween('end_at', [$start, $end])
                          ->orWhere([
                            ['start_at', '>', $start],
                            ['end_at', '<', $end]     
                          ])
                          ;
         }]);

        foreach ($needToCheckVehicles as $vehicle) {
            if ($vehicle->vehicleSchedules->isEmpty()){
                $availables['totalAvailable'][] = $vehicle;
            } else {
                $overlaps = collect([]);
                foreach ($vehicle->vehicleSchedules as $schedule) {
                    $overlapDates = buildDatesRange(max(Carbon::parse($start), $schedule->start_at), min(Carbon::parse($end), $schedule->end_at));  
                    $overlaps->push($overlapDates);
                }

                $vehicle->overlaps = $overlaps->collapse()->unique()->values(); 
                $availables['partAvailable'][] = $vehicle;
            }
        }

        return $availables;
    }
}
