<?php
/**
 * Created by PhpStorm.
 * User: skylight
 * Date: 27.10.18
 * Time: 16:26
 */

namespace App\Traits;

use App\Prize;

trait PrizeRelation
{
    /**
     * Set relation between Prize class
     *
     * @return mixed
     */
    public function prize()
    {
        return $this->morphOne( Prize::class , 'cast' );
    }
}
