<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\Faculty;
use Modules\Interns\Http\Requests\CreateFacultyRequest;
use Modules\Interns\Http\Requests\UpdateFacultyRequest;
use Modules\Interns\Repositories\FacultyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class FacultyController extends AdminBaseController
{
    /**
     * @var FacultyRepository
     */
    private $faculty;

    public function __construct(FacultyRepository $faculty)
    {
        parent::__construct();

        $this->faculty = $faculty;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $faculties = $this->faculty->all();
        $faculties = DB::table('interns__faculties')
                        ->select('interns__faculties.id', 'interns__schools.shortname', 'interns__schools.fullname', 'interns__faculties.facultyname', 'interns__faculties.created_at')
                        ->join('interns__schools', 'interns__schools.id', '=', 'interns__faculties.school')
                        ->get();

        $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();
            
        $results = [];
        foreach ($schools as $key => $value) {
            $results[$value->id] = $value->fullname;
        }

        return view('interns::admin.faculties.index', compact('faculties', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();
        
        $results = [];
        foreach ($schools as $key => $value) {
            $results[$value->id] = $value->fullname;
        }
        return view('interns::admin.faculties.create', compact('results'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFacultyRequest $request
     * @return Response
     */
    public function store(CreateFacultyRequest $request)
    {

        $exists = DB::table('interns__faculties')
                    ->where('school', $request->school)
                    ->where('facultyname', $request->facultyname)
                    ->exists();

        if ($exists) {

            $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();
        
            $results = [];
            foreach ($schools as $key => $value) {
                $results[$value->id] = $value->fullname;
            }

            $warnings = '<script>alert("Đã có khoa '.$request->facultyname.' trong CSDL của trường tương ứng");</script>';
            return view('interns::admin.faculties.create', compact('results', 'warnings'));

        } else {
            $this->faculty->create($request->all());
    
            return redirect()->route('admin.interns.faculty.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::faculties.title.faculties')]));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Faculty $faculty
     * @return Response
     */
    public function edit(Faculty $faculty)
    {
        $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();

        $results = [];
        foreach ($schools as $key => $value) {
            $results[$value->id] = $value->fullname;
        }
        return view('interns::admin.faculties.edit', compact('faculty', 'results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Faculty $faculty
     * @param  UpdateFacultyRequest $request
     * @return Response
     */
    public function update(Faculty $faculty, UpdateFacultyRequest $request)
    {
        $exists = DB::table('interns__faculties')
                    ->where('id', '!=', $faculty->id)
                    ->where('school', $request->school)
                    ->where('facultyname', $request->facultyname)
                    ->exists();

        if ($exists) {

            $schools = DB::table('interns__schools')
                    ->select('id', 'fullname')
                    ->orderBy('fullname')
                    ->get();
        
            $results = [];
            foreach ($schools as $key => $value) {
                $results[$value->id] = $value->fullname;
            }

            $warnings = '<script>alert("Đã có khoa '.$request->facultyname.' trong CSDL của trường tương ứng");</script>';
            return view('interns::admin.faculties.edit', compact('results', 'faculty', 'warnings'));

        } else {
            $this->faculty->update($faculty, $request->all());

            return redirect()->route('admin.interns.faculty.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::faculties.title.faculties')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Faculty $faculty
     * @return Response
     */
    public function destroy(Faculty $faculty)
    {
        if (DB::table('interns__students')->where('faculty', $faculty->id)->exists()) {

            $faculties = DB::table('interns__faculties')
                            ->select('interns__faculties.id', 'interns__schools.shortname', 'interns__schools.fullname', 'interns__faculties.facultyname', 'interns__faculties.created_at')
                            ->join('interns__schools', 'interns__schools.id', '=', 'interns__faculties.school')
                            ->get();
            
            $warnings = '<script>alert("Không thể xóa '.$faculty->facultyname.' do còn các sinh viên liên quan");</script>';
            return view('interns::admin.faculties.index', compact('faculties', 'warnings'));
            
        } else {
            $this->faculty->destroy($faculty);

            return redirect()->route('admin.interns.faculty.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::faculties.title.faculties')]));
        }
    }
}
