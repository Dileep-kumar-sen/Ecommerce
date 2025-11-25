<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashCash</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
  html, body {
    overflow-x: hidden; /* Prevent unwanted scroll */
  }
</style>
<style>
    .profile-mobilebtn {
        display: flex;
        align-items: center;
        background: #0e3b46;
        padding: 6px 12px;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
        width:156px;
    }
    .profile-btn {
        display: flex;
        align-items: center;
        background: #0e3b46;
        padding: 6px 12px;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }
    .profile-btn img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
        border: 2px solid white;
    }
    .profile-mobilebtn img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 8px;
        object-fit: cover;
        border: 2px solid white;
    }
    .profile-dropdown {
        display: none;
        position: absolute;
        right: 0;
        margin-top: 5px;
        background: #0c2e38;
        width: 200px;
        border-radius: 10px;
        overflow: hidden;
        padding: 6px 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: white;
        font-size: 14px;
        text-decoration: none;
        transition: .3s;
    }
    .dropdown-item:hover {
        background: #0a2331;
    }
    .dropdown-mobileitem {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: rgb(0, 0, 0);
        font-size: 14px;
        text-decoration: none;
        transition: .3s;
    }
    .dropdown-mobileitem:hover {
        background: #0a2331;
        color:white;
    }
    .offer-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
</style>
<style>
    .preview-box {
        width: 90px;
        height: 90px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
    }

    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* crop but fill */
    }
</style>

<style>
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.97);
      }

      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .animate-fadeIn {
      animation: fadeIn 0.6s ease-out;
    }

    /* Floating animation for logo */
    @keyframes float {
      0% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0px);
      }
    }

    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
  </style>
<style>
        /* Smooth fade-in animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    <style>
        #redeemTable td,
        #redeemTable th {
            white-space: nowrap;
        }

        .dropdownItem {
            display: block;
            padding: 10px 16px;
            font-size: 13px;
            color: #333;
            text-decoration: none;
            transition: 0.2s;
        }

        .dropdownItem:hover {
            background: #f5f5f5;
            color: #111;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .fade {
            animation: fadeEffect 1s ease-in-out;
        }

        @keyframes fadeEffect {
            from {
                opacity: 0.4;
            }

            to {
                opacity: 1;
            }
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <script>
        function toggleDropdown() {
            document.getElementById('dropdownMenu').classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-white">
    <!-- Include this in your main layout, e.g., app.blade.php -->


    <!-- 🔹 Top Strip -->
    <!-- 🔹 Topbar -->
    {{-- <div class=" w-full mx-auto text-white border-b border-white/20 rounded" style="background:white">
        <div class="px-4">
            <div class="flex justify-between items-center py-2 text-sm">

                <!-- Left -->
                <div class="flex items-center space-x-6">
                    <span class="flex items-center hover:text-#f5e10e-200 cursor-pointer transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.657 16.657L13.414 12.414C12.633 11.633 11.367 11.633 10.586 12.414L6.343 16.657M15 11V7a3 3 0 00-6 0v4M5 20h14" />
                        </svg>
                        <span style="color:blue">Find your city</span>
                    </span>
                </div>

                <!-- Right -->
                <div class="flex space-x-6">
                    <a href="/detail" class="hover:text-#f5e10e-200 transition" style="color:blue">How it works?</a>
                    <a href="/detail" class="hover:text-#f5e10e-200 transition" style="color:blue">Help Center</a>
                </div>

            </div>
        </div>
    </div> --}}
    <div class="mx-auto text-white border-b border-white/20 rounded">




        <!-- 🔹 Main Navbar -->
        <nav class="w-full sticky top-0 z-50 bg-white/80 backdrop-blur-md" style="background: rgba(23, 162, 184, 0.78)">
            <div class="max-w-[91rem] mx-auto px-6 sm:px-8 lg:px-12">
                <div class="flex justify-between h-[5rem]">

                    <!-- Left -->
                    <div class="flex items-center">
    <!-- Image -->
    <a class="flex items-center font-bold text-white space-x-2" href="{{ asset('/home') }}">
    <img src="{{ asset('icon_white.png') }}" class="w-8 h-8" />
    <span class="text-white text-[20px]">CashCash</span>
</a>

</div>



                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-10 justify-center" style="gap:0x">
                               <div class="flex-1 max-w-lg ml-6 relative">
    <div class="relative">
       <input
    type="text"
    id="searchInput"
    placeholder="Search deals, restaurants, activities..."
    class="w-full border rounded-lg pl-10 pr-[18rem] py-3 text-sm focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm h-[39px] text-black placeholder-gray-400"
/>


        <svg class="w-5 h-5 absolute left-4 top-3 text-gray-400" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
        </svg>
    </div>

    <!-- 🔹 Popup Search Result Box -->
    <div id="searchResults"
        class="absolute top-12 left-0 w-full bg-white border rounded-lg shadow-lg z-50 hidden max-h-64 overflow-y-auto">
        <!-- Search results will appear here dynamically -->
    </div>
</div>

                        <!-- Search -->


                    </div>

                    {{-- @php
                        use App\Models\Category;
                        use App\Models\Subcategory;

                        // Saare categories fetch karo
                        $categories = Category::all();
                    @endphp

                    <div id="dropdownMenu"
                        class="hidden absolute left-0 mt-2 w-full md:w-[800px] bg-white shadow-lg rounded-lg p-4 md:p-6 grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-sm z-50"
                        style="margin-top:59px;">

                        <button onclick="document.getElementById('dropdownMenu').classList.add('hidden')"
                            class="absolute top-3 right-3 text-gray-600 hover:text-red-600 md:hidden">
                            ✕
                        </button>

                        @foreach ($categories as $category)
                            @php
                                // Har category ki subcategories lao category_id se
                                $subcategories = SubCategory::where('category_id', $category->id)->get();
                            @endphp

                            <div>
                                <h3 class="font-semibold text-red-600 mb-2">{{ $category->name }}</h3>

                                @if ($subcategories->count() > 0)
                                    <ul class="space-y-1">
                                        @foreach ($subcategories as $subcategory)
                                            <li>
                                                <a href="#" class="text-blue-600 hover:underline">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 text-sm">No subcategories found</p>
                                @endif
                            </div>
                        @endforeach

                    </div> --}}



                    <!-- Right Desktop -->
                    <div class="hidden md:flex items-center space-x-8">

<a href="business/register"
                            class="text-[#FFFFFF] hover:text-pink-600 transition text-[15px]">Add your business</a>
                        <a href="/help-center"
                            class="text-[#FFFFFF] hover:text-pink-600 transition text-[15px]">Help Support</a>
                       <div style="position: relative; display: inline-block;">

    @auth
        @php
            $img = asset('uploads/profiles/' . Auth::user()->profile);
                 // fallback image
        @endphp

        <!-- 🔹 Profile Button -->
        <div id="profileButton" class="profile-btn">
            <img src="{{ $img }}" alt="Profile">
            {{ Auth::user()->name }}
            <span style="margin-left:6px;">▼</span>
        </div>

        <!-- 🔹 Dropdown -->
        <div id="profileDropdown" class="profile-dropdown">

            <a href="/account" class="dropdown-item">
                ⚙️ Account
            </a>

            <a href="/paymenthistory" class="dropdown-item">
                💳 History Of Plans
            </a>

            {{-- <a href="/forgot-password" class="dropdown-item">
                🔐 Forgot Password
            </a>

            <a href="/myredeem" class="dropdown-item">
                🎫 My Redeemed Coupons
            </a>

            <a href="/mypending" class="dropdown-item">
                ⏳ Pending Coupons
            </a>

            <a href="/coupon" class="dropdown-item">
                🟢 Coupons Left
            </a> --}}

            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item w-full text-left">
                    🚪 Logout
                </button>
            </form>
        </div>
    @endauth

</div>




                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex md:hidden items-center">
                        <button id="menu-btn" class="text-gray-700 focus:outline-none" style="background: #FFFFFF">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <!-- Mobile Menu Wrapper -->
                <div id="mobile-menu" class="md:hidden hidden mt-3 space-y-3">
                    <div class="flex-1 max-w-lg relative">

    <div class="relative">
        <input
            type="text"
            id="mobileSearchInput"
            placeholder="Search deals, restaurants, activities..."
            class="w-full border rounded-lg pl-10 pr-0 py-3 text-sm focus:ring-2 focus:ring-pink-500 focus:outline-none shadow-sm h-[39px] text-black placeholder-gray-400"
        />

        <svg class="w-5 h-5 absolute left-4 top-3 text-gray-400" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"></path>
        </svg>
    </div>

   <div id="mobileSearchResults"
     class="absolute top-12 left-0 w-full bg-white border rounded-lg shadow-lg
            z-[99999] hidden max-h-64 overflow-y-auto">


    </div>

</div>

                    <!-- Categories Toggle Button -->
                    {{-- <button onclick="toggleDropdown()"
                        class="w-full flex items-center justify-between text-white hover:text-pink-600 px-3 py-3 rounded transition">
                        Categories
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button> --}}

                    <!-- Add Business -->

                    <a href="business/register"
                        class="block text-white hover:text-pink-600 px-3 py-3 rounded transition">
                        Add your business
                    </a>
                    <a href="/help-center"
                        class="block text-white hover:text-pink-600 px-3 py-3 rounded transition">
                        Help Support
                    </a>

                    <!-- Guest: Sign In -->
                    @guest
                       <div class="w-[41%] ">
    <a href="/login"
        class="flex items-center border border-gray-300 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-300 hover:text-green-700 transition">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12H3m12 0l-4-4m4 4l-4 4M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        Sign In
    </a>
</div>

                    @endguest

                    <!-- Authenticated User -->
                    @auth
                        <div class="relative">
                            <button id="profileButtonDesktop"
        onclick="toggleDesktopDropdown()"
        class="hidden md:flex items-center border border-gray-300 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-300 hover:text-green-700 transition">
    <img src="{{ asset('/account.png') }}" class="w-7 h-7 mr-2 rounded-full">
    {{ Auth::user()->name }}
</button>
{{-- <button id="profileButtonMobile"
        onclick="toggleMobileDropdown()"
        class="flex md:hidden items-center border border-gray-300 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-300 hover:text-green-700 transition">
    <img src="{{ asset('/account.png') }}" class="w-7 h-7 mr-2 rounded-full">
    jj
</button> --}}
<div id="profileButtonMobile" class="profile-mobilebtn" onclick="toggleMobileDropdown()">
            <img src="{{ $img }}" alt="Profile">
            {{ Auth::user()->name }}
            <span style="margin-left:6px;">▼</span>
        </div>


                            <!-- Dropdown -->
                            <div id="profileDropdown"
                                class="hidden absolute right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-2 z-50 w-full">

                                @php
                                    $plan = auth()->user()->membership_plan ?? 0;
                                @endphp

                                @if ($plan == 0)
                                    <a href="/account" class="dropdown-item">
                ⚙️ Account
            </a>

            <a href="/paymenthistory" class="dropdown-item">
                💳 History Of Plans
            </a>

            {{-- <a href="/forgot-password" class="dropdown-item">
                🔐 Forgot Password
            </a>

            <a href="/myredeem" class="dropdown-item">
                🎫 My Redeemed Coupons
            </a>

            <a href="/mypending" class="dropdown-item">
                ⏳ Pending Coupons
            </a>

            <a href="/coupon" class="dropdown-item">
                🟢 Coupons Left
            </a> --}}

            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item w-full text-left">
                    🚪 Logout
                </button>
            </form>
                                @else
                                    <a href="/account" class="dropdownItem">Account</a>
                                    <a href="/forgot-password" class="dropdownItem">Forgot Password</a>
                                    <a href="/activemembership" class="dropdownItem">Active Membership</a>
                                    <a href="/coupon" class="dropdownItem">Coupons Left / Redeemed</a>
                                    <a href="/achievements" class="dropdownItem">Achievements / Streaks</a>
                                    <a href="/paymenthistory" class="dropdownItem">Payment History</a>
                                    <a href="/myredeem" class="dropdownItem">My Redeemed Coupon</a>
                                    <a href="/mypending" class="dropdownItem">My Pending Coupon</a>
                                    <a href="#" onclick="logout()" class="dropdownItem text-red-600">Logout</a>
                                @endif

                                <!-- Hidden Logout Form -->
                                <form id="logout-form" action="#" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                            <div id="profileDropdownMobile"
     class="hidden md:hidden bg-white border border-gray-200 rounded-lg shadow-lg mt-2 p-2 z-50 w-full">
     @php
                                    $plan = auth()->user()->membership_plan ?? 0;
                                @endphp

                                @if ($plan == 0)
                                     <a href="/account" class="dropdown-mobileitem">
                ⚙️ Account
            </a>

            <a href="/paymenthistory" class="dropdown-mobileitem">
                💳 History Of Plans
            </a>

            {{-- <a href="/forgot-password" class="dropdown-item">
                🔐 Forgot Password
            </a>

            <a href="/myredeem" class="dropdown-item">
                🎫 My Redeemed Coupons
            </a>

            <a href="/mypending" class="dropdown-item">
                ⏳ Pending Coupons
            </a>

            <a href="/coupon" class="dropdown-item">
                🟢 Coupons Left
            </a> --}}

            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-mobileitem w-full text-left">
                    🚪 Logout
                </button>
            </form>
                                @else
                                    <a href="/account" class="dropdownItem">Account</a>
                                    <a href="/forgot-password" class="dropdownItem">Forgot Password</a>
                                    <a href="/activemembership" class="dropdownItem">Active Membership</a>
                                    <a href="/coupon" class="dropdownItem">Coupons Left / Redeemed</a>
                                    <a href="/achievements" class="dropdownItem">Achievements / Streaks</a>
                                    <a href="/paymenthistory" class="dropdownItem">Payment History</a>
                                    <a href="/myredeem" class="dropdownItem">My Redeemed Coupon</a>
                                    <a href="/mypending" class="dropdownItem">My Pending Coupon</a>
                                    <a href="#" onclick="logout()" class="dropdownItem text-red-600">Logout</a>
                                @endif

                                <!-- Hidden Logout Form -->
                                <form id="logout-form" action="#" method="POST" class="hidden">
                                    @csrf
                                </form>
</div>

                        </div>
                    @endauth
                </div>

            </div>
        </nav>
    </div>




    <!-- 🔹 Hero Section -->
    @yield('content')
<div id="cashcashModal"
    class="fixed inset-0 bg-gradient-to-br from-[#2E2173]/90 to-black/90 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 sm:p-6 overflow-y-auto">

    <div
      class="bg-white rounded-3xl shadow-2xl w-full max-w-[850px] p-6 sm:p-10 relative animate-fadeIn border-4 border-[#2E2173] mt-10 mb-10 mt-[750px] lg:mt-[299px]">

      <!-- Close Button (always visible) -->
      <button id="closeModalBtn"
        class="absolute top-4 right-4 sm:top-6 sm:right-6 text-gray-500 hover:text-[#2E2173] text-3xl font-bold transition z-50 bg-white/70 rounded-full px-2">
        &times;
      </button>

      <!-- Header Section -->
      <div class="text-center mb-8">
        <div class="flex justify-center mb-6 animate-float">
          <div class="bg-[#2E2173] rounded-full p-4 sm:p-5 shadow-lg">
            <img src="{{ asset('logo2.png') }}" alt="CashCash Logo"
              class="w-24 h-16 sm:w-28 sm:h-20 object-contain">
          </div>
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-[#2E2173] leading-tight">
          Welcome to <span class="text-yellow-400">{{ auth()->user()->name }}</span>
        </h2>
        <p class="text-gray-600 mt-2 text-base sm:text-lg px-2">
          Your ultimate destination for offers, rewards, and savings!
        </p>
      </div>

      <!-- Content Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 text-gray-700">

        <!-- Purpose Section -->
        <div class="bg-[#2E2173]/5 p-5 sm:p-6 rounded-2xl border border-[#2E2173]/10 hover:shadow-md transition">
          <h3 class="text-lg sm:text-xl font-bold text-[#2E2173] mb-3 flex items-center">
            <i class="fa-solid fa-bullseye text-yellow-400 mr-2"></i> Purpose
          </h3>
          <p class="text-sm sm:text-base leading-relaxed">
            CashCash helps users discover exciting offers, earn rewards, and enjoy exclusive discounts from local stores
            and online merchants — making shopping fun and rewarding.
          </p>
        </div>

        <!-- Key Features Section -->
        <div class="bg-[#2E2173]/5 p-5 sm:p-6 rounded-2xl border border-[#2E2173]/10 hover:shadow-md transition">
          <h3 class="text-lg sm:text-xl font-bold text-[#2E2173] mb-3 flex items-center">
            <i class="fa-solid fa-star text-yellow-400 mr-2"></i> Key Features
          </h3>
          <ul class="space-y-2 sm:space-y-3 text-sm sm:text-[15px] leading-relaxed">
            <li>🎁 Claim & redeem offers with one tap</li>
            <li>🏆 Unlock achievements & collect rewards</li>
            <li>💸 Enjoy instant discounts at partner stores</li>
            <li>👥 Invite friends & earn referral bonuses</li>
            <li>📊 Track your savings & achievements easily</li>
          </ul>
        </div>
      </div>

      <!-- Why Users Love CashCash -->
      <div class="bg-gradient-to-r from-[#2E2173]/10 to-yellow-100 mt-8 p-5 sm:p-6 rounded-2xl border border-[#2E2173]/10">
        <h3
          class="text-lg sm:text-xl font-bold text-[#2E2173] mb-3 flex items-center justify-center text-center leading-snug">
          <i class="fa-solid fa-heart text-yellow-400 mr-2"></i> Why Users Love CashCash
        </h3>
        <p class="text-gray-700 text-center text-sm sm:text-[15px] leading-relaxed px-2">
          Because it’s simple, rewarding, and fun! CashCash connects you to real offers that matter — save money,
          achieve milestones, and share happiness with your friends!
        </p>
      </div>

      <!-- Footer Button -->
      <div class="mt-10 text-center">
        <button id="closeModalBtn2"
          class="bg-[#2E2173] hover:bg-[#1f1655] text-yellow-400 font-bold py-3 px-8 sm:px-10 rounded-full text-base sm:text-lg transition shadow-lg">
          Let’s Get Started
        </button>
      </div>
    </div>
  </div>


    <!-- 🔹 Footer Section -->

   <footer class="bg-black text-white pt-5 pb-4">
  <div class="container" style="padding: 27px">

    <div class="row text-center text-md-start">

      <!-- LOGO Section -->
      <div class="col-12 col-md-4 mb-4">
        <a href="index.php" class="text-white fs-3 fw-bold text-decoration-none">
          CashCash
        </a>
      </div>

      <!-- LINKS Section -->
      <div class="col-6 col-md-4 mb-4">

        <div class="d-flex gap-4 small justify-content-center justify-content-md-start">
          <a href="/" class="text-white text-decoration-none"  style="padding: 13px" >Home</a>
          <a href="/contact" class="text-white text-decoration-none" style="padding: 13px">Contact</a>
          <a href="terms.php" class="text-white text-decoration-none"  style="padding: 13px">Terms</a>
          <a href="privacy.php" class="text-white text-decoration-none"  style="padding: 13px">Privacy</a>
        </div>

      </div> <!-- ❗Ye missing closing div tha, ab laga diya -->

      <!-- SOCIAL Section -->
      <div class="col-6 col-md-4 mb-4">
        <h6 class="fw-bold mb-3">Follow Us</h6>

        <div class="d-flex gap-3 justify-content-center justify-content-md-start">
          <a href="#" class="text-white fs-5" style="padding: 9px"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white fs-5" style="padding: 9px"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white fs-5" style="padding: 9px"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="text-white fs-5" style="padding: 9px"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

    </div>

    <!-- Divider -->
    <div class="border-top border-light my-3" style="opacity: 0.15;"></div>

    <!-- COPYRIGHT -->
    {{-- <hr class="lg:ml-[130px]"> --}}
    <p class="small text-center mb-0">
      © 2025 <strong>CashCash</strong> — Exclusive Coupon Club. All rights reserved.
    </p>

  </div>
</footer>



    <!-- Hide Scrollbar -->
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.offerSlider', {
        loop: true,
        autoplay: {
            delay: 2000,
        },
        speed: 800,
    });
</script>
<script>
    let itemsToShow = 4;
    const offers = document.querySelectorAll("#offerContainer > div");
    const loadMoreBtn = document.getElementById("loadMoreBtn");

    function showItems() {
        offers.forEach((item, index) => {
            item.style.display = (index < itemsToShow) ? "block" : "none";
        });

        if (itemsToShow >= offers.length) {
            loadMoreBtn.style.display = "none";
        }
    }

    loadMoreBtn.addEventListener("click", () => {
        itemsToShow += 4;
        showItems();
    });

    showItems();
</script>


    <script>
        function toggleDropdown() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function logout() {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        }

        // Optional: Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const button = document.getElementById('profileButton');
            const dropdown = document.getElementById('profileDropdown');

            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <script>
        // Toggle mobile menu
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        let slides = document.querySelectorAll("#hero-carousel .absolute img");
        let index = 0;

        function showSlide(n) {
            slides.forEach((slide, i) => {
                slide.parentElement.classList.add("hidden");
                if (i === n) slide.parentElement.classList.remove("hidden");
            });
        }

        function nextSlide() {
            index = (index + 1) % slides.length;
            showSlide(index);
        }

        // Auto-slide every 4s
        setInterval(nextSlide, 4000);

        // Show first slide initially
        showSlide(index);
        const carousel = document.getElementById("deals-carousel");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");

        prevBtn.addEventListener("click", () => {
            carousel.scrollBy({
                left: -300,
                behavior: "smooth"
            });
        });

        nextBtn.addEventListener("click", () => {
            carousel.scrollBy({
                left: 300,
                behavior: "smooth"
            });
        });
    </script>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdownMenu");
            dropdown.classList.toggle("hidden");
        }
    </script>
    <script>
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent click from bubbling
            profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown if click outside
        document.addEventListener('click', function() {
            profileDropdown.style.display = 'none';
        });
    </script>
    @yield('javascript')
  <script>
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    searchInput.addEventListener("input", async function () {
        const query = this.value.trim();
        searchResults.innerHTML = "";

        if (query === "") {
            searchResults.classList.add("hidden");
            return;
        }

        try {
            const response = await fetch(`/search-offers?q=${encodeURIComponent(query)}`);
            const offers = await response.json();

            if (offers.length > 0) {
                offers.forEach(offer => {
                    const div = document.createElement("div");
                    div.className = "px-4 py-2 hover:bg-pink-100 cursor-pointer text-gray-800 text-sm";
                    div.textContent = offer.title;

                    div.addEventListener("click", () => {
                        window.location.href = `/detail/${offer.id}`;
                    });

                    searchResults.appendChild(div);
                });
                searchResults.classList.remove("hidden");
            } else {
                searchResults.innerHTML = `<div class="px-4 py-2 text-gray-500 text-sm">No results found</div>`;
                searchResults.classList.remove("hidden");
            }
        } catch (error) {
            console.error("Search error:", error);
        }
    });

    // 🛠 FIXED: Hide only when clicking outside both input & results
    document.addEventListener("click", (e) => {
        if (!e.target.closest("#searchInput") && !e.target.closest("#searchResults")) {
            searchResults.classList.add("hidden");
        }
    });
    const searchInputs = document.querySelectorAll("#searchInput, #mobileSearchInput");

searchInputs.forEach(input => {
    const isMobile = input.id === "mobileSearchInput";
    const resultsBox = isMobile
        ? document.getElementById("mobileSearchResults")
        : document.getElementById("searchResults");

    input.addEventListener("input", async function () {
        const query = this.value.trim();
        resultsBox.innerHTML = "";

        if (query === "") {
            resultsBox.classList.add("hidden");
            return;
        }

        try {
            const response = await fetch(`/search-offers?q=${encodeURIComponent(query)}`);
            const offers = await response.json();

            if (offers.length > 0) {
                offers.forEach(offer => {
                    const div = document.createElement("div");
                    div.className = "px-4 py-2 hover:bg-pink-100 cursor-pointer text-gray-800 text-sm";
                    div.textContent = offer.title;

                    div.addEventListener("click", () => {
                        window.location.href = `/detail/${offer.id}`;
                    });

                    resultsBox.appendChild(div);
                });
                resultsBox.classList.remove("hidden");
            } else {
                resultsBox.innerHTML = `<div class="px-4 py-2 text-gray-500 text-sm">No results found</div>`;
                resultsBox.classList.remove("hidden");
            }
        } catch (error) {
            console.error("Search error:", error);
        }
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest("#searchInput") &&
            !e.target.closest("#mobileSearchInput") &&
            !e.target.closest("#searchResults") &&
            !e.target.closest("#mobileSearchResults")
        ) {
            resultsBox.classList.add("hidden");
        }
    });
});

</script>


 <script>
    document.addEventListener("DOMContentLoaded", () => {
      const modal = document.getElementById("cashcashModal");
      const showModal = localStorage.getItem("showModal");

      if (showModal !== "true") {
        modal.classList.remove("hidden");
      }

      const closeModal = () => {
        modal.classList.add("hidden");
        localStorage.setItem("showModal", "true");
      };

      document.getElementById("closeModalBtn").addEventListener("click", closeModal);
      document.getElementById("closeModalBtn2").addEventListener("click", closeModal);
    });
  </script>
<script>


function toggleMobileDropdown() {
    document.getElementById("profileDropdownMobile").classList.toggle("hidden");
}
</script>

</body>

</html>
