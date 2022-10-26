<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $table = 'interns__histories';
    
    protected $fillable = [
        'student',
        'date',
        'firsttime',
        'firstimage',
        'lasttime',
        'lastimage',
    ];
}
