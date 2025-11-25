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
    $monthoryear = $request->monthoryear?? 'Month';
    $userId = auth()->id(); // 🔹 Get logged-in user id

    try {
        // ✅ Create pending record before redirecting to Mercado Pago
        $payment = Payment::create([
            'user_id' => $userId,
            'plan_id' => $planId,
            'amount' => $amount,
            'currency' => 'ARS',
            'status' => 'pending',
        ]);

        // ✅ Create Mercado Pago preference
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
            "back_urls" => [
                "success" => env('APP_URL') . '/payment-success?id=' . $payment->id . '&user_id=' . $userId. '&monthoryear=' . $monthoryear,

                "failure" => env('APP_URL') . '/payment-failure?id=' . $payment->id,
                "pending" => env('APP_URL') . '/payment-pending?id=' . $payment->id,
            ],
            "auto_return" => "approved"
        ]);

        $data = $response->json();

        if (isset($data['init_point'])) {
            return response()->json([
                'success' => true,
                'init_point' => $data['init_point'],

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
  public function createPreferences(Request $request,$amount,$plan_tier,$id,$business_ids,$month_year)
{
    $amount = (float) $amount;
    $planName = $plan_tier ?? 'Membership Plan';
    $planId = $id ?? null;
    $monthoryear = $month_year?? 'Month';
    $business_id = $business_ids; // 🔹 Get logged-in user id

    try {
        // ✅ Create pending record before redirecting to Mercado Pago
        $payment = BusinessPlanjoin::create([
            'business_id' => $business_ids,
            'plan' => $planId,

        ]);

        // ✅ Create Mercado Pago preference
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
            "back_urls" => [
                "success" => env('APP_URL') . '/payment-success?id=' . $payment->id . '&business_id=' . $business_ids. '&monthoryear=' . $monthoryear,

                "failure" => env('APP_URL') . '/payment-failure?id=' . $payment->id,
                "pending" => env('APP_URL') . '/payment-pending?id=' . $payment->id,
            ],
            "auto_return" => "approved"
        ]);

        $data = $response->json();

        if (isset($data['init_point'])) {
            return response()->json([
                'success' => true,
                'init_point' => $data['init_point'],

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
        $payment = Payment::where('preference_id', $data['preference_id'])->first();
        if($payment) {
            $payment->update([
                'status' => $data['status'],
                'payment_id' => $collectionId,
                'payment_method' => $data['payment_method_id'] ?? null,
                'payment_type' => $data['payment_type_id'] ?? null,
            ]);
        }
    }
    return response()->json(['success' => true]);
}


 public function paymentSuccess(Request $request)
{
    $paymentId = $request->query('id');
    $user_id = $request->query('user_id');
    $monthoryear = $request->query('monthoryear');
    $collectionId = $request->query('collection_id');
    $collectionStatus = $request->query('collection_status');
    $paymentType = $request->query('payment_type');
    $merchantOrderId = $request->query('merchant_order_id');
    $preferenceId = $request->query('preference_id');
    $siteId = $request->query('site_id');
    $processingMode = $request->query('processing_mode');
    $merchantAccountId = $request->query('merchant_account_id');

    try {
        // ✅ Get payment details from Mercado Pago API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MERCADO_PAGO_ACCESS_TOKEN'),
        ])->get("https://api.mercadopago.com/v1/payments/{$collectionId}");

        $data = $response->json();
        $status = $data['status'] === 'approved' ? 'success' : $data['status'];

        // ✅ Calculate expiry date
        $now = now();
        if (strtolower($monthoryear) === 'month') {
            $expiryDate = $now->copy()->addMonth()->format('Y-m-d');
        } elseif (strtolower($monthoryear) === 'year') {
            $expiryDate = $now->copy()->addYear()->format('Y-m-d');
        } else {
            $expiryDate = null; // fallback agar galat value aayi
        }

        // ✅ Update payment in your DB
        $payment = Payment::find($paymentId);
        if ($payment) {
            $payment->update([
                'status' => $status,
                'payment_id' => $collectionId,
                'payment_method' => $data['payment_method_id'] ?? null,
                'payment_type' => $data['payment_type_id'] ?? null,
                'currency' => $data['currency_id'] ?? 'ARS',
                'expire_date' => $expiryDate,
                'membership_status'=>1,
            ]);
        }

        // ✅ Update user membership
        $userupdate = User::find($user_id);
        if ($userupdate) {
            $userupdate->update([
                'membership_plan' => '1',
            ]);
        }

        // ✅ Redirect with success message
        return redirect(env('BASE_URL') . '/account')
            ->with('success', 'Payment Successful!');

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching payment details',
            'error' => $e->getMessage(),
        ]);
    }
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
