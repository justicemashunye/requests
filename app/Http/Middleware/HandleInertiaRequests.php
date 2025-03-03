<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    
    protected $rootView = 'app';


    protected $except = [
        '/departments', // Add your route here
    ];

  
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => fn () => [
        'user' => auth()->user() ? auth()->user()->load('department')
        ->only(['id', 'name', 'department']) 
         : null,
    ],
        ];
    }
}
