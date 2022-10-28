<?php

namespace Modules\Interns\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\History;
use Modules\Interns\Http\Requests\CreateHistoryRequest;
use Modules\Interns\Http\Requests\UpdateHistoryRequest;
use Modules\Interns\Repositories\HistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class HanetController extends AdminBaseController
{

    public function hanet(Request $request)
    {
        if (isset($request->data_type) && $request->data_type == 'log') {
            if ($request->personTitle == 'Intern' && $request->deviceID == env('HANET_DEVICES')) {
                $date = date('Y-m-d', substr($request->time, 0, -3));
                $time = date('H:i:s', substr($request->time, 0, -3));
                $studentid = $request->aliasID;
                $image = $request->detected_image_url;

                $student = DB::table('interns__students')
                            ->select('id')
                            ->where('studentid', $studentid)
                            ->limit(1)
                            ->get()[0]->id;
                        
                if (DB::table('interns__histories')->where('student', $student)->where('date', $date)->exists()) {
                    DB::table('interns__histories')
                        ->where('student', $student)
                        ->where('date', $date)
                        ->update([
                            'lasttime' => $time,
                            'lastimage' => $image,
                        ]);

                } else {
                    DB::table('interns__histories')
                        ->insert([
                            'student' => $student,
                            'date' => $date,
                            'firsttime' => $time,
                            'firstimage' => $image,
                            'lasttime' => $time,
                            'lastimage' => $image,
                        ]);
                }
            }
        }
        
        $response = ["status"=>"success"];
        return response()->json($response);
    }

}
