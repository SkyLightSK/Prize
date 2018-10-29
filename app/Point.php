<?php

namespace App;

use App\Traits\PrizeRelation;
use App\Traits\UserRelation;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use PrizeRelation,UserRelation;

    /**
     * Maximum points constant
     */
    const POINT_MAX = 5000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id' , 'prize_id', 'value'
    ];

}
