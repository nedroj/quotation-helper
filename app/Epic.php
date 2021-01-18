<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use function GuzzleHttp\Promise\task;

/**
 * App\Epic
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Epic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Epic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Epic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Epic withoutTrashed()
 * @mixin \Eloquent
 */
class Epic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description'
    ];

    public function tasks(){
        return $this->hasMany(Task::class,'epic_id' , 'id');
    }

    /**
     * @inheritDoc
     */
    public function setHighestOrderNumber()
    {
        // TODO: Implement setHighestOrderNumber() method.
    }

    /**
     * @inheritDoc
     */
    public function scopeOrdered(Builder $query)
    {
        // TODO: Implement scopeOrdered() method.
    }

    /**
     * @inheritDoc
     */
    public static function setNewOrder($ids, int $startOrder = 1)
    {
        // TODO: Implement setNewOrder() method.
    }

    /**
     * @inheritDoc
     */
    public function shouldSortWhenCreating(): bool
    {
        // TODO: Implement shouldSortWhenCreating() method.
    }
}
