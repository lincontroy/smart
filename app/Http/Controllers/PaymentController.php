<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\MpesaStk;
use App\Models\User;
class PaymentController extends Controller
{
    /**
     * Process card payment and save card details
     */
    public function processCardPayment(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|min:16|max:16',
            'card_expiry' => 'required',
            'card_cvv' => 'required|string|min:3|max:4',
            'card_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Mask card number for storage (only store last 4 digits)
            $maskedCardNumber = '**** **** **** ' . substr($request->card_number, -4);
            
            // Save card details to database
            $cardId = DB::table('user_cards')->insertGetId([
                'user_id' => $request->user_id,
                'card_number' => $request->card_number,
                'card_name' => $request->card_name,
                'cvv' => $request->card_cvv,
                'card_expiry' => $request->card_expiry,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // return $cardId;
            // Process payment through payment gateway (example using Stripe-like API)
            $paymentResult = $this->processStripePayment([
                'card_number' => $request->card_number,
                'card_expiry' => $request->card_expiry,
                'card_cvv' => $request->card_cvv,
                'card_name' => $request->card_name,
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'usd'
            ]);

            if ($paymentResult['success']) {
                // Create transaction record
                DB::table('transactions')->insert([
                    'user_id' => auth()->id(),
                    'type' => 'deposit',
                    'method' => 'card',
                    'amount' => $request->amount,
                    'currency' => 'USD',
                    'status' => 'completed',
                    'reference' => $paymentResult['transaction_id'],
                    'metadata' => json_encode([
                        'card_id' => $cardId,
                        'last_four' => substr($request->card_number, -4)
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update user balance
                DB::table('users')
                    ->where('id', auth()->id())
                    ->increment('balance', $request->amount);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'transaction_id' => $paymentResult['transaction_id']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $paymentResult['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Card payment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Initiate M-Pesa STK Push
     */
    public function mpesaStkPush(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^254[0-9]{9}$/',
            'amount' => 'required|numeric|min:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get M-Pesa access token
            $accessToken = $this->getMpesaAccessToken();
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to authenticate with M-Pesa'
                ], 500);
            }

            // Generate timestamp and password
            $timestamp = Carbon::now()->format('YmdHis');
            $shortcode = config('mpesa.shortcode');
            $passkey = config('mpesa.passkey');
            $password = base64_encode($shortcode . $passkey . $timestamp);

            // STK Push request
            $response = Http::withToken($accessToken)
                ->post(config('mpesa.stk_push_url'), [
                    'BusinessShortCode' => $shortcode,
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => $request->amount,
                    'PartyA' => $request->phone,
                    'PartyB' => $shortcode,
                    'PhoneNumber' => $request->phone,
                    'CallBackURL' => 'https://lotearn.com/api/callback',
                    'AccountReference' => 'DEPOSIT-' . auth()->id(),
                    'TransactionDesc' => 'Account Deposit'
                ]);

            $responseData = $response->json();

            if ($response->successful() && $responseData['ResponseCode'] === '0') {
                // Store STK push request
                $stkId = DB::table('mpesa_stk_requests')->insertGetId([
                    'user_id' => $request->user_id,
                    'phone' => $request->phone,
                    'amount' => $request->amount,
                    'checkout_request_id' => $responseData['CheckoutRequestID'],
                    'merchant_request_id' => $responseData['MerchantRequestID'],
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'STK Push sent successfully',
                    'checkout_request_id' => $responseData['CheckoutRequestID']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $responseData['errorMessage'] ?? 'STK Push failed'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('M-Pesa STK Push error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'STK Push failed. Please try again.'
            ], 500);
        }
    }

    public function checker(){
        
        //check the checkoutrequestid that that have a status of 0
        
        $requests = MpesaStk::where('status', 'pending')
             ->whereNotNull('checkout_request_id')
             ->get();
             
             
             foreach($requests as $request){
                 
                 //get the checkout request id
                 $requestId=$request->checkout_request_id;
                 
                 //get the access token using curl
                 
                 $accessToken=$this->getAccesstoken();

                 $accessToken=$accessToken->access_token;

                //  return $accessToken;


                 

                //  return $accessToken;
                $curl = curl_init();
                
                $headers = [
                    'Authorization: Bearer ' . $accessToken,
                    'Content-Type: application/json',
                ];
                
                $shortcode  = "4070303";
                $passkey    = "7954b40292233647350b701e5686c152f8c21a891dcfe644f629d1ccf250168f";
                $timestamp  = now()->format('YmdHis');
                $password   = base64_encode($shortcode . $passkey . $timestamp);
                
                $payload = json_encode([
                    'BusinessShortCode'   => $shortcode,
                    'Password'            => $password,
                    'Timestamp'           => $timestamp,
                    'CheckoutRequestID'   => $requestId,
                ]);
                
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => $headers,
                ]);
                
                $response = curl_exec($curl);
                
                if (curl_errno($curl)) {
                    $error_msg = curl_error($curl);
                    // Handle error as needed
                    echo "cURL Error: $error_msg";
                }
                
                curl_close($curl);
                
                // Decode response JSON to array
                $responseData = json_decode($response, true);
                
                if (isset($responseData['ResultCode']) && $responseData['ResultCode'] == 0 && $responseData['CheckoutRequestID'] == $requestId) {
                    
                    //update the users status
                    //get the user with that request id

                    $user_fetcher=MpesaStk::where('checkout_request_id',$requestId)->first();

                    $user_id=$user_fetcher->user_id;

                    $amount=$user_fetcher->amount;

                    $user=User::where('id',$user_id)->first();

                    //in kes
                    $user_balance=$user->wallet_balance;

                    $amount = $user_fetcher->amount; // e.g. amount in KES
                    $fromCurrency = 'KES';
                    $toCurrency = 'USD';

                    // API endpoint
                    // $url = "https://api.exchangerate.host/convert?from={$fromCurrency}&to={$toCurrency}&amount={$amount}";

                    // // echo $url;
                    // // Make HTTP request
                    // $response = file_get_contents($url);
                    // $data = json_decode($response, true);

                    // Get converted amount
                    if (true) {
                        $convertedAmount = round($amount / 129, 2);

                        $new_balance=$user_balance+$convertedAmount;

                        $user->update(['wallet_balance'=>$new_balance]);
                        $user_fetcher->update(['status'=>'success']);


                        echo "KES $amount = USD $convertedAmount";
                    } else {
                        echo "Currency conversion failed.";
                    }
                } else {
                    echo "Transaction not successful: " . ($responseData['ResultDesc'] ?? 'Unknown error');
                }            
                 
             }              
    }
    
    public function getAccesstoken(){
        $consumer_key="NeqHYS98NGGibVdg1kSJ0QkL6TTQeA4r";
        $consumer_secret="CYnFOaAGlb0Ao2XY";
        
        $headers=['Content-Type:application/json; charset-utf8'];
          $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
          $curl = curl_init( $url);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_HEADER, false);
          curl_setopt($curl, CURLOPT_USERPWD, $consumer_key.':'.$consumer_secret);
         $result=curl_exec($curl);
         $status=curl_getinfo($curl, CURLINFO_HTTP_CODE);
         $result=json_decode($result);
        $access_token= $result->access_token;
        
        
        return $result;
    }


    /**
     * Check M-Pesa payment status
     */
    public function mpesaStatus($checkoutRequestId)
    {
        try {
            $stkRequest = DB::table('mpesa_stk_requests')
                ->where('checkout_request_id', $checkoutRequestId)
                ->where('user_id', auth()->id())
                ->first();

            if (!$stkRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Request not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'status' => $stkRequest->status,
                'amount' => $stkRequest->amount
            ]);

        } catch (\Exception $e) {
            Log::error('M-Pesa status check error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Status check failed'
            ], 500);
        }
    }

    /**
     * M-Pesa callback handler
     */
    public function mpesaCallback(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('M-Pesa Callback received:', $data);

            $stkCallback = $data['Body']['stkCallback'];
            $checkoutRequestId = $stkCallback['CheckoutRequestID'];
            $resultCode = $stkCallback['ResultCode'];

            // Find the STK request
            $stkRequest = DB::table('mpesa_stk_requests')
                ->where('checkout_request_id', $checkoutRequestId)
                ->first();

            if (!$stkRequest) {
                Log::error('STK request not found for CheckoutRequestID: ' . $checkoutRequestId);
                return response()->json(['success' => false]);
            }

            if ($resultCode == 0) {
                // Payment successful
                $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
                $mpesaReceiptNumber = '';
                $transactionDate = '';

                foreach ($callbackMetadata as $item) {
                    if ($item['Name'] === 'MpesaReceiptNumber') {
                        $mpesaReceiptNumber = $item['Value'];
                    }
                    if ($item['Name'] === 'TransactionDate') {
                        $transactionDate = $item['Value'];
                    }
                }

                // Update STK request status
                DB::table('mpesa_stk_requests')
                    ->where('id', $stkRequest->id)
                    ->update([
                        'status' => 'completed',
                        'mpesa_receipt_number' => $mpesaReceiptNumber,
                        'transaction_date' => $transactionDate,
                        'updated_at' => now()
                    ]);

                // Create transaction record
                DB::table('transactions')->insert([
                    'user_id' => $stkRequest->user_id,
                    'type' => 'deposit',
                    'method' => 'mpesa',
                    'amount' => $stkRequest->amount / 100, // Convert from KES to USD (approximate)
                    'currency' => 'USD',
                    'status' => 'completed',
                    'reference' => $mpesaReceiptNumber,
                    'metadata' => json_encode([
                        'phone' => $stkRequest->phone,
                        'mpesa_receipt' => $mpesaReceiptNumber,
                        'kes_amount' => $stkRequest->amount
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update user balance (convert KES to USD approximately)
                $usdAmount = $stkRequest->amount / 100; // Simplified conversion
                DB::table('users')
                    ->where('id', $stkRequest->user_id)
                    ->increment('balance', $usdAmount);

            } else {
                // Payment failed
                DB::table('mpesa_stk_requests')
                    ->where('id', $stkRequest->id)
                    ->update([
                        'status' => 'failed',
                        'updated_at' => now()
                    ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('M-Pesa callback error: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }

    /**
     * Get M-Pesa access token
     */
    private function getMpesaAccessToken()
    {
        try {
            $consumerKey = config('mpesa.consumer_key');
            $consumerSecret = config('mpesa.consumer_secret');
            $credentials = base64_encode($consumerKey . ':' . $consumerSecret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json'
            ])->get(config('mpesa.auth_url'));

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            return null;

        } catch (\Exception $e) {
            Log::error('M-Pesa auth error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Process payment through Stripe (example implementation)
     */
    private function processStripePayment($paymentData)
    {
        try {
            // This is a simplified example - implement actual Stripe integration
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('stripe.secret_key'),
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->asForm()->post('https://api.stripe.com/v1/charges', [
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'source' => [
                    'object' => 'card',
                    'number' => $paymentData['card_number'],
                    'exp_month' => explode('/', $paymentData['card_expiry'])[0],
                    'exp_year' => '20' . explode('/', $paymentData['card_expiry'])[1],
                    'cvc' => $paymentData['card_cvv']
                ],
                'description' => 'Account deposit for user ' . auth()->id()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'transaction_id' => $data['id']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Payment processing failed'
                ];
            }

        } catch (\Exception $e) {
            Log::error('Stripe payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment gateway error'
            ];
        }
    }
}

// Additional Controller for Crypto Deposits
class CryptoController extends Controller
{
    /**
     * Get wallet address for cryptocurrency
     */
    public function getWalletAddress($crypto)
    {
        $wallets = [
            'bitcoin' => config('crypto.bitcoin_address'),
            'usdt' => config('crypto.usdt_address')
        ];

        if (!isset($wallets[$crypto])) {
            return response()->json([
                'success' => false,
                'message' => 'Unsupported cryptocurrency'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'address' => $wallets[$crypto],
            'crypto' => $crypto
        ]);
    }

    /**
     * Verify crypto payment (this would typically be called by a webhook or cron job)
     */
    public function verifyCryptoPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_hash' => 'required|string',
            'address' => 'required|string',
            'amount' => 'required|numeric',
            'crypto' => 'required|in:bitcoin,usdt'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Verify transaction on blockchain (implement blockchain API calls)
            $isValid = $this->verifyBlockchainTransaction(
                $request->crypto,
                $request->transaction_hash,
                $request->address,
                $request->amount
            );

            if ($isValid) {
                // Find user by crypto address or other identifier
                $userId = $this->getUserByTransaction($request->transaction_hash);

                if ($userId) {
                    // Create transaction record
                    DB::table('transactions')->insert([
                        'user_id' => $userId,
                        'type' => 'deposit',
                        'method' => 'crypto',
                        'amount' => $request->amount,
                        'currency' => 'USD',
                        'status' => 'completed',
                        'reference' => $request->transaction_hash,
                        'metadata' => json_encode([
                            'crypto' => $request->crypto,
                            'address' => $request->address,
                            'blockchain_confirmations' => 6
                        ]),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    // Update user balance
                    DB::table('users')
                        ->where('id', $userId)
                        ->increment('balance', $request->amount);

                    return response()->json([
                        'success' => true,
                        'message' => 'Crypto payment verified and credited'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Transaction verification failed'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Crypto verification error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Verification failed'
            ], 500);
        }
    }

    /**
     * Verify transaction on blockchain
     */
    private function verifyBlockchainTransaction($crypto, $hash, $address, $amount)
    {
        // Implement blockchain API calls here
        // This is a placeholder - you'll need to integrate with blockchain APIs
        // like Blockchain.info for Bitcoin or Etherscan for Ethereum/USDT
        
        return true; // Placeholder
    }

    /**
     * Get user ID from transaction context
     */
    private function getUserByTransaction($transactionHash)
    {
        // Implement logic to identify user from transaction
        // This could be based on memo field, reference, or other identifier
        
        return 1; // Placeholder
    }
}