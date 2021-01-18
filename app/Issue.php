<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * \App\Issue
 *
 * @property int $id
 * @property int $issuelist_id
 * @property string|null $default_project
 * @property string|null $default_reporter
 * @property string|null $default_assignee
 * @property string $name
 * @property string $description
 * @property int|null $original_estimate
 * @property int|null $sortorder
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Issuelist $issuelist
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereDefaultAssignee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereDefaultProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereDefaultReporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereIssuelistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereOriginalEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereSortorder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Issue extends Model implements Sortable, HasMedia
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
