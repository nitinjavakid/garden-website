<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Device;
use App\Garden;
use Auth;
use DB;

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
    public function create(Request $request)
    {
        $device = new Device;
        $device->garden_id = $request->input("garden");
        return view("device", [
            "device" => $device
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
        $garden = Garden::findOrFail($request->input("garden_id"));
        if($garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $device = new Device;
        DB::beginTransaction();
        try
        {
            $device->name = $request->input("name");
            $device->garden_id = $garden->id;
            $device->secret = bcrypt($request->input("secret"));
            $device->enabled = $request->has("enabled");
            $device->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("device.show", $device->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::findOrFail($id);
        if($device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        return view("device", [
            "device" => Device::findOrFail($id)
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
        return $this->show($id);
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
        $device = Device::findOrFail($id);
        if($device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        DB::beginTransaction();
        try
        {
            $device->name = $request->input("name");
            if($request->input("secret") != "")
            {
                $device->secret = bcrypt($request->input("secret"));
            }

            $device->enabled = $request->has("enabled");
            $device->save();
            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("device.show", $device->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        if($device->garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        $garden_id = $device->garden->id;

        DB::beginTransaction();
        try
        {
            $device->delete();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("garden.show", $garden_id);
    }
}
