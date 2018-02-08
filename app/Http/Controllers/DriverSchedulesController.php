<?php

namespace App\Http\Controllers;

use App\DriverSchedule;
use Carbon\Carbon;
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
}
