<?php

namespace App;

use App\Traits\PrizeTypeRelation;
use App\Traits\UserRelation;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use UserRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cast_id', 'cast_type'
    ];

    /**
     * Get the prizes of the user.
     *
     * @return mixed
     */
    public function cast()
    {
        return $this->morphTo();
    }

    /**
     * Remove Prize and Cast relation.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function deleteWithCast()
    {
        $this->cast()->delete();
        return $this->delete();
    }


}
