<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\Plant;
use Auth;
use DB;

class TaskController extends Controller
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
    public function create(Request $request)
    {
        $task = new Task;
        $task->plant_id = $request->input("plant");
        return view("task", [
            "task" => $task
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plant = Plant::findOrFail($request->input("plant_id"));
        if($plant->device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $task = new Task;
        DB::beginTransaction();
        try
        {
            $task->name = $request->input("name");
            $task->plant_id = $request->input("plant_id");
            $task->time_interval = $request->input("time_interval");
            $task->watering_system_index = $request->input("watering_system_index");
            $task->enabled = $request->has("enabled");
            $task->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("task.show", $task->id);
    }

    public function watering_systems()
    {
        $classes = [];
        $idx = 0;
        foreach(\App\WateringSystems\WateringSystem::$classes as $key => $value)
        {
            $classes[$idx++] = $value;
        }
        return $classes;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view("task", [
            "task" => $task,
            "watering_systems" => $this->watering_systems(),
            "events" => $task
                        ->events()
                        ->orderByDesc('created_at')
                        ->paginate(5)
        ]);
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
        $task = Task::findOrFail($id);
        if($task->plant->device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        DB::beginTransaction();
        try
        {
            $task->name = $request->input("name");
            $task->time_interval = $request->input("time_interval");
            if($task->watering_system_index != $request->input("watering_system_index"))
            {
                $task->watering_system_index = $request->input("watering_system_index");
            }
            else
            {
                $watering_system = $task->watering_system;
                foreach($watering_system->needProperties() as $key => $value)
                {
                    $watering_system->setProperty($key, $request->input("system_" . $key));
                }
                $task->watering_system = $watering_system;
            }
            $task->enabled = $request->has("enabled");
            $task->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("task.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if($task->plant->device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $plant_id = $task->plant->id;

        DB::beginTransaction();
        try
        {
            $task->delete();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("plant.show", $plant_id);
    }
}
