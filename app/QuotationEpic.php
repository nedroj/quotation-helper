<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\QuotationEpic
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationTask[] $quotationTasks
 * @property-read int|null $quotation_tasks_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEpic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEpic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEpic withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEpic withoutTrashed()
 * @mixin \Eloquent
 */
class QuotationEpic extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title', 'description'
    ];

    public function quotationTasks()
    {
        return $this->hasMany(QuotationTask::class, 'epic_id', 'id');
    }

    public function setHighestOrderNumber()
    {
        // TODO: Implement setHighestOrderNumber() method.
    }

    public function scopeOrdered(Builder $query)
    {
        // TODO: Implement scopeOrdered() method.
    }

    public static function setNewOrder($ids, int $startOrder = 1)
    {
        // TODO: Implement setNewOrder() method.
    }

    public function shouldSortWhenCreating(): bool
    {
        // TODO: Implement shouldSortWhenCreating() method.
    }
}
