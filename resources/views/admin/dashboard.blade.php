@extends('admin.sidebaar')

@section('content')

<main class="h-full overflow-y-auto">

          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Dashboard
            </h2>
            <!-- CTA -->

            <!-- Cards -->
            <div style="display: grid; gap: 24px; margin-bottom: 32px; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">

  <!-- Total Users -->
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #6366f1, #4f46e5); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #4338ca; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fas fa-users" style="font-size: 24px;"></i>
    </div>
    @php
    $totalUsers = \App\Models\User::count();
@endphp
    <div>
      <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #e0e7ff;">Total Users</p>
      <p style="font-size: 24px; font-weight: bold; color: white;"> {{ number_format($totalUsers) }}</p>
    </div>
  </div>

  <!-- Business Users -->
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #4ade80, #22c55e); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #16a34a; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fas fa-building" style="font-size: 24px;"></i>
    </div>
    @php
    $businessCount = \App\Models\Business::count();
@endphp

<div>
    <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #dcfce7;">
        Business Users
    </p>

    <p style="font-size: 24px; font-weight: bold; color: white;">
        {{ number_format($businessCount) }}
    </p>
</div>
  </div>

  <!-- Total Offers -->
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #f472b6, #ec4899); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #db2777; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fas fa-gift" style="font-size: 24px;"></i>
    </div>
    <div>
         @php
    $OfferCount = \App\Models\Offer::count();
@endphp
      <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #fce7f3;">Total Offers</p>
      <p style="font-size: 24px; font-weight: bold; color: white;">{{ number_format($OfferCount) }}</p>
    </div>
  </div>

  <!-- Membership Buy -->
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #facc15, #f59e0b); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #ca8a04; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fas fa-credit-card" style="font-size: 24px;"></i>
    </div>
    <div>
      <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #fef9c3;">Membership Buy</p>
      <p style="font-size: 24px; font-weight: bold; color: white;">376</p>
    </div>
  </div>
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #5e316b, #f59e0b); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #0460ca; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fa-solid fa-money-bills" style="font-size: 24px;"></i>
    </div>
      @php
    $MembershipCount = \App\Models\Membership_plan::count();
@endphp
    <div>
      <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #fef9c3;">Total Created Plan</p>
      <p style="font-size: 24px; font-weight: bold; color: white;">{{ number_format($MembershipCount) }}</p>
    </div>
  </div>
  <div style="display: flex; align-items: center; padding: 24px; background: linear-gradient(to right, #35c7bb, #993e6e); border-radius: 16px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); transform: scale(1); transition: all 0.3s;">
    <div style="padding: 16px; margin-right: 16px; background: #a24bed; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.3); color: white;">
      <i class="fas fa-credit-card" style="font-size: 24px;"></i>
    </div>
    @php
        $totalcampaign=\App\Models\CampaignJoin::count();
    @endphp
    <div>
      <p style="margin-bottom: 4px; font-size: 14px; font-weight: 500; color: #fef9c3;">Total Campaigns Join</p>
      <p style="font-size: 24px; font-weight: bold; color: white;">{{ number_format($totalcampaign) }}</p>
    </div>
  </div>

</div>

<div class="m-2 shadow-md bg-white p-4 rounded-lg">
  <h2 class="text-xl font-semibold mb-4">Monthly Active Users</h2>
  <div id="barChart" class="w-full h-80"></div>
</div>
            <!-- New Table -->
            <h2
              class="my-6 text-1xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Recent Payment Status
            </h2>
            @php
    use App\Models\Payment;

    // Blade me hi payment fetch kar rahe hain
    $payments = Payment::with(['user', 'plan'])->where('status', 'success')->latest()->get();
@endphp


<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">

        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                  class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">

                    <th class="px-4 py-3">User Name</th>
                    <th class="px-4 py-3">Plan Name</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
@if ($payments->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500 text-lg">
                            ❌ No Payments Found
                        </td>
                    </tr>
                @endif
                @foreach ($payments as $payment)
                    <tr class="text-gray-700 dark:text-gray-400">

                        {{-- USER NAME --}}
                        <td class="px-4 py-3">
                            <p class="font-semibold">
                                {{ $payment->user->name ?? 'Unknown User' }}
                            </p>
                        </td>

                        {{-- PLAN NAME --}}
                        <td class="px-4 py-3 text-sm">
                            {{ $payment->plan->plan_tier ?? 'No Plan' }}
                        </td>

                        {{-- PRICE --}}
                        <td class="px-4 py-3 text-xs">
                            <span
                              class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                ₹{{ number_format($payment->amount) }}
                            </span>
                        </td>

                        {{-- DATE --}}
                        <td class="px-4 py-3 text-sm">
                            {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</div>


            <!-- Charts -->
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Charts
            </h2>
            <div class="grid gap-6 mb-8 md:grid-cols-2">

              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Business Join
                </h4>
                <canvas id="line"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->


                </div>
              </div>
            </div>
          </div>
        </main>

@endsection
