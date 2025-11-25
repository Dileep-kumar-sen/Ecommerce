@extends('landing')

@section('content')
<style>
  html, body {
    overflow-x: hidden; /* Prevent unwanted scroll */
  }
</style>

<section class="relative bg-gradient-to-br from-blue-50 via-white to-yellow-50 py-16 overflow-hidden max-w-screen">
    <!-- Decorative background circles -->
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-200 rounded-full blur-2xl opacity-40"></div>
    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-blue-200 rounded-full blur-2xl opacity-40"></div>

    <div class="relative max-w-5xl mx-auto px-4 text-center">

        <!-- Main Heading -->
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-4 leading-tight">
             Welcome to <span class="text-yellow-500">CashCash</span>
        </h1>
        <p class="max-w-xl mx-auto text-gray-600 text-sm mb-8 leading-relaxed">
            Argentina’s #1 destination for exclusive coupons, vouchers, and unbeatable discounts —
            making saving money as easy as one click.
        </p>

        <!-- Info Cards -->
        <div class="grid md:grid-cols-2 gap-6 text-left">

            <!-- For Shoppers -->
            <div class="group bg-white shadow-md rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-yellow-400 text-white p-2 rounded-md text-base">💰</div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">For Shoppers</h2>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-2">
                    Get instant access to Argentina’s hottest deals — from cafés and restaurants to salons, travel, and more.
                    At CashCash, saving is a daily habit.
                </p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Browse offers, grab your <strong>voucher</strong>, and enjoy real savings — no fees, no surprises.
                </p>
            </div>

            <!-- For Businesses -->
            <div class="group bg-white shadow-md rounded-xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-2 mb-2">
                    <div class="bg-blue-500 text-white p-2 rounded-md text-base">🏪</div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800">For Businesses</h2>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-2">
                    Partner with us and reach thousands of smart Argentine shoppers every day. Boost your
                    brand visibility and grow faster.
                </p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Manage offers, share digital vouchers, and increase your revenue — all with <strong>CashCash Business</strong>.
                </p>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="mt-12 relative">
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white py-8 px-5 rounded-2xl shadow-xl transform hover:scale-[1.02] transition duration-300">
                <h2 class="text-base sm:text-lg font-bold mb-3">🌎 Our Mission</h2>
                <p class="max-w-2xl mx-auto text-sm leading-relaxed">
                    To transform Argentina’s discount culture by connecting shoppers with real savings and empowering local businesses.
                </p>
            </div>
        </div>

        <!-- Vision / Extra Info -->
        <div class="mt-10 text-gray-700 max-w-3xl mx-auto">
            <h3 class="text-base sm:text-lg font-semibold mb-2">✨ Our Vision</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                We believe saving money should be simple and fun. CashCash is building a community
                where every purchase feels like a win.
            </p>
        </div>

        <!-- CTA -->
        <div class="mt-10">
            <a href="/login"
               class="inline-block bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full text-sm
                      hover:bg-yellow-600 transition duration-300 shadow-md hover:shadow-lg">
                 Join CashCash Today
            </a>
        </div>

        <!-- Tagline -->
        <div class="mt-10 text-gray-600 italic text-sm">
            “CashCash Argentina — <span class="text-yellow-500 font-semibold">Where every deal counts.</span>”
        </div>
    </div>
</section>
@endsection
