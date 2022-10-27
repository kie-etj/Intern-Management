<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\School;
use Modules\Interns\Http\Requests\CreateSchoolRequest;
use Modules\Interns\Http\Requests\UpdateSchoolRequest;
use Modules\Interns\Repositories\SchoolRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;

class SchoolController extends AdminBaseController
{
    /**
     * @var SchoolRepository
     */
    private $school;

    public function __construct(SchoolRepository $school)
    {
        parent::__construct();

        $this->school = $school;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $schools = $this->school->all();

        return view('interns::admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('interns::admin.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSchoolRequest $request
     * @return Response
     */
    public function store(CreateSchoolRequest $request)
    {

        $exists = DB::table('interns__schools')
                    ->where('shortname', $request->shortname)
                    ->orWhere('fullname', $request->fullname)
                    ->exists();

        if ($exists) {
            $warnings = '<script>alert("Đã có trường này trong CSDL!");</script>';
            return view('interns::admin.schools.create', compact('warnings'));
        } else {

            $this->school->create($request->all());
            
            return redirect()->route('admin.interns.school.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::schools.title.schools')]));

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  School $school
     * @return Response
     */
    public function edit(School $school)
    {
        return view('interns::admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  School $school
     * @param  UpdateSchoolRequest $request
     * @return Response
     */
    public function update(School $school, UpdateSchoolRequest $request)
    {

        $exists = DB::table('interns__schools')
                    ->where('id', '!=', $school->id)
                    ->where(function($query) use ($request) {
                        $query ->where('shortname', $request->shortname)
                            ->orWhere('fullname', $request->fullname);
                    })
                    ->exists();

        if ($exists) {
            
            $warnings = '<script>alert("Không thể cập nhật do dữ liệu trùng với trường đã tồn tại");</script>';
            return view('interns::admin.schools.edit', compact('school', 'warnings'));

        } else {
            $this->school->update($school, $request->all());

            return redirect()->route('admin.interns.school.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::schools.title.schools')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  School $school
     * @return Response
     */
    public function destroy(School $school)
    {
        if (DB::table('interns__faculties')->where('school', $school->id)->exists()) {

            $schools = $this->school->all();
            $warnings = '<script>alert("Không thể xóa '.$school->shortname.' do còn các khoa liên quan");</script>';
            return view('interns::admin.schools.index', compact('schools', 'warnings'));
            
        } else {
            $this->school->destroy($school);

            return redirect()->route('admin.interns.school.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::schools.title.schools')]));
        }
    }
}
