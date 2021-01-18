<?php

namespace App\Http\Controllers;

use App\Department;
use App\Project;
use App\ProjectQuotation;
use App\Quotation;
use App\QuotationEpic;
use App\QuotationEstimates;
use App\QuotationTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class QuotationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::all();
        return view('quotations.index')->with('quotatons', $quotations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quotations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request)
    {
        // VAlidate values
        $this->validate($request, [
            'title' => ['unique:projects,title' . ($this->project ?? '')],
            'status' => ['required'],
        ]);

        DB::beginTransaction();
        // restoring all created if goes wrong
        try {
            // Create project
            $project = new Project();
            $project->title = $request->input('title');
            $project->save();

            // Create quotations
            $quotation = new Quotation();
            $quotation->status_id = $request->input('status');
            $quotation->save();

            // Create projectQuotation
            $projectQuotation = new ProjectQuotation();
            $projectQuotation->round = 1;
            // associate get the id of the just created $project and $quotation
            $projectQuotation->project()->associate($project);
            $projectQuotation->quotation()->associate($quotation);
            $projectQuotation->save();

            // Loop through selectedItems
            foreach ($request->selectedItems as $requestTask) {
                // Create new epic for every task
                $requestEpic = $requestTask['epic'];
                $epic = new QuotationEpic();
                $epic->title = $requestEpic['title'];
                $epic->description = $requestEpic['description'];
                $epic->save();

                // Create task
                $task = new QuotationTask();
                $task->title = $requestTask['title'];
                $task->description = $requestTask['description'];
                $task->quotationEpic()->associate($epic);
                $task->quotation()->associate($quotation);

                $task->save();

                foreach ($requestTask['task_estimates'] as $task_estimates) {
                    $quotationEstimate = new QuotationEstimates();
                    $quotationEstimate->min_estimate = $task_estimates['NewMinEstimate'];
                    $quotationEstimate->max_estimate = $task_estimates['NewMaxEstimate'];
                    $quotationEstimate->base_min_estimate = $task_estimates['min_estimate'];
                    $quotationEstimate->base_max_estimate = $task_estimates['max_estimate'];
                    $quotationEstimate->comment = $task_estimates['comment'];
                    $quotationEstimate->department()->associate(Department::findOrFail($task_estimates['department_id']));
                    $quotationEstimate->projectQuotation()->associate($projectQuotation);
                    $quotationEstimate->quotationTask()->associate($task);
                    $quotationEstimate->save();
                }
            }

            // Safe on succes
            DB::commit();
            return response(['message' => 'ALL GOOD'], 200);
        } catch (\Exception $e) {
            // Delete all on fail
            DB::rollBack();
//            throw $e;
            return response(['message' => $e], 500);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->projectQuotations()->delete();
        $quotation->delete();

        $request->session()->flash('successmessage', __('Quotation deleted'));
        return back();
    }

    public function pdf($id)
    {
        $quotation = Quotation::with('status',
            'projectQuotations',
            'projectQuotations.project',
            'projectQuotations.quotationEstimates',
            'projectQuotations.quotationEstimates.quotationTask',
            'projectQuotations.quotationEstimates.department')
            ->findOrFail($id);
        $pdf = \PDF::loadView('quotations.pdf', compact('quotation'));
        return $pdf->stream();
    }
}
