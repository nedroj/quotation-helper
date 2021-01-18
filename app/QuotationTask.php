<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\QuotationTask
 *
 * @property int $id
 * @property int $epic_id
 * @property int $quotation_id
 * @property string $title
 * @property string $description
 * @property float $base_min_estimate
 * @property float $base_max_estimate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Quotation $quotations
 * @property-read \App\QuotationEpic $quotationEpic
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationEstimate[] $quotationEstimates
 * @property-read int|null $quotation_estimates_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationTask onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereBaseMaxEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereBaseMinEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereEpicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereQuotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationTask withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationTask withoutTrashed()
 * @mixin \Eloquent
 */
class QuotationTask extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title', 'description', 'epic_id', 'quotation_id'
    ];

    public function quotationEpic(){
        return $this->belongsTo(QuotationEpic::class, 'epic_id','id');
    }

    public function quotationEstimates(){
        return $this->hasMany(QuotationEstimates::class, 'quotation_task_id','id');
    }

    public function quotation(){
        return $this->belongsTo(Quotation::class);
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
