<?php
/**
 * Created by PhpStorm.
 * User: skylight
 * Date: 29.10.18
 * Time: 14:43
 */

namespace App\Traits;


trait UserRelation
{
    /**
     * Get the user owner .
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo( 'App\User' );
    }
}
