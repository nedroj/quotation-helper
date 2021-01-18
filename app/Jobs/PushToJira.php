<?php

namespace App\Jobs;

use App\Issuelist;
use App\Mail\IssueListEmail;
use App\Services\JiraService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PushToJira implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $issuelist;
    public $description;
    public $project;
    public $report;
    public $reporter;
    public $assignee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Issuelist $issuelist, string $description, string $project, string $reporter, string $assignee)
    {
        $this->issuelist   = $issuelist;
        $this->description = $description;
        $this->project     = JiraService::getProject($project);
        $this->reporter    = JiraService::getUser($reporter);
        $this->assignee    = JiraService::getUser($assignee);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->issuelist->issues->count() > 0) {
            $parent_key = JiraService::addIssueToProject(
                $this->project->key,
                'Epic',
                null,
                $this->reporter->accountId,
                $this->assignee->accountId,
                $this->issuelist->name,
                $this->description,
                null,
                []
            );

            foreach ($this->issuelist->issues as $issue) {
                $attachments = $issue->getMedia('attachments')
                    ->map(function ($media) {
                        return $media->getPath();
                    })
                    ->toArray();

                if ($issue->default_project != $this->project->key) {
                    $issueType  = 'Task';
                    $parent_key = null;
                } else {
                    $issueType = 'Sub-task';
                }

                JiraService::addIssueToProject(
                    $issue->default_project ?? $this->project->key,
                    $issueType,
                    $parent_key,
                    $issue->default_reporter ?? $this->reporter->accountId,
                    $issue->default_assignee ?? $this->assignee->accountId,
                    $issue->name,
                    $issue->description,
                    $issue->original_estimate,
                    $attachments
                );
            }
        }

        foreach ($this->issuelist->emails as $email) {
            Mail::to($email->default_recipient ?? $this->assignee->emailAddress)
                ->send(new IssueListEmail($email));
        }
    }
}
