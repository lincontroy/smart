<?php

namespace App\Http\Controllers;

use App\Models\markets;
use Illuminate\Http\Request;

class MarketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bt1(){
        return view('running');
    }
    public function bt2(){
        return view('running2');
    }
    public function index()
    {
        //
        return view('markets');
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
    public function show(markets $markets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(markets $markets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, markets $markets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(markets $markets)
    {
        //
    }
}
