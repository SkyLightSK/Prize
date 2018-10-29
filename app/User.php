<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set the prizes relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prizes()
    {
        return $this->hasMany('App\Prize');
    }

    /**
     * Get the gifts relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gifts()
    {
        return $this->hasMany('App\Gift');
    }

    /**
     * Get the money relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function money()
    {
        return $this->hasMany('App\Money');
    }

    /**
     * Get the points relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany('App\Points');
    }

    /**
     * Sum of active user money
     *
     * @return int
     */
    public function totalMoney() : int
    {
        return Money::where(["user_id" => $this->id, "active" => true ])->sum('value');
    }

    /**
     * Total of user points
     *
     * @return int
     */
    public function totalPoints() : int
    {
        return Point::where("user_id", $this->id )->sum('value');
    }


    /**
     * Total of user gifts
     *
     * @return int
     */
    public function totalGifts() : int
    {
        return Gift::where("user_id", $this->id )->count();
    }


    /**
     * Return available random Prize type Class
     *
     * @return mixed
     */
    public function availableRandomPrize()
    {
        $prize_list = [ Point::class ];
        if( $this->totalMoney() < Money::MONEY_MAX) $prize_list[] = Money::class;
        if( $this->totalGifts() < Gift::MAX_GIFT_ITEMS) $prize_list[] = Gift::class;

        return $prize_list[array_rand( $prize_list , 1)];
    }

    /**
     * Convert all available user money to points by
     * money/point coefficient
     *
     * @return int
     */
    public function convert()
    {
        $points = new Point([
            "user_id" => $this->id,
            "value" => $this->totalMoney() * Money::MONEY_TO_POINT_COF
        ]);
        $points->save();

        return $this->money()->update(["active" => false]);
    }


}
