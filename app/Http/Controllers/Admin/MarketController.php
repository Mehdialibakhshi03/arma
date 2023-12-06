<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormValuesDataTable;
use App\Http\Controllers\Controller;
use App\Models\FormValue;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\User;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::orderBy('start', 'desc')->paginate(100);
        return view('admin.markets.index', compact('markets'));
    }

    public function edit(Market $market)
    {
        return view('admin.markets.edit', compact('market'));
    }
    public function bids(Market $market)
    {
        $bids=$market->Bids;
        return view('admin.markets.bids', compact('market','bids'));
    }

    public function update(Market $market, Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'min_price' => 'required|numeric',
            'min_wallet' => 'required|numeric',
            'min_quantity' => 'required|numeric',
        ]);
        $request['status']=7;
        if (Carbon::now() < $request->start){
            $request['status']=1;
        }
            $market->update($request->all());
        return redirect()->route('admin.markets.index')->with('success', 'Market updated successfully');
    }

    public function setting_index()
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->first()->value;
        $open_duration = MarketSetting::where('key', 'open_duration')->first()->value;
        $q_1 = MarketSetting::where('key', 'q_1')->first()->value;
        $q_2 = MarketSetting::where('key', 'q_2')->first()->value;
        $q_3 = MarketSetting::where('key', 'q_3')->first()->value;
        return view('admin.markets.settings', compact('ready_to_duration', 'open_duration', 'q_1', 'q_2', 'q_3'));
    }

    public function setting_update(Request $request)
    {
        $request->validate([
            'ready_to_duration' => 'required',
            'open_duration' => 'required',
            'q_1' => 'required',
            'q_2' => 'required',
            'q_3' => 'required',
        ]);
        $array = [
            'ready_to_duration' => $request->ready_to_duration,
            'open_duration' => $request->open_duration,
            'q_1' => $request->q_1,
            'q_2' => $request->q_2,
            'q_3' => $request->q_3,
        ];
        foreach ($array as $key => $value) {
            MarketSetting::where('key', $key)->update(['value' => $value]);
        }
        return redirect()->route('admin.market.setting.index')->with('success', 'Settings updated successfully');
    }
}
