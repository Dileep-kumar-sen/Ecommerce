@extends('business.sidebaar')
@section('title', 'Choose Plan')

@section('content')

<div class="container mx-auto p-6">

    <div class="max-w-[71rem] mx-auto bg-white shadow-2xl rounded-2xl  border border-gray-200" style="padding:80px">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800" style="font-size: 30px">
                {{ $plan->plan_tier }} Plan
            </h1>

            @if($plan->plan_icon)
                <img src="{{ asset($plan->plan_icon) }}"
                     class="w-20 h-20 object-contain"
                     alt="Plan Icon" style="width:292px;height:196px">
            @endif
        </div>

        {{-- Status Badge --}}
        <div class="mb-6">
            @if($plan->status == 1)
                <span class="px-4 py-1 bg-green-100 text-green-700 font-bold rounded-full text-sm">
                    ● Active
                </span>
            @else
                <span class="px-4 py-1 bg-red-100 text-red-700 font-bold rounded-full text-sm">
                    ● Inactive
                </span>
            @endif
        </div>

        {{-- Plan Info Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Left Box --}}
            <div class="space-y-3">

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-semibold text-gray-700">Trial Period</p>
                    <p class="text-gray-900 text-lg">{{ $plan->trial_period_days ??'N/A' }} days</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-semibold text-gray-700">Coupons Per Week</p>
                    <p class="text-gray-900 text-lg">{{ $plan->coupons_per_week??'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-semibold text-gray-700">Month / Year</p>
                    <p class="text-gray-900 text-lg">{{ $plan->month_year??'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-semibold text-gray-700">Discount Limit</p>
                    <p class="text-gray-900 text-lg">{{ $plan->discount_limit??'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-semibold text-gray-700">Exclusive Monthly Offers</p>
                    <p class="text-gray-900 text-lg">{{ $plan->exclusive_offers_monthly??'N/A' }}</p>
                </div>

                <div class="p-4 bg-blue-50 border-blue-200 rounded-lg shadow">
                    <p class="font-semibold text-blue-700">Plan Price</p>
                    <p class="text-2xl font-bold text-blue-900">${{ number_format($plan->plan_price,2) }}</p>
                </div>

            </div>

            {{-- Right Box --}}
            <div class="space-y-4">

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-bold text-gray-800">Features</p>
                    <div class="text-gray-700">{!! nl2br(e($plan->features??'N/A')) !!}</div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-bold text-gray-800">Achievements</p>
                    <div class="text-gray-700">{!! nl2br(e($plan->achievements ??'N/A')) !!}</div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-bold text-gray-800">Referral Bonus</p>
                    <div class="text-gray-700">{!! nl2br(e($plan->referral_bonus??'N/A')) !!}</div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg shadow-sm border">
                    <p class="font-bold text-gray-800">Description</p>
                    <div class="text-gray-700">{!! nl2br(e($plan->description ??'N/A')) !!}</div>
                </div>

            </div>

        </div>

        {{-- Back Button --}}
        <br>
        <div class="mt-10">
            <a href="{{ url()->previous() }}"
               class="px-6 py-2 bg-gray-800 text-white rounded-lg shadow hover:bg-black transition" style="background:gray">
               ← Back
            </a>
        </div>

    </div>

</div>

@endsection
