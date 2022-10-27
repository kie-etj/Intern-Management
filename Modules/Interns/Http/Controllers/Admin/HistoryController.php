<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\History;
use Modules\Interns\Http\Requests\CreateHistoryRequest;
use Modules\Interns\Http\Requests\UpdateHistoryRequest;
use Modules\Interns\Repositories\HistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class HistoryController extends AdminBaseController
{
    /**
     * @var HistoryRepository
     */
    private $history;

    public function __construct(HistoryRepository $history)
    {
        parent::__construct();

        $this->history = $history;
    }

    public function hanet(Request $request)
    {
        $post = [
            'token' =>'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjMwNzQwNjQzMTE2Mzg5MzIyMjQiLCJlbWFpbCI6ImxlZHVjdG9hbkBsZWR1Y3RvYW4uY29tIiwiY2xpZW50X2lkIjoiYzNiYjU3MDVmM2Y3ZjcyMDI3ZWYwZmJmMmRkYmQ1MjQiLCJ0eXBlIjoiYXV0aG9yaXphdGlvbl9jb2RlIiwiaWF0IjoxNjY2ODYyODE0LCJleHAiOjE2OTgzOTg4MTR9.FRV12hDyk-zJ-Y0UNxTtwzeOB9-o3cAPvwnXrrEI5As',
            'placeID' => '8037',
            'devices' => 'C21024B609',
            // 'personID' => '2281795527890698240',
            // 'aliasID' => '197CT31392',
            'date' => '2022-10-27',
            'exType' => '4,2',
            'type' => '0',
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://partner.hanet.ai/person/getCheckinByPlaceIdInDay',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post,
        ));

        $response = json_decode(curl_exec($curl));
        

        curl_close($curl);
        
        // $time = $response->data[0]->checkinTime;
        // echo $response;
        // dd($request);

        // echo date('H:i:s', substr($time, 0, -3));
        dd($response);

        // DB::table('interns__histories')
        //     ->insert([
        //         'student' => $request->aliasID,
        //         'date' => $request->date,
                
        //     ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $histories = $this->history->all();
        $histories = DB::table('interns__histories')
            ->select('interns__histories.id', 'interns__students.fullname AS student',
                    'date', 'firsttime', 'firstimage', 'lasttime', 'lastimage')
            ->join('interns__students', 'interns__students.id', 'interns__histories.student')
            ->get();

        return view('interns::admin.histories.index', compact('histories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $students = DB::table('interns__students')
                        ->select('interns__students.id', 'interns__students.fullname', 'interns__schools.shortname', 
                                'interns__faculties.facultyname', 'interns__students.email')
                        ->join('interns__schools', 'interns__schools.id', 'interns__students.school')
                        ->join('interns__faculties', 'interns__faculties.id', 'interns__students.faculty')
                        ->orderBy('interns__schools.shortname')
                        ->orderBy('interns__faculties.facultyname')
                        ->get();
        
        $liststudents = [];
            foreach ($students as $student) {
                $liststudents[$student->id] = 
                    $student->shortname.' - '.$student->facultyname.' - '.$student->fullname.' - '.$student->email;
            }
        
        return view('interns::admin.histories.create', compact('liststudents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateHistoryRequest $request
     * @return Response
     */
    public function store(CreateHistoryRequest $request)
    {
        $personID = DB::table('interns__students')
                    ->select('hanetpersonid')
                    ->where('id', $request->student)
                    ->get();
        if (count($personID) == 0) {
            $warnings = '<script>alert("Student chưa có HanetPersonID");</script>';
            return redirect()->route('admin.interns.history.index')->with('warnings', $warnings);
        }


        $post = [
            'token' =>'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjMwNzQwNjQzMTE2Mzg5MzIyMjQiLCJlbWFpbCI6ImxlZHVjdG9hbkBsZWR1Y3RvYW4uY29tIiwiY2xpZW50X2lkIjoiYzNiYjU3MDVmM2Y3ZjcyMDI3ZWYwZmJmMmRkYmQ1MjQiLCJ0eXBlIjoiYXV0aG9yaXphdGlvbl9jb2RlIiwiaWF0IjoxNjYzNzU2MDExLCJleHAiOjE2NjYzNDgwMTF9.abnKUVTMFnkASlvP_IpiKQLocQyhl5Q96TdoxPg18lo',
            'placeID' => '8037',
            'devices' => 'C21024B609',
            'date' => $request->date,
            // 'date' => '2022-10-17',
            'exType' => '4,2',
            'type' => '0',
            // 'aliasID' => $request->student,
            'personID' => $personID[0]->hanetpersonid,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://partner.hanet.ai/person/getCheckinByPlaceIdInDay',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $post,
        ));

        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);
        dd($response);
        if (count((array)($response->data)) > 0) {
            $first = $response->data[0];
            $last = $response->data[count($response->data)-1];
        } else {
            $warnings = '<script>alert("Không có dữ liệu của yêu cầu vừa gửi");</script>';
            return redirect()->route('admin.interns.history.index')->with('warnings', $warnings);
        }

        // dd($response);
        DB::table('interns__histories')
            ->updateOrInsert(
                [
                    'student' => $request->student,
                    'date' => $request->date,
                ],
                [
                    'firsttime' => date('H:i:s', substr($first->checkinTime, 0, -3)),
                    'firstimage' => $first->avatar,
                    'lasttime' => date('H:i:s', substr($last->checkinTime, 0, -3)),
                    'lastimage' => $last->avatar,
                ]
            );

        return redirect()->route('admin.interns.history.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::histories.title.histories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  History $history
     * @return Response
     */
    public function edit(History $history)
    {
        return view('interns::admin.histories.edit', compact('history'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  History $history
     * @param  UpdateHistoryRequest $request
     * @return Response
     */
    public function update(History $history, UpdateHistoryRequest $request)
    {
        $this->history->update($history, $request->all());

        return redirect()->route('admin.interns.history.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::histories.title.histories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  History $history
     * @return Response
     */
    public function destroy(History $history)
    {
        $this->history->destroy($history);

        return redirect()->route('admin.interns.history.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::histories.title.histories')]));
    }
}
