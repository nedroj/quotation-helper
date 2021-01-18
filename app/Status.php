<?php


namespace App;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * App\status
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Quotation[] $quotations
 * @property-read int|null $quotations_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\status newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\status onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\status ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\status query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\status withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\status withoutTrashed()
 * @mixin \Eloquent
 */
class Status extends Model implements Sortable
{
    protected $table = 'status';
    use SoftDeletes;

    protected $fillable = [
        'id', 'title'
    ];

    public function quotations(){
        return $this->hasMany(Quotation::class);
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
