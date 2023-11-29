<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(User $user)
    {
        $wallets = $user->wallets()->paginate(100);
        $total_amount = 0;
        foreach ($wallets as $wallet) {
            $amount = $wallet->amount;
            if ($wallet->type == 'positive') {
                $total_amount = $total_amount + $amount;
            } else {
                $total_amount = $total_amount - $amount;
            }
        }
        return view('admin.wallets.index', compact('wallets', 'user', 'total_amount'));
    }

    public function wallet_change(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $type = $request->type;
            $amount = $request->amount;
            $description =$request->description;
            $status = 'change by admin';
            wallet::create([
                'user_id' => $user_id,
                'type' => $type,
                'amount' => $amount,
                'status' => $status,
                'description' => $description,
            ]);
            session()->flash('success', 'wallet change successfully');
            return response()->json([1]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            session()->flash('error', $e->getMessage());
            return response()->json([1]);
        }
    }
}
