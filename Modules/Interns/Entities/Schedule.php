<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $table = 'interns__schedules';
    
    protected $fillable = [
        'student',
        'schedule',
    ];
}
