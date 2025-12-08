<?php

namespace App\Http\Controllers;

use App\Models\bots;
use Illuminate\Http\Request;

class BotsController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('bot2');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(bots $bots)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bots $bots)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bots $bots)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bots $bots)
    {
        //
    }
}
