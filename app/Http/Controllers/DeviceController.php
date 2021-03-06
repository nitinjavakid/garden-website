<?php

namespace App\Http\Controllers;

use DB;
use App\Device;
use App\Event;
use App\Plant;
use App\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function config($id)
    {
        $config = "";
        $device = Device::findOrFail($id);
        $counter = 0;
        $time_interval = null;
        if($device->enabled)
        {
            foreach($device->plants as $plant)
            {
                if($plant->enabled)
                {
                    foreach($plant->tasks as $task)
                    {
                        if($task->enabled)
                        {
                            if($time_interval == null)
                            {
                                $time_interval = $task->time_interval;
                            }
                            else
                            {
                                $time_interval = min($task->time_interval, $time_interval);
                            }

                            $config .= "," . $plant->id . "," .
                                  $plant->forward_pin . "," .
                                  $plant->reverse_pin . "," .
                                  $plant->adc_pin;
                            $counter++;
                            break;
                        }
                    }
                }
            }
        }

        if($time_interval == null)
        {
            $time_interval = 15;
        }

        $config = $time_interval . "," . $counter . $config;
        return $config;
    }

    public function execute(Request $request, $id)
    {     
        $device = Device::findOrFail($id);
        $idx = $request->input("i");
        $flip = $request->input("f");
        $value = $request->input("v");
        $watering_system = null;
        $watered = false;

        if($idx != null &&
           $flip != null &&
           $value != null)
        {
            $idx = (int) $idx;
            $flip = (int) $flip;
            $value = (int) $value;

            $plant = Plant::findOrFail($idx);
            if($plant->device->id == $device->id)
            {
                $tasks = DB::table('tasks')->where('enabled', true)
                       ->where('plant_id', '=', $plant->id)->get();

                foreach($tasks as $task)
                {
                    if(($task->last_run != null) &&
                       (Carbon::parse($task->last_run)->addSeconds($task->time_interval)->timestamp >=
                        Carbon::now()->timestamp))
                    {
                        continue;
                    }

                    $watering_system = \App\WateringSystems\WateringSystem::deserialize($task->data);

                    if($task->rules != null)
                    {
                        $event_watered_timestamp = 0;
                        $last_event = DB::table("events")->where([
                            ['task_id', '=', $task->id],
                            ['watered', '>', 0]
                        ])->max("created_at");
                        if($last_event != null)
                        {
                            $event_watered_timestamp = Carbon::parse($last_event)->timestamp;
                        }

                        $evaluator = new \App\RuleEvaluator($task->rules);
                        $evaluator->set("event_watered_timestamp", $event_watered_timestamp);
                        $evaluator->set("value", $value);
                        $evaluator->set("flip", $flip);

                        if($evaluator->evaluate())
                        {
                            $watered = true;
                        }
                    }

                    DB::beginTransaction();
                    try
                    {
                        $event = new Event;
                        $event->task_id = $task->id;
                        $event->value = $value;
                        $event->flip = $flip;
                        $event->watered = $watered ? $watering_system->getWateringTime() : 0;
                        $event->save();

                        $task = Task::findOrFail($task->id);
                        $task->last_run = now();
                        $task->save();

                        if($watered)
                        {
                            $plant = $task->plant;
                            $plant->last_watered_event_id = $event->id;
                            $plant->save();
                        }
                        DB::commit();
                        break;
                    }
                    catch( \Exception $e)
                    {
                        print_r($e);
                        DB::rollback();
                    }
                }
            }
        }

        if($watered == true)
        {
            return $watering_system->getInstruction();
        }
        else
        {
            return "";
        }
    }
}
