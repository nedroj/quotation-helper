<?php


namespace App\Http\Controllers;

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\TaskEstimate
 *
 * @property int $id
 * @property int $task_id
 * @property int $department_id
 * @property int $min_estimate
 * @property int $max_estimate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Department $department
 * @property-read \App\Task $task
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\TaskEstimate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereMaxEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereMinEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TaskEstimate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TaskEstimate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\TaskEstimate withoutTrashed()
 * @mixin \Eloquent
 */
class TaskEstimate extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'task_id', 'min_estimate', 'max_estimate', 'department_id'
    ];

    protected $appends = [
        'new_min_estimate',
        'new_max_estimate',
        'comment'
    ];

    public function getNewMinEstimateAttribute()
    {
        return '0m';
    }

    public function getNewMaxEstimateAttribute()
    {
        return '0m';
    }

    public function getCommentAttribute(){
        return '';
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
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
