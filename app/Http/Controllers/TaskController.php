<?php

namespace App\Http\Controllers;

use App\Department;
use App\Task;
use App\TaskEstimate;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tasks = Task::all();
        if ($request->ajax()) {
            return response()->json($tasks);
        }

        return view('tasks.index')
            ->with('tasks',$tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'epic_id' => ['required'],
            'title' => ['unique:tasks,title'. ($this->tasks ?? '')],
            'description' => ['min:8']
        ]);
        $task = new Task();
        $task->epic_id = $request->input('epic_id');
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();
        $departments = Department::all();
        foreach ($departments as $department){
            $estimate = TaskEstimate::create([
                    'task_id' => $task->id,
                    'min_estimate'=>'0',
                    'max_estimate'=>'0',
                    'department_id' => $department->id
                ]
            );
//            'task_id', 'min_estimate', 'max_estimate', 'department_id'
        }
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $estimates = TaskEstimate::where("task_id", $id);
        $estimates->delete();
        $task = Task::findOrFail($id);
        $task->delete();

    }
    /**
     * Display the specified resource by group.
     */
    public function getTasksByEpic(Request $request ,$epic)
    {
        $tasks = Task::where('epic_id' ,$epic)->with('epic','taskEstimates')->get();
        if ($request->ajax()) {
            return response()->json($tasks);
        }

        return view('tasks.index')
            ->with('tasks',$tasks);
    }
}
