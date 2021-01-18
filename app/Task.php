<?php


namespace App\Http\Controllers;

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
//use Spatie\Searchable\Searchable;
//use Spatie\Searchable\SearchResult;


/**
 * App\Task
 *
 * @property int $id
 * @property int $epic_id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Epic $epic
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TaskEstimate[] $taskEstimates
 * @property-read int|null $task_estimates_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Task onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereEpicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
      'title', 'description', 'epic_id'
    ];

    public function epic(){
        return $this->belongsTo(Epic::class);
    }

    public function taskEstimates(){
        return $this->hasMany(TaskEstimate::class, 'task_id', 'id');
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
