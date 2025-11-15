<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('location', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_place' => 'required|max:300',
            'country_location' => 'required|max:50',
            'state_location' => 'required|max:50',
            'city_location' => 'required|max:20',
        ]);

        Location::create($request->all());

        return redirect()->route('location.index')->with('success', 'Ubicación creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'location_place' => 'required|max:300',
            'country_location' => 'required|max:50',
            'state_location' => 'required|max:50',
            'city_location' => 'required|max:20',
        ]);

        $location = Location::findOrFail($id);
        $location->update($request->all());

        return redirect()->route('location.index')->with('success', 'Ubicación actualizada correctamente');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('location.index')->with('success', 'Ubicación eliminada');
    }
}
