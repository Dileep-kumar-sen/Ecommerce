@extends('admin.sidebaar')

@section('title', 'Upload Banners')

@section('content')

<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-3">Upload Banner Photos</h2>

    @if(session('success'))
        <p class="p-2 bg-green-200 text-green-800">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="p-2 bg-red-200 text-red-800">{{ session('error') }}</p>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="font-medium">Banner Photos (Min 2)</label>
        <input type="file" name="images[]" multiple class="w-full border p-2 mb-3">

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Upload</button>
    </form>
</div>

<div class="max-w-full mx-auto mt-6 flex flex-nowrap gap-4 overflow-x-auto">
    @foreach($banners as $banner)
        @foreach($banner->images as $img)
            <img src="{{ asset('uploads/banners/'.$img) }}"
                 class="w-32 h-32 object-cover rounded shadow flex-shrink-0">
        @endforeach
    @endforeach
</div>


@endsection
