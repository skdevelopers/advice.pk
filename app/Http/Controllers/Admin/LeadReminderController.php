<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadReminderRequest;
use App\Http\Requests\UpdateLeadReminderRequest;
use App\Models\LeadReminder;

class LeadReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadReminderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadReminder $leadReminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadReminder $leadReminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadReminderRequest $request, LeadReminder $leadReminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadReminder $leadReminder)
    {
        //
    }
}
