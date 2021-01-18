<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Issuelist
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Email[] $emails
 * @property-read int|null $emails_count
 * @property mixed $tag_names
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tagged[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Issue[] $issues
 * @property-read int|null $issues_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Conner\Tagging\Model\Tagged[] $tagged
 * @property-read int|null $tagged_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist withAllTags($tagNames)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist withAnyTag($tagNames)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issuelist withoutTags($tagNames)
 * @mixin \Eloquent
 */
class Issuelist extends Model
{
    use \Conner\Tagging\Taggable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
