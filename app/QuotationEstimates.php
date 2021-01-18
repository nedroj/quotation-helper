<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\QuotationEstimates
 *
 * @property int $id
 * @property int $quotation_task_id
 * @property int $min_estimate
 * @property int $max_estimate
 * @property int $project_quotation_id
 * @property string $comment
 * @property int $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $base_min_estimate
 * @property int $base_max_estimate
 * @property-read \App\Department $department
 * @property-read \App\ProjectQuotation $projectQuotation
 * @property-read \App\QuotationTask $quotationTask
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEstimates onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereBaseMaxEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereBaseMinEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereMaxEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereMinEstimate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereProjectQuotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereQuotationTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\QuotationEstimates whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEstimates withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\QuotationEstimates withoutTrashed()
 * @mixin \Eloquent
 */
class QuotationEstimates extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'quotation_task_id', 'min_estimate', 'max_estimate', 'project_quotation_id', 'comment', 'department_id' , 'base_min_estimate', 'base_max_estimate'
    ];

    public function quotationTask(){
        return $this->belongsTo(QuotationTask::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function projectQuotation(){
        return $this->belongsTo(ProjectQuotation::class);
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
