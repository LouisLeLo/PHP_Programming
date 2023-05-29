<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function department(){
        return $this->hasOne('App\Models\Department','id', 'department_id');
    }

    public function avatar(){
        return $this->hasOne('App\Models\File', 'id', 'avatar_id');
    }
}
