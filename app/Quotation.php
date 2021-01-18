<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\Quotation
 *
 * @property int $id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationTask[] $quotationTasks
 * @property-read int|null $quotation_tasks_count
 * @property-read \App\status $stat
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Quotation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Quotation withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProjectQuotation[] $projectQuotations
 * @property-read int|null $project_quotations_count
 */
class Quotation extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'statis_id'
    ];

    public function quotationTasks(){
        return $this->hasMany(QuotationTask::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function projectQuotations(){
        return $this->hasMany(ProjectQuotation::class);
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
