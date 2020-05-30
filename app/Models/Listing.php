<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Listing
 * @package App\Models
 * @method static Builder unread
 * @property-read int id
 */
class Listing extends Model
{
    protected $fillable = [
        'query_id',
        'listing_id',
        'title',
        'price',
        'condition',
        'thumbnail',
        'url',
        'read_at'
    ];

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeUnread(Builder $builder)
    {
        return $builder->whereNull('read_at');
    }

    public function markAsRead()
    {
        $this->read_at = Carbon::now();
    }

}
