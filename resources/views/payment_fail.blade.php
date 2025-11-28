@extends('landing')

@section('content')

<div class="min-h-[80vh] flex items-center justify-center bg-gray-50 px-4 py-10">

    <div class="bg-white shadow-xl rounded-2xl p-8 max-w-md w-full text-center relative overflow-hidden">

        {{-- Red Glow Animation --}}
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-red-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-red-500/20 rounded-full blur-3xl animate-ping"></div>

        {{-- Error Icon --}}
        <div class="text-red-600 text-6xl mb-4 animate-bounce">
            ❌
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            Payment Failed!
        </h2>

        <p class="text-gray-600 text-sm leading-relaxed mb-4">
            Unfortunately, your transaction couldn't be completed.<br>
            Please try again after some time.
        </p>

        {{-- Possible Issue Message --}}
        <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-3 text-sm mb-6">
            ⚠️ If money has been deducted from your account,<br>
            it will be automatically refunded back to you.
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-center gap-3 mt-4">

            <a href="{{ url('/home') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-medium transition">
                Go Home
            </a>

            <a href="{{ url('/plan') }}"
               class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg font-semibold shadow-md transition">
                Try Again
            </a>

        </div>
    </div>

</div>

@endsection
