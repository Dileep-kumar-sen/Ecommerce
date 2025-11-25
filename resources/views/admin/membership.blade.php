@extends('admin.sidebaar')
@section('title', 'Membership Plans')
@section('content')

    <div class="w-full max-w-[900px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

        <!-- Membership Type Toggle -->
        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-1">Membership Type</label>
            <select id="membershipType"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="user" selected>User</option>
                <option value="business">Business</option>
            </select>
        </div>

        <!-- ================= USER MEMBERSHIP FORM ================= -->
      <div id="userFormContainer">
    <form  id="userForm" class="space-y-4" enctype="multipart/form-data">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-1">Plan Tier</label>
            <select name="plan_tier" id="userPlanTier"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="free">Free</option>
                <option value="basic">Basic</option>
                <option value="plus">Plus</option>
                <option value="premium">Premium</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700 font-medium mb-1">Month/year</label>
            <select name="month_year" id="monthyear"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="Month">Month</option>
                <option value="Year">Year</option>

            </select>
        </div>

        <div id="userTrialDiv">
            <label class="block text-gray-700 font-medium mb-1">Trial Period (Days)</label>
            <input type="number" name="trial_period_days" placeholder="7"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div id="userCouponsDiv">
            <label class="block text-gray-700 font-medium mb-1">Coupons per Week</label>
            <input type="number" name="coupons_per_week" placeholder="3"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div id="userDiscountDiv">
            <label class="block text-gray-700 font-medium mb-1">Discount Limit (%)</label>
            <input type="text" name="discount_limit" placeholder="e.g., 10, 30, Unlimited"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div id="userExclusiveDiv">
            <label class="block text-gray-700 font-medium mb-1">Exclusive Offers (Monthly)</label>
            <input type="number" name="exclusive_offers_monthly" placeholder="3"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div id="userSpecialDiv">
            <label class="block text-gray-700 font-medium mb-1">Features</label>
            <textarea name="features" placeholder="Early access, Surprise coupon, Special events"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div id="userGamificationDiv">
            <label class="block text-gray-700 font-medium mb-1">Achievements</label>
            <textarea name="achievements" placeholder="Streaks, Weekly missions, User levels (Bronze/Silver/Gold/Diamond)"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div id="userReferralDiv">
            <label class="block text-gray-700 font-medium mb-1">Referral / Bonus Benefits</label>
            <textarea name="referral_bonus" placeholder="2 friends → 1 month Basic free, 5+ friends → 1 month Premium free"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div id="userPriceDiv">
            <label class="block text-gray-700 font-medium mb-1">Plan Price (Optional)</label>
            <input type="number" name="plan_price" placeholder="199"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div id="userIconDiv">
            <label class="block text-gray-700 font-medium mb-1">Icon For Plan</label>
            <input type="file" name="plan_icon"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                accept="image/*">
            <img id="iconPreview" class="mt-2 hidden w-10 h-10 rounded-lg border">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" placeholder="Describe the plan benefits here"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div class="flex justify-center">
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                Save Plan
            </button>
        </div>
    </form>
</div>


        <!-- ================= BUSINESS MEMBERSHIP FORM ================= -->
        <div id="businessForm" style="display:none;">
            <form class="space-y-4"> <!-- Plan Tier -->
                <div> <label class="block text-gray-700 font-medium mb-1">Plan Tier</label> <select id="businessPlanTier"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="free">Free</option>
                        <option value="basic">Basic (Paid)</option>
                        <option value="standard">Standard (Paid)</option>
                        <option value="featured">Featured / Paid</option>
                        <option value="premium">Premium Partner / Top</option>
                    </select> </div> <!-- Trial Period -->
                <div id="businessTrialDiv"> <label class="block text-gray-700 font-medium mb-1">Trial Period (Days)</label>
                    <input type="number" placeholder="7"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> <!-- Discount -->
                <div id="businessDiscountDiv"> <label class="block text-gray-700 font-medium mb-1">Discount (%)</label>
                    <input type="number" placeholder="e.g. 10 or 30"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> <!-- Visibility Level -->
                <div id="businessVisibilityDiv"> <label class="block text-gray-700 font-medium mb-1">Visibility
                        Level</label> <select
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="low">Low (Basic)</option>
                        <option value="medium">Medium (Standard)</option>
                        <option value="high">High (Featured)</option>
                        <option value="top">Top (Premium Partner)</option>
                    </select> </div> <!-- Active Offers Limit -->
                <div id="businessOffersDiv"> <label class="block text-gray-700 font-medium mb-1">Active Offers Limit</label>
                    <input type="number" placeholder="e.g. 1, 5, Unlimited"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> <!-- Metrics -->
                <div id="businessMetricsDiv"> <label class="block text-gray-700 font-medium mb-1">Metrics Access</label>
                    <select
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="none">No Metrics</option>
                        <option value="basic">Basic Metrics</option>
                        <option value="advanced">Advanced Metrics</option>
                    </select> </div> <!-- Highlight / Banner -->
                <div id="businessHighlightDiv"> <label class="block text-gray-700 font-medium mb-1">Highlight Banner /
                        Logo</label> <select
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select> </div> <!-- Push Notifications -->
                <div id="businessPushDiv"> <label class="block text-gray-700 font-medium mb-1">Push Notifications</label>
                    <select
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select> </div> <!-- Marketing Campaigns -->
                <div id="businessMarketingDiv"> <label class="block text-gray-700 font-medium mb-1">Marketing
                        Campaigns</label>
                    <textarea placeholder="Marketing campaigns, reports, consulting"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
                </div> <!-- Price -->
                <div id="businessPriceDiv"> <label class="block text-gray-700 font-medium mb-1">Plan Price (₹)</label>
                    <input type="number" placeholder="e.g. 499"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> <!-- Duration -->
                <div id="businessDurationDiv"> <label class="block text-gray-700 font-medium mb-1">Duration
                        (Months)</label> <input type="number" placeholder="1, 3, 6, 12"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div> <!-- Description -->
                <div> <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea placeholder="Describe the plan benefits here"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
                </div> <!-- Status -->
                 <!-- Submit -->
                <div class="flex justify-center"> <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                        Save Plan </button> </div>
            </form>
        </div>

    </div>
   <script>
$(document).ready(function() {

    // ========== User Form Validation ==========
    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        let valid = true;
        let errors = [];

        // Get values
        let planTier = $('select[name="plan_tier"]').val();
        let trialDays = $('input[name="trial_period_days"]').val();
        let couponsPerWeek = $('input[name="coupons_per_week"]').val();
        let discountLimit = $('input[name="discount_limit"]').val();
        let features = $('textarea[name="features"]').val();
        let planPrice = $('input[name="plan_price"]').val();
        let icon = $('input[name="plan_icon"]').val();
        let month_year = $('input[name="month_year"]').val();
        let description = $('textarea[name="description"]').val();

        // Validation rules
        if(planTier === '') {
            valid = false;
            errors.push('Plan Tier is required.');
        }

        // Free plan => trial days required
        if(planTier === 'free' && trialDays === '') {
            valid = false;
            errors.push('Trial Period is required for Free plan.');
        }

        if(month_year === 'Month' && trialDays === '') {
            valid = false;
            errors.push('Month or Year is required for Free plan.');
        }

        // All plans => coupons per week required
        if(couponsPerWeek === '') {
            valid = false;
            errors.push('Coupons per Week is required.');
        }

        if(discountLimit === '') {
            valid = false;
            errors.push('Discount Limit (%) is required.');
        }

        if(features.trim() === '') {
            valid = false;
            errors.push('Features are required.');
        }

        if(planPrice === '') {
            valid = false;
            errors.push('Plan Price is required.');
        }

        if(description.trim() === '') {
            valid = false;
            errors.push('Description is required.');
        }

        if(!valid) {
            toastr.error(errors.join("\n"));
            return false;
        }

        // Submit using AJAX
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.membership.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                if (response.success=== true) {
                    toastr.success(response.message);
                    $('#userForm')[0].reset();
                    $('#iconPreview').attr('src','').addClass('hidden');
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.statusText);
            }
        });

    });

    // ========== Business Form Validation ==========
    $('#businessForm form').on('submit', function(e){
        e.preventDefault();

        let valid = true;
        let errors = [];

        let planTier = $('#businessPlanTier').val();
        let trialDays = $('#businessTrialDiv input').val();
        let discount = $('#businessDiscountDiv input').val();
        let activeOffers = $('#businessOffersDiv input').val();
        let planPrice = $('#businessPriceDiv input').val();
        let duration = $('#businessDurationDiv input').val();
        let description = $('#businessForm textarea').val();

        if(planTier === '') {
            valid = false;
            errors.push('Plan Tier is required.');
        }

        // Free plan => Trial Days required
        if(planTier === 'free' && trialDays === '') {
            valid = false;
            errors.push('Trial Period is required for Free plan.');
        }

        if(discount === '') {
            valid = false;
            errors.push('Discount (%) is required.');
        }

        if(activeOffers === '') {
            valid = false;
            errors.push('Active Offers Limit is required.');
        }

        if(planPrice === '') {
            valid = false;
            errors.push('Plan Price is required.');
        }

        if(duration === '') {
            valid = false;
            errors.push('Duration (Months) is required.');
        }

        if(description.trim() === '') {
            valid = false;
            errors.push('Description is required.');
        }

        if(!valid) {
            toastr.error(errors.join("\n"));
            return false;
        }

       $.ajax({
    url: "{{ route('business.store') }}",
    method: "POST",
    data: {
        _token: "{{ csrf_token() }}",
        plan_tier: planTier,
        trial_days: trialDays,
        discount: discount,
        active_offers: activeOffers,
        plan_price: planPrice,
        duration_months: duration,
        visibility_level: $('#businessVisibilityDiv select').val(),
        metrics_access: $('#businessMetricsDiv select').val(),
        highlight_banner: $('#businessHighlightDiv select').val() === 'yes' ? 1 : 0,
        push_notifications: $('#businessPushDiv select').val() === 'yes' ? 1 : 0,
        marketing_campaigns: $('#businessMarketingDiv textarea').val(),
        description: description,
    },
    success: function(response) {
        toastr.success(response.message);
        $('#businessForm form')[0].reset();
    },
    error: function(xhr) {
        toastr.error('Failed to save plan!');
    }
});

    });

});
</script>




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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const membershipType = document.getElementById('membershipType');
            const userForm = document.getElementById('userForm');
            const businessForm = document.getElementById('businessForm');

            membershipType.addEventListener('change', function() {
                if (this.value === 'user') {
                    userForm.style.display = 'block';
                    businessForm.style.display = 'none';
                } else {
                    userForm.style.display = 'none';
                    businessForm.style.display = 'block';
                }
            });
        });
    </script>

@endsection
