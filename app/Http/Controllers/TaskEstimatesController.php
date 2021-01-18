<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;

class TaskEstimatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $estimates = TaskEstimate::with('department')->where('task_id', $id)->get();
        if ($request->ajax()) {
            return response()->json($estimates);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $task = Task::findOrFail($id);
        $estimates = $request->input('estimates');
        $this->validate($request, [
            'estimates.*.department.id' => ['exists:App\department,id'],
            'estimates.*.minEstimate' => ['lte:estimates.*.maxEstimate'],
            'estimates.*.maxEstimate' => ['gte:estimates.*.minEstimate']
        ]);
        foreach ($estimates as $estimate) {
            $dbEstimate = TaskEstimate::findOrFail($estimate['id']);
            $dbEstimate->department_id = $estimate['department_id'];
            $dbEstimate->min_estimate = $estimate['minEstimate'];
            $dbEstimate->max_estimate = $estimate['maxEstimate'];
            $dbEstimate->save();
        }

        DB::commit();
        return response(['status' => 'success', 'data' => $estimates]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $estimate = TaskEstimate::findOrFail($id);
        $estimate->max_estimate = "0";
        $estimate->min_estimate = "0";
        $estimate->save();
    }
}
