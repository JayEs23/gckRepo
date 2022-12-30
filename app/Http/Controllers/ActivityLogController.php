<?php

namespace App\Http\Controllers;

use App\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Display the activity log.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        return view('activity_log.index', compact('logs'));
    }
}
