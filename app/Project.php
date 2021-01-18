<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\Project
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ProjectQuotation[] $projectQuotations
 * @property-read int|null $project_quotations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Project onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Project withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Project withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereTitle($value)
 */
class Project extends Model implements Sortable
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'title'
    ];

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
