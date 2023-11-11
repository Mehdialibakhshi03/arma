<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormValue;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketController extends Controller
{
    public function index($status)
    {
        $stts = $status == 'open' ? 1 : 0;
        $markets = Market::orderby('priority', 'asc')->where('status', $stts)->paginate(20);
        return view('admin.markets.index', compact('markets', 'status'));
    }

    public function create($status)
    {
        $form_values = FormValue::where('status',1)->where('show_in_market', 1)->get();
        return view('admin.markets.create', compact('status', 'form_values'));
    }

    public function store($status, Request $request)
    {
        $stts = $status == 'open' ? 1 : 0;
        $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        try {
            DB::beginTransaction();
            $market = Market::create([
                'status' => $stts,
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start,
                'end' => $request->end,
            ]);
            //category_product
            $FormValues = $request->form_id;
            if (!empty($FormValues)) {
                foreach ($FormValues as $FormValue) {
                    $market->FormValues()->attach($FormValue);
                }
            }
            DB::commit();
            session()->flash('success', 'The Item Has Been Created Successfully');
            return redirect()->route('admin.markets.index', ['status' => $status]);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
        }

    }

    public function edit($status,Market $market)
    {
        $form_values = FormValue::where('status',1)->where('show_in_market', 1)->get();
        return view('admin.markets.edit', compact('status', 'form_values','status','market'));
    }

    public function update($status,Market $market,Request $request)
    {
        $stts = $status == 'open' ? 1 : 0;
        $request->validate([
            'title' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);
        try {
            $market->update([
                'status' => $stts,
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start,
                'end' => $request->end,
            ]);
            //category_product
            $market->FormValues()->detach();
            if ($request->has('form_id')){
                $FormValues = $request->form_id;
                if (!empty($FormValues)) {
                    foreach ($FormValues as $FormValue) {
                        $market->FormValues()->attach($FormValue);
                    }
                }
            }

            session()->flash('success', 'The Item Has Been Created Successfully');
            return redirect()->route('admin.markets.index', ['status' => $status]);
        } catch (\Exception $exception) {
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
        }

    }

    public function remove(Request $request)
    {
        try {
            $item = Market::findOrFail($request->id);
            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            session()->flash('success', $message);
            $type = 1;
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
            $type = 0;
        }
        $alert = view('admin.sections.alert')->render();
        return response()->json([$type, $alert]);
    }
}
