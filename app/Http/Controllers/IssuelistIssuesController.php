<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Issuelist;
use App\Http\Requests\IssueFormRequest;
use Illuminate\Http\Request;
use function redirect;
use function view;

class IssuelistIssuesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Issuelist $issuelist)
    {
        $issue = new Issue();
        $issue->issueList()->associate($issuelist);

        return view('issuelists.issues.editform')
            ->with('issue', $issue);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IssueFormRequest $request
     * @param Issuelist        $issuelist
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function store(IssueFormRequest $request, Issuelist $issuelist)
    {
        $issue = new Issue();
        $issue->issueList()->associate($issuelist);
        $issue->default_project   = $request->input('default_project');
        $issue->default_reporter  = $request->input('default_reporter');
        $issue->default_assignee  = $request->input('default_assignee');
        $issue->name              = $request->input('name');
        $issue->description       = $request->input('description');
        $issue->original_estimate = $request->input('original_estimate');
        $issue->save();

        foreach ($request->file('attachments', []) as $attachment) {
            $issue->addMedia($attachment)
                ->toMediaCollection('attachments');
        }

        $request->session()->flash('successmessage', __('Issue added'));

        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Issuelist $issuelist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Issuelist $issuelist, Issue $issue)
    {
        return view('issuelists.issues.editform')
            ->with('issue', $issue);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IssueFormRequest $request
     * @param Issuelist        $issuelist
     * @param Issue            $issue
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig
     */
    public function update(IssueFormRequest $request, Issuelist $issuelist, Issue $issue)
    {
        $issue->default_project   = $request->input('default_project');
        $issue->default_reporter  = $request->input('default_reporter');
        $issue->default_assignee  = $request->input('default_assignee');
        $issue->name              = $request->input('name');
        $issue->description       = $request->input('description');
        $issue->original_estimate = $request->input('original_estimate');
        $issue->save();

        $issue->media()->whereNotIn('id', $request->input('keepattachments', []))->delete();

        foreach ($request->file('attachments', []) as $attachment) {
            $issue->addMedia($attachment)
                ->toMediaCollection('attachments');
        }

        $request->session()->flash('successmessage', __('Issue updated'));
        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request   $request
     * @param Issuelist $issuelist
     * @param Issue     $issue
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Issuelist $issuelist, Issue $issue)
    {
        $issue->delete();

        $request->session()->flash('successmessage', __('Issue deleted'));
        return redirect()->route('issuelists.show', [$issuelist]);
    }
}
