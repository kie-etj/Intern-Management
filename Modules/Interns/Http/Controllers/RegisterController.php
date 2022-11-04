<?php

namespace Modules\Interns\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\History;
use Modules\Interns\Http\Requests\CreateHistoryRequest;
use Modules\Interns\Http\Requests\UpdateHistoryRequest;
use Modules\Interns\Repositories\HistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class RegisterController extends AdminBaseController
{

    public function index(Request $request)
    {
        $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();
        $listschools = [];
        foreach ($schools as $key => $value) {
            $listschools[$value->id] = $value->fullname;
        }

        $faculties = DB::table('interns__faculties')
                    ->select('id', 'school', 'facultyname')
                    ->orderBy('facultyname')
                    ->get();
                    
        return view('interns::public.create', compact('listschools', 'faculties'));
    }

}
