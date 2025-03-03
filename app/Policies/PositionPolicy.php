<?php

namespace App\Policies;

use App\Models\Position;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PositionPolicy
{
    
    public function viewAny(User $user): bool
    {
        return false;
    }

   
    public function view(User $user, Position $position): bool
    {
        return false;
    }

  

    public function create(User $user): bool
    {
        return true;
    }
        

   
    public function update(User $user, Position $position): bool
    {
        return false;
    }

   
    public function delete(User $user, Position $position): bool
    {
        return false;
    }

    
    public function restore(User $user, Position $position): bool
    {
        return false;
    }

    
    public function forceDelete(User $user, Position $position): bool
    {
        return false;
    }
}
