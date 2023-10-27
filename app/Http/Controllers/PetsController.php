<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePetsRequest;
use App\Http\Resources\PetsResources;
use App\Models\Pets;
use Illuminate\Support\Facades\Auth;

class PetsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Use show instead';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        Pets::create($data);

        return new PetsResources($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Get all pets
        if ($request->all == true) {
            return Pets::withTrashed()->get();
        }

        return Pets::all();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pets)
    {
        $data = $request->all();
        $updatePet = Pets::find($pets);

        $updatePet->update($data);

        return response()->json(['success' => "Pet was Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($request)
    {
        $pet = Pets::find($request);

        $pet->delete();

        return response()->json(["success" => "Pet ID: {$request} has been deleted"]);
    }
}