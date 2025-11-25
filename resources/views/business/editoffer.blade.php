@extends('business.sidebaar')

@section('title', 'Edit Offer')
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

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf


        <!-- Title -->
        <div>
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter title" value="{{ old('title', $offer->title) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter description"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description', $offer->description) }}</textarea>
        </div>

        <!-- Expiry Date -->
        <div class="mt-4">
            <label for="expiry_datetime" class="block text-gray-700 font-medium mb-2">Expiry Date & Time</label>
            <input type="datetime-local" name="expiry_datetime" id="expiry_datetime"
                value="{{ old('expiry_datetime', \Carbon\Carbon::parse($offer->expiry_datetime)->format('Y-m-d\TH:i')) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Stock Limit -->
        <div class="mt-4">
            <label for="stock_limit" class="block text-gray-700 font-medium mb-2">Stock Limit</label>
            <input type="number" name="stock_limit" id="stock_limit" value="{{ old('stock_limit', $offer->stock_limit) }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Category -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
            <select id="category" name="category" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                <option value="">Select Category</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (old('category', $offer->category_id) == $c->id) ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SubCategory -->
        <div class="mb-4">
            <label for="subcategory" class="block text-gray-700 font-medium mb-2">SubCategory</label>
            <select id="subcategory" name="subcategory" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                @if($offer->subcategory)
                    <option value="{{ $offer->subcategory_id }}" selected>{{ $offer->subcategory->name }}</option>
                @else
                    <option value="">Select Subcategory</option>
                @endif
            </select>
        </div>

        <!-- Price -->
        <div>
            <label for="price" class="block text-gray-700 font-medium mb-2">Price (₹)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $offer->price) }}" step="0.01"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <!-- Discount -->
        <div>
            <label for="discount" class="block text-gray-700 font-medium mb-2">Discount (%)</label>
            <input type="number" name="discount" id="discount" value="{{ old('discount', $offer->discount) }}" min="0" max="100"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <!-- Discount Price -->
        <div>
            <label for="discount_price" class="block text-gray-700 font-medium mb-2">Discount Price</label>
            <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price', $offer->discount_price) }}" readonly
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <!-- Voucher Code -->


        <!-- Image Upload -->
        <div class="w-full">
            <label for="image_upload" class="block text-gray-700 font-medium mb-2">Upload Image</label>
            <div class="flex items-center justify-center w-full">
                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all duration-300">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        @if($offer->image)
                            <img src="{{ asset('uploads/'.$offer->image) }}" alt="" class="rounded w-40 h-40 object-cover">
                        @else
                            <img src="{{asset('upload.png')}}" alt="" width="120" height="120">
                        @endif
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-400">PNG, JPG or GIF (max 5MB)</p>
                    </div>
                    <input id="image_upload" type="file" name="image" class="hidden" accept="image/*">
                </label>
            </div>
             <!-- Image Upload -->
<div class="w-full">



    <!-- Images Container: existing + new -->
    <div id="imagesContainer" class="mt-3 flex space-x-4">
        @if($offer->image)
            <div class="flex flex-col items-center">
                <p class="text-gray-600 text-sm mb-1">Current Image</p>
                <img src="{{ asset('uploads/offers/'.$offer->image) }}" class="rounded w-40 h-40 object-cover" id="currentImage">
            </div>
        @endif
        <!-- New upload will append here -->
        <div id="imagePreview"></div>
    </div>
</div>



        </div>

        <!-- Status -->


        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit"
                class="bg-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300" style="background: indianred">
                Update Offer
            </button>
        </div>

    </form>
</div>

<!-- Scripts -->
<script>
$(document).ready(function() {
    // CSRF setup
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Discount price calculation
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
    $('#price, #discount').on('input', calculateDiscountPrice);
    calculateDiscountPrice();

    // Category -> Subcategory AJAX
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

                    @if($offer->subcategory_id)
                        $('#subcategory').val('{{ $offer->subcategory_id }}');
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

    // Trigger category change on load to populate subcategory
    $('#category').trigger('change');

    // Image preview
    $('#image_upload').on('change', function(e) {
        var file = this.files[0];
        if(!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
        $('#imagePreview').html(`<p class="text-gray-600 mb-1">New Selected Image:</p><img src="${e.target.result}" class="rounded w-40 h-40 object-cover">`);
        };
        reader.readAsDataURL(file);
    });
});
$('form').on('submit', function(e){
    e.preventDefault(); // prevent normal submit

    var formData = new FormData(this); // form data including file
    var offerId = "{{ $offer->id }}"; // pass offer id

    $.ajax({
        url: '/business/offer/update/' + offerId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(res){
            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                window.location.href='/business/activeoffer';

                // Update current image preview if new image uploaded
                if(res.data.image){
                    $('#currentImage').attr('src', '/uploads/offers/' + res.data.image);
                }
            } else {
                Swal.fire('Error', 'Something went wrong!', 'error');
            }
        },
        error: function(xhr){
            var errors = xhr.responseJSON.errors;
            var errorMsg = '';
            $.each(errors, function(key, value){
                errorMsg += value + '\n';
            });
            Swal.fire('Validation Error', errorMsg, 'error');
        }
    });
});

</script>

@endsection
