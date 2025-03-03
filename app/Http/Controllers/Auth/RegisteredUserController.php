<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Department;
use App\Models\Position;



class RegisteredUserController extends Controller
{
   
    public function create(): Response
    {
        $departments = Department::all();
        $positions = Position::all();
        return Inertia::render('Auth/Register',[
            'departments' =>$departments,
            'positions'=>$positions
        ]);
    }

    
    public function store(Request $request): RedirectResponse
    {
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'ecNumber' => 'required|string|max:10|unique:' . User::class,
            'department_id' => 'required|integer',
            'phoneNumber' => 'required|string|max:255',
            'position_id' => 'required|integer|max:255',
            'officeExtePhone' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
           
        ]);
        
         
        $validatedData['isSuspended'] = false;
            

        $user = User::create($validatedData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
