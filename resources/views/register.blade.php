<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

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
        <h2 class="text-center text-3xl font-bold text-white">Create account</h2>
        <p class="text-center text-gray-400 mt-2">
            You get <span class="font-bold text-white">7 free days</span> trial.
        </p>

        <form id="registerForm" class="mt-10 space-y-6" enctype="multipart/form-data">
            @csrf

            <div>
                <label class="text-gray-300 text-sm">Full name</label>
                <input type="text" name="name" id="name"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter Full Name" />
                <p id="nameError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label class="text-gray-300 text-sm">E-mail</label>
                <input type="email" name="email" id="email"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter Email" />
                <p id="emailError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label class="text-gray-300 text-sm">Phone Number</label>
                <input type="number" name="phone" id="phone"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter Phone Number" />
                <p id="phoneError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label class="text-gray-300 text-sm">Select Your City</label>
                <input type="text" name="location" id="location" readonly
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 cursor-pointer focus:ring-2 focus:ring-indigo-500"
                    placeholder="Click to select location" />
                <p id="locationError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <input type="hidden" id="latitude" name="latitude" />
            <input type="hidden" id="longitude" name="longitude" />

            <div>
                <label class="text-gray-300 text-sm">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Enter password" />
                <p id="passwordError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label class="text-gray-300 text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700 focus:ring-2 focus:ring-indigo-500"
                    placeholder="Confirm password" />
                <p id="confirmError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <div>
                <label class="text-gray-300 text-sm">Profile Picture</label>
                <input type="file" name="profile" id="profile" accept="image/*"
                    class="w-full mt-2 bg-[#131419] text-white rounded-md px-3 py-2 border border-gray-700" />
                <p id="profileError" class="text-red-500 text-sm mt-1"></p>
            </div>

            <button id="submitBtn"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold transition">
                Create account
            </button>
        </form>

        <p class="text-center text-gray-400 mt-6">
            I already have an account. <a href="/" class="text-indigo-400">Sign In</a>
        </p>
    </div>

    <!-- MAP MODAL -->
    <div id="mapModal"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:1000; justify-content:center; align-items:center;">
        <div
            style="background:white; width:90%; max-width:600px; border-radius:8px; padding:10px; position:relative; overflow:hidden;">
            <h3 style="text-align:center; font-weight:bold;">Select Your Location</h3>

            <input id="mapSearch" type="text" placeholder="Search location..."
                style="width:100%; padding:8px; margin:10px 0; border:1px solid #ccc; border-radius:6px;" />

            <div id="map" style="height:400px; width:100%; border-radius:6px;"></div>

            <div style="text-align:center; margin-top:10px;">
                <button id="closeMapBtn"
                    style="background:#dc3545; color:white; padding:6px 12px; border-radius:6px;">Close</button>
                <button id="selectLocationBtn"
                    style="background:#007bff; color:white; padding:6px 12px; border-radius:6px;">Select</button>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- GOOGLE MAPS -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6oBwyKGYp3YY-4M_dtgigaVDvbW55f4&libraries=places">
    </script>

    <script>
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const phoneInput = document.getElementById("phone");
        const locationInput = document.getElementById("location");
        const passwordInput = document.getElementById("password");
        const confirmInput = document.getElementById("password_confirmation");
        const profileInput = document.getElementById("profile");

        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        const phoneError = document.getElementById("phoneError");
        const locationError = document.getElementById("locationError");
        const passwordError = document.getElementById("passwordError");
        const confirmError = document.getElementById("confirmError");
        const profileError = document.getElementById("profileError");

        document.getElementById("registerForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById("submitBtn");
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = "Please Wait...";

            nameError.innerText = "";
            emailError.innerText = "";
            phoneError.innerText = "";
            locationError.innerText = "";
            passwordError.innerText = "";
            confirmError.innerText = "";
            profileError.innerText = "";

            let valid = true;

            if (nameInput.value.trim().length < 3) {
                nameError.innerText = "Name is required";
                valid = false;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
                emailError.innerText = "Enter valid email";
                valid = false;
            }
            if (phoneInput.value.trim().length < 10) {
                phoneError.innerText = "Enter valid phone";
                valid = false;
            }
            if (!locationInput.value.trim()) {
                locationError.innerText = "Select location";
                valid = false;
            }
            if (passwordInput.value.trim().length < 6) {
                passwordError.innerText = "Password must be 6+ characters";
                valid = false;
            }
            if (passwordInput.value.trim() !== confirmInput.value.trim()) {
                confirmError.innerText = "Passwords do not match";
                valid = false;
            }
            if (!profileInput.files.length) {
                profileError.innerText = "Profile required";
                valid = false;
            }

            if (!valid) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('register.store') }}", {
                    method: "POST",
                    headers: { Accept: "application/json" },
                    body: formData,
                });

                const data = await response.json();

                if (data.success) {
                    toastr.success("Account created!");
                    // setTimeout(() => (window.location.href = "/login"), 1500);
                } else {
                    toastr.error(data.message || "Error");
                }
            } catch (err) {
                toastr.error("Server error");
            }

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });

        // MAP CODE
        let map, marker, geocoder;

        locationInput.addEventListener("click", () => {
            document.getElementById("mapModal").style.display = "flex";
            initMap();
        });

        document.getElementById("closeMapBtn").onclick = () =>
            (document.getElementById("mapModal").style.display = "none");

        document.getElementById("selectLocationBtn").onclick = () =>
            (document.getElementById("mapModal").style.display = "none");

        function initMap() {
            if (map) return;

            const defaultLoc = { lat: 28.6139, lng: 77.209 };

            geocoder = new google.maps.Geocoder();

            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLoc,
                zoom: 12,
            });

            marker = new google.maps.Marker({
                map,
                position: defaultLoc,
                draggable: true,
            });

            google.maps.event.addListener(marker, "dragend", (e) =>
                setLocation(e.latLng)
            );

            map.addListener("click", (e) => setLocation(e.latLng));

            // AUTOCOMPLETE
            const input = document.getElementById("mapSearch");
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                }

                marker.setPosition(place.geometry.location);
                setLocation(place.geometry.location);
            });
        }

        function setLocation(latlng) {
            marker.setPosition(latlng);
            map.panTo(latlng);

            geocoder.geocode({ location: latlng }, (results, status) => {
                let address = latlng.lat() + "," + latlng.lng();

                if (status === "OK" && results[0]) {
                    address = results[0].formatted_address;
                }

                locationInput.value = address;
                document.getElementById("latitude").value = latlng.lat();
                document.getElementById("longitude").value = latlng.lng();
            });
        }
    </script>
</body>

</html>
