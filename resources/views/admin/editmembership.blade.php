@extends('admin.sidebaar')
@section('title', 'Edit Membership Plans')
@section('content')

<div class="w-full max-w-[900px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

    <!-- Membership Type Toggle -->
    <div class="mb-6">
        <label class="block text-gray-700 font-medium mb-1">Membership Type</label>
        <select id="membershipType"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="user" {{ $type == 'user' ? 'selected' : '' }}>User</option>
            <option value="business" {{ $type == 'business' ? 'selected' : '' }}>Business</option>
        </select>
    </div>

    <!-- ================= USER MEMBERSHIP FORM ================= -->
    <div id="userFormContainer">
        <form id="userForm" class="space-y-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $data->id ?? '' }}">

            <!-- Plan Tier -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Plan Tier</label>
                <select name="plan_tier" id="userPlanTier" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="free" {{ ($data->plan_tier ?? '') == 'free' ? 'selected' : '' }}>Free</option>
                    <option value="basic" {{ ($data->plan_tier ?? '') == 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="plus" {{ ($data->plan_tier ?? '') == 'plus' ? 'selected' : '' }}>Plus</option>
                    <option value="premium" {{ ($data->plan_tier ?? '') == 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>

            <!-- Trial Period -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Trial Period (Days)</label>
                <input type="number" name="trial_period_days" value="{{ $data->trial_period_days ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Coupons per Week -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Coupons per Week</label>
                <input type="number" name="coupons_per_week" value="{{ $data->coupons_per_week ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Discount Limit -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Discount Limit (%)</label>
                <input type="text" name="discount_limit" value="{{ $data->discount_limit ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Exclusive Offers -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Exclusive Offers (Monthly)</label>
                <input type="number" name="exclusive_offers_monthly" value="{{ $data->exclusive_offers_monthly ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Features -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Features</label>
                <textarea name="features" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ $data->features ?? '' }}</textarea>
            </div>

            <!-- Achievements -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Achievements</label>
                <textarea name="achievements" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ $data->achievements ?? '' }}</textarea>
            </div>

            <!-- Referral Bonus -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Referral / Bonus Benefits</label>
                <textarea name="referral_bonus" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ $data->referral_bonus ?? '' }}</textarea>
            </div>

            <!-- Plan Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Plan Price (Optional)</label>
                <input type="number" name="plan_price" value="{{ $data->plan_price ?? '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Plan Icon -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Icon For Plan</label>
                <input type="file" name="plan_icon" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" accept="image/*">
                @if(!empty($data->plan_icon))
                    <img id="iconPreview" src="{{ asset($data->plan_icon) }}" class="mt-2 w-16 h-16 rounded-lg border">
                @else
                    <img id="iconPreview" class="mt-2 w-16 h-16 rounded-lg border hidden">
                @endif
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ $data->description ?? '' }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Save Plan
                </button>
            </div>
        </form>
    </div>
<div id="businessForm" style="display: {{ $type === 'business' ? 'block' : 'none' }};">
    <form class="space-y-4" method="POST" action="{{ route('membership.update', $data->id ?? '') }}">
        @csrf

        <input type="hidden" name="membership_type" value="business">
        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">

        <!-- Plan Tier -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Plan Tier</label>
            <select id="businessPlanTier" name="plan_tier" class="w-full px-4 py-2 border rounded-lg">
                <option value="free" {{ ($data->plan_tier ?? '') === 'free' ? 'selected' : '' }}>Free</option>
                <option value="basic" {{ ($data->plan_tier ?? '') === 'basic' ? 'selected' : '' }}>Basic (Paid)</option>
                <option value="standard" {{ ($data->plan_tier ?? '') === 'standard' ? 'selected' : '' }}>Standard (Paid)</option>
                <option value="featured" {{ ($data->plan_tier ?? '') === 'featured' ? 'selected' : '' }}>Featured / Paid</option>
                <option value="premium" {{ ($data->plan_tier ?? '') === 'premium' ? 'selected' : '' }}>Premium Partner / Top</option>
            </select>
        </div>

        <!-- Trial Period -->
        <div id="businessTrialDiv">
            <label class="block text-gray-700 font-medium mb-1">Trial Period (Days)</label>
            <input type="number" name="trial_days" placeholder="7" class="w-full px-4 py-2 border rounded-lg"
                   value="{{ $data->trial_days ?? '' }}">
        </div>

        <!-- Discount -->
        <div id="businessDiscountDiv">
            <label class="block text-gray-700 font-medium mb-1">Discount (%)</label>
            <input type="number" name="discount" class="w-full px-4 py-2 border rounded-lg"
                   value="{{ $data->discount ?? '' }}">
        </div>

        <!-- Visibility Level -->
        <div id="businessVisibilityDiv">
            <label class="block text-gray-700 font-medium mb-1">Visibility Level</label>
            <select name="visibility_level" class="w-full px-4 py-2 border rounded-lg">
                <option value="low" {{ ($data->visibility_level ?? '') === 'low' ? 'selected' : '' }}>Low (Basic)</option>
                <option value="medium" {{ ($data->visibility_level ?? '') === 'medium' ? 'selected' : '' }}>Medium (Standard)</option>
                <option value="high" {{ ($data->visibility_level ?? '') === 'high' ? 'selected' : '' }}>High (Featured)</option>
                <option value="top" {{ ($data->visibility_level ?? '') === 'top' ? 'selected' : '' }}>Top (Premium Partner)</option>
            </select>
        </div>

        <!-- Active Offers Limit -->
        <div id="businessOffersDiv">
            <label class="block text-gray-700 font-medium mb-1">Active Offers Limit</label>
            <input type="number" name="active_offers" class="w-full px-4 py-2 border rounded-lg"
                   value="{{ $data->active_offers ?? '' }}">
        </div>

        <!-- Metrics -->
        <div id="businessMetricsDiv">
            <label class="block text-gray-700 font-medium mb-1">Metrics Access</label>
            <select name="metrics_access" class="w-full px-4 py-2 border rounded-lg">
                <option value="none" {{ ($data->metrics_access ?? '') === 'none' ? 'selected' : '' }}>No Metrics</option>
                <option value="basic" {{ ($data->metrics_access ?? '') === 'basic' ? 'selected' : '' }}>Basic Metrics</option>
                <option value="advanced" {{ ($data->metrics_access ?? '') === 'advanced' ? 'selected' : '' }}>Advanced Metrics</option>
            </select>
        </div>

        <!-- Highlight Banner -->
        <div id="businessHighlightDiv">
            <label class="block text-gray-700 font-medium mb-1">Highlight Banner / Logo</label>
            <select name="highlight_banner" class="w-full px-4 py-2 border rounded-lg">
                <option value="0" {{ ($data->highlight_banner ?? 0) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($data->highlight_banner ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <!-- Push Notifications -->
        <div id="businessPushDiv">
            <label class="block text-gray-700 font-medium mb-1">Push Notifications</label>
            <select name="push_notifications" class="w-full px-4 py-2 border rounded-lg">
                <option value="0" {{ ($data->push_notifications ?? 0) == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ ($data->push_notifications ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <!-- Marketing Campaigns -->
        <div id="businessMarketingDiv">
            <label class="block text-gray-700 font-medium mb-1">Marketing Campaigns</label>
            <textarea name="marketing_campaigns" class="w-full px-4 py-2 border rounded-lg">{{ $data->marketing_campaigns ?? '' }}</textarea>
        </div>

        <!-- Price -->
        <div id="businessPriceDiv">
            <label class="block text-gray-700 font-medium mb-1">Plan Price (₹)</label>
            <input type="number" name="plan_price" class="w-full px-4 py-2 border rounded-lg" value="{{ $data->plan_price ?? '' }}">
        </div>

        <!-- Duration -->
        <div id="businessDurationDiv">
            <label class="block text-gray-700 font-medium mb-1">Duration (Months)</label>
            <input type="number" name="duration_months" class="w-full px-4 py-2 border rounded-lg" value="{{ $data->duration_months ?? '' }}">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded-lg">{{ $data->description ?? '' }}</textarea>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Status</label>
            <select name="status" class="w-full px-4 py-2 border rounded-lg">
                <option value="1" {{ ($data->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($data->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex justify-center">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                Save Plan
            </button>
        </div>
    </form>
</div>


</div>

<!-- JS: Icon preview -->
<script>
document.querySelector('input[name="plan_icon"]').addEventListener('change', function (e) {
    const preview = document.getElementById('iconPreview');
    const file = e.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>

<!-- JS: Membership Type toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const membershipType = document.getElementById('membershipType');
    const userForm = document.getElementById('userFormContainer');
    const businessForm = document.getElementById('businessForm');

    // Page load par bhi sahi form dikhaye
    if(membershipType.value === 'user') {
        userForm.style.display = 'block';
        businessForm.style.display = 'none';
    } else {
        userForm.style.display = 'none';
        businessForm.style.display = 'block';
    }

    membershipType.addEventListener('change', function() {
        if(this.value === 'user') {
            userForm.style.display = 'block';
            businessForm.style.display = 'none';
        } else {
            userForm.style.display = 'none';
            businessForm.style.display = 'block';
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // User form submit
    $('#userForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('membership_type', 'user');

        $.ajax({
            url: "/admin/membership/update/" + $('input[name="id"]').val(),
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                toastr.success(response.message);
                window.location.href='/admin/membershiphistory'; // Redirect to membership history page
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    alert('Validation failed! Check console for errors.');
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });

    // Business form submit
    $('#businessForm form').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serializeArray();
        formData.push({name: 'membership_type', value: 'business'});

        $.ajax({
            url: "/admin/membership/update/" + $('input[name="id"]').val(),
            method: "POST",
            data: formData,
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    alert('Validation failed!');
                } else {
                    alert('Something went wrong!');
                }
            }
        });
    });
});
</script>


@endsection
