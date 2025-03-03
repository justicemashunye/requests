<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    
    use HasFactory;

    protected $fillable = [  'number','name'];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


}
