<?php

namespace App\Http\Controllers;

use App\Epic;
use http\Header;
use Illuminate\Http\Request;

class EpicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $epics = Epic::all();
        if ($request->ajax()) {
             return response()->json($epics);
        }

        return view('epics.index')
            ->with('epics',$epics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $this->validate($request, [
            'title' => ['unique:epics,title'. ($this->epic ?? '')],
            'description' => ['min:8']
        ]);
        $epic = new Epic();
        $epic->title = $request->input('title');
        $epic->description = $request->input('description');
        $epic->save();

//        if(request()->ajax()) {
//            //do something
//            return redirect()->with('successmessage', 'epics has been added');
//        }
//        return redirect()->route('epics.index')->with('successmessage', 'epics has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $epic = Epic::findOrFail($id);
        $epic->title = $request->input('title');
        $epic->description = $request->input('description');
        $epic->save();
//        if(request()->ajax()) {
//            //do something
//            return redirect()->with('successmessage', 'epics has been updated');
//        }
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
        $epic = Epic::findOrFail($id);
        $epic->delete();


//        if(request()->ajax()) {
//            //do something
//            return redirect()->with('successmessage', 'epics has been deleted');
//        }
//        return redirect()->route('epics.index')->with('successmessage', 'epics has been deleted');
    }

//    public function orderBy(Request $request){
//        dd($request);
//        $epics = Epic::all();
//        if ($request->ajax()) {
//            return response()->json($epics);
//        }
//    }
}
