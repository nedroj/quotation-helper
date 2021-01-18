<?php

namespace App\Http\Controllers\Postmark;

use App\EmailBounce;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Postmark\Models\Webhooks\WebhookConfigurationBounceTrigger;
use Postmark\Models\Webhooks\WebhookConfigurationTriggers;
use Postmark\PostmarkAdminClient;
use Postmark\PostmarkClient;
use function cache;
use function config;
use function redirect;

/**
 * Class EmailController
 * @package App\Http\Controllers\Postmark
 */
class EmailController extends Controller
{
    /**
     * Show a list of all bounces
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bounces = EmailBounce::all();

        return view('bounces.overview', [
            'bounces' => $bounces,
        ]);
    }

    /**
     * Show the details of a bounced message
     * @param EmailBounce $bounce
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message(EmailBounce $bounce)
    {
        return view('bounces.show', [
            'bounce' => $bounce,
        ]);
    }

    /**
     * Show and cache the list of postmark servers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function serverlist()
    {
        $servers = cache()->remember('email-serverlist', Carbon::now()->addHours(1), function () {
            $client = new PostmarkAdminClient(config('postmark.account_token'));
            return $client->listServers()->servers;
        });

        return view('bounces.serverlist', [
            'servers' => $servers,
        ]);
    }

    /**
     * Add a bounce webhook to the chosen server
     * @param $servertoken
     * @param $serverid
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function addWebhook($servertoken, $serverid)
    {
        $client = new PostmarkClient($servertoken);
        $bounceTrigger = new WebhookConfigurationBounceTrigger(true, true);
        $triggers = new WebhookConfigurationTriggers(null, null, null, $bounceTrigger, null);

        $url = route('webhook.bounce');
        $client->createWebhookConfiguration($url, null, null, null, $triggers);

        $guzzle = new Client();
        $guzzle->request('PUT', 'https://api.postmarkapp.com/servers/' . $serverid, [
            'headers' => [
                'X-Postmark-Account-Token' => config('postmark.account_token'),
            ],
            'json' => [
                'EnableSmtpApiErrorHooks' => true,
            ],
        ]);

        cache()->forget('email-serverlist');

        return redirect()->route('email.servers');
    }

    /**
     * Remove all webhooks from a server
     * @param $servertoken
     * @param $webhookid
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteWebhook($servertoken, $webhookid)
    {
        $client = new PostmarkClient($servertoken);
        $client->deleteWebhookConfiguration($webhookid);

        cache()->forget('email-serverlist');

        return redirect()->route('email.servers');
    }
}
