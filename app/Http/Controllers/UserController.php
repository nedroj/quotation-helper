<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use function __;
use function redirect;
use function view;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.index')
            ->with('users', User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User();
        return view('users.editform')
            ->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserFormRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserFormRequest $request)
    {
        $this->validate($request, ['password' => ['required']]);

        $user           = new User();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $request->session()->flash('successmessage', __('User added'));
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.editform')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserFormRequest
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserFormRequest $request, $id)
    {
        $user        = User::findOrFail($id);
        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        $request->session()->flash('successmessage', __('User updated'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $request->session()->flash('successmessage', __('User deleted'));
        return redirect()->route('users.index');
    }
}
