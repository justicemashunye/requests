<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RequisitionStatus;
use App\Enums\RequisitionUrgency;
use App\Models\SupervisorApproval;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisition extends Model
{
    
    use HasFactory;


    protected $fillable = [ 
        'user_id',
        'department_id',
        'typeOfProduct',
        'nameOfProduct',
        'description',
        'quantity',
        'purpose',
        'estimatedCost',
        'status',
        'urgency',
    ];



 

protected $appends = [
        'current_stage', 
    'is_rejected_at_supervisor',
    'is_rejected',
    'is_currently_rejected',
    'current_status_duration'
    ];


    protected $casts = [
        'status' => RequisitionStatus::class,
        'urgency' => RequisitionUrgency::class, 
    ];
   

    public function supervisorApprovals()
    {
        return $this->hasMany(SupervisorApproval::class)->orderBy('created_at', 'desc');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
   

    public function isRejectedAtSupervisor()
    {
            return $this->supervisorApprovals()
                ->where('status', 'rejected')
                ->where('stage', RequisitionStatus::SUPERVISOR->value)
                ->exists();
        
    }




    public function getIsRejectedAtSupervisorAttribute()
    {
            return $this->supervisorApprovals
                ->where('stage', RequisitionStatus::SUPERVISOR->value)
                ->where('status', 'rejected')
                ->isNotEmpty();
    }

    public function getStatusLabelAttribute()
    {
        return $this->status->name;
    }



    public function getIsRejectedAttribute()
    {
        return $this->supervisorApprovals()
            ->where('status', 'rejected')
            ->exists();
    }


    public function getCurrentStageAttribute()
    {
        
        return $this->status->value;
    }





    public function getIsCurrentlyRejectedAttribute()
    {
        
        $latestApproval = $this->supervisorApprovals->first();
        return $latestApproval && $latestApproval->status->value === 'rejected';
    }
    public function getCurrentStatusDurationAttribute()
    {
      
        $latestApproval = $this->supervisorApprovals
            ->where('status', $this->status->value)
            ->sortByDesc('created_at')
            ->first();
    
        if (!$latestApproval) {
            return 0; 
        }

        return abs(now()->diffInHours($latestApproval->created_at));
    }

}
