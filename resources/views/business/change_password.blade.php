@extends('business.sidebaar')
@section('title', 'Change Password')

@section('content')

<div class="flex justify-center items-center w-full px-4 py-10">

    <div class="w-full max-w-lg bg-white text-black shadow-lg rounded-xl p-6 border">

        <h2 class="text-2xl font-bold mb-5 text-center">Change Password</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <p class="text-green-600 text-sm mb-3 text-center">{{ session('success') }}</p>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <p class="text-red-600 text-sm mb-3 text-center">{{ session('error') }}</p>
        @endif

        <form action="{{ route('password.update.custom') }}" method="POST">
            @csrf

            {{-- Current Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" name="current_password"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-indigo-600">

                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="new_password"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-indigo-600">

                @error('new_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-indigo-600">
            </div>

            <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                Update Password
            </button>

        </form>

    </div>

</div>

@endsection
