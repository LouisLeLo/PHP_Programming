<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    //Mặc định tạo table trong mysql thì phải có 's'. Muốn define lại thì khai báo 'public $table = 'file' trong models
    public $table = 'file';
}
