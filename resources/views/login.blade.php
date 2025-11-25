<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | Business Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-[#0D0D0F] min-h-screen flex items-center justify-center px-4">

    <div class="grid grid-cols-1 md:grid-cols-2 max-w-6xl w-full gap-10">

        <!-- LEFT -->
        <div class="flex flex-col justify-center">
            <h1 class="text-5xl font-bold text-white leading-tight">
                Pay less <br> in real places
            </h1>

            <p class="text-gray-400 mt-6 text-lg">
                Benefits at cafes, bars, nail salons, gyms, barbershops, restaurants and more.
            </p>

            <div class="mt-6 space-y-3 text-gray-300">
                <div class="flex items-center gap-2">
                    💎 <span>Verified discounts</span>
                </div>
                <div class="flex items-center gap-2">
                    📍 <span>Local businesses near you</span>
                </div>
                <div class="flex items-center gap-2">
                    ⚡ <span>Show the app and you're done</span>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="bg-[#151515] shadow-xl rounded-2xl p-8 w-full max-w-md mx-auto">

            <h2 class="text-center text-2xl font-bold text-white mb-4">Cash</h2>
            <p class="text-center text-gray-400 mb-6">Get into</p>

            <!-- TABS -->
            <div class="flex justify-center mb-6 border-b border-gray-700 pb-2">
                <button id="userTab"
                        class="px-6 py-2 font-semibold text-purple-400 border-b-2 border-purple-500">
                    User Login
                </button>
                <button id="businessTab"
                        class="px-6 py-2 font-semibold text-gray-400 hover:text-purple-400">
                    Business Login
                </button>
            </div>

            <!-- USER LOGIN -->
            <form id="userLoginForm" class="space-y-5">
                @csrf

                <div>
                    <label class="text-gray-300 text-sm">User Email</label>
                    <input id="userEmail" type="email"
                           class="w-full px-3 py-2 rounded-md bg-[#222] text-white border border-gray-700">
                </div>

                <div>
                    <label class="text-gray-300 text-sm">Password</label>
                    <input id="userPassword" type="password"
                           class="w-full px-3 py-2 rounded-md bg-[#222] text-white border border-gray-700">
                </div>

                <button id="userLoginBtn"
                        class="w-full py-2 rounded-md bg-purple-600 text-white font-semibold hover:bg-purple-700">
                    Sign in
                </button>

                <p class="text-center text-gray-500 text-sm mt-4">
                    Don't have an account?
                    <a href="/register" class="text-purple-400">Create an account</a>
                </p>
            </form>

            <!-- BUSINESS LOGIN -->
            <form id="businessLoginForm" class="space-y-5 hidden">
                @csrf

                <div>
                    <label class="text-gray-300 text-sm">Business Email</label>
                    <input id="businessEmail" type="email"
                           class="w-full px-3 py-2 rounded-md bg-[#222] text-white border border-gray-700">
                </div>

                <div>
                    <label class="text-gray-300 text-sm">Password</label>
                    <input id="businessPassword" type="password"
                           class="w-full px-3 py-2 rounded-md bg-[#222] text-white border border-gray-700">
                </div>

                <button id="businessLoginBtn"
                        class="w-full py-2 rounded-md bg-purple-600 text-white font-semibold hover:bg-purple-700">
                    Sign in
                </button>
                <p class="text-center text-gray-500 text-sm mt-4">
                    Don't have an account?
                    <a href="/business/register" class="text-purple-400">Create an account</a>
                </p>
            </form>

        </div>
    </div>


<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // TAB SWITCH
    $('#userTab').click(function () {
        $(this).addClass('text-purple-400 border-purple-500 border-b-2')
               .removeClass('text-gray-400');
        $('#businessTab').removeClass('text-purple-400 border-purple-500 border-b-2')
                         .addClass('text-gray-400');
        $('#userLoginForm').removeClass('hidden');
        $('#businessLoginForm').addClass('hidden');
    });

    $('#businessTab').click(function () {
        $(this).addClass('text-purple-400 border-purple-500 border-b-2')
               .removeClass('text-gray-400');
        $('#userTab').removeClass('text-purple-400 border-purple-500 border-b-2')
                     .addClass('text-gray-400');
        $('#businessLoginForm').removeClass('hidden');
        $('#userLoginForm').addClass('hidden');
    });

    // USER LOGIN
    $('#userLoginForm').submit(function(e){
        e.preventDefault();

        let email = $('#userEmail').val().trim();
        let password = $('#userPassword').val().trim();
        let btn = $('#userLoginBtn');

        if (!email) return toastr.error("Enter email");
        if (!password) return toastr.error("Enter password");

        btn.prop('disabled', true).text('Please wait...');

        $.post("{{ route('login.user') }}", { email, password }, function(res){

            if (res.errors && res.errors.membership_plan) {
                toastr.error(res.errors.membership_plan[0]);
                setTimeout(()=> location.href="/account", 1500);
                return;
            }

            if (res.errors && res.errors.approved) {
                toastr.error(res.errors.approved[0]);
                return;
            }

            if (res.success) {
                toastr.success(res.message);
                setTimeout(()=> location.href = res.redirect || "/home", 1000);
                return;
            }

            toastr.error(res.message);
        })
        .fail(function(){
            toastr.error("Login failed");
        })
        .always(function(){
            btn.prop('disabled', false).text('Sign in');
        });

    });

    // BUSINESS LOGIN
    $('#businessLoginForm').submit(function(e){
        e.preventDefault();

        let email = $('#businessEmail').val().trim();
        let password = $('#businessPassword').val().trim();
        let btn = $('#businessLoginBtn');

        if (!email) return toastr.error("Enter business email");
        if (!password) return toastr.error("Enter password");

        btn.prop('disabled', true).text('Please wait...');

        $.post("{{ route('business.login') }}", { email, password }, function(res){
            if (res.success) {
                toastr.success(res.message);
                setTimeout(() => location.href = res.redirect || "/business/dashboard", 1000);
            } else {
                toastr.error(res.message);
            }
        })
        .always(function(){
            btn.prop('disabled', false).text('Sign in');
        });
    });

});
</script>

</body>
</html>
