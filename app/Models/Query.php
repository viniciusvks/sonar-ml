<?php

namespace App\Models;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Query
 * @package App\Models
 * @property string search_key
 * @property-read int id
 */
class Query extends Model
{
    protected $fillable = [
        'search_key'
    ];

    public function listings() : HasMany
    {
        return $this->hasMany(Listing::class);
    }

}
