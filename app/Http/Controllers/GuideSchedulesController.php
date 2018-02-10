<?php

namespace App\Http\Controllers;

use App\GuideSchedule;
use App\Guide;
use Carbon\Carbon;
use DB;
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

     public function checkAvailableSchedules(Request $request) {
        // 1. get all with right type
        $availables = [
            'totalAvailable' => null,
            'partAvailable' => [],
        ];
        $start = $request->start_at;
        $end = $request->end_at;
        $orderID=$request->order_id;
        $assignedV = DB::table('guide_order')->where('order_id', $orderID)->pluck('guide_id');
     
        $startDate = Carbon::parse($start)->toDateString();
        $endDate = Carbon::parse($end)->toDateString();


        $vacancyGuides = 
            Guide::doesntHave('guideSchedules')
            ->get();

        $availables['totalAvailable'] = $vacancyGuides;

       

        $needToCheckGuides = 
            Guide::has('guideSchedules')
            ->whereNotIn('id', $assignedV)
            ->get();

        $needToCheckGuides->load(['guideSchedules'=>function($query) use($start, $end){
             return $query 
                          ->whereBetween('start_at', [$start, $end])
                          ->orWhereBetween('end_at', [$start, $end])
                          ->orWhere([
                            ['start_at', '>', $start],
                            ['end_at', '<', $end]     
                          ])
                          ;
         }]);

        foreach ($needToCheckGuides as $guide) {
            if ($guide->guideSchedules->isEmpty()){
                $availables['totalAvailable'][] = $guide;
            } else {
                $overlaps = collect([]);
                foreach ($guide->guideSchedules as $schedule) {
                    $overlapDates = buildDatesRange(max(Carbon::parse($start), $schedule->start_at), min(Carbon::parse($end), $schedule->end_at));  
                    $overlaps->push($overlapDates);
                }

                $guide->overlaps = $overlaps->collapse()->unique()->values(); 
                $availables['partAvailable'][] = $guide;
            }
        }

        return $availables;
    }
}
