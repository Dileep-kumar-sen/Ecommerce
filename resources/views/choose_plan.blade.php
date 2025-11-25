@extends('landing')

@section('content')

<div class="max-w-6xl mx-auto py-10">

    {{-- PAGE HEADING --}}
    <h1 class="text-3xl font-bold text-center mb-2 text-gray-900">
        Choose your CashCash plan
    </h1>

    <p class="text-center text-gray-600 mb-6">
        Welcome, <span class="font-semibold">{{ auth()->user()->name }}</span>
    </p>

    <p class="text-center text-gray-500 mb-10">
        Access more benefits, coupons and exclusive discounts with your membership.
    </p>

    {{-- ACTIVE PLAN BADGE --}}
    <div class="flex justify-center mb-12">
        <div class="bg-green-500 text-white px-6 py-3 rounded-full flex items-center gap-2 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
            </svg>
            Your plan is active
            <span class="ml-2 font-semibold">
                Valid until {{ auth()->user()->plan_expiry ?? '01/12/2025' }}
            </span>
        </div>
    </div>


    {{-- PLAN CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4">

    {{-- CARD --}}
    <div class="border rounded-xl overflow-hidden shadow bg-white flex flex-col h-full">
        <div class="bg-gray-200 p-4 text-center font-semibold flex items-center justify-center gap-2">
            <span>🪙</span> Silver
        </div>

        <div class="p-6 text-center flex flex-col flex-grow">
            <p class="text-3xl font-bold">$1,999</p>
            <p class="text-sm text-gray-500 mb-5">/month</p>

            <ul class="text-left text-gray-600 text-sm space-y-2 mb-6 flex-grow">
                <li>• 7-day trial</li>
                <li>• Basic access to coupons</li>
                <li>• Discounts up to 10%</li>
            </ul>

            <p class="text-green-600 text-sm font-semibold mb-3">
                Active until {{ auth()->user()->plan_expiry ?? '01/12/2025' }}
            </p>

            <button class="w-full bg-gray-300 text-gray-600 rounded py-2 font-semibold" disabled>
                Your current plan
            </button>
        </div>
    </div>

    {{-- GOLD --}}
    <div class="border rounded-xl overflow-hidden shadow bg-white flex flex-col h-full">
        <div class="bg-yellow-400 p-4 text-center font-semibold flex items-center justify-center gap-2">
            <span>🏅</span> Gold
        </div>

        <div class="p-6 text-center flex flex-col flex-grow">
            <p class="text-3xl font-bold">$2,999</p>
            <p class="text-sm text-gray-500 mb-5">/month</p>

            <ul class="text-left text-gray-600 text-sm space-y-2 mb-6 flex-grow">
                <li>• 7-day trial</li>
                <li>• Basic access</li>
                <li>• Up to 25% discount</li>
            </ul>

            <div class="mt-auto">
                <button class="w-full bg-yellow-500 hover:bg-yellow-600 text-white rounded py-2 font-semibold transition">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

    {{-- BLACK --}}
    <div class="border rounded-xl overflow-hidden shadow bg-white flex flex-col h-full">
        <div class="bg-black text-white p-4 text-center font-semibold flex items-center justify-center gap-2">
            <span>👑</span> Black
        </div>

        <div class="p-6 text-center flex flex-col flex-grow">
            <p class="text-3xl font-bold">$4,999</p>
            <p class="text-sm text-gray-500 mb-5">/month</p>

            <ul class="text-left text-gray-600 text-sm space-y-2 mb-6 flex-grow">
                <li>• Unlimited benefits</li>
                <li>• VIP Access</li>
                <li>• Exclusive Promotions</li>
            </ul>

            <div class="mt-auto">
                <button class="w-full bg-black hover:bg-gray-900 text-white rounded py-2 font-semibold transition">
                    Subscribe
                </button>
            </div>
        </div>
    </div>

</div>


</div>

@endsection
