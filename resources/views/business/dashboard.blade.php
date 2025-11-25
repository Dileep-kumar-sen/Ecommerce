@extends('business.sidebaar')

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
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                   <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                @php
    use App\Models\Offer;

    // Session se business_id lo
    $businessId = session('business_id');

    // Offers count jinka business_id yehi hai
    $offerCount = Offer::where('business_id', $businessId)->count();
@endphp
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total Offer
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $offerCount }}
                  </p>
                </div>
              </div>
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>

                </div>
                @php

    use App\Models\UserRedeem;

    // Step 1: Session se business_id lo
    $businessId = session('business_id');

    // Step 2: Is business ke sare offer IDs lo
    $offerIds = Offer::where('business_id', $businessId)->pluck('id');

    // Step 3: In offer IDs se user redeem count karo
    $redeemCount = UserRedeem::whereIn('offer_id', $offerIds)->count();
@endphp
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total User Redeem
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ $redeemCount }}
                  </p>
                </div>
              </div>
              <div
  class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
>
  <div
    class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
  >
    <!-- 🎯 Campaign Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 8v4l3 3m6-3a9 9 0 11-9-9 9 9 0 019 9z" />
    </svg>
  </div>

  @php
    use App\Models\CampaignJoin;

    // Session se business_id lo
    $businessId = session('business_id');

    // CampaignJoin me jitne records is business_id se match hote hain unka count
    $campaignJoinCount = CampaignJoin::where('business_id', $businessId)->count();
@endphp

<div>
    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
        Total My Campaigns
    </p>

    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
        {{ $campaignJoinCount }}
    </p>
</div>

</div>

              <div
  class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
>
  <div
    class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500"
  >
    <!-- 💳 Active Plan Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 10h18M3 6h18a2 2 0 012 2v8a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2z" />
    </svg>
  </div>

  <div>
    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
      Total Active Plans
    </p>
    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
      4
    </p>
  </div>
</div>
              {{-- <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>

                </div>

              </div> --}}
              <!-- Card -->
              @php

    use Carbon\Carbon;

    $businessId = session('business_id');

    // Saare offers jinka business_id match karta hai
    $offers = Offer::where('business_id', $businessId)->get();

    $expireCount = 0;

    foreach ($offers as $offer) {
        $created = Carbon::parse($offer->created_at);
        $expiry  = Carbon::parse($offer->expiry_datetime);

        // Expiry created se aage hai → tabhi expire count karo
        if ($expiry->gt($created)) {
            $expireCount++;
        }
    }
@endphp
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                    ></path>
                  </svg>
                </div>
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Total Expire Offer
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{$expireCount}}
                  </p>
                </div>
              </div>
              <!-- Card -->

            </div>

            <!-- New Table -->
            <h2
              class="my-6 text-1xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Recent User Claim Offer
            </h2>
            @php


    // Step 1: Session business_id
    $businessId = session('business_id');

    // Step 2: Get Offer IDs of this business
    $offerIds = Offer::where('business_id', $businessId)->pluck('id');

    // Step 3: Get User Redeem of these offer IDs with user & offer relationships
    $recentRedeems = UserRedeem::with(['user', 'offer'])
        ->whereIn('offer_id', $offerIds)
        ->latest()
        ->take(10) // latest 10 records
        ->get();
@endphp
            <div class="w-full overflow-hidden rounded-lg shadow-xs">

              <div class="w-full overflow-x-auto">

                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">User Name</th>
                      <th class="px-4 py-3">Offer Name</th>
                      <th class="px-4 py-3">Price</th>
                      <th class="px-4 py-3">Discount</th>
                      <th class="px-4 py-3">Date</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >

@forelse ($recentRedeems as $redeem)
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <!-- Avatar with inset shadow -->

                          <div>
                            <p class="font-semibold"> {{ $redeem->user->name ?? 'Unknown User' }}</p>

                          </div>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                          {{ $redeem->offer->title ?? 'N/A' }}
                      </td>
                      <td class="px-4 py-3 text-xs">
                        <span
                          class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600"
                        >
                          {{ $redeem->offer->price ?? 0 }}
                        </span>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        {{ $redeem->offer->discount ?? 0 }}%
                      </td>
                      <td class="px-4 py-3 text-sm">
                       {{ $redeem->created_at->format('d/m/Y') }}
                      </td>
                    </tr>
                    @empty
    <tr>
        <td colspan="5" class="text-center py-4 text-gray-500">
            No recent claims found
        </td>
    </tr>
                    @endforelse



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
                  User Claim Offer
                </h4>
                <canvas id="line"></canvas>
                <div
                  class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400"
                >
                  <!-- Chart legend -->

                  <div class="flex items-center">
                    <span
                      class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"
                    ></span>
                    <span>User Claim</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        <script>

        </script>
        @endsection
