@extends('landing')
@section('content')

<div class="w-full max-w-4xl mx-auto p-6">

    {{-- PERSONAL INFORMATION --}}
    @if(session('success'))
    <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif


    <div class="bg-white shadow rounded-lg border mb-6">
        <div class="bg-[#0095DA] text-white px-4 py-2 rounded-t-lg font-semibold text-sm">
            Personal Information
        </div>

        <form action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="p-6">

        {{-- Profile Image --}}
        <div class="flex flex-col items-center mb-5">
            <img src="{{ asset('/uploads/profiles/'.auth()->user()->profile) }}"
                 class="w-20 h-20 rounded-full border object-cover" />

            <p class="text-gray-600 text-sm mt-2">Change profile picture</p>
        </div>

        {{-- File Upload --}}
        <label class="text-gray-600 text-sm font-medium">Profile Picture</label>
        <input type="file"
               name="profile"
               class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />


        {{-- Full Name --}}
        <label class="text-gray-600 text-sm font-medium">Full Name</label>
        <input type="text"
               name="name"
               value="{{ auth()->user()->name }}"
               placeholder="Enter full name"
               class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />

        {{-- Email --}}
        <label class="text-gray-600 text-sm font-medium">Email Address</label>
        <input type="email"
               name="email"
               value="{{ auth()->user()->email }}"
               placeholder="Enter email"
               class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />

        {{-- Phone --}}
        <label class="text-gray-600 text-sm font-medium">Phone Number</label>
        <input type="text"
               name="phone"
               value="{{ auth()->user()->phone }}"
               placeholder="Enter phone number"
               class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />


        {{-- Location --}}
        <label class="text-gray-600 text-sm font-medium">Select Your Location</label>
        <input
            type="text"
            name="location"
            id="location"
            readonly
            value="{{ auth()->user()->location }}"
            placeholder="Click to select location"
            class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200 cursor-pointer"
        />

        <input type="hidden" id="latitude" name="latitude" value="{{ auth()->user()->latitude }}" />
        <input type="hidden" id="longitude" name="longitude" value="{{ auth()->user()->longitude }}" />


        <button class="w-full bg-[#0095DA] hover:bg-[#0085c4] transition text-white py-2 rounded text-sm font-medium">
            Update Information
        </button>

    </div>
</form>

    </div>



    {{-- CHANGE PASSWORD --}}
    {{-- SESSION SUCCESS MESSAGE --}}
@if(session('password_success'))
    <div class="bg-green-100 text-green-700 px-3 py-2 rounded mb-3">
        {{ session('password_success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3">
        <ul class="list-disc ml-4 text-sm">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- SESSION ERROR MESSAGES --}}



<div class="bg-white shadow rounded-lg border mb-6">
    <div class="bg-[#0095DA] text-white px-4 py-2 rounded-t-lg font-semibold text-sm">
        Change Password
    </div>

    <div class="p-6">

        <form action="{{ route('password.update.custom') }}" method="POST">
            @csrf

            <label class="text-gray-600 text-sm font-medium">Current Password</label>
            <input type="password" name="current_password"
                placeholder="Enter current password"
                class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />

            <label class="text-gray-600 text-sm font-medium">New Password</label>
            <input type="password" name="new_password"
                placeholder="Enter new password"
                class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />

            <label class="text-gray-600 text-sm font-medium">Confirm New Password</label>
            <input type="password" name="new_password_confirmation"
                placeholder="Confirm new password"
                class="w-full border rounded px-3 py-2 mb-4 text-sm focus:ring focus:ring-blue-200" />

            <button class="w-full bg-[#0095DA] hover:bg-[#0085c4] transition text-white py-2 rounded text-sm font-medium">
                Update Password
            </button>

        </form>

    </div>
</div>




    {{-- SUBSCRIPTION --}}
    <div class="bg-white shadow rounded-lg border p-6">

        <p class="text-gray-700 text-sm font-semibold mb-3">Subscription</p>

        <div class="grid grid-cols-3 gap-4">

            {{-- PLAN --}}
            <div class="border rounded px-3 py-2">
                <p class="text-xs text-gray-500">Plan</p>
                <p class="font-medium text-sm">Silver</p>
            </div>

            {{-- STATUS --}}
            <div class="border rounded px-3 py-2">
                <p class="text-xs text-gray-500">Status</p>
                <p class="font-medium text-sm">Active</p>
            </div>

            {{-- MATURITY --}}
            <div class="border rounded px-3 py-2">
                <p class="text-xs text-gray-500">Maturity Date</p>
                <p class="font-medium text-sm">2025-12-01</p>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-center gap-4">

    <a href="{{ route('user.plan') }}"
       class="bg-[#0095DA] hover:bg-[#0085c4] transition text-white px-4 py-2 rounded text-sm font-medium">
        Change Plan
    </a>

    {{-- <a href="/showcard"
       class="bg-gray-700 hover:bg-gray-800 transition text-white px-4 py-2 rounded text-sm font-medium">
        Show My Card
    </a> --}}

</div>

    </div>

</div>
<!-- MAP MODAL -->
<div id="mapModal"
     class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">

    <div class="bg-white w-full max-w-2xl rounded-lg shadow-xl p-4">

        <!-- Top Header -->
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-semibold">Select Location</h2>
            <button onclick="closeMap()"
                    class="text-gray-500 hover:text-black">✕</button>
        </div>

        <!-- Search Input -->
        <input
            id="mapSearch"
            type="text"
            placeholder="Search location..."
            class="w-full border px-3 py-2 rounded mb-3"
        />

        <!-- Map Box -->
        <div id="map" class="w-full h-64 rounded"></div>

        <button onclick="applyLocation()"
                class="mt-4 w-full bg-[#0095DA] hover:bg-[#007bb3] text-white py-2 rounded">
            Select this location
        </button>
    </div>
</div>
 <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6oBwyKGYp3YY-4M_dtgigaVDvbW55f4&libraries=places">
    </script>
<script>
let map, marker, autocomplete;

document.getElementById("location").addEventListener("click", function () {
    openMap();
});

function openMap() {
    document.getElementById("mapModal").classList.remove("hidden");

    const userLat = parseFloat("{{ auth()->user()->latitude }}") || 23.2599;
    const userLng = parseFloat("{{ auth()->user()->longitude }}") || 77.4126;

    const centerPos = { lat: userLat, lng: userLng };

    map = new google.maps.Map(document.getElementById("map"), {
        center: centerPos,
        zoom: 14,
    });

    marker = new google.maps.Marker({
        position: centerPos,
        map: map,
        draggable: true
    });

    google.maps.event.addListener(map, "click", function (event) {
        marker.setPosition(event.latLng);
        updateLatLng(event.latLng.lat(), event.latLng.lng());
    });

    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById("mapSearch")
    );

    autocomplete.addListener("place_changed", function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) return;

        map.setCenter(place.geometry.location);
        marker.setPosition(place.geometry.location);

        updateLatLng(
            place.geometry.location.lat(),
            place.geometry.location.lng()
        );

        document.getElementById("location").value = place.formatted_address;
    });
}

function updateLatLng(lat, lng) {
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
}

function applyLocation() {
    const lat = marker.getPosition().lat();
    const lng = marker.getPosition().lng();

    updateLatLng(lat, lng);

    // Reverse geocode for address
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ location: { lat, lng } }, function (results) {
        if (results[0]) {
            document.getElementById("location").value = results[0].formatted_address;
        }
    });

    closeMap();
}

function closeMap() {
    document.getElementById("mapModal").classList.add("hidden");
}
</script>


@endsection
