@extends('admin.sidebaar')

@section('title', 'Upload Banners')

@section('content')

<div class="w-full max-w-[600px] mx-auto p-8 bg-gradient-to-r from-white to-gray-50 rounded-2xl shadow-2xl border border-gray-200">

    <h2 class="text-3xl font-extrabold mb-6 text-gray-900 text-center">Upload Banner Photos</h2>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="p-4 mb-4 bg-green-100 text-green-800 border border-green-300 rounded-lg shadow-sm animate-fadeIn">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR MESSAGE --}}
    @if(session('error'))
        <div class="p-4 mb-4 bg-red-100 text-red-800 border border-red-300 rounded-lg shadow-sm animate-fadeIn">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf



        {{-- Upload Box --}}
        <label
            class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group">
            <svg class="w-12 h-12 text-gray-400 mb-3 group-hover:text-blue-500 transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v6m0-6l-3 3m3-3l3 3M12 4v4"/>
            </svg>
            <span class="text-gray-500 font-medium group-hover:text-blue-600 transition">Click or Drag & Drop to Upload Banners</span>
            <input type="file" name="images[]" multiple class="hidden">
        </label>

        {{-- Upload Button --}}
      <button
    class="mt-6 w-full md:w-[310px] mx-auto block bg-gradient-to-r from-purple-600 to-indigo-600
           hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 rounded-xl
           shadow-lg transform hover:-translate-y-1 transition-all duration-300" style="background: #4948af">
    Upload
</button>


    </form>
</div>

{{-- Optional: Add animation --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.4s ease forwards;
}
</style>


{{-- BANNERS TABLE --}}
<div class="max-w-6xl mx-auto mt-10 bg-white shadow rounded-lg overflow-hidden" style="margin-top: 20px">

    <h3 class="text-xl font-bold mb-4 p-5 text-gray-800">Uploaded Banners</h3>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
           <tbody class="bg-white divide-y divide-gray-200">

    @foreach($banners as $banner)
    <tr class="hover:bg-gray-50 transition">

        <td class="px-6 py-4 whitespace-nowrap">
            {{-- Wrapper div fixed size --}}
            <div class="w-36 h-24 overflow-hidden rounded-lg shadow border border-gray-200">
                <img src="{{ asset('uploads/banners/' . $banner->images) }}"
                     class="w-full h-full object-cover">
            </div>
        </td>

        <td class="px-6 py-4 whitespace-nowrap">
            <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this banner?');"
                  class="inline-block">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </td>
    </tr>
    @endforeach

</tbody>

        </table>
    </div>

</div>



@endsection
