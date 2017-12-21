<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plant;
use App\Device;
use DB;
use Auth;

class PlantController extends Controller
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
        $plant = new Plant;
        $plant->device_id = $request->input("device");
        return view("plant", [
            "plant" => $plant
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
        $device = Device::findOrFail($request->input("device_id"));
        if($device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $plant = new Plant;
        DB::beginTransaction();
        try
        {
            $plant->name = $request->input("name");
            $plant->device_id = $request->input("device_id");
            $plant->reverse_pin = $request->input("reverse_pin");
            $plant->forward_pin = $request->input("forward_pin");
            $plant->adc_pin = $request->input("adc_pin");
            $plant->enabled = $request->has("enabled");
            $plant->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("plant.show", $plant->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("plant", [
            "plant" => Plant::findOrFail($id),
            "events" => Plant::findOrFail($id)
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
        $plant = Plant::findOrFail($id);
        if($plant->device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        DB::beginTransaction();
        try
        {
            $plant->name = $request->input("name");
            $plant->reverse_pin = $request->input("reverse_pin");
            $plant->forward_pin = $request->input("forward_pin");
            $plant->adc_pin = $request->input("adc_pin");
            $plant->enabled = $request->has("enabled");
            $plant->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("plant.show", $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plant = Plant::findOrFail($id);
        if($plant->device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $device_id = $plant->device->id;

        DB::beginTransaction();
        try
        {
            $plant->delete();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("device.show", $device_id);
    }
}
