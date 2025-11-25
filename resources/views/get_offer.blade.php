@extends('landing')

@section('content')
<div class="w-full mx-auto text-white border-b border-white/20 rounded py-20 overflow-x-hidden">
  <div class="max-w-[91rem] mx-auto px-4 md:px-6 flex flex-col lg:flex-row gap-6">

    <!-- ✅ Left Sidebar / Filter -->
    <aside class="w-full lg:w-1/4 bg-gray-50 text-gray-800 rounded-xl p-4 shadow-md top-24 h-fit">
      <h3 class="text-lg font-semibold mb-4 border-b pb-2">Filter by Subcategory</h3>

      @php
          $subcategories = \App\Models\Subcategory::where('category_id', $category->id)->get();
          $activeSubcategory = request()->query('subcategory');
      @endphp

      @if($subcategories->count() > 0)
          <!-- Desktop View -->
          <ul class="hidden lg:flex flex-col gap-3 mt-4">
              @foreach($subcategories as $sub)
                  <li>
                      <a href="{{ url('/get/offer/'.$category->id.'?subcategory='.$sub->id) }}"
                         class="flex items-center justify-between px-3 py-2 rounded-lg transition cursor-pointer
                         {{ $activeSubcategory == $sub->id ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-gray-200' }}">
                          <span>{{ $sub->name }}</span>
                      </a>
                  </li>
              @endforeach
          </ul>

          <!-- Mobile View -->
          <div class="lg:hidden overflow-x-auto flex gap-3 mt-4 pb-2 no-scrollbar">
              @foreach($subcategories as $sub)
                  <a href="{{ url('/get/offer/'.$category->id.'?subcategory='.$sub->id) }}"
                     class="flex-shrink-0 px-4 py-2 rounded-full text-sm transition
                     {{ $activeSubcategory == $sub->id ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                      {{ $sub->name }}
                  </a>
              @endforeach
          </div>
      @else
          <p class="text-sm text-gray-500 mt-4">No subcategories found</p>
      @endif
    </aside>

    <!-- ✅ Right Side -->
    <div class="w-full lg:w-3/4">
      <div class="text-sm text-gray-600 mb-6 flex flex-wrap gap-1">
        <a href="/" class="text-blue-600 hover:underline">Home</a> ›
        <a href="/category" class="text-blue-600 hover:underline">Category</a> ›
        <span class="text-gray-800 font-semibold">{{ $category->name }}</span>
      </div>

      <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">{{ $category->name }} Offers</h2>
        <p class="text-gray-500 mt-2">
          Explore all offers under <strong>{{ $category->name }}</strong> category.
        </p>
      </div>

      <!-- Offers Grid -->
      <section class="bg-white py-10 rounded-2xl shadow-md overflow-hidden">
        <div id="discount-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          @forelse($offers as $key => $offer)
              @php
                  $ratings = \App\Models\Review::where('offer_id', $offer->id)->pluck('rating');
                  $avgRating = $ratings->avg() ?? 0;
                  $totalReviews = $ratings->count();
                  $filledStars = floor($avgRating);
                  $halfStar = ($avgRating - $filledStars) >= 0.5;
                  $emptyStars = 5 - $filledStars - ($halfStar ? 1 : 0);
              @endphp

              <div class="deal-card group bg-white rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1 p-3 text-left offer-item" data-index="{{ $key }}">
                <div class="relative">
                  <img src="{{ asset('uploads/offers/' . $offer->image) }}" alt="{{ $offer->title }}"
                       class="w-full h-40 sm:h-44 object-cover rounded-lg">

                  <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                    {{ $offer->discount }}% OFF
                  </span>

                  <span class="absolute top-2 right-2 bg-gray-200 text-gray-700 text-xs font-semibold px-2 py-1 rounded">
                    {{ $offer->subcategory->name ?? 'Subcategory' }}
                  </span>
                </div>

                <h3 class="mt-3 text-sm sm:text-md font-semibold text-gray-800 truncate">{{ $offer->title }}</h3>

                <div class="flex items-center text-xs sm:text-sm mt-1">
                  @for ($i = 0; $i < $filledStars; $i++)
                      <i class="fa-solid fa-star text-yellow-400"></i>
                  @endfor
                  @if ($halfStar)
                      <i class="fa-solid fa-star-half-stroke text-yellow-400"></i>
                  @endif
                  @for ($i = 0; $i < $emptyStars; $i++)
                      <i class="fa-regular fa-star text-gray-300"></i>
                  @endfor
                  <span class="text-gray-500 text-xs ml-1">
                      {{ number_format($avgRating, 1) }} ({{ $totalReviews }})
                  </span>
                </div>

                <div class="mt-1 flex items-center gap-2">
                  <span class="text-sm sm:text-base font-bold text-gray-800">${{ $offer->discount_price }}</span>
                  <span class="text-gray-400 text-xs line-through">${{ $offer->price }}</span>
                </div>

                <a href="/detail/{{ $offer->id }}"
                   class="block text-center mt-3 border border-gray-300 text-blue-600 font-medium py-1.5 text-xs sm:text-sm rounded-md hover:bg-yellow-400 hover:text-blue-700 transition">
                   🎟️ Get Coupon
                </a>
              </div>
          @empty
              <div class="col-span-full flex justify-center items-center flex-col mt-10">
                <img src="{{ asset('/no_offer.jpg') }}" alt="No Offer" class="w-48 h-48 sm:w-64 sm:h-64 object-contain mb-4">
                <p class="text-gray-600 text-sm sm:text-base">No offers found for this category.</p>
              </div>
          @endforelse
        </div>

        <!-- Pagination -->
        @if($offers->count() > 8)
        <div class="flex justify-center space-x-4 mt-6">
          <button id="prev-btn" class="text-white p-3 rounded-full shadow hover:shadow-lg transition w-[46px] h-[46px] border border-[#bcf020e6]">
            <i class="fa-solid fa-arrow-left text-black"></i>
          </button>
          <button id="next-btn" class="text-white p-3 rounded-full bg-[#f5e10e] shadow hover:shadow-lg transition w-[46px] h-[46px] border border-[#bcf020e6]">
            <i class="fa-solid fa-arrow-right text-black"></i>
          </button>
        </div>
        @endif
      </section>
    </div>
  </div>
</div>

@endsection
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.offer-item');
        const perPage = 8;
        let currentPage = 1;
        const totalPages = Math.ceil(items.length / perPage);

        function showPage(page) {
            const start = (page - 1) * perPage;
            const end = start + perPage;

            items.forEach((item, index) => {
                if(index >= start && index < end) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }

        document.getElementById('prev-btn').addEventListener('click', () => {
            if(currentPage > 1) {
                currentPage--;
                showPage(currentPage);
            }
        });

        document.getElementById('next-btn').addEventListener('click', () => {
            if(currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
            }
        });

        // Initial page
        showPage(currentPage);
    });
</script>

@endsection
