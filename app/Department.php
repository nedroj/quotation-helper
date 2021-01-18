<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * App\Department
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationEstimate[] $quotationEstimates
 * @property-read int|null $quotation_estimates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationTask[] $quotationTasks
 * @property-read int|null $quotation_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TaskEstimate[] $taskEstimates
 * @property-read int|null $task_estimates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $tasks
 * @property-read int|null $tasks_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Department onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Department withoutTrashed()
 * @mixin \Eloquent
 */
class Department extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function taskEstimates()
    {
        return $this->hasMany(TaskEstimate::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)
            ->using(TaskEstimate::class)
            ->as('taskEstimate')
            ->withPivot(['min_estimate', 'max_estimate']);
    }

    public function quotationEstimates()
    {
        return $this->hasMany(QuotationEstimates::class);
    }

    public function quotationTasks()
    {
        return $this->belongsToMany(QuotationTask::class)
            ->using(QuotationEstimates::class)
            ->as('quotationEstimate')
            ->withPivot(['min_estimate', 'max_estimate', 'comment']);
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
    public function scopeOrdered(\Illuminate\Database\Eloquent\Builder $query)
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
