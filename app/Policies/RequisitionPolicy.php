<?php

namespace App\Policies;

use App\Models\Requisition;
use App\Models\User;
use App\Models\Department;
use Illuminate\Auth\Access\Response;
use App\Enums\RequisitionStatus;
use Illuminate\Database\Eloquent\Builder;


class RequisitionPolicy
{
    
    public function viewAny(User $user)
    {
        return true; 
    }

    public function scope(User $user, Builder $query)
    {
        if (!$user->isAdmin()) {
            $query->where('department_id', $user->department_id);
        }
    }
    
    public function view(User $user, Requisition $requisition): bool
    {
        return false;
    }

   
    public function create(User $user): bool
    {
        return true;
    }

   
   
public function update(User $user, Requisition $requisition)
{
   
    if (!$requisition->is_currently_rejected) {
        return false;
    }

   
    if ($user->id === $requisition->user_id) {
        return true;
    }

 
    return $user->department_id === $requisition->department_id &&
           in_array($user->position_id, User::SUPERVISOR_POSITIONS);
}

    public function viewTrack(User $user, Requisition $requisition)
        {
            
            return !$user->isSuspended && $user->id === $requisition->user_id;
        }


public function track(User $user, Requisition $requisition)
{
    return $user->id === $requisition->user_id;
}

    public function approve(User $user, Requisition $requisition)
    {
    
    //if ($user->isAdmin()) return true;
    $department = $user->department;

    if ($user->isSuspended || $user->id === $requisition->user_id) {
        return false;
    }

    $status = $requisition->status->value;

    $requiredDepartment = match ($status) {
        RequisitionStatus::SUPERVISOR->value => $requisition->user->department_id,
        RequisitionStatus::PROCUREMENT->value => Department::where('name', 'Procurement')->first()->id,
        RequisitionStatus::ADMINISTRATION->value => Department::where('name', 'Administration')->first()->id,
        RequisitionStatus::FINANCE->value => Department::where('name', 'Finance')->first()->id,
        default => null,
    };

    // Check if status is in approval workflow
    if (!in_array($status, [
        RequisitionStatus::SUPERVISOR->value,
        RequisitionStatus::PROCUREMENT->value,
        RequisitionStatus::ADMINISTRATION->value,
        RequisitionStatus::FINANCE->value
    ])) {
        return false;
    }

    
 
    if ($status === RequisitionStatus::SUPERVISOR->value) {
        $isSupervisor = in_array($user->position_id, User::SUPERVISOR_POSITIONS);
        return $isSupervisor && ($user->department_id === $requiredDepartment);
    }


    return in_array($requisition->status->value, $department->handles ?? []);
}
                  
    public function delete(User $user, Requisition $requisition): bool
    {
        return false;
    }

   
    public function restore(User $user, Requisition $requisition): bool
    {
        return false;
    }

   
    public function forceDelete(User $user, Requisition $requisition): bool
    {
        return false;
    }
}
