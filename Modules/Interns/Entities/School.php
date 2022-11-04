<?php

namespace Modules\Interns\Entities;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{

    protected $table = 'interns__schools';

    protected $fillable = [
        'logo',
        'shortname',
        'fullname',
        'webpage',
    ];
}
