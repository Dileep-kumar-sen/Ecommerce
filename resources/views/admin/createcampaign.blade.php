@extends('admin.sidebaar')

@section('title', 'Create Campaign')

@section('content')

    <div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
@if (session('success'))
    <div class="text-center">
    <h1>{{ session('success') }}</h1>
</div>
@endif

<form id="createCampaignForm" action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Campaign Name -->
            <div>
                <label for="campaign_name" class="block text-sm font-semibold text-gray-700 mb-2">Campaign Name</label>
                <input type="text" id="campaign_name" name="campaign_name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                    placeholder="e.g., Diwali Dhamaka 2025" required>
            </div>

            <!-- Start & End Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                        required>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                        required>
                </div>
            </div>
      <div>
    <label for="categories" class="block text-sm font-semibold text-gray-700 mb-2">
        Select Categories
    </label>

    <select id="categories" name="categories[]" multiple
        class="select2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="mt-4">
    <label for="subcategories" class="block text-sm font-semibold text-gray-700 mb-2">
        Select Subcategories
    </label>

    <select id="subcategories" name="subcategories[]" multiple
        class="select2 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none">
        <option value="">-- Select Category First --</option>
    </select>
</div>



            <!-- Target Categories -->




<div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Max Offer Created</label>
                <input type="number" name="max_offer" placeholder="e.g., 4" class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none border " required>
            </div>
<div class="mb-4">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Campaign Join Fee (₹)</label>
    <input type="number"
           name="join_fee"
           placeholder="e.g., 0 (Free)"
           class="w-full border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none border"
           required>
</div>


            <!-- Discount Rules -->
            <div>
                <label for="discount_rules" class="block text-sm font-semibold text-gray-700 mb-2">Discount Limit</label>
                <input type="number" id="discount_rules" name="discount_rules"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                    placeholder="e.g., Minimum 20% discount required">
            </div>

            <!-- Visibility -->
            <div>
                <label for="visibility" class="block text-sm font-semibold text-gray-700 mb-2">benefit</label>
<input type="text" id="discount_rules" name="benefit"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none"
                    placeholder="">
            </div>

            <!-- Banner Image -->
            <div>
                <label for="banner" class="block text-sm font-semibold text-gray-700 mb-2">Banner Image</label>
                <input type="file" id="banner" name="banner"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none">
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none resize-none"
                    placeholder="Describe the purpose of this campaign..."></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center pt-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-semibold shadow-md transition-transform transform hover:scale-105">
                     Create Campaign
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
