@extends('landing')
@section('content')

<div class="flex justify-center items-center min-h-screen px-4">

    <div class="w-full max-w-md bg-white text-black rounded-xl shadow-lg p-6 border">

        <h2 class="text-xl font-bold mb-4 text-center">Change Password</h2>

        @if(session('success'))
            <p class="text-green-600 text-sm mb-3 text-center">{{ session('success') }}</p>
        @endif

        <form action="{{ route('password.update.custom') }}" method="POST">
            @csrf

            {{-- Current Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Current Password</label>
                <input type="password" name="current_password"
                    class="w-full px-3 py-2 rounded border focus:outline-indigo-500">

                @error('current_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="new_password"
                    class="w-full px-3 py-2 rounded border focus:outline-indigo-500">

                @error('new_password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" name="new_password_confirmation"
                    class="w-full px-3 py-2 rounded border focus:outline-indigo-500">
            </div>

            <button type="submit"
                class="w-full px-4 py-2 bg-indigo-600 rounded text-white font-semibold hover:bg-indigo-700 transition">
                Update Password
            </button>

        </form>
    </div>

</div>

@endsection

@section('javascript')
@endsection
