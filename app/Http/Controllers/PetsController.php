<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetsRequest;
use App\Http\Requests\UpdatePetsRequest;
use App\Models\Pets;

class PetsController extends Controller
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
    public function store(StorePetsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pets $pets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pets $pets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetsRequest $request, Pets $pets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pets $pets)
    {
        //
    }
}
