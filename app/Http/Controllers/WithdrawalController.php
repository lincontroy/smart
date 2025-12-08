<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function cryptoWithdrawal(Request $request)
    {
        $request->validate([
            'crypto_type' => 'required|in:bitcoin,usdt,ethereum',
            'amount' => 'required|numeric|min:10',
            'wallet_address' => 'required|string'
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();
            
            if ($user->wallet_balance < $request->amount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'method' => 'crypto',
                'amount' => $request->amount,
                'status' => 'pending',
                'details' => [
                    'crypto_type' => $request->crypto_type,
                    'wallet_address' => $request->wallet_address
                ]
            ]);

            // Deduct from user balance
            $user->decrement('wallet_balance', $request->amount);

            // In a real app, you would queue a job to process the crypto transaction
            // ProcessCryptoWithdrawal::dispatch($withdrawal);

            return response()->json([
                'message' => 'Withdrawal request submitted successfully',
                'balance' => $user->fresh()->wallet_balance
            ]);
        });
    }

    public function bankWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
            'swift_code' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();
            
            if ($user->wallet_balance < $request->amount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'method' => 'bank',
                'amount' => $request->amount,
                'status' => 'pending',
                'details' => [
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_holder' => $request->account_holder,
                    'swift_code' => $request->swift_code
                ]
            ]);

            // Deduct from user balance
            $user->decrement('wallet_balance', $request->amount);

            // In a real app, you would queue a job to process the bank transfer
            // ProcessBankWithdrawal::dispatch($withdrawal);

            return response()->json([
                'message' => 'Bank withdrawal request submitted',
                'balance' => $user->fresh()->wallet_balance
            ]);
        });
    }

    public function mpesaWithdrawal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100', // Minimum 100 KES
            'phone' => 'required|string|regex:/^254[0-9]{9}$/'
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();
            $usdAmount = $request->amount; // Assuming 100 KES = 1 USD
            
            if ($user->wallet_balance < $usdAmount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // Create withdrawal record
            $withdrawal = Withdrawal::create([
                'user_id' => $user->id,
                'method' => 'mpesa',
                'amount' => $usdAmount,
                'status' => 'pending',
                'details' => [
                    'phone' => $request->phone,
                    'kes_amount' => $request->amount
                ]
            ]);

            // Deduct from user balance
            $user->decrement('wallet_balance', $usdAmount);

            // In a real app, you would initiate M-Pesa STK push here
            // ProcessMpesaWithdrawal::dispatch($withdrawal);

            return response()->json([
                'message' => 'M-Pesa withdrawal initiated',
                'balance' => $user->fresh()->wallet_balance
            ]);
        });
    }
}