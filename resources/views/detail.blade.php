@extends('landing')
@section('content')
    {{-- <section class="bg-white py-16">
        <div class="max-w-[68rem] mx-auto px-6 flex flex-col lg:flex-row items-center lg:items-start justify-between gap-6">

            <!-- Left Column: Title + Links + Rating -->
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                    {!! nl2br(chunk_split(e($offer->title . ' (Up to ' . $offer->discount . '% Off).'), 34, "\n")) !!}
                </h1>


                <div class="mt-2 flex flex-wrap justify-center lg:justify-start items-center gap-2 text-sm text-gray-600">
                    <a href="#" class="flex items-center gap-1 hover:underline">
                        <i class="fa-solid fa-building"></i>
                        {{ $offer->business->shop_name }}
                    </a>

                    <span class="text-gray-400">|</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 shrink-0">
                        <g clip-path="url(#clip0_5393_18120)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.99977 1.3335C7.40665 1.3335 4.66644 3.29887 4.66644 6.66683C4.66644 7.44723 4.9878 8.40407 5.52202 9.43701C6.05078 10.4594 6.76153 11.5065 7.48126 12.454C8.19967 13.3997 8.9193 14.2361 9.4599 14.8366C9.67121 15.0713 9.85479 15.2695 9.99977 15.4237C10.1448 15.2695 10.3283 15.0713 10.5396 14.8366C11.0802 14.2361 11.7999 13.3997 12.5183 12.454C13.238 11.5065 13.9488 10.4594 14.4775 9.43701C15.0117 8.40407 15.3331 7.44723 15.3331 6.66683C15.3331 3.29887 12.5929 1.3335 9.99977 1.3335ZM9.99977 16.146C9.64484 16.4982 9.64476 16.4981 9.64467 16.498L9.64436 16.4977L9.64335 16.4967L9.63976 16.493L9.62638 16.4794L9.57579 16.4277C9.53183 16.3824 9.46786 16.3162 9.38673 16.2308C9.22452 16.0602 8.99355 15.8131 8.71673 15.5057C8.16358 14.8913 7.42488 14.0329 6.68495 13.0589C5.94634 12.0865 5.19876 10.9888 4.63378 9.89639C4.07424 8.81449 3.66644 7.68643 3.66644 6.66683C3.66644 2.65145 6.95456 0.333496 9.99977 0.333496C13.045 0.333496 16.3331 2.65145 16.3331 6.66683C16.3331 7.68643 15.9253 8.81449 15.3658 9.89639C14.8008 10.9888 14.0532 12.0865 13.3146 13.0589C12.5747 14.0329 11.836 14.8913 11.2828 15.5057C11.006 15.8131 10.775 16.0602 10.6128 16.2308C10.5317 16.3162 10.4677 16.3824 10.4238 16.4277L10.3732 16.4794L10.3598 16.493L10.3562 16.4967L10.3552 16.4977L10.3549 16.498C10.3548 16.4981 10.3547 16.4982 9.99977 16.146ZM9.99977 16.146L10.3547 16.4982L9.99977 16.8559L9.64484 16.4982L9.99977 16.146ZM1.21923 18.9432L3.71923 13.9432L4.61365 14.3904L2.47546 18.6668H17.5241L15.3859 14.3904L16.2803 13.9432L18.7803 18.9432L19.1421 19.6668H18.3331H1.66644H0.857422L1.21923 18.9432ZM8.83311 6.66683C8.83311 6.0225 9.35544 5.50016 9.99977 5.50016C10.6441 5.50016 11.1664 6.0225 11.1664 6.66683C11.1664 7.31116 10.6441 7.8335 9.99977 7.8335C9.35544 7.8335 8.83311 7.31116 8.83311 6.66683ZM9.99977 4.50016C8.80316 4.50016 7.83311 5.47021 7.83311 6.66683C7.83311 7.86345 8.80316 8.8335 9.99977 8.8335C11.1964 8.8335 12.1664 7.86345 12.1664 6.66683C12.1664 5.47021 11.1964 4.50016 9.99977 4.50016Z"
                                fill="currentColor"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_5393_18120">
                                <rect width="20" height="20" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    <div class="flex items-center gap-1 text-gray-700">

                        <span class="font-medium">{{ $offer->business->location }}</span>

                    </div>
                </div>
                <br>
                <div class="lg:col-span-2 relative bg-white rounded-xl shadow overflow-hidden">
                    <img src="{{ asset('uploads/offers/' . $offer->image) }}" alt="Valvoline shop"
                        class="w-full h-96 object-cover" />

                    <!-- Top Right Icon -->


                </div>
                <div class="gap-4 flex flex-wrap mb-8 relative" style="margin-top: 20px">
                    <button class="tab-btn active font-semibold px-6 py-3 transition border-b-2 border-blue-600"
                        data-tab="about">About To</button>
                    <button class="tab-btn font-semibold px-6 py-3 transition" data-tab="redeem">Where To Redeem</button>
                   <button
    class="tab-btn font-semibold px-6 py-3 transition {{ auth()->check() ? '  font-semibold' : ' cursor-not-allowed' }}"
    data-tab="code"
    {{ auth()->check() ? '' : 'disabled' }}
>
    Get A Code
</button>

                </div>

                <hr style="background: black;height:2px">

                <!-- About Content -->
                <div id="about" class="tab-content">
                    <p class="text-sm text-gray-700 transition-all duration-300" id="desc-{{ $offer->id }}">
                        <span id="short-desc-{{ $offer->id }}">
                            {!! nl2br(chunk_split(e($offer->description), 80, "\n")) !!}
                        </span>
                    </p>
                </div>


                <!-- Where To Redeem Content -->
                <div id="redeem" class="tab-content" style="display:none;">
                    <br>
                    <iframe
                        src="https://www.google.com/maps?q={{ $offer->business->latitude }},{{ $offer->business->longitude }}&hl=es;z=15&output=embed"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>

                </div>

                <!-- Get A Code Content -->
       @php
use Illuminate\Support\Facades\Auth;
use App\Models\UserRedeem;
use App\Models\Review;

$userId = Auth::id();

// Normal offer id → /detail/13
$offerId = request()->segment(2);

// Check if URL contains campaign_id
$campaignId = request()->query('campaign_id');

$alreadyRedeemed = false;
$alreadyReviewed = false;

if ($userId) {

    if ($campaignId) {
        // ⭐ CAMPAIGN REDEEM CHECK
        $alreadyRedeemed = UserRedeem::where('user_id', $userId)
            ->where('campaign_id', $campaignId)
            ->exists();

        // ⭐ CAMPAIGN REVIEW CHECK
        $alreadyReviewed = Review::where('user_id', $userId)
            ->where('campaign_id', $campaignId)
            ->exists();

    } else {
        // ⭐ NORMAL OFFER REDEEM CHECK
        $alreadyRedeemed = UserRedeem::where('user_id', $userId)
            ->where('offer_id', $offerId)
            ->exists();

        // ⭐ NORMAL REVIEW CHECK
        $alreadyReviewed = Review::where('user_id', $userId)
            ->where('offer_id', $offerId)
            ->exists();
    }
}
@endphp


<div id="code" class="tab-content" style="display:none;">
    <span style="display:flex; justify-content:center; align-items:center; width:100%; margin-top:20px;">

        @if($alreadyReviewed)
            <!-- ✅ Agar review already diya hai -->
            <div style="padding:10px 20px;background:#e0f7fa;color:#00695c;
                        font-weight:bold;border-radius:8px;border:solid #b2dfdb 1px;
                        box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                🌟 Thank you for your review!
            </div>

        @elseif($alreadyRedeemed)
            <!-- ✅ Agar redeem kar liya hai but review nahi diya -->
            <button onclick="openReviewModal()"
                style="padding:10px 20px;background:white;color:green;
                       font-weight:bold;border-radius:5px;border:solid #e3e3e3 1px;
                       box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                Give Review
            </button>

        @else
            <!-- ✅ Agar redeem nahi kiya hai -->
            <button id="openModal"
                style="padding:10px 20px;background:white;color:blue;
                       font-weight:bold;border-radius:5px;border:solid #e3e3e3 1px;
                       box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                Show My Code
            </button>
        @endif

    </span>
</div>




                <!-- Modal -->

                <div id="voucherModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="bg-white rounded-xl w-96 p-6 relative">
                        <!-- Close button -->
                        <button id="closeModal"
                            class="absolute top-3 right-3 text-gray-500 font-bold text-xl">&times;</button>

                        <!-- Top Image -->
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('/voucher.png') }}" alt="Voucher Image"
                                class="rounded-full w-[200px] h-[200px] sm:w-[150px] sm:h-[150px] md:w-[200px] md:h-[200px] object-cover">
                        </div>


                        <!-- Voucher Code -->
                        @php
    use Illuminate\Support\Str;
    $voucherCode = 'VC-' . strtoupper(Str::random(8));
@endphp

<div class="text-center mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Your Voucher Code</h2>
    <p class="mt-2 text-2xl font-bold text-blue-600">{{ $voucherCode }}</p>
      <input type="hidden" id="hiddenVoucherCode" value="{{ $voucherCode }}">
</div>


                        <!-- Claim Button -->
                        <div class="flex justify-center">
                            <button id="claimBtn" data-offer="{{ $offer->id }}"
                                class="bg-blue-600 text-white px-6 py-2 rounded-md font-medium hover:bg-blue-700 transition">
                                Claim
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Reviews Card -->
            <aside class="w-full lg:w-96">
                <div class="bg-white rounded-xl shadow p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Reviews</h2>
                        <div class="text-sm text-gray-500">
                            @php
    $campaignIdFromUrl = request()->campaign_id;
    $userId = auth()->id();
    $offerId = $offeridcheck; // tumhare code me jo offer id aa raha hai

    // CONDITION 1: URL me campaign_id hai
    if ($campaignIdFromUrl) {
        $reviews = \App\Models\Review::with('user')
            ->where('campaign_id', $campaignIdFromUrl)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    // CONDITION 2: URL me campaign_id NA HO
    else {
        $reviews = \App\Models\Review::with('user')
            ->where('offer_id', $offerId)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    $avgRating = $reviews->avg('rating');
@endphp

                            {{ number_format($avgRating, 1) }} ★ ({{ $reviews->count() }} reviews)
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @foreach ($reviews as $review)
                            <div class="border rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div class="font-medium text-gray-800">{{ $review->user->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        @for ($i = 1; $i <= $review->rating; $i++)
                                            ⭐
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>



        </div>
    </section>
    <!-- ✅ Button to Open Modal -->


    <!-- ✅ Review Modal -->
    <!-- 🌟 Review Modal -->
    <!-- 🌟 Review Modal -->
    <div id="reviewModal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 transition-all duration-300">
        <div
            class="bg-gradient-to-br from-white to-gray-100 rounded-3xl shadow-2xl w-[90%] md:w-[420px] p-6 relative animate__animated animate__fadeInUp">

            <!-- ❌ Close Button -->
            <button onclick="closeReviewModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl transition-all duration-200">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- 🏆 Title -->
            <h2 class="text-2xl font-extrabold text-center text-black mb-5">
                Rate this Offer
            </h2>

            <!-- ⭐ Star Rating -->
            <div class="flex justify-center mb-5 space-x-2" id="starContainer">
                <svg onclick="setRating(1)" id="star1"
                    class="w-9 h-9 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.748l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.595 0 9.748l8.332-1.593z" />
                </svg>
                <svg onclick="setRating(2)" id="star2"
                    class="w-9 h-9 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.748l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.595 0 9.748l8.332-1.593z" />
                </svg>
                <svg onclick="setRating(3)" id="star3"
                    class="w-9 h-9 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.748l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.595 0 9.748l8.332-1.593z" />
                </svg>
                <svg onclick="setRating(4)" id="star4"
                    class="w-9 h-9 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.748l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.595 0 9.748l8.332-1.593z" />
                </svg>
                <svg onclick="setRating(5)" id="star5"
                    class="w-9 h-9 cursor-pointer text-gray-300 hover:text-yellow-400 transition-all duration-200"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 .587l3.668 7.568L24 9.748l-6 5.847L19.335 24 12 19.897 4.665 24 6 15.595 0 9.748l8.332-1.593z" />
                </svg>
            </div>

            <!-- ✍ Review Form -->
            @php
    $campaignId = request()->campaign_id;
@endphp

       <form id="reviewForm" class="space-y-3">
    @csrf

    <!-- Offer ID: only if NO campaign_id in URL -->
    <input type="hidden" name="offer_id" value="{{ $campaignId ? '' : $offeridcheck }}">

    <!-- Campaign ID from URL -->
    <input type="hidden" name="campaign_id" value="{{ $campaignId ?? '' }}">

    <input type="hidden" name="rating" id="ratingValue" value="0">

    <textarea name="comment" rows="3" placeholder="Share your experience..."
        class="w-full border-2 border-gray-300 text-black rounded-2xl p-3 text-sm"></textarea>

    <button type="submit"
        class="w-full bg-white border border-yellow-400 text-black py-2.5 rounded-2xl">
        Submit Review
    </button>
</form>



            <!-- 📝 Footer -->
            <p class="text-center text-gray-600 text-xs mt-3">
                Your feedback helps others make better decisions 💬
            </p>
        </div>
    </div> --}}
<div class="max-w-6xl mx-auto p-4">

    <!-- Wrapper -->
    <div class="bg-white rounded-xl shadow-md p-4
                flex flex-col md:flex-row gap-6">

        <!-- IMAGE LEFT (ON DESKTOP) / TOP (ON MOBILE) -->
        <div class="md:w-1/2 w-full relative">

    <!-- Slider main container -->
    <div class="swiper myOfferSlider rounded-xl">
        <div class="swiper-wrapper">
            @foreach(json_decode($offer->image, true) as $img)
                <div class="swiper-slide">
                    <img src="{{ asset('uploads/offers/' . $img) }}"
                         class="w-full h-[22rem] rounded-xl object-cover">
                </div>
            @endforeach
        </div>

        <!-- Arrows -->
        <div class="swiper-button-prev !text-white"></div>
        <div class="swiper-button-next !text-white"></div>
    </div>
</div>


        <!-- RIGHT SIDE CONTENT -->
        <div class="md:w-1/2 w-full flex flex-col gap-3">

            <h2 class="text-3xl font-bold text-gray-900">
                {{$offer->title}}
            </h2>

            <p class="text-gray-700">
                <strong>Location:</strong> {{ $offer->business->location }}
            </p>

            <p class="text-green-600 text-2xl font-bold">
                {{ $offer->discount }}% discount
            </p>

            <span class="inline-block bg-green-500 text-white text-sm rounded-md px-3 py-1 w-fit">
                Available
            </span>

            <!-- BUTTONS -->
            <button onclick="openClaimModal()"
    class="w-full bg-orange-500 text-white py-3 rounded-lg text-lg font-medium">
    How to claim
</button>


            <button class="w-full bg-teal-600 text-white py-3 rounded-lg text-lg font-medium">
                Go to site
            </button>

            <button onclick="openReportModal()"
        class="w-full bg-red-600 text-white py-3 rounded-lg text-lg font-medium">
    Report
</button>


            <p class="text-gray-500 text-sm">
                Valid until: {{ \Carbon\Carbon::parse($offer->expiry_datetime)->format('F d, Y – h:i A') }}

            </p>

        </div>

    </div>

</div>
<!-- 🔹 MAIN WRAPPER -->
<div class="max-w-6xl mx-auto mt-10 px-4">



    <!-- 🔹 INFO SECTION (Description + Map) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mt-10">

        <!-- ===========================
             LEFT SIDE — DESCRIPTION
        ============================== -->
        <div class="lg:col-span-2">

            <h2 class="text-2xl font-bold mb-4">Coupon Description</h2>

            <p class="text-gray-700 leading-relaxed mb-4">
    {!! nl2br(e(wordwrap($offer->description, 70, "\n", true))) !!}
</p>




            <!-- Terms of use -->
            <h3 class="text-xl font-bold mt-10 mb-2">Terms of Use</h3>

            <ul class="list-disc ml-6 text-gray-700 space-y-2">
                <li>Valid as indicated by the merchant</li>
                <li>Present digital coupon upon entry</li>
            </ul>
                        <h2 class="text-2xl font-bold mb-4 mt-3">User Review</h2>
<div class="bg-white rounded-xl shadow p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Reviews</h2>
                        <div class="text-sm text-gray-500">
                            @php
    $campaignIdFromUrl = request()->campaign_id;
    $userId = auth()->id();
    $offerId = $offeridcheck; // tumhare code me jo offer id aa raha hai

    // CONDITION 1: URL me campaign_id hai
    if ($campaignIdFromUrl) {
        $reviews = \App\Models\Review::with('user')
            ->where('campaign_id', $campaignIdFromUrl)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    // CONDITION 2: URL me campaign_id NA HO
    else {
        $reviews = \App\Models\Review::with('user')
            ->where('offer_id', $offerId)
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    $avgRating = $reviews->avg('rating');
@endphp

                            {{ number_format($avgRating, 1) }} ★ ({{ $reviews->count() }} reviews)
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4">
                        @foreach ($reviews as $review)
                            <div class="border rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div class="font-medium text-gray-800">{{ $review->user->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        @for ($i = 1; $i <= $review->rating; $i++)
                                            ⭐
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
           @php
           use Illuminate\Support\Facades\Auth;
use App\Models\UserRedeem;
use App\Models\Review;
$userId = Auth::id();

// Normal offer id → /detail/13
$offerId = request()->segment(2);

// Check campaign or normal
$campaignId = request()->query('campaign_id');

$alreadyReviewed = false;

if ($userId) {

    if ($campaignId) {
        // Only review check for campaign
        $alreadyReviewed = \App\Models\Review::where('user_id', $userId)
            ->where('campaign_id', $campaignId)
            ->exists();

    } else {
        // Only review check for normal
        $alreadyReviewed = \App\Models\Review::where('user_id', $userId)
            ->where('offer_id', $offerId)
            ->exists();
    }
}
@endphp



<!-- UI -->
<div style="display:flex; justify-content:center; margin-top:20px;margin-bottom:20px;">

    @if($alreadyReviewed)
        <!-- ⭐ Review Exists -->
        <div style="padding:10px 20px; background:#e0f7fa;
                    color:#00695c; font-weight:bold;
                    border-radius:8px; border:1px solid #b2dfdb;">
            🌟 Thank you for your review!
        </div>

    @else
        <!-- ⭐ Show Only "Give Review" -->
        <button onclick="openReviewModal()"
            style="padding:10px 20px; background:white; color:green;
                   font-weight:bold; border-radius:5px;
                   border:1px solid #e3e3e3;
                   box-shadow:0 2px 6px rgba(0,0,0,0.1);">
            Give Review
        </button>
    @endif

</div>




        </div>


        <!-- ===========================
             RIGHT SIDE — MAP
        ============================== -->
        <div>
            <h2 class="text-2xl font-bold mb-4">Location</h2>

            <iframe
                        src="https://www.google.com/maps?q={{ $offer->business->latitude }},{{ $offer->business->longitude }}&hl=es;z=15&output=embed"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
        </div>

    </div>
</div>
<!-- Claim Modal -->
<div id="claimModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-11/12 max-w-md p-6 relative">

        <!-- Close Button -->
        <button onclick="closeClaimModal()"
                class="absolute right-4 top-4 text-gray-500 hover:text-gray-700 text-2xl">
            &times;
        </button>

        <!-- Modal Title -->
        <h2 class="text-xl font-semibold mb-4">How to claim your coupon</h2>

        <!-- Modal Text -->
        <p class="text-gray-700 leading-relaxed">
            To redeem this coupon, visit the store and show your CashCash card.
            The staff will give you the discount and explain the details of the promotion.
        </p>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 mt-6">

            <button onclick="window.location.href='#'"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                View credential
            </button>

            <button onclick="closeClaimModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                Close
            </button>

        </div>

    </div>
</div>
<!-- 🔴 REPORT MODAL -->
<div id="reportModal"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-[9999]">

    <div class="bg-white rounded-xl shadow-xl w-[90%] sm:w-[500px] p-5">

        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-xl font-semibold">Report coupon problem</h2>
            <button onclick="closeReportModal()" class="text-gray-500 text-2xl">&times;</button>
        </div>

        <div class="mt-4">
            <label class="font-medium text-gray-700">Problem description</label>
            <textarea id="reportText"
                      class="w-full border rounded-lg p-3 mt-2 h-32 focus:ring focus:ring-red-300"
                      placeholder="Describe the issue..."></textarea>
        </div>

        <div class="flex justify-end gap-3 mt-5">
            <button onclick="sendReport()"
                    class="bg-red-600 text-white px-5 py-2 rounded-lg">
                Send report
            </button>

            <button onclick="closeReportModal()"
                    class="bg-gray-300 text-gray-700 px-5 py-2 rounded-lg">
                Close
            </button>
        </div>

    </div>
</div>


@endsection
@section('javascript')
<script>
    function openClaimModal() {
        document.getElementById('claimModal').classList.remove('hidden');
    }

    function closeClaimModal() {
        document.getElementById('claimModal').classList.add('hidden');
    }
</script>
<script>
function openReportModal() {
    document.getElementById("reportModal").classList.remove("hidden");
}

function closeReportModal() {
    document.getElementById("reportModal").classList.add("hidden");
}

function sendReport() {
    let message = document.getElementById("reportText").value.trim();

    if (message === "") {
        alert("Please enter the problem details.");
        return;
    }

    // Yahan AJAX ya form submit karna hoga
    alert("Report sent successfully!");

    closeReportModal();
}
</script>

    <script>
        function toggleDescription(id, fullText) {
            let shortEl = document.getElementById('short-desc-' + id);
            if (shortEl.dataset.expanded == 'true') {
                // Collapse
                shortEl.innerHTML = fullText.substring(0, 75);
                shortEl.dataset.expanded = 'false';
            } else {
                // Expand with line breaks
                let wrappedText = '';
                let lineLength = 75; // 15 characters per line
                for (let i = 0; i < fullText.length; i += lineLength) {
                    wrappedText += fullText.substr(i, lineLength) + '<br>';
                }
                shortEl.innerHTML = wrappedText;
                shortEl.dataset.expanded = 'true';
            }
        }
    </script>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tab = this.dataset.tab;

                // Tab content toggle
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.style.display = (content.id === tab) ? 'block' : 'none';
                });

                // Active class toggle
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'border-b-2', 'border-blue-600');
                });
                this.classList.add('active', 'border-b-2', 'border-blue-600');
            });
        });
    </script>


    <script>
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const modal = document.getElementById('voucherModal');

        openModal.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Click outside modal closes it
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>
    <script>
        let currentRating = 0;

        // 🔹 Review Modal Open/Close
        function openReviewModal() {
            document.getElementById('reviewModal').classList.remove('hidden');
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        // 🔹 Star Rating Selection
        function setRating(rating) {
            currentRating = rating;
            document.getElementById('ratingValue').value = rating;

            for (let i = 1; i <= 5; i++) {
                document.getElementById(`star${i}`).classList.remove('text-yellow-400');
                document.getElementById(`star${i}`).classList.add('text-gray-400');
            }

            for (let i = 1; i <= rating; i++) {
                document.getElementById(`star${i}`).classList.remove('text-gray-400');
                document.getElementById(`star${i}`).classList.add('text-yellow-400');
            }
        }

        // 🔹 jQuery — Voucher Redeem Request
        $(document).ready(function() {
       $('#claimBtn').click(function() {
    var offerId = $(this).data('offer');
    var voucherCode = $('#hiddenVoucherCode').val();
    var campaignId = "{{ request()->campaign_id }}"; // URL se get

    $.ajax({
        url: "{{ route('redeem.vouchers') }}",
        type: "POST",
        data: {
            offer_id: campaignId ? null : offerId,       // 🔥 agar campaign mode hai → null
            actual_offer_id: offerId,                    // 🔥 real offer id
            campaign_id: campaignId,                     // 🔥 campaign id send
            voucher_code: voucherCode,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            toastr.success(response.message);

            if (response.voucher_code) {
                Swal.fire({
                    icon: 'success',
                    title: 'Your Voucher Code',
                    html: `<strong style="font-size: 20px; color: #2563eb;">${response.voucher_code}</strong>`,
                    confirmButtonText: 'OK'
                });
            }
        }
    });
});


        });

        // 🔹 Submit Review via AJAX (Fetch)
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/reviews', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // ✅ Success Message
                        toastr.success(data.message || 'Review added successfully!');

                        closeReviewModal();
                        closeModal.click();
                        this.reset();
                        setRating(0);
                    } else {
                        // ❌ Error Message
                        toastr.error(data.message || 'You have already reviewed this offer.');
                        closeReviewModal();
                        closeModal.click();
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Something went wrong!');
                });
        });
    </script>
    <script>
    var swiper = new Swiper(".myOfferSlider", {
        loop: true,
        autoplay: {
            delay: 10000, // 20 seconds
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        effect: "slide",
        speed: 600,
    });
</script>
@endsection
