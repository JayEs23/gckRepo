<?php

namespace App\Http\Controllers;

use App\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the zones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Zone::all();
        return view('zone.index', compact('zones'));
    }

    /**
     * Show the form for creating a new zone.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('zone.create');
    }

    /**
     * Store a newly created zone in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:zones|max:255',
        ]);
        Zone::create($request->all());
        return redirect()->route('zone.index')
                        ->with('success','Zone created successfully.');
    }

    /**
     * Show the form for editing the specified zone.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        return view('zone.edit', compact('zone'));
    }

    /**
     * Update the specified zone in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'name' => 'required|unique:zones|max:255',
        ]);
        $zone->update($request->all());
        return redirect()->route('zone.index')
                        ->with('success','Zone updated successfully.');
    }

    /**
     * Remove the specified zone from storage.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zone.index')
                        ->with('success','Zone deleted successfully.');
    }
}
