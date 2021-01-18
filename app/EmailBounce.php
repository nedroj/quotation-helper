<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Postmark\PostmarkAdminClient;
use Postmark\PostmarkClient;
use function cache;
use function config;

/**
 * \App\EmailBounce
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $tag
 * @property string $message_id
 * @property int $server_id
 * @property string $description
 * @property string $details
 * @property string $address_to
 * @property string $address_from
 * @property string $subject
 * @property string $bounced_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereAddressFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereAddressTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereBouncedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EmailBounce whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $postmark_url
 * @property-read mixed $server
 */
class EmailBounce extends Model
{
    protected $dates = [
        'bounced_at',
    ];

    public function getPostmarkUrlAttribute()
    {
        return 'https://account.postmarkapp.com/servers/' . $this->server_id . '/streams/outbound/messages/' . $this->message_id;
    }

    public function getServerAttribute()
    {
        return cache()->remember('postmark-server-'.$this->server_id, Carbon::now()->addHours(4), function () {
            $postmark = new PostmarkAdminClient(config('postmark.account_token'));
            return $postmark->getServer($this->server_id);
        });
    }

    public static function getWebhooks($serverToken)
    {
        $client = new PostmarkClient($serverToken);
        return $client->getWebhookConfigurations();
    }
}
