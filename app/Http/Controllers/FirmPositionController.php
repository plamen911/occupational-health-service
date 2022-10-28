<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFirmPositionRequest;
use App\Http\Requests\UpdateFirmPositionRequest;
use App\Models\FirmPosition;

class FirmPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFirmPositionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFirmPositionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Http\Response
     */
    public function show(FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Http\Response
     */
    public function edit(FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFirmPositionRequest  $request
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFirmPositionRequest $request, FirmPosition $firmPosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FirmPosition  $firmPosition
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirmPosition $firmPosition)
    {
        //
    }
}
