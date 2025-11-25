@extends('admin.sidebaar')

@section('content')
@section('title', 'Business Offer Report')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Card 1: Owner Name -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- User Icon -->
        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4.992 4.992 0 0112 15a4.992 4.992 0 016.879 2.804M12 11a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Owner Name</p>
            <h2 class="text-lg font-bold">{{ $owner_name }}</h2>
        </div>
    </div>

    <!-- Card 2: Shop Name -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Store Icon -->
        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l1.528-2.445A2 2 0 016.328 4h11.344a2 2 0 011.8 0.555L21 7m-18 0v10a2 2 0 002 2h14a2 2 0 002-2V7H3z" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Shop Name</p>
            <h2 class="text-lg font-bold">{{ $shop_name }}</h2>
        </div>
    </div>

    <!-- Card 3: Location Name -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Location Icon -->
        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4.5 8-11a8 8 0 10-16 0c0 6.5 8 11 8 11z" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Location</p>
            <h2 class="text-lg font-bold">{{ $location }}</h2>
        </div>
    </div>

    <!-- Card 4: Offer Name -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Offer Icon -->
        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3a3 3 0 000-6z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414m12.728 0l1.414-1.414M6.05 6.05L4.636 4.636" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Offer Name</p>
            <h2 class="text-lg font-bold">{{ $offer_name }}</h2>
        </div>
    </div>

    <!-- Card 5: Business Plan Name -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Plan Icon -->
        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Business Plan</p>
            <h2 class="text-lg font-bold">{{ $plan_name }}</h2>
        </div>
    </div>

    <!-- Card 6: Email -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Email Icon -->
        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12H8m0 0l4-4m0 8l-4-4m12-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Email</p>
            <h2 class="text-lg font-bold">{{ $email }}</h2>
        </div>
    </div>

</div>

<!-- Info Cards above Table -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
    <!-- Stock Limit Card -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Box Icon -->
        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v13a2 2 0 002 2h14a2 2 0 002-2V7M3 7l9 6 9-6M3 7h18" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Stock Limit</p>
            <h2 class="text-lg font-bold">{{ $stock_limit }}</h2>
        </div>
    </div>
@php
    use App\Models\UserRedeem;

    // Eager load user and offer relationships
    $userRedemptions = UserRedeem::with(['user', 'offer'])
        ->where('offer_id', $id)
        ->where('status', 'redeem')
        ->get();
@endphp
    <!-- Total Redeemed Users Card (dummy) -->
    <div class="bg-white p-4 rounded-xl shadow-md flex items-center space-x-3">
        <!-- Users Icon -->
        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2h5m4-10a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
        <div>
            <p class="text-gray-500 text-sm">Total Redeemed Users</p>
            <h2 class="text-lg font-bold">{{ $userRedemptions->count() }}</h2>
        </div>
    </div>
</div>

<!-- Existing Table (dummy) -->


<div class="bg-white rounded-xl shadow-md p-4">
    <h2 class="text-xl font-bold mb-4">User Redemptions</h2>

    <table class="min-w-full divide-y divide-gray-200 border">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">User Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Offer Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">user Location</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Redeem Date</th>

                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Price</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Discount %</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Discount Price</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @forelse($userRedemptions as $redeem)
                <tr>
                    <td class="px-4 py-2">{{ $redeem->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $redeem->offer->title ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $redeem->user->location ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $redeem->updated_at ?? 'N/A' }}</td>

                    <td class="px-4 py-2">{{ $redeem->offer->price ?? 0 }}</td>
                    <td class="px-4 py-2">{{ $redeem->offer->discount ?? 0 }}%</td>
                    <td class="px-4 py-2">{{ $redeem->offer->discount_price ?? 0 }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">No redemptions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


@endsection
