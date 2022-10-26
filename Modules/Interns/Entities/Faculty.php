<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{

    protected $table = 'interns__faculties';
    
    protected $fillable = [
        'school',
        'facultyname'
    ];
}
