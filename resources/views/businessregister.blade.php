<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        body {
            background: #111216;
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-lg bg-[#1b1d24] p-8 rounded-2xl shadow-xl">
        <h2 class="text-center text-3xl font-bold text-white">Add Your Business </h2>

<br>

        <form id="businessRegisterForm" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-300">Shop Name</label>
                <input type="text" name="shop_name" placeholder="Enter Your Shop Name"
                    class="w-full border bg-[#131419] text-white rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="shopNameError" class="text-red-600 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300">Full Name</label>
                <input type="text" name="name" placeholder="Enter Your Full Name"
                    class="w-full border  bg-[#131419] text-white rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="nameError" class="text-red-600 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300">Email</label>
                <input type="email" name="email" placeholder="Enter Your Email"
                    class="w-full border bg-[#131419] text-white rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="emailError" class="text-red-600 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300">Phone Number</label>
                <input type="number" name="phone" placeholder="Enter Your Phone Number"
                    class="w-full border bg-[#131419] text-white  rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="phoneError" class="text-red-600 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300">Select Your Business City</label>
                <input type="text" name="location" id="location" placeholder="Click to select location"
                    readonly class="w-full bg-[#131419] border rounded px-3 py-2 mt-1 cursor-pointer bg-white text-black">
                <span id="locationError" class="text-red-600 text-sm"></span>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="mb-4">
                <label class="block text-gray-300">Password</label>
                <input type="password" name="password" placeholder="Enter Your Password"
                    class="w-full border rounded bg-[#131419] text-white px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="passwordError" class="text-red-600 text-sm"></span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Enter Your Confirm Password"
                    class="w-full border bg-[#131419] text-white rounded px-3 py-2 mt-1 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <span id="passwordConfirmationError" class="text-red-600 text-sm"></span>
            </div>
            <div>
                <label class="text-gray-300 text-sm">Profile Picture</label>
                <input type="file" name="profile" id="profile" accept="image/*"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700" />
                <p id="profileError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">
                Register Business
            </button>
        </form>

        <p class="text-center text-gray-400 mt-6">
            I already have an account. <a href="/" class="text-indigo-400">Sign In</a>
        </p>
    </div>

    <!-- MAP MODAL -->
    <div id="mapModal"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:1000; justify-content:center; align-items:center;">
        <div style="background:white; width:90%; max-width:600px; border-radius:8px; padding:10px;">
            <h3 style="text-align:center; font-weight:bold;">Select Your Location</h3>

            <input id="mapSearch" type="text" placeholder="Search location..."
                style="width:100%; padding:8px; margin:10px 0; border:1px solid #ccc; border-radius:6px;" />

            <div id="map" style="height:400px; width:100%; border-radius:6px;"></div>

            <div style="text-align:center; margin-top:10px;">
                <button id="closeMapBtn" style="background:#dc3545; color:white; padding:6px 12px; border-radius:6px;">Close</button>
            </div>
        </div>
    </div>

    <!-- Toastr -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Google Maps -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6oBwyKGYp3YY-4M_dtgigaVDvbW55f4&libraries=places"></script>

    <!-- MAP + AJAX -->
    <script>

        let map, marker, geocoder;

        document.getElementById('location').addEventListener('click', function () {
            document.getElementById('mapModal').style.display = 'flex';
            initMap();
        });

        document.getElementById('closeMapBtn').addEventListener('click', function () {
            document.getElementById('mapModal').style.display = 'none';
        });

        function initMap() {
            if (map) return;

            geocoder = new google.maps.Geocoder();

            const defaultLoc = { lat: 23.2599, lng: 77.4126 }; // Bhopal default

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLoc,
            });

            marker = new google.maps.Marker({
                position: defaultLoc,
                map: map,
                draggable: true
            });

            map.addListener("click", (e) => {
                const lat = e.latLng.lat();
                const lng = e.latLng.lng();
                marker.setPosition(e.latLng);
                updateLocation(lat, lng);
            });

            marker.addListener("dragend", (e) => {
                updateLocation(e.latLng.lat(), e.latLng.lng());
            });

            const input = document.getElementById("mapSearch");
            const searchBox = new google.maps.places.SearchBox(input);

            searchBox.addListener("places_changed", () => {
                const place = searchBox.getPlaces()[0];
                if (!place.geometry) return;

                marker.setPosition(place.geometry.location);
                map.panTo(place.geometry.location);

                updateLocation(place.geometry.location.lat(), place.geometry.location.lng());
            });
        }

        function updateLocation(lat, lng) {
            geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                if (status === "OK" && results[0]) {
                    document.getElementById("location").value = results[0].formatted_address;
                } else {
                    document.getElementById("location").value = `${lat},${lng}`;
                }
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
            });
        }

        // AJAX SUBMIT

        $('#businessRegisterForm').submit(function (e) {
    e.preventDefault();

    $('.text-red-600').text("");

    let formData = new FormData(this);

    $.ajax({
        url: '{{ route("business.store") }}',
        method: 'POST',
        data: formData,
        processData: false,  // ❗❗ Important for file upload
        contentType: false,  // ❗❗ Important for file upload
        success: function (response) {
            toastr.success("Registration Successful!");
            window.location.href = "/login";
        },
        error: function (xhr) {
            if (xhr.status === 422) {

                let e = xhr.responseJSON.errors;

                if (e.shop_name) $('#shopNameError').text(e.shop_name[0]);
                if (e.name) $('#nameError').text(e.name[0]);
                if (e.email) $('#emailError').text(e.email[0]);
                if (e.phone) $('#phoneError').text(e.phone[0]);
                if (e.location) $('#locationError').text(e.location[0]);
                if (e.password) $('#passwordError').text(e.password[0]);
                if (e.password_confirmation) $('#passwordConfirmationError').text(e.password_confirmation[0]);
                if (e.profile) $('#profileError').text(e.profile[0]);
            } else {
                toastr.error("Something went wrong!");
            }
        }
    });
});


    </script>
</body>

</html>
