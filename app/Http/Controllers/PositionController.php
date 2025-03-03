<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;





class PositionController extends Controller
{
    
    public function index()
        {
            $positions = Position::all();
            return Inertia::render('Position/Index', [ 'positions'=> $positions]);
        }

    public function create()
        {
            return Inertia::render('Position/Create');
        }

   
    public function store(StorePositionRequest $request)
        {
            $validatedData = $request->validate([

                'name' => 'required|string|max:255',
            ]);
        
            Position::create($validatedData);
    
            return redirect()->route('positions.index')
                             ->with('success', 'Position created successfully!');
        }

    
    public function show(Position $position)
        {
            return Inertia::render('Position/Show', [
            'position' => $position,
        ]);
        }

   
    public function edit(Position $position)
        {
            $position = Position::all()->find($position);
            return Inertia::render('Position/Edit', [
                'position' => $position
            ]);
        }

    
    public function update(UpdatePositionRequest $request, Position $position)
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $position->update([
                'name' => $validatedData['name'],
            ]);

            return redirect()->route('positions.index')->with('success', 'Position updated successfully!');
        }

   
    public function destroy(Position $position)
        {
           
            $position->delete();       
            return redirect()->route('positions.index')->with('success', 'Position deleted successfully!');
        }
}
