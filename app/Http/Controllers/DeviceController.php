<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

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
        //
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

    public function execute($id)
    {
    }
}
