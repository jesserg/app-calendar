<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventList;
use Carbon\Carbon;

class CalendarController extends Controller
{
    
    public function index()
    {   
        return view('index');
    }

    public function createEvents(Request $request){
        $check_events = EventList::all();
        if(!empty($check_events)){
            // delete all events
            EventList::truncate();
        }
        $start_date = new Carbon($request['start']);
        $end_date = new Carbon($request['end']);
        $all_dates = array();
        while ($start_date->lte($end_date)){
            if($start_date->dayOfWeek == Carbon::MONDAY && $request['monday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::TUESDAY && $request['tuesday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::WEDNESDAY && $request['wednesday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::THURSDAY && $request['thursday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::FRIDAY && $request['friday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::SATURDAY && $request['saturday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else if($start_date->dayOfWeek == Carbon::SUNDAY && $request['sunday'] == true){
                $all_dates[] = $start_date->toDateString();
            }else{
                //do nothing
            }
            //we will add day to start date
            $start_date->addDay();
        }
        foreach($all_dates as $sp_date){
            //create new events
            $new_event = new EventList();
            $new_event->title = $request['title'];
            $new_event->start = $sp_date;
            $new_event->end = $sp_date;
            $new_event->save();
        }

        return response()->json([
            "status" => 'success',
            "message" => 'ok'
        ],200);
        

    }
    public function calendarEvents(Request $request)
    {
        $event_list = EventList::all();
        return response()->json([
            "event_list" => $event_list
        ]);
    }
}