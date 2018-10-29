<?php

namespace App;

use App\Traits\PrizeRelation;
use App\Traits\UserRelation;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use PrizeRelation,UserRelation;

    /**
     * Maximum gift items
     */
    const MAX_GIFT_ITEMS = 25;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'prize_id', 'value'
    ];

}
