<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Requests\PushToJiraRequest;
use App\Issue;
use App\Issuelist;
use App\Http\Requests\IssuelistFormRequest;
use App\Jobs\PushToJira;
use App\Services\JiraService;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;
use function __;
use function redirect;
use function view;

class IssuelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $issuelists = Issuelist::all();

        return view('issuelists.index')
            ->with('issuelists', $issuelists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $issuelist = new Issuelist();

        $availableTags = Tag::all();

        return view('issuelists.editform')
            ->with('issuelist', $issuelist)
            ->with('availableTags', $availableTags)
            ->with('currentTags', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CategoryFormRequest
     * @return \Illuminate\Http\Response
     */
    public function store(IssuelistFormRequest $request)
    {
        $issuelist = new Issuelist();
        $issuelist->name = $request->input('name');
        $issuelist->save();
        $issuelist->retag($request->input('tags', []));

        $request->session()->flash('successmessage', __('Issuelist added'));
        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Display the specified resource.
     *
     * @param Issuelist $issuelist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Issuelist $issuelist)
    {
        if ($request->has('up')) {
            Issue::findOrFail($request->input('up'))->moveOrderUp();
        }
        if ($request->has('down')) {
            Issue::findOrFail($request->input('down'))->moveOrderDown();
        }

        if ($request->has('email_up')) {
            Email::findOrFail($request->input('email_up'))->moveOrderUp();
        }
        if ($request->has('email_down')) {
            Email::findOrFail($request->input('email_down'))->moveOrderDown();
        }

        return view('issuelists.show')
            ->with('issuelist', $issuelist)
            ->with('issues', $issuelist->issues()->ordered()->get())
            ->with('emails', $issuelist->emails()->ordered()->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Issuelist $issuelist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Issuelist $issuelist)
    {
        $availableTags = Tag::all();
        $currentTags = $issuelist->tags->map(function ($tag) { return $tag->name; })->toArray();

        return view('issuelists.editform')
            ->with('issuelist', $issuelist)
            ->with('availableTags', $availableTags)
            ->with('currentTags', $currentTags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CategoryFormRequest
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IssuelistFormRequest $request, Issuelist $issuelist)
    {
        $issuelist->name = $request->input('name');
        $issuelist->save();
        $issuelist->retag($request->input('tags', []));

        $request->session()->flash('successmessage', __('Issuelist updated'));

        return redirect()->route('issuelists.show', [$issuelist]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Issuelist $issuelist)
    {
        $issuelist->issues()->delete();
        $issuelist->delete();

        $request->session()->flash('successmessage', __('Issuelist deleted'));

        return redirect()->route('issuelists.index');
    }


    public function getPush(Issuelist $issuelist)
    {
        $projects = JiraService::getProjects();
        $users    = JiraService::getUsers();

        return view('issuelists.push')
            ->with('issuelist', $issuelist)
            ->with('projects', $projects)
            ->with('users', $users);
    }

    public function postPush(PushToJiraRequest $request, Issuelist $issuelist)
    {
        $this->dispatch(
            new PushToJira(
                $issuelist,
                $request->input('description'),
                $request->input('project'),
                $request->input('reporter'),
                $request->input('assignee')
            )
        );

        $request->session()->flash('successmessage', __('Issuelist pushed'));

        return redirect()->route('issuelists.show', [$issuelist]);
    }


}
