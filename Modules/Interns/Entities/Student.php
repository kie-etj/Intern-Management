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
        'position',
        'school',
        'faculty',
        'year',
        'avatar',
        'lecturername',
        'lectureremail',
        'lecturerphone',
    ];
}
