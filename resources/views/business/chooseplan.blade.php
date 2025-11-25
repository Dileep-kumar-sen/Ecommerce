@extends('business.sidebaar')
@section('title', 'Choose Plan')
@section('content')

<div class="p-6 bg-white rounded-xl shadow-md mt-6">
    <table id="planTable" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead>
        <tr>
            <th>Plan Name</th>
            <th>Monthly Fee</th>

            <th>Offer Create</th>
            <th>Discount Limit</th>

            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg">
        <h1 class="text-center font-bold">Plan Info</h1>
        <h2 class="text-xl font-bold mb-4" id="modalPlanName"></h2>
        <div class="space-y-2 text-sm">
            <p><strong>Trial Days:</strong> <span id="modalTrialDays"></span></p>
            <p><strong>Highest Discount Create:</strong> <span id="modalDiscount"></span></p>
            <p><strong>Active Offers Limit:</strong> <span id="modalActiveOffers"></span></p>
            <p><strong>Duration (Months):</strong> <span id="modalDuration"></span></p>
            <p><strong>Metrics Access:</strong> <span id="modalMetrics"></span></p>
            <p><strong>Highlight Banner:</strong> <span id="modalHighlight"></span></p>
            <p><strong>Push Notifications:</strong> <span id="modalPush"></span></p>
            <p><strong>Marketing Campaigns:</strong> <span id="modalMarketing"></span></p>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Created At:</strong> <span id="modalCreated"></span></p>
        </div>
        <div class="text-right mt-4">
            <button id="closeModal" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" style="background: red">Close</button>
        </div>
    </div>
</div>

<script>
$(function() {
    var table = $('#planTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('business.chooseplan') }}",
        columns: [
            { data: 'plan_name', name: 'plan_name' },
            { data: 'monthly_fee', name: 'monthly_fee' },

            { data: 'active_offer_limit', name: 'active_offer_limit' },
            { data: 'discount_limit', name: 'discount_limit' },

            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // View button click
    $('#planTable').on('click', '.viewBtn', function() {
        var id = $(this).data('id');
        $.get("{{ route('business.viewPlan') }}", { id: id }, function(data) {
            $('#modalPlanName').text(data.plan_tier+'  '+'Plan');
            $('#modalTrialDays').text(data.trial_days);
            $('#modalDiscount').text(data.discount);
            $('#modalActiveOffers').text(data.active_offers);
            $('#modalDuration').text(data.duration_months);
            $('#modalMetrics').text(data.metrics_access);
            $('#modalHighlight').text(data.highlight_banner ? 'Yes' : 'No');
            $('#modalPush').text(data.push_notifications ? 'Yes' : 'No');
            $('#modalMarketing').text(data.marketing_campaigns);
            $('#modalDescription').text(data.description);
            $('#modalStatus').text(data.status == 1 ? 'Active' : (data.status == 0 ? 'Deactive' : 'Expired'));
            $('#modalCreated').text(data.created_at);
            $('#viewModal').removeClass('hidden');
        });
    });

    // Close modal
    $('#closeModal').click(function() {
        $('#viewModal').addClass('hidden');
    });
});
</script>
<script>
    $(document).on("click", ".joinBtn", function () {
    let planId = $(this).data("id");
    let price = parseFloat($(this).data("price"));
    let plan = $(this).data("plan");
    let monthYear = $(this).data("monthyear");
    let businessId = "{{ session('business_id') }}"; // Logged-in business id

    if (price === 0) {
        // ⭐ Direct Join API
        $.ajax({
            url: "/direct-join",
            method: "POST",
            data: {
                plan_id: planId,
                business_id: businessId,
                month_year: monthYear,
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                alert("Plan Successfully Joined ✔");
                location.reload();
            }
        });

    } else {
        // ⭐ Payment Required → createPreferences() call
        $.ajax({
            url: "/create-preferences/" + price + "/" + plan + "/" + planId + "/" + businessId + "/" + monthYear,
            method: "GET",
            success: function (res) {
                if (res.success) {
                    window.location.href = res.init_point; // MercadoPago payment page
                } else {
                    alert("Payment initialization failed!");
                }
            }
        });
    }
});

</script>

@endsection
