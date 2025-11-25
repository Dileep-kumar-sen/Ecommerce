@extends('admin.sidebaar')

@section('title', 'Edit Campaign')

@section('content')

    <div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
@if (session('success'))
    <div class="text-center">
    <h1>{{ session('success') }}</h1>
</div>
@endif

<form
    id="createCampaignForm"
    action="{{ isset($campaign) ? route('campaign.update', $campaign->id) : route('campaign.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-5">

    @csrf

    <!-- Campaign Name -->
    <div>
        <label for="campaign_name" class="block text-sm font-semibold text-gray-700 mb-2">Campaign Name</label>
        <input type="text" id="campaign_name" name="campaign_name"
            value="{{ $campaign->campaign_name ?? '' }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
            placeholder="e.g., Diwali Dhamaka 2025" required>
    </div>

    <!-- Dates -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
            <input type="date" id="start_date" name="start_date"
                value="{{ $campaign->start_date ?? '' }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none" required>
        </div>
        <div>
            <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
            <input type="date" id="end_date" name="end_date"
                value="{{ $campaign->end_date ?? '' }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none" required>
        </div>
    </div>

    <!-- Categories -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Categories</label>
        <select id="categories" name="categories[]" multiple class="select2 w-full border border-gray-300 rounded-lg px-4 py-2">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ isset($campaign) && in_array($cat->id, json_decode($campaign->categories ?? '[]')) ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Subcategories -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Subcategories</label>
        <select id="subcategories" name="subcategories[]" multiple class="select2 w-full border border-gray-300 rounded-lg px-4 py-2">
            @foreach($subcategories as $sub)
                <option value="{{ $sub->id }}"
                    {{ isset($campaign) && in_array($sub->id, json_decode($campaign->subcategories ?? '[]')) ? 'selected' : '' }}>
                    {{ $sub->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Join Fee -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Join Fee (₹)</label>
        <input type="number" name="join_fee"
            value="{{ $campaign->join_fee ?? '' }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2">
    </div>
    <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Max Offer Created</label>
                <input type="number" name="max_offer" placeholder="e.g., 4" value="{{ $campaign->max_offer??'' }}" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none border " required>
            </div>
<div>
                <label for="discount_rules" class="block text-sm font-semibold text-gray-700 mb-2">Discount Limit</label>
                <input type="number" id="discount_rules" name="discount_rules" value="{{ $campaign->discount_rules ?? '' }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                    placeholder="e.g., Minimum 20% discount required">
            </div>
    <!-- Benefit -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Benefit</label>
        <input type="text" name="benefit"
            value="{{ $campaign->benefit ?? '' }}"
            class="w-full border border-gray-300 rounded-lg px-4 py-2">
    </div>

    <!-- Description -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
        <textarea name="description" rows="4"
            class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ $campaign->description ?? '' }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-center pt-4">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-semibold shadow-md transition-transform transform hover:scale-105">
            {{ isset($campaign) ? 'Update Campaign' : 'Create Campaign' }}
        </button>
    </div>
</form>

    </div>


@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select options",
        width: '100%'
    });

    // On category change
    $('#categories').on('change', function() {
        let categoryIds = $(this).val(); // selected categories
        if (categoryIds.length > 0) {
            $.ajax({
                url: "{{ route('get.subcategories') }}",
                type: 'GET',
                data: { category_ids: categoryIds },
                success: function(data) {
                    $('#subcategories').empty(); // clear old subcategories
                    $.each(data, function(index, subcat) {
                        $('#subcategories').append(
                            `<option value="${subcat.id}">${subcat.name}</option>`
                        );
                    });
                    $('#subcategories').trigger('change'); // refresh Select2
                }
            });
        } else {
            $('#subcategories').empty().append('<option value="">-- Select Category First --</option>');
        }
    });
});
</script>

@endsection
