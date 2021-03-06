<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Article
 *
 * @property int $id
 * @property int $categorie_id
 * @property int $manufacturer_id
 * @property string $name
 * @property float $price
 * @property string $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Categorie $categorie
 * @property-read mixed $status_badge
 * @property-read \App\Manufacturer $manufacturer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use LogsActivity;

    protected static $logName = 'article';

    protected static $logFillable = true;

    protected static $logOnlyDirty = true;

    protected $fillable = ['categorie_id', 'manufacturer_id', 'name', 'price', 'description', 'status'];

    public function categorie() {
        return $this->belongsTo('App\Categorie');
    }

    public function manufacturer() {
        return $this->belongsTo('App\Manufacturer');
    }

    public function tags() {
        return $this->morphToMany('App\Tag', 'tagable');
    }

    public function tarifs() {
        return $this->belongsToMany('App\Tarif')->withPivot('status', 'price');
    }

    public function images() {
        return $this->morphMany('App\Image', 'imageable');
    }

    /**
     * @param $count
     * @param $dimension
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function imageCountDimension($count, $dimension) {
        $img = $this->morphMany('App\Image', 'imageable')
            ->where([
                ['count', '=', $count],
                ['dimension', '=', $dimension],
            ])->get();

        $url = '';
        foreach($img as $item) {
            $url = $item->url;
        }
        return $url;
    }

    public function getStatusBadgeAttribute() {

        $status = [
            '0' => 'Inactive',
            '1' => 'Active',
        ];

        $state = ($this->attributes['status']) ? 'badge-success' : 'badge-danger';

        $html = '<div class="badge ' . $state . '">' . $status[$this->attributes['status']] . '</div>';

        return $html;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query) {
        return $query->where('status', '=', 1);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $query) {
        return $query->where('status', '=', 0);
    }
}
