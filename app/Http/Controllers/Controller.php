<?php

namespace App\Http\Controllers;

use App\Models\MarketSetting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function statusTimeMarket($market)
    {

        $ready_to_duration = MarketSetting::where('key', 'ready_to_open')->pluck('value')->first();
        $open_duration = MarketSetting::where('key', 'opening')->pluck('value')->first();
        $q_1 = MarketSetting::where('key', 'q_1')->pluck('value')->first();
        $q_2 = MarketSetting::where('key', 'q_2')->pluck('value')->first();
        $q_3 = MarketSetting::where('key', 'q_3')->pluck('value')->first();
        $endMinutes = $open_duration + $q_1 + $q_2 + $q_3 + 3;
        $date = $market->date;
        $time = $market->time;
        $date_time = $date.' '.$time;

        $startTime = Carbon::parse($date_time);

        $now = Carbon::now();
        $benchmark1 = $startTime->copy()->addMinutes(-$ready_to_duration);
        $benchmark2 = $startTime;
        $benchmark3 = $startTime->copy()->addMinutes($open_duration);
        $benchmark4 = $benchmark3->copy()->addMinutes($q_1);
        $benchmark5 = $benchmark4->copy()->addMinutes($q_2);
        $benchmark6 = $benchmark5->copy()->addMinutes($q_3);

        $bids = $market->Bids;
        if ($market->status == 7) {
            return [0, $market->status, $benchmark1, $benchmark2, $benchmark3, $benchmark4, $benchmark5, $benchmark6,$date_time];
        }

        if ($now < $benchmark1) {
            //normal show time
            $status = 1;
            $difference = $benchmark1->diffInSeconds($now);

        } elseif ($benchmark1 < $now and $now < $benchmark2) {
            //ready to open
            $status = 2;
            $difference = $benchmark2->diffInSeconds($now);

        } elseif ($benchmark2 < $now and $now < $benchmark3) {
            //open
            $status = 3;
            $difference = $benchmark3->diffInSeconds($now);

        } elseif ($benchmark3 < $now and $now < $benchmark4) {
            //open(1/3)
            $status = 4;
            $difference = $benchmark4->diffInSeconds($now);
            //if no bid received market must be closed!
            if (count($bids) == 0) {
                $status = 7;
                $difference = 0;
            }
            //exists min-price
//            $bid_touch_price = $market->Bids()->where('price', '>=', $market->min_price)->exists();
            $bid_touch_price=true;
            if (!$bid_touch_price) {
                $status = 7;
                $difference = 0;
            }

        } elseif ($benchmark4 < $now and $now < $benchmark5) {
            //open(2/3)
            $status = 5;
            $difference = $benchmark5->diffInSeconds($now);

        } elseif ($benchmark5 < $now and $now < $benchmark6) {
            //open(3/3)
            $difference = $benchmark6->diffInSeconds($now);
            $status = 6;
            //check if total quality < $market->quantity
            $bids_quantity = $market->Bids()->sum('quantity');
            $market_quantity = $market->quantity;

            if ($bids_quantity <= $market_quantity) {
                $status = 7;
                $difference = 0;
            }

        } else {
            //close
            $difference = 0;
            $status = 7;

        }
        $market->update(['status' => $status]);
        return [$difference, $status, $benchmark1, $benchmark2, $benchmark3, $benchmark4, $benchmark5, $benchmark6,$date_time];
    }

    public function convertTime($seconds)
    {
        $remaining = $seconds % 60;
        $minutes = ($seconds - $remaining) / 60;
        if ($remaining < 10) {
            $remaining = '0' . $remaining;
        }
        return $minutes . ':' . $remaining;
    }

}
