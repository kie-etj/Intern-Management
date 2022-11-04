<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{

    protected $table = 'interns__registers';
    
    protected $fillable = [
        'firstname',
        'lastname',
        'dateofbirth',
        'email',
        'phone',
        'studentid',
        'position',
        'school',
        'faculty',
        'year',
        'avatar',
        'cv',
        'lecturername',
        'lectureremail',
        'lecturerphone',
    ];
}
