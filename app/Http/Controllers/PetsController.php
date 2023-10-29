<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PetsResources;
use App\Models\Pets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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


        if (isset($data['image'])) {
            $image_path = $request->file('image')->store('pets', 'public');
            $data['image'] = $image_path;
        }

        Pets::create($data);

        return new PetsResources($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id = null)
    {
        // Get all pets
        if ($request->all == true) {
            $pets = Pets::withTrashed()->get();
        } else {
            // Get only one pet
            if (isset($id) && !empty($id)) {
                $pet =  Pets::find($id);
                $pet->image = env('APP_URL') . Storage::url($pet->image);
                return $pet;
            }

            $pets = Pets::all();
        }

        foreach ($pets as $key => &$pet) {
            $pet->image = env('APP_URL') . Storage::url($pet->image);
        }

        return $pets;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $pets)
    {
        $data = $request->all();
        $updatePet = Pets::find($pets);

        if (isset($data['image'])) {
            $image_path = $request->file('image')->store('pets', 'public');
            $data['image'] = $image_path;
        }

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