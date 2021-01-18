<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Email
 *
 * @property int $id
 * @property int $issuelist_id
 * @property string|null $default_recipient
 * @property string $subject
 * @property string $body
 * @property int $sortorder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Issuelist $issuelist
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereDefaultRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereIssuelistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereSortorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Email whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Email extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasMediaTrait;

    public $sortable = [
        'order_column_name'  => 'sortorder',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('issuelist_id', $this->issuelist_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issuelist()
    {
        return $this->belongsTo(Issuelist::class);
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections()
    {
        $this->addMediaCollection('attachments');
    }
}
