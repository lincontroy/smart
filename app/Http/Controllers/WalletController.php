<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Update user's wallet balance via AJAX
     */
    public function updateBalance(Request $request)
    {
        try {
            $request->validate([
                'balance' => 'required|numeric|min:0'
            ]);

            $user = Auth::user();
            
            // Update the user's wallet balance
            $user->wallet_balance = $request->balance;
            $user->save();

            // Optional: Log the transaction for audit purposes
            // DB::table('wallet_transactions')->insert([
            //     'user_id' => $user->id,
            //     'amount' => $request->balance - $user->wallet_balance,
            //     'type' => 'trading_bot',
            //     'description' => 'MACD Trading Bot P/L',
            //     'created_at' => now(),
            //     'updated_at' => now()
            // ]);

            return response()->json([
                'success' => true,
                'new_balance' => number_format($user->wallet_balance, 2),
                'message' => 'Wallet balance updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update wallet balance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current wallet balance
     */
    public function getBalance()
    {
        $user = Auth::user();
        
        return response()->json([
            'balance' => $user->wallet_balance,
            'formatted_balance' => '$' . number_format($user->wallet_balance, 2)
        ]);
    }
}
