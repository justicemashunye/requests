<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    const IT = 1;
    use HasFactory;

  
    protected $casts = [
        'handles' => 'array'
    ];

    protected $fillable = [  'name','program_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }


}
