<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\Intern_Diary;
use Modules\Interns\Http\Requests\CreateIntern_DiaryRequest;
use Modules\Interns\Http\Requests\UpdateIntern_DiaryRequest;
use Modules\Interns\Repositories\Intern_DiaryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class Intern_DiaryController extends AdminBaseController
{
    /**
     * @var Intern_DiaryRepository
     */
    private $intern_diary;

    public function __construct(Intern_DiaryRepository $intern_diary)
    {
        parent::__construct();

        $this->intern_diary = $intern_diary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (auth()->user()->roles[0]->id == 1) {
            $intern_diaries = DB::table('interns__intern_diaries')
                                ->select('interns__intern_diaries.id', 'interns__students.fullname AS student', 'interns__students.position', 'task', 'startdate', 'enddate', 'status')
                                ->join('interns__students', 'interns__students.id', 'interns__intern_diaries.student')
                                ->get();
        } else {
            $intern_diaries = DB::table('interns__intern_diaries')
                                ->select('interns__intern_diaries.id', 'interns__students.fullname AS student', 'interns__students.position', 'task', 'startdate', 'enddate', 'status')
                                ->join('interns__students', 'interns__students.id', 'interns__intern_diaries.student')
                                ->where('email', auth()->user()->email)
                                ->get();
        } 
        foreach ($intern_diaries as $key => $value) {
            if ($value->status == 'Done') {
                $value->statistic = 'Done';
            } elseif (($value->status == 'New' || $value->status == 'In Progress') && $value->enddate < date("Y-m-d")) {
                $value->statistic = 'Not Completed';
            } elseif (($value->status == 'New' || $value->status == 'In Progress') && $value->enddate < date("Y-m-d", strtotime("5 day")) && $value->enddate >= date("Y-m-d")) {
                $value->statistic = 'Warning';
            } elseif ($value->status == 'In Progress') {
                $value->statistic = 'In Progress';
            } else {
                $value->statistic = 'New';
            }
        }
        return view('interns::admin.intern_diaries.index', compact('intern_diaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $students = DB::table('interns__students')
                    ->orderBy('fullname')
                    ->get();
        
        $liststudents = [];
        foreach ($students as $student) {
            $liststudents[$student->id] = $student->fullname . ' - ' . $student->email;
        }

        return view('interns::admin.intern_diaries.create', compact('liststudents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateIntern_DiaryRequest $request
     * @return Response
     */
    public function store(CreateIntern_DiaryRequest $request)
    {
        $input = $request->all();

        $student = DB::table('interns__students')
                    ->select('id')
                    ->where('email', auth()->user()->email)
                    ->get();
        $input['student'] = (string)$student[0]->id;
        
        $this->intern_diary->create($input);

        return redirect()->route('admin.interns.intern_diary.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::intern_diaries.title.intern_diaries')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Intern_Diary $intern_diary
     * @return Response
     */
    public function edit(Intern_Diary $intern_diary)
    {
        $user = (string)DB::table('interns__students')
                            ->select('id')
                            ->where('email', auth()->user()->email)
                            ->get()[0]->id;

        if ($intern_diary->student == $user || auth()->user()->roles[0]->id == 1) {
            $students = DB::table('interns__students')
                        ->where('id', $intern_diary->student)
                        ->get();
            
            $student[$students[0]->id] = $students[0]->fullname . ' - ' . $students[0]->email;
            return view('interns::admin.intern_diaries.edit', compact('intern_diary', 'student'));
        } else {
            $warnings = '<script>alert("Bạn không có quyền truy cập vào đây!!!");</script>';
            return redirect()->route('admin.interns.intern_diary.index')->with('warnings', $warnings);
        }
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Intern_Diary $intern_diary
     * @param  UpdateIntern_DiaryRequest $request
     * @return Response
     */
    public function update(Intern_Diary $intern_diary, UpdateIntern_DiaryRequest $request)
    {
        $this->intern_diary->update($intern_diary, $request->all());

        return redirect()->route('admin.interns.intern_diary.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::intern_diaries.title.intern_diaries')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Intern_Diary $intern_diary
     * @return Response
     */
    public function destroy(Intern_Diary $intern_diary)
    {
        $this->intern_diary->destroy($intern_diary);

        return redirect()->route('admin.interns.intern_diary.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::intern_diaries.title.intern_diaries')]));
    }
}
