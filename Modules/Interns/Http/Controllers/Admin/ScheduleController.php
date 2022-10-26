<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\Schedule;
use Modules\Interns\Http\Requests\CreateScheduleRequest;
use Modules\Interns\Http\Requests\UpdateScheduleRequest;
use Modules\Interns\Repositories\ScheduleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class ScheduleController extends AdminBaseController
{
    /**
     * @var ScheduleRepository
     */
    private $schedule;

    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();

        $this->schedule = $schedule;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $schedules = $this->schedule->all();
        $schedules = DB::table('interns__schedules')
                        ->select('interns__schedules.id', 'fullname', 'position', 'schedule', 'interns__schedules.created_at')
                        ->join('interns__students', 'interns__students.id', 'interns__schedules.student')
                        ->orderBy('position')
                        ->get();

        return view('interns::admin.schedules.index', compact('schedules'));
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
                        ->whereNotIn('interns__students.id', 
                        function($q) {
                            $q->select('student')
                                ->from('interns__schedules')
                                ->get();
                        })
                        ->get();
        
        if (count($students) == 0) {
            $schedules = DB::table('interns__schedules')
                        ->select('interns__schedules.id', 'fullname', 'position', 'schedule', 'interns__schedules.created_at')
                        ->join('interns__students', 'interns__students.id', 'interns__schedules.student')
                        ->orderBy('position')
                        ->get();
                        
            $warnings = '<script>alert("Tất cả sinh viên đã có lịch thực tập!!!");</script>';
            return view('interns::admin.schedules.index', compact('schedules', 'warnings'));
        } else {
            $liststudents = [];
            foreach ($students as $student) {
                $liststudents[$student->id] = 
                    $student->shortname.' - '.$student->facultyname.' - '.$student->fullname.' - '.$student->email;
            }
    
            return view('interns::admin.schedules.create', compact('liststudents'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateScheduleRequest $request
     * @return Response
     */
    public function store(CreateScheduleRequest $request)
    {
        if (isset($request->schedules)) {
            $schedules = $request->schedules;
            asort($schedules);
            $schedules = implode(',',$schedules);
        } else {
            $schedules = '';
        }
        
        DB::table('interns__schedules')
            ->insert([
                'student' => $request->student,
                'schedule' => $schedules,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        // $this->schedule->create($request->all());

        return redirect()->route('admin.interns.schedule.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::schedules.title.schedules')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Schedule $schedule
     * @return Response
     */
    public function edit(Schedule $schedule)
    {
        $students = DB::table('interns__students')
                        ->select('interns__students.id', 'interns__students.fullname', 'interns__schools.shortname', 
                                'interns__faculties.facultyname', 'interns__students.email')
                        ->join('interns__schools', 'interns__schools.id', 'interns__students.school')
                        ->join('interns__faculties', 'interns__faculties.id', 'interns__students.faculty')
                        ->where('interns__students.id', $schedule->student)
                        ->get();
        
        $liststudents = [];
        foreach ($students as $student) {
            $liststudents[$student->id] = 
                $student->shortname.' - '.$student->facultyname.' - '.$student->fullname.' - '.$student->email;
        }

        return view('interns::admin.schedules.edit', compact('schedule', 'liststudents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Schedule $schedule
     * @param  UpdateScheduleRequest $request
     * @return Response
     */
    public function update(Schedule $schedule, UpdateScheduleRequest $request)
    {
        if (isset($request->schedules)) {
            $schedules = $request->schedules;
            asort($schedules);
            $schedules = implode(',', $schedules);
        } else {
            $schedules = '';
        }
        
        DB::table('interns__schedules')
            ->where('id', $schedule->id)
            ->update([
                'schedule' => $schedules,
                'updated_at' => now(),
            ]);
        // $this->schedule->update($schedule, $request->all());

        return redirect()->route('admin.interns.schedule.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::schedules.title.schedules')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Schedule $schedule
     * @return Response
     */
    public function destroy(Schedule $schedule)
    {
        $this->schedule->destroy($schedule);

        return redirect()->route('admin.interns.schedule.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::schedules.title.schedules')]));
    }
}
