<?php

namespace App\Http\Controllers;

use App\DriverSchedule;
use App\Driver;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DriverSchedulesController extends Controller
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
        //
        $ds = new DriverSchedule();

        $ds->driver_id = $request->item['id'];
        $ds->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->startDate . ' ' . $request->startTime);
        $ds->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->endDate . ' ' . $request->endTime);
        $ds->type = $request->scheduleType['id'];
        $ds->note = $request->note;

        $ds->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DriverSchedule  $driverSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(DriverSchedule $driverSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DriverSchedule  $driverSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(DriverSchedule $driverSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DriverSchedule  $driverSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverSchedule $driverSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DriverSchedule  $driverSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(DriverSchedule $driverSchedule)
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
        $orderID=$request->order_id;
        $assignedV = DB::table('driver_order')->where('order_id', $orderID)->pluck('driver_id');
     
        $startDate = Carbon::parse($start)->toDateString();
        $endDate = Carbon::parse($end)->toDateString();


        $vacancyDrivers = 
            Driver::doesntHave('driverSchedules')
            ->get();

        $availables['totalAvailable'] = $vacancyDrivers;

       

        $needToCheckDrivers = 
            Driver::has('driverSchedules')
            ->whereNotIn('id', $assignedV)
            ->get();

        $needToCheckDrivers->load(['driverSchedules'=>function($query) use($start, $end){
             return $query 
                          ->whereBetween('start_at', [$start, $end])
                          ->orWhereBetween('end_at', [$start, $end])
                          ->orWhere([
                            ['start_at', '>', $start],
                            ['end_at', '<', $end]     
                          ])
                          ;
         }]);

        foreach ($needToCheckDrivers as $driver) {
            if ($driver->driverSchedules->isEmpty()){
                $availables['totalAvailable'][] = $driver;
            } else {
                $overlaps = collect([]);
                foreach ($driver->driverSchedules as $schedule) {
                    $overlapDates = buildDatesRange(max(Carbon::parse($start), $schedule->start_at), min(Carbon::parse($end), $schedule->end_at));  
                    $overlaps->push($overlapDates);
                }

                $driver->overlaps = $overlaps->collapse()->unique()->values(); 
                $availables['partAvailable'][] = $driver;
            }
        }

        return $availables;
    }
}
