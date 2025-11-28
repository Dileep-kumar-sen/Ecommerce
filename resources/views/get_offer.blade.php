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
     <section class="bg-white py-16 relative">
    <div class="max-w-[91rem] mx-auto px-4">



        <div >

            {{-- GRID SAME LIKE NICHE --}}
            <section class="bg-white  relative">
    <div class="max-w-[91rem] mx-auto px-4">



        <div >

      <div id="offerContainerTop" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @foreach($offers as $key => $offer)

    @php
        $ratings = \App\Models\Review::where('offer_id', $offer->id)->pluck('rating');
        $avgRating = $ratings->avg() ?? 0;
        $totalReviews = $ratings->count();
        $images = json_decode($offer->image, true);
        if(!is_array($images)) $images = [$offer->image];
    @endphp

    <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1
                flex flex-col h-[440px] offer-card
                {{ $key >= 3 ? 'hidden-card' : 'show-card' }}"> {{-- DO NOT USE hidden --}}

        {{-- IMAGE SLIDER --}}
        <div class="relative overflow-hidden">
            <div class="swiper offerSlider">
                <div class="swiper-wrapper">
                    @foreach($images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset('/uploads/offers/'.$img) }}" class="w-full h-56 object-cover"/>
                        </div>
                    @endforeach
                </div>
            </div>

            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-lg shadow-md">
                -{{ $offer->discount }}%
            </span>

            <span class="absolute top-3 right-3 bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-lg shadow-md">
                {{ $offer->subcategory->name ?? 'Category' }}
            </span>
        </div>

        <div class="p-5 flex flex-col flex-grow">
            <h3 class="font-bold text-gray-800 text-[15px] text-left h-[40px] overflow-hidden">
                {{ Str::limit($offer->title, 30) }}
            </h3>

            <p class="text-gray-600 text-sm mt-1 text-left h-[40px] overflow-hidden">
                {{ Str::limit($offer->description, 35) }}
            </p>

            <div class="mt-3 text-left">
                <span class="text-lg font-extrabold text-green-600">
                    {{ $offer->discount }}% OFF
                </span>
            </div>

            <div class="mt-3 text-sm text-gray-600 space-y-1 text-left">
                <p>👀 {{ rand(20, 120) }} Visits</p>
                <p>⏳ Ends: {{ date('d/m/Y', strtotime($offer->expiry_datetime)) }}</p>
            </div>

            <a href="/detail/{{ $offer->id }}"
                class="block mt-auto text-center bg-[#7a5af8] text-white font-semibold py-3 rounded-xl
                       hover:bg-[#6845e0] transition">
                View Benefit →
            </a>
        </div>
    </div>

    @endforeach
</div>

@if($offers->count() > 3)
<div class="text-center mt-8">
    <button id="topLoadMoreBtn"
        class="bg-[#7a5af8] text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition shadow-md">
        Load More
    </button>
</div>
@endif




        </div>

    </div>
</section>


        </div>

    </div>
</section>

    </div>
  </div>
</div>

@endsection
@section('javascript')
<script>
document.getElementById("topLoadMoreBtn")?.addEventListener("click", function () {

    let cards = document.querySelectorAll(".hidden-card");

    cards.forEach((card, index) => {
        if (index < 3) {
            card.classList.remove("hidden-card");
            card.classList.add("show-card");
        }
    });

    if (document.querySelectorAll(".hidden-card").length === 0) {
        this.style.display = "none";
    }

});
</script>



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
