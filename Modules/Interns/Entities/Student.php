<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'interns__students';

    protected $fillable = [
        'fullname',
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
        'internyear',
        'internquarter',
    ];
}
