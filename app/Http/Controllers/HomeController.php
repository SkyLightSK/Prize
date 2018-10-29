<?php

namespace App\Http\Controllers;

use App\Gift;
use App\GiftItem;
use App\Money;
use App\Point;
use App\Prize;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Creating random Prize for User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function prize( Request $request )
    {
        $user = User::findOrFail($request->user);

        $prize = new Prize([
            'user_id' => $user->id,
        ]);
        $prize->save();

        $type = $user->availableRandomPrize();

        switch ($type) {

            case Money::class :

                $money = new Money([
                    'user_id' => $user->id,
                    'prize_id' => $prize->id,
                    'value' => rand(1, Money::MONEY_MAX - $user->totalMoney())
                ]);
                $money->save();
                $prize->update(["cast_id" => $money->id, "cast_type" => $type ]);

                return response()->json(array(
                    'prize_type'    => $type,
                    'prize_id'      => $prize->id,
                    'value'         => $money->value,
                    'total'         => $user->totalMoney()
                ), 200);
                break;

            case Point::class:

                $points = new Point([
                    'user_id' => $user->id,
                    'prize_id' => $prize->id,
                    'value' => rand(1, Point::POINT_MAX)
                ]);
                $points->save();
                $prize->update(["cast_id" => $points->id, "cast_type" => $type ]);

                return response()->json(array(
                    'prize_type'    => $type,
                    'prize_id'      => $prize->id,
                    'value'         => $points->value,
                    'total'         => $user->totalPoints()
                ), 200);
                break;

            case Gift::class:

                $gift = new Gift([
                    'user_id' => $user->id,
                    'prize_id' => $prize->id,
                    'value' => GiftItem::count() ? GiftItem::inRandomOrder()->first()->name : "Coffee"
                ]);
                $gift->save();
                $prize->update(["cast_id" => $gift->id, "cast_type" => $type ]);

                return response()->json(array(
                    'prize_type'    => $type,
                    'prize_id'      => $prize->id,
                    'value'         => $gift->value,
                    'total'         => $user->totalGifts()
                ), 200);
                break;

        }

    }

    /**
     * Refuses given prize
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refuse( Request $request )
    {
        $user = User::findOrFail($request->user);

        Prize::find($request->prize_id )->deleteWithCast();

        return response()->json(array(
            'total_money' => $user->totalMoney(),
            'total_points' => $user->totalPoints(),
            'total_gifts' => $user->totalGifts(),
        ), 200);
    }

    /**
     * Convert money to points
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function convert( Request $request )
    {
        $user = User::findOrFail($request->user);

        $user->convert();

        return response()->json(array(
            'total_money' => $user->totalMoney(),
            'total_points' => $user->totalPoints(),
            'total_gifts' => $user->totalGifts(),
        ), 200);
    }
}
