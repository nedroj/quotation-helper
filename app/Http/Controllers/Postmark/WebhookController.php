<?php

namespace App\Http\Controllers\Postmark;

use App\EmailBounce;
use App\Http\Controllers\Controller;
use App\Notifications\EmailBounced;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use function json_decode;

class WebhookController extends Controller
{
    public function bounce(Request $request)
    {
        $content = json_decode($request->getContent());

        $bounce = new EmailBounce();
        $bounce->type = $content->Type;
        $bounce->name = $content->Name;
        $bounce->tag = $content->Tag ?? '';
        $bounce->message_id = $content->MessageID;
        $bounce->server_id = $content->ServerID;
        $bounce->description = $content->Description;
        $bounce->details = $content->Details;
        $bounce->address_to = $content->Email;
        $bounce->address_from = $content->From;
        $bounce->subject = $content->Subject;
        $bounce->bounced_at = Carbon::parse($content->BouncedAt)->toDateTimeString();
        $bounce->save();

        $notification = new EmailBounced($bounce);

        User::query()
            ->whereIn('email', config('postmark.bounce_notification_emails'))
            ->get()
            ->each(function ($user) use ($notification) {
                $user->notify($notification);
            });

    }
}
