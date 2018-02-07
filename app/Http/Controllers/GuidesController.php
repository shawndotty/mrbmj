<?php

namespace App\Http\Controllers;

use App\Guide;
use Illuminate\Http\Request;

class GuidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Guide::all();
    }
    public function indexWtihSchedules(Request $request){
        if (isset($request->start_at) && isset($request->end_at)) {
            $start = $request->start_at;
            $end = $request->end_at;
            $scheduleType = $request->types;


            // $startDate = Carbon::parse($start)->toDateString();
            // $endDate = Carbon::parse($end)->toDateString();

            $guides = Guide::with(['guideSchedules'=>function($query) use($start, $end, $scheduleType){
                return $query
                            // ->whereIn('type', [1,2])
                            ->whereIn('type', $scheduleType)
                            ->where(function($query) use($start, $end){
                                return $query->whereBetween('start_at', [$start, $end])
                                             ->orWhereBetween('end_at', [$start, $end])
                                             ->orWhere([['start_at', '>', $start],['end_at', '<', $end]]);
                            })->orderBy('start_at', 'asc')
                            // ->whereBetween('start_at', [$start, $end])
                            // ->orWhereBetween('end_at', [$start, $end])
                            // ->orWhere([['start_at', '>', $start],['end_at', '<', $end]])

                            ;
                            }])

                            ->get();

            return $guides;

        } else {
            return Guide::all();
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

        $guide = new Guide();
        $guide->first_name = $request->first_name;
        $guide->last_name = $request->last_name;
        $guide->email = $request->email;
        $guide->phone = $request->phone;
        $guide->save();
        //
        return $guide;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guide $guide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guide $guide)
    {
        //
    }
}
