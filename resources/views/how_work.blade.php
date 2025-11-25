@extends('landing')

@section('content')
<style>
  html, body {
    overflow-x: hidden; /* Prevent unwanted scroll */
  }
</style>
<section class="relative bg-gradient-to-br from-white via-yellow-50 to-blue-50 py-16 overflow-hidden">
    <!-- Decorative background -->
    <div class="absolute -top-16 -left-16 w-56 h-56 bg-yellow-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-blue-300 rounded-full blur-3xl opacity-30"></div>

    <div class="relative max-w-5xl mx-auto px-4 text-center">
        <!-- Main Heading -->
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-4">
            How <span class="text-yellow-500">CashCash</span> Works
        </h1>
        <p class="text-gray-600 text-sm max-w-2xl mx-auto leading-relaxed mb-10">
            Discover how easy it is to save big with CashCash. Whether you're a shopper or a business partner,
            our platform connects you to Argentina’s best deals in just a few simple steps.
        </p>

        <!-- Steps -->
        <div class="grid md:grid-cols-3 gap-6 text-left">

            <!-- Step 1 -->
            <div class="group bg-white border border-gray-100 shadow-md rounded-xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="bg-yellow-400 text-white w-10 h-10 flex items-center justify-center rounded-full mb-3">1</div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Find Your Offer</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Browse through a wide range of offers — from food and fashion to beauty and travel.
                    Each deal is verified and updated daily for the best savings.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="group bg-white border border-gray-100 shadow-md rounded-xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="bg-blue-500 text-white w-10 h-10 flex items-center justify-center rounded-full mb-3">2</div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Grab a Voucher</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Click to get your unique voucher code instantly. It’s 100% free — no hidden charges,
                    no hassle, just pure savings at your favorite stores.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="group bg-white border border-gray-100 shadow-md rounded-xl p-6 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="bg-green-500 text-white w-10 h-10 flex items-center justify-center rounded-full mb-3">3</div>
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">Redeem & Save</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Show your voucher at the partner store or apply it online — and enjoy instant discounts.
                    The more you use, the more you save with CashCash.
                </p>
            </div>

        </div>

        <!-- Extra Info -->
        <div class="mt-12 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-2xl p-6 shadow-lg max-w-3xl mx-auto">
            <h3 class="text-base sm:text-lg font-bold mb-3">💡 For Businesses</h3>
            <p class="text-sm leading-relaxed">
                Partnering with CashCash means more visibility, more customers, and more sales.
                Create your offers, track redemptions, and grow your business effortlessly.
            </p>
        </div>

        <!-- CTA -->
        <div class="mt-10">
            <a href="/"
               class="inline-block bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full text-sm
                      hover:bg-yellow-600 transition duration-300 shadow-md hover:shadow-lg">
                🎟️ Start Saving Now
            </a>
        </div>

        <!-- Tagline -->
        <div class="mt-10 text-gray-600 italic text-sm">
            “CashCash Argentina — <span class="text-yellow-500 font-semibold">Simple. Smart. Saving.</span>”
        </div>
    </div>
</section>
@endsection
