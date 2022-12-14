<?php

namespace Modules\Interns\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        if (isset($request->studentid)) {
            $existPersonID = DB::table('interns__students')
                                ->where('studentid', $request->studentid)
                                ->exists();

            $existRegisterID = DB::table('interns__registers')
                                ->where('studentid', $request->studentid)
                                ->exists();

            if ($existPersonID || $existRegisterID) {
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
                $warnings = '<script>alert("???? c?? sinh vi??n d??ng MSSV n??y ho???c b???n ???? ????ng k?? tr?????c ????y!!!");</script>';
                return view('interns::public.create', compact('listschools', 'faculties', 'warnings', 'student'));
            }
        }

        $existEmail = DB::table('interns__students')
                    ->where('email', $request->email)
                    ->exists();
        
        $existRegisterEmail = DB::table('interns__registers')
                                ->where('email', $request->email)
                                ->exists();

        if ($existEmail || $existRegisterEmail) {
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
            $warnings = '<script>alert("???? c?? sinh vi??n s??? h???u EMAIL n??y ho???c b???n ???? ????ng k?? tr?????c ????y!!!");</script>';
            return view('interns::public.create', compact('listschools', 'faculties', 'warnings', 'student'));
        } else {
            $input = $request->all();
            $input['avatar'] = null;
            $input['cv'] = null;
            $input['created_at'] = now();
            $input['updated_at'] = now();
            unset($input['_token']);

            $student = DB::table('interns__registers')->insert($input);
            
            $id = DB::table('interns__registers')
                    ->select('id')
                    ->where('email', $request->email)
                    ->get()[0]->id;

            $destination_path = 'public/assets/register/'.$id.'/';
            if ($request->file('avatar') !== null) {
                $avatar_name = 'avatar.'. $request->file('avatar')->getClientOriginalExtension();
                if (Storage::exists($destination_path . $avatar_name)) {
                    Storage::delete($destination_path . $avatar_name);
                }
                $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
                DB::table('interns__registers')
                    ->where('id' , $id)
                    ->update(['avatar' => $avatar_name]);
            }
            if ($request->file('cv') !== null) {
                $cv_name = $request->file('cv')->getClientOriginalName();
                if (Storage::exists($destination_path . $cv_name)) {
                    Storage::delete($destination_path . $cv_name);
                }
                $path = $request->file('cv')->storeAs($destination_path, $cv_name);
                DB::table('interns__registers')
                    ->where('id' , $id)
                    ->update(['cv' => $cv_name]);
            }
            return view('interns::public.success');
        }
    }
    public function success(Request $request)
    {            
        return view('interns::public.success');
    }

    public function sendMail(Request $request) {
        return view('interns::public.mail');
    }

}
