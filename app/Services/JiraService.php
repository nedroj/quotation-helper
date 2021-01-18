<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Str;

use JiraRestApi\Issue\Issue;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Reporter;
use JiraRestApi\Issue\TimeTracking;
use JiraRestApi\JiraException;
use JiraRestApi\Project\ProjectService;
use JiraRestApi\User\UserService;

use function collect;
use function dd;
use function is_null;

class JiraService
{
    /**
     * @return \Illuminate\Support\Collection
     * @throws JiraException
     */
    public static function getProjects()
    {
        return Cache::remember('jira_projects', 5, function () {
            $result = collect([]);

            $projectService = new ProjectService();

            $projects = $projectService->getAllProjects();

            foreach ($projects as $project) {
                $result->put($project->id, ['key' => $project->key, 'name' => $project->name]);
            }

            return $result;
        });
    }

    /**
     * @param $id
     *
     * @return \JiraRestApi\Project\Project|object
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public static function getProject($id)
    {
        $projectService = new ProjectService();
        $project = $projectService->get($id);

        return $project;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public static function getUsers()
    {
        return Cache::remember('jira_users', 5, function () {
            $result = collect([]);

            $userService = new UserService();
            $paramArray  = [
                'username'   => '', // get all users.
                'startAt'    => 0,
                'maxResults' => 1000,
            ];
            $users       = $userService->findUsers($paramArray);

            $users = collect($users)
                ->filter(function ($user) {
                    return Str::contains($user->emailAddress, 'doitonlinemedia.nl') && $user->accountType === 'atlassian';
                });
            foreach ($users as $user) {
                $result->put($user->accountId, (array)$user);
            }

            return $result;
        });
    }

    /**
     * @param $id
     *
     * @return \JiraRestApi\User\User|object
     * @throws JiraException
     * @throws \JsonMapper_Exception
     */
    public static function getUser($id)
    {
        $userService = new UserService();
        return $userService->get(['accountId' => $id]);
    }


    /**
     * @param string      $project_key
     * @param string       $issueType
     * @param string|null $parent_key
     * @param null        $reporter_id
     * @param null        $assignee_id
     * @param string      $summary
     * @param string      $description
     * @param float       $original_estimate
     * @param array       $attachments
     *
     * @return mixed
     * @throws \Atlassian\JiraRest\Exceptions\JiraClientException
     * @throws \Atlassian\JiraRest\Exceptions\JiraNotFoundException
     * @throws \Atlassian\JiraRest\Exceptions\JiraUnauthorizedException
     */
    public static function addIssueToProject(
        string $project_key,
        $issueType,
        ?string $parent_key = null,
        ?string $reporter_id = null,
        ?string $assignee_id = null,
        string $summary,
        ?string $description = null,
        ?float $original_estimate = null,
        array $attachments = [])
    {
        $issueService = new IssueService();

        $issueField = new IssueField();
        $issueField->setProjectKey($project_key)
            ->setSummary($summary)
            ->setDescription($description)
            ->setIssueType($issueType);

        if ($issueType === 'Epic') {
            // Custom field "Epic name"
            $issueField->addCustomField('customfield_10005', $summary);
        } else {
//            $issueField->setParentKeyOrId($parent_key);
            $issueField->addCustomField('customfield_10008', $parent_key);

        }

        if ($reporter_id) {
            $issueField->setReporterAccountId($reporter_id);
        }

        if ($assignee_id) {
            $issueField->setAssigneeAccountId($assignee_id);
        }

        /** @var Issue $issue */
        $issue = $issueService->create($issueField);

        $atIssueService = new IssueService();
        $atIssueService->addAttachments($issue->key, $attachments);

        if ($original_estimate) {
            $timeTracking = new TimeTracking();
            $timeTracking->setOriginalEstimate($original_estimate . 'm');
            $issueService->timeTracking($issue->key, $timeTracking);
        }

        return $issue->key;
    }
}
