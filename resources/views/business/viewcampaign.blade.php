@extends('business.sidebaar')

@section('title', 'View Campaign')

@section('content')

<div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

    <!-- 🟦 Banner Card -->
     <div class="flex justify-center">
<h1 style="font-size: 32px">Event Name-{{ $campaign->campaign_name }}</h1>
     </div>
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
        @if($campaign->banner)

      <div class="relative w-full flex justify-center">

    <div class="relative w-[75%]">
        <img src="{{ asset($campaign->banner) }}"
             alt="Campaign Banner"
             class="w-[378px] h-[378px] object-cover rounded-t-3xl">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent rounded-t-3xl"></div>
        <h1 class="absolute bottom-4 left-5 text-2xl font-bold text-white drop-shadow-lg">
            🎉 {{ $campaign->campaign_name }}
        </h1>
    </div>
</div>



        @else
            <div class="h-72 bg-gray-100 flex items-center justify-center text-gray-500 italic text-lg">
                No Banner Uploaded
            </div>
        @endif
    </div>

    <!-- 🟩 Basic Info Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-2">📅 Event Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Start Date</p>
                <p class="text-lg font-semibold text-gray-800">{{ $campaign->start_date }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">End Date</p>
                <p class="text-lg font-semibold text-gray-800">{{ $campaign->end_date }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Join Fee</p>
                <p class="text-lg font-semibold text-gray-800">₹{{ number_format($campaign->join_fee, 2) }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Max Offer</p>
                <p class="text-lg font-semibold text-gray-800">{{ $campaign->max_offer }}</p>
            </div>
        </div>
    </div>

    <!-- 🟨 Description Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-2">📝 Event Info</h2>
        <div class="space-y-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Discount Rules</p>
                <p class="text-base text-gray-800">{{ $campaign->discount_rules ?? 'No discount rules defined' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Benefit</p>
                <p class="text-base text-gray-800">{{ $campaign->benefit ?? 'N/A' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-1">Description</p>
                <p class="text-base text-gray-800 leading-relaxed">{{ $campaign->description }}</p>
            </div>
        </div>
    </div>

    <!-- 🟧 Category Cards -->
   @php
use App\Models\Category;
use App\Models\Subcategory;

// Decode stored IDs from campaign
$categoryIds = json_decode($campaign->categories, true) ?? [];
$subcategoryIds = json_decode($campaign->subcategories, true) ?? [];

// Fetch data from DB directly inside Blade
$categories = Category::whereIn('id', $categoryIds)->get();
$subcategories = Subcategory::whereIn('id', $subcategoryIds)->with('category')->get();
@endphp

<div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-2">
        You Can Join These Categories & Subcategories
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Categories -->
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
            <p class="text-sm text-gray-500 mb-2">Categories</p>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $cat)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        #{{ $cat->name }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Subcategories -->
        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
            <p class="text-sm text-gray-500 mb-2">Subcategories</p>
            <div class="flex flex-wrap gap-2">
                @foreach($subcategories as $sub)
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $sub->category?->name }} → #{{ $sub->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>


    <!-- 🟥 Status Card -->
    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-2">⚙️ Status & Timeline</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Status</p>
                <span class="px-4 py-1 rounded-full text-white text-sm font-medium
                    {{ $campaign->status == 1 ? 'bg-blue-500' : 'bg-blue-500' }}">
                    {{ $campaign->status == 1 ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 mb-1">Created At</p>
                <p class="text-base text-gray-800">{{ $campaign->created_at->format('d M Y, h:i A') }}</p>
            </div>


        </div>
    </div>

</div>

@endsection
