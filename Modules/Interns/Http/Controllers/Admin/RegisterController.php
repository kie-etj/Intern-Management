<?php

namespace Modules\Interns\Http\Controllers\Admin;

use App\Mail\HelloMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\Interns\Entities\Register;
use Modules\Interns\Http\Requests\CreateRegisterRequest;
use Modules\Interns\Http\Requests\UpdateRegisterRequest;
use Modules\Interns\Repositories\RegisterRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Repositories\UserRepository;

class RegisterController extends AdminBaseController
{
    /**
     * @var RegisterRepository
     */
    private $register;
    private $user;

    public function __construct(RegisterRepository $register, UserRepository $user)
    {
        parent::__construct();

        $this->register = $register;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // $registers = $this->register->all();
        $registers = DB::table('interns__registers')
                        ->select('interns__registers.id', 'firstname', 'lastname', 'dateofbirth', 'email', 'phone',
                        'studentid', 'position', 'interns__schools.shortname AS school', 'interns__faculties.facultyname AS faculty',
                        'year', 'avatar', 'cv', 'lecturername', 'lectureremail', 'lecturerphone', 'interns__registers.created_at')
                        ->leftJoin('interns__schools', 'interns__schools.id', 'interns__registers.school')
                        ->leftJoin('interns__faculties', 'interns__faculties.id', 'interns__registers.faculty')
                        ->get();
        return view('interns::admin.registers.index', compact('registers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('interns::admin.registers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRegisterRequest $request
     * @return Response
     */
    public function store(CreateRegisterRequest $request)
    {
        $id = $request->id;

        $register = $this->register->find($id);

        $data = [
            'fullname' => $register->firstname . ' ' . $register->lastname,
            'dateofbirth' => $register->dateofbirth,
            'email' => $register->email,
            'phone' => $register->phone,
            'position' => $register->position,
            'school' => $register->school,
            'faculty' => $register->faculty,
            'year' => $register->year,
            'avatar' => $register->avatar,
            'cv' => $register->cv,
            'studentid' => $register->studentid,
            'lecturername' => $register->lecturername,
            'lectureremail' => $register->lectureremail,
            'lecturerphone' => $register->lecturerphone,
        ];
        
        $student = DB::table('interns__students')->insertGetId($data);

        if ($student) {
            $source_path = 'public/assets/register/'.$register->id.'/';
            $destination_path = 'public/assets/student/'.$student.'/';
            if (Storage::exists($source_path)) {
                Storage::move($source_path, $destination_path);
            }

            $dataUser = [
                'email' => $register->email,
                'password' => 123,
                'first_name' => $register->firstname,
                'last_name' => $register->lastname,
            ];

            $this->user->createWithRoles($dataUser, [3], true);

            $mailable = new HelloMail($data);
            Mail::to($data['email'])->send($mailable);

            DB::table('interns__registers')->where('id', $id)->delete();

        }
        
        return redirect()->route('admin.interns.register.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::students.title.students')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Register $register
     * @return Response
     */
    public function edit(Register $register)
    {
        return view('interns::admin.registers.edit', compact('register'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Register $register
     * @param  UpdateRegisterRequest $request
     * @return Response
     */
    public function update(Register $register, UpdateRegisterRequest $request)
    {
        $this->register->update($register, $request->all());

        return redirect()->route('admin.interns.register.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('interns::registers.title.registers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Register $register
     * @return Response
     */
    public function destroy(Register $register)
    {
        
        $destination_path = 'public/assets/register/'.$register->id.'/';
        if (Storage::exists($destination_path)) {
            Storage::deleteDirectory($destination_path);
        }

        $this->register->destroy($register);
        
        return redirect()->route('admin.interns.register.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::registers.title.registers')]));
    }
}
