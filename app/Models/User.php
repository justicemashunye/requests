<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'ecNumber',
        'position_id',
        'department_id',
        'phoneNumber',
        'officeExtePhone',
        'isSuspended',
       
    ];


    protected $attributes = [
        'isSuspended' => false,
    ];

  
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }

    public function supervisorapproval()
    {
        return $this->hasMany(SupervisorApproval::class, 'supervisor_approval_id');
    }

    const SUPERVISOR_POSITIONS = [3, 4, 5];

    // app/Models/User.php
    public function isAdmin()
    {
        return $this->department_id === Department::IT;
    }


}
