<?php

namespace App;

use App\Traits\PrizeRelation;
use App\Traits\UserRelation;
use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    use PrizeRelation,UserRelation;

    /**
     * Maximum of money constant
     */
    const MONEY_MAX = 5000;

    /**
     * Money/Points coefficient
     */
    const MONEY_TO_POINT_COF = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'prize_id', 'value', 'active'
    ];

}
