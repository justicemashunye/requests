<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RequisitionStatus;
use App\Enums\RequisitionUrgency;
use App\Models\User;

class SupervisorApproval extends Model
{
    /** @use HasFactory<\Database\Factories\SupervisorApprovalFactory> */
    use HasFactory;

    protected $fillable = [
        'comments',
        'approver_id',
        'user_id',
        'requisition_id',
        'department_id',
        'status',
        'stage' 
    ];

    protected $casts = [
        'status' => RequisitionStatus::class,
        'urgency' => RequisitionUrgency::class,
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

  

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }



}
