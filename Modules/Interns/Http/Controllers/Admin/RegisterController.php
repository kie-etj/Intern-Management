<?php

namespace Modules\Interns\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Interns\Entities\Register;
use Modules\Interns\Http\Requests\CreateRegisterRequest;
use Modules\Interns\Http\Requests\UpdateRegisterRequest;
use Modules\Interns\Repositories\RegisterRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RegisterController extends AdminBaseController
{
    /**
     * @var RegisterRepository
     */
    private $register;

    public function __construct(RegisterRepository $register)
    {
        parent::__construct();

        $this->register = $register;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$registers = $this->register->all();

        return view('interns::admin.registers.index', compact(''));
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
        dd($request->all());
        $this->register->create($request->all());

        return redirect()->route('admin.interns.register.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('interns::registers.title.registers')]));
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
        $this->register->destroy($register);

        return redirect()->route('admin.interns.register.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('interns::registers.title.registers')]));
    }
}
