<?php

namespace App\Http\Controllers;

use App\Department;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use function __;
use function redirect;
use function view;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index')
            ->with('departments', $departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $department = new Department();
        return view('departments.editform')
            ->with('department', $department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, ['name' => ['unique:departments,name' . ($this->department ?? '')]]);
        $department = new Department();
        $department->name = $request->input('name');
        $department->abbreviation = $request->input('abbreviation');
        $department->save();
        $request->session()->flash('successmessage', __('department has been added'));
        return redirect()->route('departments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('departments.editform')
            ->with('department', $department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->name = $request->input('name');
        $department->abbreviation = $request->input('abbreviation');
        $department->save();

        $request->session()->flash('successmessage', __('Department updated'));
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        $request->session()->flash('successmessage', __('Department deleted'));
        return redirect()->route('departments.index');
    }

    public function showAll()
    {
        $departments = Department::all();
    }
}
