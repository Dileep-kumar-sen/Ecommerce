@extends('business.sidebaar')

@section('title', 'Edit Profile')
@section('content')

<div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
@if(session()->has('success'))
    <div class="flex justify-center ">
        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-lg  font-semibold">
            {{ session('success') }}
        </span>
    </div>
@endif

    <form action="{{ route('business.profile.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT') <!-- For update -->

        <!-- Shop Name -->
        <div>
            <label for="shop_name" class="block text-gray-700 font-medium mb-2">Shop Name</label>
            <input type="text" name="shop_name" id="shop_name" placeholder="Enter Shop Name"
                value="{{ session('shop_name') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>

        <!-- Full Name -->
        <div>
            <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
            <input type="text" name="name" id="name" placeholder="Enter Full Name"
                value="{{ session('name') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Email"
                value="{{ session('email') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>
        <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Phone Number.</label>
            <input type="text" name="phone" id="phone" placeholder="Enter Phone Number"
                value="{{ session('phone') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400" required>
        </div>

        <!-- Password -->


        <!-- Submit Button -->
        <div class="flex justify-center mt-6">
            <button type="submit"
                class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 max-w-[308px]" style="background: indianred">
                Update Profile
            </button>
        </div>

    </form>
</div>

@endsection
