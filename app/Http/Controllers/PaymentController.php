<?php

namespace App\Http\Controllers;

use App\Models\BusinessPlanjoin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;

class PaymentController extends Controller
{
 public function createPreference(Request $request)
{
    $amount = (float) $request->amount;
    $planName = $request->plan_name ?? 'Membership Plan';
    $planId = $request->id ?? null;
    $monthoryear = $request->monthoryear ?? 'Month';
    $userId = auth()->id();

    try {

        // ✅ Direct Mercado Pago preference create
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MERCADO_PAGO_ACCESS_TOKEN'),
            'Content-Type' => 'application/json'
        ])->post('https://api.mercadopago.com/checkout/preferences', [
            "items" => [
                [
                    "title" => $planName,
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => $amount
                ]
            ],

            // ❗ Payment table me kuch save nahi ho raha
            "back_urls" => [
                "success" => env('APP_URL') . "/payment-success?user_id={$userId}&plan_id={$planId}&monthoryear={$monthoryear}",
                "failure" => env('APP_URL') . "/payment-failure",
                "pending" => env('APP_URL') . "/payment-pending",
            ],

            "auto_return" => "approved"
        ]);

        $data = $response->json();

        if (isset($data['init_point'])) {
            return response()->json([
                'success' => true,
                'init_point' => $data['init_point']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to create preference',
                'data' => $data
            ]);
        }

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}



// webhook URL: /mercadopago/webhook
public function webhook(Request $request) {
    $collectionId = $request->input('data.id');
    $type = $request->input('type');

    if($type === 'payment') {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MERCADO_PAGO_ACCESS_TOKEN')
        ])->get("https://api.mercadopago.com/v1/payments/{$collectionId}");
        $data = $response->json();

        // Update DB

    }
    return response()->json(['success' => true]);
}


public function paymentSuccess(Request $request)
{
    $userId = $request->query('user_id');
    $planId = $request->query('plan_id');
    $monthoryear = $request->query('monthoryear');
    $collectionId = $request->query('collection_id'); // Mercado Pago payment ID

    try {

        // 🔹 Fetch Mercado Pago payment details
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MERCADO_PAGO_ACCESS_TOKEN'),
        ])->get("https://api.mercadopago.com/v1/payments/{$collectionId}");

        $data = $response->json();
        $status = $data['status']; // approved, pending, rejected
        $paymentMethod = $data['payment_method_id'] ?? null; // 🔥 Mercado Pago se payment method

        // 🔹 Calculate subscription end date
        $now = now();

        if (strtolower($monthoryear) === 'month') {
            $expiryDate = $now->copy()->addMonth()->format('Y-m-d H:i:s');
        } elseif (strtolower($monthoryear) === 'year') {
            $expiryDate = $now->copy()->addYear()->format('Y-m-d H:i:s');
        } else {
            $expiryDate = null;
        }

        // 🔥 Only if payment approved → Create subscription
        if ($status === 'approved') {

            \App\Models\Subscription::create([
                'user_id' => $userId,
                'plan_id' => $planId,
                'payment_method' => $paymentMethod, // 🔥 Mercado Pago ka method
                'status' => 'active',
                'mp_subscription_id' => $collectionId,
                'current_period_start' => $now->format('Y-m-d H:i:s'),
                'current_period_end' => $expiryDate,
            ]);
        }

        return redirect(env('BASE_URL') . '/plan')
            ->with('success', 'Payment Successful!');

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching payment details',
            'error' => $e->getMessage(),
        ]);
    }
}
 public function payment_failure(){
    return view('payment_fail');
 }

public function directJoin(Request $request)
{
    BusinessPlanjoin::create([
        'business_id' => $request->business_id,
        'plan'        => $request->plan_id,


    ]);

    return response()->json(['success' => true, 'message' => 'Plan Joined']);
}


    public function paymentFailure()
    {
        return response()->json([
            'status' => 'failed',
            'message' => 'Payment failed. Please try again.'
        ]);
    }

    public function paymentPending()
    {
        return response()->json([
            'status' => 'pending',
            'message' => 'Payment is pending. Please wait.'
        ]);
    }
}
