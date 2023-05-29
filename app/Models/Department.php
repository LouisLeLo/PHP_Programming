<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public function truongPhong(){
        return $this->hasOne('App\Models\Employee', 'id','truongphong_id');
    }

    public function employees(){
            return $this->hasMany('App\Models\Employee', 'department_id');
        }
}
