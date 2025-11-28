@extends('landing')
@section('content')
@php
use Carbon\Carbon;

$subscription = \App\Models\Subscription::where('user_id', auth()->id())
                ->where('status', 'active')
                ->orderBy('id','desc')
                ->first();

$daysLeft = null;

if ($subscription) {

    // 🔹 End date from subscription
    $end = Carbon::parse($subscription->current_period_end);

    // 🔹 Aaj ki date se pure din bache hue (integer only)
    $daysLeft = now()->startOfDay()->diffInDays($end->startOfDay());
}
@endphp


@if($subscription && $daysLeft !== null)
<div class="flex justify-center">
    <div class="px-6 py-4 rounded-xl bg-white/30 backdrop-blur-md shadow-lg border border-white/20
                text-center text-lg font-semibold text-gray-800
                flex items-center gap-2 flex-nowrap
                hover:shadow-xl hover:scale-105 transition-all duration-200">

        <span class="text-[15px]">⏳ You have</span>
        <span class="text-red-600 font-extrabold">{{ $daysLeft }} days</span>
        left —
        <a href="/plan"
           class="text-blue-700 underline underline-offset-4 hover:text-blue-900 font-bold">
           Renew Plan
        </a>

    </div>
</div>

@endif





@php
    use App\Models\Banner;
    $banners = Banner::all();
@endphp

<div class="relative w-full h-[500px] overflow-hidden" id="hero-carousel">
    <!-- Slides -->
    @foreach($banners as $banner)
        <div class="absolute inset-0 hidden carousel-slide fade">
            <img src="{{ asset('uploads/banners/' . $banner->images) }}"
                 class="w-full h-[500px] object-cover"
                 alt="Banner">
        </div>
    @endforeach
</div>



        <!-- 🔹 Overlay -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/70 flex flex-col justify-center items-center text-center px-4">
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-#f5e10e-400 to-#e3e3e3-500 bg-clip-text text-transparent drop-shadow-lg"
                style="color: #9E9E9E">
                Get your coupon

            </h1>
            <p class="text-1xl text-gray-200 mt-3">The best deals in Dining, Travel, Beauty and much more</p>

            <!-- Card -->
            <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-2xl p-6 mt-8 max-w-md border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Don't miss the best deals!</h3>
                <p class="text-gray-600 mt-2">Up to 70% discount at the best places in Argentina</p>
                <a href="#deals"
                    class="mt-4 inline-flex items-center justify-center

          hover:from-#e3e3e3-500 hover:to-pink-600
          text-white font-medium px-6 py-3 rounded-lg shadow-lg
          transition-transform duration-500 ease-in-out
          hover:rotate-[360deg]"
                    style="background: #7a5af8;color:white">
                    <i class="fa-solid fa-ticket" ></i>&nbsp;
                    View Deals
                </a>

            </div>
        </div>
    </div>

    <!-- 🔹 Categories Section -->
    <!-- Explore Categories -->
    <!-- 🔹 Main Wrapper -->
<div class="mx-auto text-white border-b border-white/20 rounded" style="overflow-x:hidden;">
    <section class="py-20">
        <div class="max-w-[91rem] mx-auto w-full px-6 text-center">

            <!-- Title -->
            <h2 class="text-[1.7rem] font-extrabold text-gray-800">Explore by Categories</h2>
            <p class="text-gray-600 mt-3 text-1xl">Find the best deals organized by category</p>

            <!-- Categories Grid -->
            <div class="mt-14">
                <div id="category-container" class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach ($category as $Categories)
                        <div
                            class="category-item group bg-white rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 p-4 text-center">

                            <div
                                class="lg:w-[6rem] lg:h-[6rem] w-[5rem] h-[5rem] mx-auto flex items-center justify-center rounded-full  text-red-500 text-2xl group-hover:scale-110 transition overflow-hidden">
                                <img src="{{ asset('/uploads/category/' . $Categories->icon) }}"
                                    alt="{{ $Categories->name }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>

                            <h3 class="mt-2 text-[17px] font-semibold text-gray-800">{{ $Categories->name }}</h3>

                            <a href="{{ route('get.offer', $Categories->id) }}"
                               class="mt-2 inline-block text-xs font-medium hover:underline text-blue-600">
                               See more →
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- Show buttons only if more than 16 categories --}}
                @if(count($category) > 10)
                    <div class="flex justify-center space-x-4 mt-4">
                        <button id="category-prev"
                            class="p-2 rounded-full shadow hover:shadow-md transition w-10 h-10 border border-gray-300 bg-white">
                            <i class="fa-solid fa-arrow-left text-black"></i>
                        </button>
                        <button id="category-next"
                            class="p-2 rounded-full shadow hover:shadow-md transition w-10 h-10 border border-gray-300 bg-[#7a5af8]">
                            <i class="fa-solid fa-arrow-right text-black"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @php
        use App\Models\Review;
    @endphp

    <!-- 🔹 Top Discount Section -->
    @if($allget->count() > 0)
    <section class="bg-white py-16 relative">
        <div class="max-w-[91rem] mx-auto px-4 text-center">
            <h2 class="text-[1.7rem] font-bold text-gray-800">Exclusive Benefits Just For You</h2>
            <p class="text-gray-500 mt-2">Don't miss these incredible limited-time offers</p>

        <div class="mt-12">

    {{-- 4-4 Offers Grid --}}
    <div id="offerContainer" class="offer-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        @foreach($allget as $offer)

            <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1">

                {{-- TOP Image Slider --}}
               <div class="relative overflow-hidden">

    <div class="swiper offerSlider">
        <div class="swiper-wrapper">
            @foreach(json_decode($offer->image, true) as $img)
                <div class="swiper-slide">
                    <img src="{{ asset('/uploads/offers/'.$img) }}"
                         class="w-full h-56 object-cover"/>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Discount Ribbon --}}
    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-lg z-20 shadow-md">
        -{{ $offer->discount }}%
    </span>

    {{-- Category Badge --}}
    <span class="absolute top-3 right-3 bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-lg z-20 shadow-md">
        {{ $offer->category->name }}
    </span>

</div>


                {{-- Content --}}
                <div class="p-5">

                    {{-- Title --}}
                    <h3 class="font-bold text-gray-800 text-[15px] text-left">
                        {{ Str::limit($offer->title, 30) }}
                    </h3>

                    {{-- Description 20 chars --}}
                    <p class="text-gray-600 text-sm mt-1 text-left">
                        {{ Str::limit($offer->description, 30) }}
                    </p>

                    {{-- Discount Price --}}
                    <div class="mt-3 text-left" >
                        <span class="text-lg font-extrabold text-green-600">
                            {{ $offer->discount }}% OFF
                        </span>
                    </div>

                    {{-- Visits + Expiry --}}
                    <div class="mt-3 text-sm text-gray-600 space-y-1 text-left">
                        <p>👀 40 Visits</p>
                        <p>⏳ Ends: {{ date('d/m/Y', strtotime($offer->expiry_datetime)) }}</p>
                    </div>

                    {{-- Button --}}
                    <a href="/detail/{{ $offer->id }}"
                       class="block text-center bg-[#7a5af8] text-white font-semibold py-3 rounded-xl mt-4
                       hover:bg-[#6845e0] transition">
                        View Benefit →
                    </a>

                </div>

            </div>

        @endforeach

    </div>

    {{-- Load More --}}
    <div class="text-center mt-8">
        <button id="loadMoreBtn"
                class="bg-[#7a5af8] text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition shadow-md">
            Load More
        </button>
    </div>

</div>

        </div>
    </section>

    @else
    {{-- <div class="bg-gradient-to-r from-yellow-200 via-yellow-100 to-yellow-200 py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 mx-auto bg-yellow-400 rounded-full shadow-lg mb-6 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1 4v-4h1m-1-4h.01M12 20h.01M12 4h.01M20 12h.01M4 12h.01M16.24 7.76h.01M7.76 16.24h.01M16.24 16.24h.01M7.76 7.76h.01" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Top Discount</h2>
            <p class="text-gray-600 text-lg">😔 Sorry! No offers available at the moment.</p>
        </div>
    </div>
    @endif
    {{-- @if($offers->where('discount', '>=', 50)->count() > 0)
    <section class="bg-white py-2 relative">
        <div class="max-w-[91rem] mx-auto px-4 text-center">
            <h2 class="text-[1.7rem] font-bold text-gray-800">Top Discount</h2>
            <p class="text-gray-500 mt-2">Don't miss these incredible limited-time offers</p>

            <div class="relative mt-12">
                <div id="deals-carousel"
                    class="flex space-x-6 overflow-x-auto scrollbar-hide scroll-smooth snap-x snap-mandatory">

                    @foreach($offers->where('discount', '>=', 50) as $offer)
                        @php
                            $ratings = Review::where('offer_id', $offer->id)->pluck('rating');
                            $averageRating = $ratings->count() > 0 ? round($ratings->avg(), 1) : 0;
                            $totalReviews = $ratings->count();
                        @endphp

                        <div
                            class="group relative min-w-[280px] bg-white rounded-xl shadow-md transition-all duration-300 overflow-hidden snap-start hover:-translate-y-2 hover:shadow-[0_8px_0px_rgba(198,199,200,0.7)]">
                            <div class="relative">
                                <img src="{{ asset('/uploads/offers/'.$offer->image) }}" alt="{{ $offer->title }}"
                                    class="w-full h-48 object-cover">
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">{{ $offer->discount }}% OFF</span>
                                <span class="absolute top-3 right-3 bg-gray-200 text-gray-700 text-xs font-semibold px-2 py-1 rounded">{{ $offer->category->name }}</span>
                            </div>

                            <div class="p-4 text-left flex flex-col justify-between h-[201px]">
                                <h3 class="text-sm font-semibold text-gray-800 leading-5 h-[40px] overflow-hidden text-ellipsis break-words">
                                    {!! nl2br(chunk_split(e($offer->title), 30, "\n")) !!}
                                </h3>

                                <div>
                                    <div class="flex items-center text-sm mt-2">
                                        <span class="text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </span>
                                        <span class="text-gray-600 text-xs ml-2">
                                            {{ $averageRating }} / 5 ({{ $totalReviews }} Reviews)
                                        </span>
                                    </div>

                                    <div class="mt-2">
                                        <span class="text-lg font-bold text-gray-800">$ {{ $offer->discount_price }}</span>
                                        <span class="text-gray-400 line-through text-sm ml-2">$ {{ $offer->price }}</span>
                                    </div>

                                    <a href="/detail/{{ $offer->id }}"
                                        class="block text-center border border-gray-300 text-blue-600 font-medium py-2 rounded hover:bg-[#7a5af8] hover:text-white transition mt-3">
                                        🎟️ View Benefit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($offers->where('discount', '>=', 50)->count() > 4)
                <div class="flex justify-center space-x-4 mt-6">
                    <button id="prev-btn" class="text-white p-3 rounded-full shadow hover:shadow-lg transition w-[46px] h-[46px] border border-[#bcf020e6]">
                        <i class="fa-solid fa-arrow-left text-black"></i>
                    </button>
                    <button id="next-btn" class="text-white p-3 rounded-full bg-[#7a5af8] shadow hover:shadow-lg transition w-[46px] h-[46px] border border-[#bcf020e6]">
                        <i class="fa-solid fa-arrow-right text-black"></i>
                    </button>
                </div>
                @endif

                <div class="mt-12">
                    <a href="#" class="custom-btn">View All Deals →</a>
                </div>
            </div>
        </div>
    </section>

    @else --}}
    <div class="bg-gradient-to-r from-yellow-200 via-yellow-100 to-yellow-200 py-20">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 mx-auto bg-yellow-400 rounded-full shadow-lg mb-6 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1 4v-4h1m-1-4h.01M12 20h.01M12 4h.01M20 12h.01M4 12h.01M16.24 7.76h.01M7.76 16.24h.01M16.24 16.24h.01M7.76 7.76h.01" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">No Offer</h2>
            <p class="text-gray-600 text-lg">😔 Sorry! No offers available at the moment.</p>
        </div>
    </div>
    @endif --}}
    {{-- @php
    use App\Models\Campaign;
    use App\Models\CampaignOffer;


    // 🔹 Get all unique campaign IDs from CampaignOffer
    $campaignIds = CampaignOffer::distinct()->pluck('campaign_id');

    // 🔹 Fetch campaigns with their offers
    $campaigns = Campaign::whereIn('id', $campaignIds)->with('offers')->get();
@endphp

<div class="max-w-[91rem] mx-auto px-6 py-12">

    @foreach($campaigns as $campaign)
        <section class="py-10 border-b border-gray-200 mb-10">
            <!-- 🔹 Campaign Title -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800">
                    🎉 {{ $campaign->event_name ?? 'Event' }} — {{ $campaign->campaign_name }}
                </h2>
                <p class="text-gray-600 mt-2">Check out amazing offers in this campaign!</p>
            </div>

            <!-- 🔹 Offers Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    // Get all offers for this campaign
                    $offers = CampaignOffer::where('campaign_id', $campaign->id)->get();
                @endphp

                @forelse($offers as $offer)
                    @php
                        // Get reviews and rating
                        $ratings = Review::where('offer_id', $offer->id)->pluck('rating');
                        $averageRating = $ratings->count() ? round($ratings->avg(), 1) : 0;
                        $totalReviews = $ratings->count();
                    @endphp

                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1">
                        <!-- Image -->
                        <div class="relative">
                            <img src="{{ asset('/uploads/offers/'.$offer->image) }}" alt="{{ $offer->title }}"
                                 class="w-full h-48 object-cover">
                            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded">
                                {{ $offer->discount }}% OFF
                            </span>
                            <span class="absolute top-3 right-3 bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                {{ $offer->category->name ?? 'General' }}
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-4 text-left">
                            <h3 class="text-sm font-semibold text-gray-800 leading-5 h-[40px] overflow-hidden text-ellipsis break-words">
                                {!! nl2br(chunk_split(e($offer->title), 30, "\n")) !!}
                            </h3>

                            <div class="flex items-center text-sm mt-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="text-gray-600 text-xs ml-2">
                                    {{ $averageRating }} / 5 ({{ $totalReviews }} Reviews)
                                </span>
                            </div>

                            <div class="mt-2">
                                <span class="text-lg font-bold text-gray-800">$ {{ $offer->discount_price }}</span>
                                <span class="text-gray-400 line-through text-sm ml-2">$ {{ $offer->price }}</span>
                            </div>

                            <a href="/detail/{{ $offer->id }}"
                               class="block text-center border border-gray-300 text-blue-600 font-medium py-2 rounded hover:bg-yellow-400 transition mt-3">
                                🎟️ View Benefit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-10">
                        🚫 No offers available for this campaign.
                    </div>
                @endforelse
            </div>
        </section>
    @endforeach

</div> --}}

         {{-- <section class="py-16" id="deals">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Title -->
        <div class="text-center">
            <h2 class="text-2xl font-extrabold text-gray-900">Trending Offers</h2>
            <p class="text-gray-600 mt-3 text-1xl">Popular deals that everyone are talking about</p>
        </div>

        <!-- Scrollable Cards -->
        <div class="relative mt-12">
            <div class="flex space-x-6 overflow-x-auto pb-6 scrollbar-hide snap-x snap-mandatory">

                @forelse($offersForBlade as $offer)
                    <div class="group relative min-w-[280px] bg-white rounded-xl
                        shadow-md transition-all duration-300
                        overflow-hidden snap-start
                        hover:-translate-y-2
                        hover:shadow-[0_8px_0px_rgba(198,199,200,0.7)]
                        active:shadow-[0_8px_30px_rgba(37,99,235,0.6)]">

                        <div class="relative">
                            <img src="{{ asset($offer->image ?? 'default-image.jpg') }}" alt="{{ $offer->name }}"
                                class="w-full h-44 object-cover">

                            <!-- Badges -->
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-gray-400 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                {{ $offer->discount }}% OFF
                            </span>
                            <span class="absolute top-3 right-3 bg-white/80 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full shadow">
                                {{ $offer->category->name ?? 'General' }}
                            </span>
                            <span class="absolute bottom-3 left-3 bg-gray-400 text-white text-xs px-3 py-1 rounded-full flex items-center shadow">
                                ⏰ {{ $offer->days_left ?? 2 }} days left
                            </span>
                        </div>

                        <div class="p-5 text-left">
                            <h3 class="text-base font-semibold text-gray-800 leading-snug">{{ $offer->name }}</h3>
                            <div class="mt-3">
                                <span class="text-lg font-bold text-gray-900">$ {{ $offer->discounted_price ?? $offer->price }}</span>
                                <span class="text-gray-400 line-through text-sm ml-2">$ {{ $offer->price }}</span>
                            </div>
                            <a href="#"
                                style="display:block; text-align:center; border:1px solid #e3e3e3; color:blue; font-weight:500; padding:8px; border-radius:6px; font-size:14px; transition:0.3s; text-decoration:none;"
                                onmouseover="this.style.background='#7a5af8'; this.style.color='white';"
                                onmouseout="this.style.background=''; this.style.color='blue';">
                                🎟️ Get Deal
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center w-full py-10">
                        <p class="text-gray-500 text-lg font-medium">🚫 No trending offers available at the moment.</p>
                    </div>
                @endforelse

            </div>
        </div>

        <!-- View All Deals Button -->
        @if($offersForBlade->count() > 0)
        <div class="mt-12 justify-center flex">
            <a href="#" class="custom-btn">
                View All Deals →
            </a>

            <style>
                .custom-btn {
                    border: 1px solid #e3e3e3;
                    color: blue;
                    font-weight: 500;
                    padding: 12px 32px;
                    border-radius: 8px;
                    transition: 0.3s;
                    display: inline-block;
                }

                .custom-btn:hover {
                    background: #f5e10e;
                    color: blue;
                }
            </style>
        </div>
        @endif

    </div>
</section> --}}



    <!-- 🔹 Top Discount Section -->
@php


    // Sabhi campaign-offers fetch
    $campaignOffers = \App\Models\CampaignOffer::with('campaign')->get();

    // Group by campaign_id
    $campaignGroups = $campaignOffers->groupBy('campaign_id');
@endphp

@foreach($campaignGroups as $campaignId => $offers)
    @php
        $campaign = \App\Models\Campaign::find($campaignId);
        if (!$campaign) continue;

        // Dates
        $now = Carbon::now();
        $today = Carbon::today();
        $startDate = Carbon::parse($campaign->start_date);
        $endDate = Carbon::parse($campaign->end_date);

        // Days left (for future dates)
        $daysLeft = $today->diffInDays($endDate, false);

        // Today end time (12 AM)
        $secondsLeft = null;
        if ($endDate->isToday()) {
            $secondsLeft = intval($now->diffInSeconds($endDate->endOfDay(), false));

        }

        // Agar already expire ho gaya
        if ($daysLeft < 0 && (!$secondsLeft || $secondsLeft <= 0)) continue;
    @endphp

    <!-- 🌟 EVENT SECTION -->
    <section class="relative py-24 overflow-hidden">

        <!-- Floating Lights -->
        <div class="absolute inset-0">
            <div class="absolute w-40 h-40 bg-pink-400/20 blur-3xl rounded-full -top-10 -left-10 animate-pulse"></div>
            <div class="absolute w-56 h-56 bg-yellow-300/20 blur-3xl rounded-full bottom-0 right-0 animate-ping"></div>
        </div>

        <div class="relative max-w-[90rem] mx-auto px-6">

            <!-- TITLE + DAYS LEFT / COUNTDOWN -->
            <div class="flex text-center justify-between">

                <!-- ⭐ Campaign Name -->


                <!-- ⭐ Countdown / Days Left -->
                {{-- Today ke liye LIVE countdown --}}
                @if($endDate->isToday() && $secondsLeft > 0)
                    <div id="countdown-{{ $campaignId }}"
                         class="bg-yellow-400 text-black px-5 py-2 rounded-full shadow-lg font-bold text-sm">
                        ⏳ Loading...
                    </div>

                    <script>
                        let seconds{{ $campaignId }} = {{ $secondsLeft }};
                        function countdown{{ $campaignId }}() {
                            if (seconds{{ $campaignId }} <= 0) {
                                document.getElementById('countdown-{{ $campaignId }}').style.display = 'none';
                                return;
                            }

                            let h = Math.floor(seconds{{ $campaignId }} / 3600);
                            let m = Math.floor((seconds{{ $campaignId }} % 3600) / 60);
                            let s = seconds{{ $campaignId }} % 60;

                            document.getElementById('countdown-{{ $campaignId }}').innerHTML =
                                `⏳ Ends Today: ${h}h ${m}m ${s}s`;

                            seconds{{ $campaignId }}--;
                        }
                        countdown{{ $campaignId }}();
                        setInterval(countdown{{ $campaignId }}, 1000);
                    </script>

                {{-- Future date ke liye days left --}}
                @elseif($daysLeft >= 0)
                    <div class="bg-red-600 text-white px-5 py-2 rounded-full shadow-lg font-bold text-sm">
                        ⏳ {{ $daysLeft }} Days Left
                    </div>
                @endif

            </div>
            <h2 class="text-3xl font-extrabold text-black text-center tracking-wide">
                    🎉 {{ $campaign->campaign_name }} 🎉
                </h2>
<p class="text-black/70 mt-3 text-lg text-center">
    Exclusive Limited-Time Mega Deals
</p>
            <div class="relative mt-16">

                <!-- ⭐ Carousel -->
                <div class="flex space-x-8 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-8">

                    @foreach($offers as $offer)
                        <!-- ⭐ Offer Card -->
                        <div class="snap-start min-w-[300px] group bg-white/10 backdrop-blur-xl
                                    border border-white/20 rounded-3xl shadow-xl overflow-hidden
                                    transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">

                            <!-- ⭐ Image -->
                            <div class="relative">
                                <img src="{{ asset('/uploads/offers/'.$offer->image) }}"
                                     class="w-full h-60 object-cover">

                                <span class="absolute top-4 left-4 bg-gradient-to-r from-red-600 to-pink-500
                                             text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    {{ $offer->discount }}% OFF
                                </span>

                                <span class="absolute top-3 right-3 bg-white/80 text-gray-800 text-xs font-semibold px-2 py-1 rounded-full shadow">
                                    {{ $offer->category->name ?? 'General' }}
                                </span>
                            </div>

                            <!-- ⭐ Details -->
                            <div class="p-5 text-left h-[220px] flex flex-col justify-between">

                                <h3 class="text-lg text-black font-semibold leading-6 line-clamp-2">
                                    {{ $offer->title }}
                                </h3>

                                <div class="mt-2">
                                    <span class="text-2xl font-bold text-black">${{ $offer->discount_price }}</span>
                                    <span class="text-black/60 line-through ml-2">${{ $offer->price }}</span>

                                    <a href="/detail/{{ $offer->id }}?campaign_id={{ $offer->id }}"
                                       class="mt-5 block text-center bg-gradient-to-r from-yellow-400 to-orange-400
                                              text-gray-900 font-extrabold py-3 rounded-xl shadow-lg hover:scale-105
                                              transition-all">
                                        🎟️ View Benefit
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>

    </section>
@endforeach





</div>

<!-- ✅ Prevent Horizontal Scroll -->
<style>
    body {
        overflow-x: hidden !important;
    }
</style>



@endsection
@section('javascript')

<script>
document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".category-item");
    const nextBtn = document.getElementById("category-next");
    const prevBtn = document.getElementById("category-prev");

    const itemsPerPage = 16;
    let currentPage = 0;

    function showPage(page) {
        items.forEach((item, index) => {
            item.classList.add("hidden");
            if (index >= page * itemsPerPage && index < (page + 1) * itemsPerPage) {
                item.classList.remove("hidden");
            }
        });

        // Disable buttons if no more pages
        if (prevBtn) prevBtn.disabled = page === 0;
        if (nextBtn) nextBtn.disabled = (page + 1) * itemsPerPage >= items.length;

        // Optional: smooth scroll to top after switching page
        document.getElementById('category-container').scrollIntoView({ behavior: 'smooth' });
    }

    if (nextBtn && prevBtn) {
        nextBtn.addEventListener("click", function () {
            if ((currentPage + 1) * itemsPerPage < items.length) {
                currentPage++;
                showPage(currentPage);
            }
        });

        prevBtn.addEventListener("click", function () {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });
    }

    // Initialize first page
    showPage(0);
});
</script>
<script>
function toggleTitle(id, fullText) {
    let shortEl = document.getElementById('short-' + id);
    if(shortEl.dataset.expanded == 'true') {
        // Collapse
        shortEl.innerHTML = fullText.substring(0, 12);
        shortEl.dataset.expanded = 'false';
    } else {
        // Expand with line breaks
        let wrappedText = '';
        let lineLength = 25; // 15 characters per line
        for(let i = 0; i < fullText.length; i += lineLength){
            wrappedText += fullText.substr(i, lineLength) + '<br>';
        }
        shortEl.innerHTML = wrappedText;
        shortEl.dataset.expanded = 'true';
    }
}
</script>







@endsection
