<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class Intern_Diary extends Model
{

    protected $table = 'interns__intern_diaries';
    
    protected $fillable = [
        'student',
        'task',
        'startdate',
        'enddate',
        'status',
        'description',
    ];
}
