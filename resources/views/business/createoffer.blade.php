@extends('business.sidebaar')

@section('title', 'Create Offer')
@section('content')

<div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

    @if(session('success'))
        <div class="flex justify-center mb-4">
            <div class="bg-green-100 text-green-800 px-6 py-3 rounded-lg text-lg font-semibold">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($errors->any())
    <div class="mb-4">
        <ul class="text-red-600">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('business.offer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
@php
    use App\Models\CampaignJoin;
    use App\Models\Campaign;
    use Carbon\Carbon;

    $businessId = session('business_id');
    $today = Carbon::today();

    $activeCampaigns = collect(); // active campaigns array

    if ($businessId) {
        // 🔹 Get all campaigns joined by this business
        $joinedCampaigns = CampaignJoin::where('business_id', $businessId)->get();

        foreach ($joinedCampaigns as $join) {
            $campaign = Campaign::where('id', $join->campaign_id)
                                ->where('status', 1)   // 🔥 Only active campaigns
                                ->first();

            if ($campaign) {
                $start = Carbon::parse($campaign->start_date);
                $end = Carbon::parse($campaign->end_date);

                // ✅ Check if today's date is between start_date and end_date
                if ($today->between($start, $end)) {
                    $activeCampaigns->push($campaign);
                }
            }
        }
    }
@endphp

<div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

    {{-- ✅ Agar ek ya zyada active campaigns hain --}}
    @if($activeCampaigns->count() > 0)
        <div class="mb-4">
            <label for="campaign_id" class="block text-gray-700 font-medium mb-2">
                Do You want to Participcate Event
            </label>
            <select name="campaign_id" id="campaign_id"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">Select Campaign</option>

                @foreach($activeCampaigns as $camp)
                    <option value="{{ $camp->id }}">
                        {{ $camp->campaign_name }}
                    </option>
                @endforeach
            </select>
        </div>

    @endif
        <!-- Title -->
        <div>
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter title" value="{{ old('title') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter description"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description') }}</textarea>
        </div>

        <!-- Expiry Date -->
        <div class="mt-4">
            <label for="expiry_datetime" class="block text-gray-700 font-medium mb-2">Expiry Date & Time</label>
            <input type="datetime-local" name="expiry_datetime" id="expiry_datetime" value="{{ old('expiry_datetime') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Stock Limit -->
        <div class="mt-4">
            <label for="stock_limit" class="block text-gray-700 font-medium mb-2">Stock Limit</label>
            <input type="number" name="stock_limit" id="stock_limit" value="{{ old('stock_limit', 0) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
            <select id="category" name="category" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                <option value="">Select Category</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SubCategory (populated by AJAX) -->
        <div class="mb-4">
            <label for="subcategory" class="block text-gray-700 font-medium mb-2">SubCategory</label>
            <select id="subcategory" name="subcategory" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                <option value="">Select Subcategory</option>
                {{-- options filled by AJAX --}}
            </select>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-gray-700 font-medium mb-2">Price (₹)</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Discount -->
        <div>
            <label for="discount" class="block text-gray-700 font-medium mb-2">Discount (%)</label>
            <input type="number" name="discount" id="discount" value="{{ old('discount', 0) }}" min="0" max="100"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div>
            <label for="discount" class="block text-gray-700 font-medium mb-2">Discount Price</label>
            <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', ) }}"  readonly
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <!-- Image Upload -->
        <div class="w-full">
    <label  class="block text-gray-700 font-medium mb-2">Upload Images (Max 4)</label>
    <div class="flex items-center justify-center w-full">
        <label
            class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <img src="{{asset('upload.png')}}" alt="" width="100">
                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-400">Upload upto 4 images</p>
            </div>

            <!-- MULTIPLE FILES -->
            <input id="image_upload" type="file" name="images[]" class="hidden" accept="image/*" multiple>
        </label>
    </div>

    <!-- Preview -->
    <div id="imagePreview" class="mt-3 flex flex-wrap gap-3"></div>

</div>


        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit"
                class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300" style="background: indianred">
                Create Offer
            </button>
        </div>

    </form>
</div>
<script>
        $(document).ready(function() {
            function calculateDiscountPrice() {
                let price = parseFloat($('#price').val());
                let discount = parseFloat($('#discount').val());

                if (!isNaN(price) && !isNaN(discount)) {
                    let discountedPrice = price - (price * discount / 100);
                    $('#discount_price').val(discountedPrice.toFixed(2));
                } else {
                    $('#discount_price').val('');
                }
            }

            // Jab bhi price ya discount badle toh calculate kare
            $('#price, #discount').on('input', calculateDiscountPrice);
        });
    </script>

<script>

$(document).ready(function() {

    // CSRF for AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // When category changes, fetch subcategories
    $('#category').on('change', function() {
        var catId = $(this).val();
        $('#subcategory').html('<option value="">Loading...</option>');

        if(!catId) {
            $('#subcategory').html('<option value="">Select Subcategory</option>');
            return;
        }

        $.ajax({
            url: '{{ route("ajax.subcategories", ["category" => "##id##"]) }}'.replace('##id##', catId),
            method: 'GET',
            success: function(res) {
                if(res.success) {
                    var opts = '<option value="">Select Subcategory</option>';
                    res.data.forEach(function(s) {
                        opts += `<option value="${s.id}">${s.name}</option>`;
                    });
                    $('#subcategory').html(opts);

                    // if old value present, set it
                    @if(old('subcategory'))
                        $('#subcategory').val('{{ old("subcategory") }}');
                    @endif
                } else {
                    $('#subcategory').html('<option value="">Select Subcategory</option>');
                }
            },
            error: function() {
                $('#subcategory').html('<option value="">Select Subcategory</option>');
            }
        });
    });

    // Image preview
    $('#image_upload').on('change', function (e) {
    let files = this.files;

    if (files.length > 4) {
        alert("You can upload maximum 4 images only!");
        $(this).val("");
        $('#imagePreview').html("");
        return;
    }

    $('#imagePreview').html("");

    $.each(files, function (index, file) {
        let reader = new FileReader();
        reader.onload = function (event) {

            $('#imagePreview').append(`
                <div class="preview-box">
                    <img src="${event.target.result}"  style="width:200px;height:200px;">
                </div>
            `);
        };
        reader.readAsDataURL(file);
    });
});


    // Trigger change on page load if category preselected (for old input)
    @if(old('category'))
        $('#category').trigger('change');
    @endif
});
</script>
<script>
document.getElementById('campaign_id').addEventListener('change', function () {
    let campaignId = this.value;

    if (campaignId === "") return;

    fetch("{{ url('/get-campaign-data') }}/" + campaignId)
        .then(res => res.json())
        .then(data => {
            // 1️⃣ Category set karo
            document.getElementById('category').value = data.category_ids[0];

            // 2️⃣ Subcategories load karo
            loadSubcategories(data.category_ids[0], data.subcategory_ids);
        });
});

// Subcategory Loader
function loadSubcategories(categoryId, allowedSubcategories = []) {
    fetch("{{ url('/get-subcategories') }}/" + categoryId)
        .then(res => res.json())
        .then(data => {
            let subcatSelect = document.getElementById('subcategory');
            subcatSelect.innerHTML = '<option value="">Select Subcategory</option>';

            data.forEach(sub => {
                if (allowedSubcategories.includes(sub.id.toString())) {
                    subcatSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                }
            });
        });
}
</script>

@endsection




