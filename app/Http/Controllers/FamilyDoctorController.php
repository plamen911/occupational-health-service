<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFamilyDoctorRequest;
use App\Http\Requests\UpdateFamilyDoctorRequest;
use App\Models\FamilyDoctor;

class FamilyDoctorController extends Controller
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
     * @param  \App\Http\Requests\StoreFamilyDoctorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFamilyDoctorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FamilyDoctor  $familyDoctor
     * @return \Illuminate\Http\Response
     */
    public function show(FamilyDoctor $familyDoctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FamilyDoctor  $familyDoctor
     * @return \Illuminate\Http\Response
     */
    public function edit(FamilyDoctor $familyDoctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFamilyDoctorRequest  $request
     * @param  \App\Models\FamilyDoctor  $familyDoctor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFamilyDoctorRequest $request, FamilyDoctor $familyDoctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FamilyDoctor  $familyDoctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(FamilyDoctor $familyDoctor)
    {
        //
    }
}
