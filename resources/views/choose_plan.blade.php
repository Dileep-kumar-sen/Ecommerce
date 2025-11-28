@extends('landing')

@section('content')

{{-- SUCCESS MESSAGE + CONFETTI --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

@if(session('success'))
    <div id="successBox" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50">

        <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-3 animate-slideDown">
            🎉 <span class="font-semibold">{{ session('success') }}</span>
        </div>

    </div>

    <script>
        setTimeout(() => {
            confetti({ particleCount: 150, spread: 80, origin: { y: 0.6 } });
            confetti({ particleCount: 80, angle: 60, spread: 120, origin: { x: 0 } });
            confetti({ particleCount: 80, angle: 120, spread: 120, origin: { x: 1 } });
        }, 400);

        setTimeout(() => {
            const box = document.getElementById('successBox');
            if(box){
                box.style.transition = "all 0.6s";
                box.style.opacity = "0";
                setTimeout(() => box.remove(), 600);
            }
        }, 4000);
    </script>

    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translate(-50%, -20px); }
            to   { opacity: 1; transform: translate(-50%, 0px); }
        }
        .animate-slideDown { animation: slideDown 0.6s ease-out; }
    </style>

@endif


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

    {{-- FETCH ACTIVE SUBSCRIPTION --}}
    @php
        use App\Models\Subscription;
        use App\Models\Membership_plan;
        use Carbon\Carbon;

        $user = auth()->user();

        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderBy('current_period_end', 'desc')
            ->first();

        $activePlanId = $activeSubscription->plan_id ?? null;
        $validTill = $activeSubscription->current_period_end ?? null;
    @endphp

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
                {{ $validTill ? Carbon::parse($validTill)->format('d M Y') : 'No Active Plan' }}
            </span>
        </div>
    </div>



    {{-- PLAN CARDS --}}
    @php
        $plans = Membership_plan::all();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4">

        @foreach($plans as $plan)
            <div class="border rounded-xl overflow-hidden shadow bg-white flex flex-col h-full">

                {{-- TOP ICON AREA --}}
                <div class="p-4 text-center font-semibold flex items-center justify-center gap-2"
                     style="background-color: {{ $plan->color }}">

                    <img src="{{ asset($plan->plan_icon) }}" alt="Icon"
                         class="w-8 h-8 object-contain">

                    <span class="text-black font-bold">{{ $plan->plan_tier }}</span>
                </div>

                {{-- BODY --}}
                <div class="p-6 text-center flex flex-col flex-grow">

                    <p class="text-3xl font-bold">${{ number_format($plan->plan_price, 2) }}</p>
                    <p class="text-sm text-gray-500 mb-5">/{{ $plan->month_year }}</p>

                    <ul class="text-left text-gray-600 text-sm space-y-2 mb-6 flex-grow">
                        @if($plan->features)
                            @foreach(explode(',', $plan->features) as $feature)
                                <li>• {{ trim($feature) }}</li>
                            @endforeach
                        @endif

                        @if($plan->access_benefit)
                            @foreach(explode(',', $plan->access_benefit) as $benefit)
                                <li>• {{ trim($benefit) }}</li>
                            @endforeach
                        @endif
                    </ul>

                    {{-- BUTTON SECTION --}}
                    <div class="mt-auto w-full">

                        {{-- ACTIVE PLAN --}}
                        @if($activePlanId == $plan->id)

                            <p class="text-green-600 font-semibold mb-2">
                                Valid till: {{ Carbon::parse($validTill)->format('d M Y') }}
                            </p>

                            <button class="w-full bg-gray-300 text-gray-600 rounded py-2 font-semibold cursor-not-allowed" disabled>
                                Your Current Plan
                            </button>

                        @else
                            {{-- SUBSCRIBE BUTTON --}}
                            <form class="subscribe-form w-full" action="{{ route('create.preference') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $plan->plan_price }}">
                                <input type="hidden" name="plan_name" value="{{ $plan->plan_tier }}">
                                <input type="hidden" name="id" value="{{ $plan->id }}">
                                <input type="hidden" name="monthoryear" value="{{ $plan->month_year }}">

                                <button type="submit"
                                        class="w-full rounded py-2 font-semibold text-white transition"
                                        style="background-color: {{ $plan->color }}">
                                    Subscribe
                                </button>
                            </form>

                        @endif

                    </div>

                </div>

            </div>
        @endforeach

    </div>

</div>




{{-- AJAX PAYMENT HANDLER --}}
<script>
document.querySelectorAll('.subscribe-form').forEach(form => {

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.success && data.init_point) {
                window.location.href = data.init_point;
            } else {
                alert(data.message || 'Payment initiation failed');
            }

        })
        .catch(err => {
            console.error(err);
            alert('Payment failed. Please try again later.');
        });
    });

});
</script>

@endsection
