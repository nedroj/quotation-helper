<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\ProjectQuotation
 *
 * @property int $id
 * @property int $project_id
 * @property int $quotation_id
 * @property string $round
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\QuotationEstimate[] $quotationEstimates
 * @property-read int|null $quotation_estimates_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ProjectQuotation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereQuotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereRound($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ProjectQuotation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ProjectQuotation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ProjectQuotation withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Quotation $quotations
 */
class ProjectQuotation extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'project_id', 'quotation_id', 'round'
    ];

    public function quotationEstimates(){
        return $this->hasMany(QuotationEstimates::class);
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
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
