<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\Student;
use Modules\Interns\Http\Requests\CreateStudentRequest;
use Modules\Interns\Http\Requests\UpdateStudentRequest;
use Modules\Interns\Repositories\StudentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\UserRepository;

class StudentController extends AdminBaseController
{
    /**
     * @var StudentRepository
     */
    private $student;
    private $user;
    
    public function __construct(StudentRepository $student, UserRepository $user, PermissionManager $permissions)
    {
        parent::__construct();
        $this->student = $student;
        $this->user = $user;
        $this->permissions = $permissions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $students = $this->student->all();
        $students = DB::table('interns__students')
                    ->select('interns__schedules.id AS schedule', 'interns__students.id', 
                            'interns__students.fullname', DB::raw('date_format(dateofbirth, "%d-%m-%Y") AS dateofbirth'), 
                            'email', 'phone', 'studentid', 'position', 'interns__schools.shortname AS school', 
                            'interns__faculties.facultyname AS faculty', 'year', 'avatar', 'cv', 'lecturername', 'lectureremail', 'lecturerphone',
                            'internyear', 'internquarter')
                    ->join('interns__schools', 'interns__schools.id', 'interns__students.school')
                    ->leftJoin('interns__faculties', 'interns__faculties.id', 'interns__students.faculty')
                    ->leftJoin('interns__schedules', 'interns__schedules.student', 'interns__students.id')
                    ->get();
        
        return view('interns::admin.students.index', compact('students'));
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
        $listschools = [];
        foreach ($schools as $key => $value) {
            $listschools[$value->id] = $value->fullname;
        }

        $faculties = DB::table('interns__faculties')
                    ->select('id', 'school', 'facultyname')
                    ->orderBy('facultyname')
                    ->get();

        return view('interns::admin.students.create', compact('listschools', 'faculties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateStudentRequest $request
     * @return Response
     */
    public function store(CreateStudentRequest $request)
    {
        if (isset($request->studentid)) {
            $existPersonID = DB::table('interns__students')
                                ->where('studentid', $request->studentid)
                                ->exists();
            if ($existPersonID) {
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

                $student['faculty'] = $request->faculty;
                $warnings = '<script>alert("Đã có sinh viên sở hữu MSSV vừa nhập");</script>';
                return view('interns::admin.students.create', compact('listschools', 'faculties', 'warnings', 'student'));
            }
        }

        $existEmail = DB::table('interns__students')
                    ->where('email', $request->email)
                    ->exists();

        if ($existEmail) {
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

            $student['faculty'] = $request->faculty;
            $warnings = '<script>alert("Đã có sinh viên sở hữu email vừa nhập");</script>';
            return view('interns::admin.students.create', compact('listschools', 'faculties', 'warnings', 'student'));
        } else {
            $input = $request->all();
            $input['avatar'] = null;
            $input['cv'] = null;
            
            $student = $this->student->create($input);
            
            $id = DB::table('interns__students')
                    ->select('id')
                    ->where('email', $request->email)
                    ->get()[0]->id;

            if ($request->file('avatar') !== null) {
                $destination_path = 'public/assets/student/'.$id.'/';
                $avatar_name = 'avatar.'. $request->file('avatar')->getClientOriginalExtension();
                if (Storage::exists($destination_path . $avatar_name)) {
                    Storage::delete($destination_path . $avatar_name);
                }
                $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
                DB::table('interns__students')
                    ->where('id', $id)
                    ->update(['avatar' => $avatar_name]);
            }
            if ($request->file('cv') !== null) {
                $destination_path = 'public/assets/student/'.$id.'/';
                $cv_name = $request->file('cv')->getClientOriginalName();
                if (Storage::exists($destination_path . $cv_name)) {
                    Storage::delete($destination_path . $cv_name);
                }
                $path = $request->file('cv')->storeAs($destination_path, $cv_name);
                DB::table('interns__students')
                    ->where('id', $id)
                    ->update(['cv' => $cv_name]);
            }

            DB::table('interns__schedules')
                ->insert([
                    'student' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            // Handle Create Account
            if ($student) {
                $fullname = explode(' ', $input['fullname']);
                $firstname = null; $lastname = null;
                if (count($fullname) == 1) {
                    $lastname = $fullname[0];
                } else {
                    $firstname = $fullname[0];
                    for ($i=1; $i < count($fullname); $i++) { 
                        $lastname .= $fullname[$i] . ' ';
                    }
                }
                $lastname = trim($lastname);
                $data = [
                    'email' => $request->email,
                    'password' => 123,
                    'first_name' => $firstname,
                    'last_name' => $lastname,
                ];

                $this->user->createWithRoles($data, [3], true);
            }

            return redirect()->route('admin.interns.student.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::students.title.students')]));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Student $student
     * @return Response
     */
    public function edit(Student $student)
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

        return view('interns::admin.students.edit', compact('student', 'listschools', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Student $student
     * @param  UpdateStudentRequest $request
     * @return Response
     */
    public function update(Student $student, UpdateStudentRequest $request)
    {
        if (isset($request->studentid)) {
            $existPersonID = DB::table('interns__students')
                                ->where('id', '!=', $student->id)
                                ->where('studentid', $request->studentid)
                                ->exists();

            if ($existPersonID) {
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

                $student['faculty'] = $request->faculty;
                $warnings = '<script>alert("Đã có sinh viên sở hữu MSSV vừa nhập");</script>';
                return view('interns::admin.students.edit', compact('listschools', 'faculties', 'warnings', 'student'));
            }
        }

        $exists = DB::table('interns__students')
                    ->where('id', '!=', $student->id)
                    ->where('email', $request->email)
                    ->exists();
        
        if ($exists) {
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

            $warnings = '<script>alert("Đã có sinh viên sở hữu email vừa nhập");</script>';
            return view('interns::admin.students.edit', compact('student', 'listschools', 'faculties', 'warnings'));
        } else {
            $input = $request->all();
            $destination_path = 'public/assets/student/'.$student->id.'/';

            if ($request->file('avatar') !== null) {
                $avatar_name = 'avatar.'. $request->file('avatar')->getClientOriginalExtension();
                if (Storage::exists($destination_path . $avatar_name)) {
                    Storage::delete($destination_path . $avatar_name);
                }
                $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
                $input['avatar'] = $avatar_name;
            }

            if ($request->file('cv') !== null) {
                $cv_name = $request->file('cv')->getClientOriginalName();
                if (Storage::exists($destination_path . $cv_name)) {
                    Storage::delete($destination_path . $cv_name);
                }
                $path = $request->file('cv')->storeAs($destination_path, $cv_name);
                $input['cv'] = $cv_name;
            } else {
                unset($input['cv']);
            }

            if (isset($request->clearavatar)) {
                if (Storage::exists($destination_path . $student->avatar)) {
                    Storage::delete($destination_path . $student->avatar);
                }
                $input['avatar'] = null;
            }
            
            // $id = DB::table('users')
            //     ->select('id')
            //     ->where('email', $student->email)
            //     ->get()[0]->id;
            
            // $this->user->update()

            $this->student->update($student, $input);

            return redirect()->route('admin.interns.student.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::students.title.students')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Student $student
     * @return Response
     */
    public function destroy(Student $student)
    {
        DB::table('interns__schedules')
            ->where('student', $student->id)
            ->delete();

        $destination_path = 'public/assets/student/'.$student->id.'/';
        if (Storage::exists($destination_path)) {
            Storage::deleteDirectory($destination_path);
        }

        $id = DB::table('users')
                ->select('id')
                ->where('email', $student->email)
                ->get();
                
        if (count($id) > 0) {
            $this->user->delete($id[0]->id);
        }
        
        $this->student->destroy($student);

        return redirect()->route('admin.interns.student.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::students.title.students')]));
    }
}
