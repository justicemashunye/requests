<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class DepartmentController extends Controller
{
    
    public function index()
    {
        $departments = Department::with('program')->get();

        return Inertia::render('Department/Index', [
            'departments' => $departments,
        ]);
    }

    
    public function create()
    {   
        $programs = Program::all();
        return Inertia::render('Department/Create', [
            'programs' => $programs,
        ]);
    }

    
    public function store(Request $request)
        {
            $validatedData = $request->validate([
                'program_id' => 'required|numeric', 
                'name' => 'required|string|max:255',
            ]);
        
            Department::create($validatedData);
    
            return redirect()->route('departments.index')
                             ->with('success', 'Department created successfully!');
        }
    
    public function show(Department $department)
    {
        $department->load('program');
        return Inertia::render('Department/Show', [
            'department' => $department,
        ]);
    }

    
    public function edit(Department $department)
    {
        $programs = Program::all();
        $department = Department::find($department)->first();

        return Inertia::render('Department/Edit', [
            'department' => $department,
            'programs'=>$programs
        ]);
    }

   
    public function update(Request $request, Department $department)
        {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'program_id' => [
                    'required',
                    'integer',
                    Rule::exists('programs', 'id'),
                ],
            ]);

            $department->update([
                'name' => $validatedData['name'],
                'program_id' => $validatedData['program_id'],
            ]);

            return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
        }

   
    public function destroy(Department $department)
    {
        {
            // Delete the department
            $department->delete();
    
            // Redirect back with a success message
            return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
        }
    }
}
