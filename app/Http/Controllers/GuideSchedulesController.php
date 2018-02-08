<?php

namespace App\Http\Controllers;

use App\GuideSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuideSchedulesController extends Controller
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
        $gs = new GuideSchedule();

        $gs->guide_id = $request->item['id'];
        $gs->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->startDate . ' ' . $request->startTime);
        $gs->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->endDate . ' ' . $request->endTime);
        $gs->type = $request->scheduleType['id'];
        $gs->note = $request->note;

        $gs->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GuideSchedule  $guideSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(GuideSchedule $guideSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GuideSchedule  $guideSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(GuideSchedule $guideSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GuideSchedule  $guideSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GuideSchedule $guideSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GuideSchedule  $guideSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(GuideSchedule $guideSchedule)
    {
        //
    }
}
