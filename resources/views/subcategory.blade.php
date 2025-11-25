@extends('landing')
@section('content')


    <!-- 🔹 Categories Section -->
    <!-- Explore Categories -->
    <div class="lg:w-[1132px] mx-auto  text-white border-b border-white/20 rounded">
        <section class=" py-20">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <!-- Title -->
                <h2 class="text-2xl font-extrabold text-gray-800"> Explore by Subcategories</h2>
                <p class="text-gray-600 mt-3 text-1xl">Find the best deals organized by Subcategories</p>

                <!-- Categories Grid -->
       <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse ($subcategories as $sub)
            <a href="{{ route('get.offer', ['category_id' => $id, 'subcategory_id' => $sub->id]) }}">
    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition transform hover:-translate-y-2 p-8 text-center">
        <div class="w-16 h-16 mx-auto flex items-center justify-center rounded-full bg-yellow-100 text-yellow-500 text-3xl group-hover:scale-110 transition overflow-hidden">
            <img src="{{ asset('uploads/subcategory/' . $sub->icon) }}"
                alt="{{ $sub->name }}"
                class="w-full h-full object-cover rounded-full">
        </div>

        <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ $sub->name }}</h3>
    </div>
</a>
        @empty
            <p class="col-span-full text-center text-gray-600" style="margin-top: 20px;color:black">No subcategories found for this category.</p>
        @endforelse
    </div>

            </div>
        </section>

        <!-- Font Awesome -->

        <!-- 🔹 Top Deals Section -->


        <!-- 🔹 Newsletter Section -->

    </div>


@endsection
@section('javascript')


@endsection
