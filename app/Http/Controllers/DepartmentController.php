<?php

namespace App\Http\Controllers;

use App\Department;
use App\Zone;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('zone')->get();
        return view('department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('department.create', compact('zones'));
    }

    /**
     * Store a newly created department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'zone_id' => 'required',
            'name' => 'required|unique:departments|max:255',
        ]);
        Department::create($request->all());
        return redirect()->route('department.index')
                        ->with('success','Department created successfully.');
    }

        /**
     * Show the form for editing the specified department.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $zones = Zone::all();
        return view('department.edit', compact('department', 'zones'));
    }

    /**
     * Update the specified department in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'zone_id' => 'required',
            'name' => 'required|unique:departments|max:255',
        ]);
        $department->update($request->all());
        return redirect()->route('department.index')
                        ->with('success','Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('department.index')
                        ->with('success','Department deleted successfully.');
    }
}
