<?php

namespace App\Http\Controllers\Web;

use App\Garden;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class GardenController extends Controller
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
        $garden = new Garden;
        return view("garden", [
            "garden" => $garden
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
        $garden = new Garden;
        DB::beginTransaction();
        try
        {
            $garden->name = $request->input("name");
            $garden->user_id = Auth::user()->id;
            $garden->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("garden.show", $garden->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $garden = Garden::findOrFail($id);
        if($garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        return view("garden", [
            "garden" => Garden::findOrFail($id)
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
        $garden = Garden::findOrFail($id);
        if($garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        DB::beginTransaction();
        try
        {
            $garden->name = $request->input("name");
            $garden->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }
        return redirect()->route("garden.show", $garden->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $garden = Garden::findOrFail($id);
        if($garden->user->id != Auth::user()->id)
        {
            return response(null, 401);
        }

        DB::beginTransaction();
        try
        {
            $garden->delete();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response(null, 500);
        }

        return redirect()->route("home");
    }
}
