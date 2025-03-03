<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use Inertia\Inertia;

class ProgramController extends Controller
{
    
    public function index()
    {
        
        $programs = Program::all();

        return Inertia::render('Program/Index', [
            'programs' => $programs,
        ]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(StoreProgramRequest $request)
    {
        //
    }

    public function show(Program $program)
    {
        //
        dd($program);
    }

 
    public function edit(Program $program)
    {
       
            return Inertia::render('Program/Edit', [
                'program' => $program
            ]);
        }

   
    public function update(UpdateProgramRequest $request, Program $program)
    {
        //
    }

   
    public function destroy(Program $program)
    {
        //
    }
}
