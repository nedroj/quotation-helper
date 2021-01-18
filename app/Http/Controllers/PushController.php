<?php

namespace App\Http\Controllers;

use App;
use App\Issuelist;
use App\Mail\IssueListEmail;
use App\Services\JiraService;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function __;
use function redirect;
use function view;

class PushController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \JiraRestApi\JiraException
     * @throws \JsonMapper_Exception
     */
    public function get()
    {
        $projects = JiraService::getProjects();
        $users    = JiraService::getUsers();
        $issuelists = Issuelist::all();

        $availableTags = Tag::all();

        return view('push.form')
            ->with('projects', $projects)
            ->with('users', $users)
            ->with('issuelists', $issuelists)
            ->with('availableTags', $availableTags);
    }

    public function getIssuelistsTable(Request $request)
    {
        $issuelists = Issuelist::query()
        ->when($request->has('tags'), function($q) use ($request) {
            $q->withAnyTag($request->input('tags'), []);
        })->get();
        return view('push.issuelists')
            ->with('issuelists', $issuelists);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIssueTable(Request $request)
    {
        $issuelists = Issuelist::whereIn('id', $request->input('issuelists', []))
            ->with('issues')
            ->get();
        return view('push.table')
            ->with('issuelists', $issuelists);
    }



    public function post(Request $request)
    {
        $this->validate($request,
            [
                'project'  => ['required'],
                'reporter' => ['required'],
            ]
        );

        $project  = JiraService::getProject($request->input('project'));
        $reporter = JiraService::getUser($request->input('reporter'));

        foreach ($request->get('enabled_issuelist') as $il_id => $details) {
            $issuelist = Issuelist::findOrFail($il_id);

            $issues = collect($details['issues']);
            $issues_enabled = $issues->filter(function ($issue) {
                return (bool) $issue['enabled'];
            });
            if ($issues_enabled->count() === 0) {
                continue;
            }

            $epic_key = JiraService::addIssueToProject(
                $project->key,
                'Epic',
                null,
                $reporter->accountId,
                null,
                $issuelist->name,
                null,
                null,
                []
            );

            foreach ($issues_enabled as $issue_id => $issue_details) {
                $issue = App\Issue::findOrFail($issue_id);
                $attachments = $issue->getMedia('attachments')
                    ->map(function ($media) {
                        return $media->getPath();
                    })
                    ->toArray();

                if (!is_null($issue->default_project) && $issue->default_project != $project->key) {
                    $parent_key = null;
                } else {
                    $parent_key = $epic_key;
                }

                JiraService::addIssueToProject(
                    $issue->default_project ?? $project->key,
                    'Task',
                    $parent_key,
                    $issue->default_reporter ?? $reporter->accountId,
                    null,
                    $issue->name,
                    $issue->description,
                    $issue_details['original_estimate'],
                    $attachments
                );
            }

            foreach ($issuelist->emails as $email) {
                Mail::to($email->default_recipient)
                    ->send(new IssueListEmail($email));
            }
        }

        $request->session()->flash('successmessage', __('Issuelists pushed'));

        return redirect()->route('issuelists.index');
    }
}
