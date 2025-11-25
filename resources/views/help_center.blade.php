@extends('landing')

@section('content')
<style>
  html, body {
    overflow-x: hidden; /* Prevent unwanted scroll */
  }
</style>
<section class="relative bg-gradient-to-br from-blue-50 via-white to-yellow-50 py-20 overflow-hidden">

    <!-- Decorative background shapes -->
    <div class="absolute -top-20 -left-20 w-64 h-64 bg-yellow-200 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-blue-200 rounded-full blur-3xl opacity-40"></div>

    <div class="relative max-w-5xl mx-auto px-5 text-center">
        <!-- Heading -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-4">
            🆘 Help <span class="text-yellow-500">Center</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto mb-10 leading-relaxed">
            Need help with CashCash? Find answers to common questions or contact our friendly support team.
        </p>

        <!-- FAQs Section -->
        <div class="text-left space-y-4">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">❓ Frequently Asked Questions</h2>

            <!-- Accordion -->
            <div x-data="{ open: null }" class="space-y-3">

                <!-- FAQ 1 -->
                <div class="border border-gray-200 rounded-xl bg-white shadow-sm">
                    <button @click="open === 1 ? open = null : open = 1"
                        class="flex justify-between w-full px-5 py-3 text-sm font-medium text-gray-700 focus:outline-none">
                        <span>How do I redeem a voucher?</span>
                        <span x-show="open !== 1">➕</span>
                        <span x-show="open === 1">➖</span>
                    </button>
                    <div x-show="open === 1" class="px-5 pb-3 text-gray-600 text-sm">
                        Simply go to the partnered store, show your CashCash voucher code, and enjoy your discount instantly.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-gray-200 rounded-xl bg-white shadow-sm">
                    <button @click="open === 2 ? open = null : open = 2"
                        class="flex justify-between w-full px-5 py-3 text-sm font-medium text-gray-700 focus:outline-none">
                        <span>Can I use multiple vouchers at once?</span>
                        <span x-show="open !== 2">➕</span>
                        <span x-show="open === 2">➖</span>
                    </button>
                    <div x-show="open === 2" class="px-5 pb-3 text-gray-600 text-sm">
                        Usually one voucher per transaction is allowed, but check the offer terms for exceptions.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-gray-200 rounded-xl bg-white shadow-sm">
                    <button @click="open === 3 ? open = null : open = 3"
                        class="flex justify-between w-full px-5 py-3 text-sm font-medium text-gray-700 focus:outline-none">
                        <span>How can I list my business on CashCash?</span>
                        <span x-show="open !== 3">➕</span>
                        <span x-show="open === 3">➖</span>
                    </button>
                    <div x-show="open === 3" class="px-5 pb-3 text-gray-600 text-sm">
                        Create a business account, add your store details, and start publishing offers to reach new customers.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-gray-200 rounded-xl bg-white shadow-sm">
                    <button @click="open === 4 ? open = null : open = 4"
                        class="flex justify-between w-full px-5 py-3 text-sm font-medium text-gray-700 focus:outline-none">
                        <span>My voucher isn’t working — what should I do?</span>
                        <span x-show="open !== 4">➕</span>
                        <span x-show="open === 4">➖</span>
                    </button>
                    <div x-show="open === 4" class="px-5 pb-3 text-gray-600 text-sm">
                        Make sure your voucher hasn’t expired or been used. If it’s still not working, contact our support team below.
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-14 bg-white border border-gray-100 rounded-2xl shadow-lg p-8 text-center">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">💬 Still Need Help?</h3>
            <p class="text-gray-600 text-sm mb-5">
                Our support team is always ready to help. Reach us through any of the methods below:
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-5 text-sm">
                <a href="mailto:support@cashcash.com" class="text-blue-600 hover:underline">
                    📧 support@cashcash.com
                </a>
                <a href="/contact" class="text-yellow-500 hover:underline">
                    📞 Contact Form
                </a>
            </div>
        </div>

        <!-- Tagline -->
        <div class="mt-10 text-gray-500 italic text-sm">
            “CashCash Argentina — <span class="text-yellow-500 font-semibold">Your savings assistant, always ready.</span>”
        </div>
    </div>
</section>

<!-- Add Alpine.js for Accordion -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
