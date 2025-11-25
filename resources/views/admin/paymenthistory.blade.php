@extends('admin.sidebaar')

@section('title', 'Payment History')
@section('content')

<!-- Filter Card -->
<div class="flex items-center mb-6">
    <label for="typeFilter" class="font-medium mr-2 text-gray-700">Show for:</label>
    <select id="typeFilter" class="px-4 py-2 border rounded-lg shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <option value="user" selected>User</option>
        <option value="business">Business</option>
    </select>
</div>



<!-- Payment Table -->
<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="payment-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Transaction ID</th>
                <th id="nameColumn" class="px-4 py-3 text-left text-sm font-semibold text-gray-600">User Name</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Amount</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Plan</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Payment Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Membership Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<!-- 🟢 Payment History Modal -->
<div id="paymentHistoryModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-xl w-[90%] max-w-lg p-6 relative">
    <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>

    <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Payment History</h2>

    <div class="space-y-2 text-gray-700">
      <p><strong>User ID:</strong> <span id="ph_user_id">1</span></p>
      <p><strong>Plan ID:</strong> <span id="ph_plan_id">2</span></p>
      <p><strong>Payment Type:</strong> <span id="ph_payment_type">Credit Card</span></p>
      <p><strong>Amount:</strong> <span id="ph_amount">1500.00</span></p>
      <p><strong>Currency:</strong> <span id="ph_currency">ARS</span></p>
      <p><strong>Payment ID:</strong> <span id="ph_payment_id">PMT-123456</span></p>
      <p><strong>Expire Date:</strong> <span id="ph_expire_date">2025-12-31</span></p>
      <p><strong>Membership Status:</strong> <span id="ph_membership_status">Active</span></p>
      <p><strong>Status:</strong> <span id="ph_status">Success</span></p>
      <p><strong>Payment Method:</strong> <span id="ph_payment_method">Mercado Pago</span></p>
    </div>
  </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$(document).ready(function () {

    // ✅ Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ✅ Initialize DataTable
    let table = $('#payment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.paymenthistory") }}',
            data: function(d) {
                d.type = $('#typeFilter').val();
            }
        },
        columns: [
            { data: 'txn_id', name: 'txn_id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'amount', name: 'amount' },
            { data: 'plan', name: 'plan' },
            { data: 'date', name: 'date' },
            { data: 'membership_status', name: 'membership_status' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });

    // ✅ Handle status toggle
    $(document).on('click', '.toggle-status-btn', function () {
        let paymentId = $(this).data('id');
        let currentStatus = $(this).data('status');

        $.ajax({
            url: '/admin/toggle-membership-status/' + paymentId,
            type: 'POST',
            data: {
                current_status: currentStatus
            },
            success: function (response) {
                toastr.success(response.message);
                table.ajax.reload(null, false); // Reload without losing pagination
            },
            error: function () {
                toastr.error('Something went wrong');
            }
        });
    });

    // ✅ Filter change
    $('#typeFilter').change(function() {
        let type = $(this).val();
        $('#nameColumn').text(type === 'user' ? 'User Name' : 'Business Name');
        table.ajax.reload();
    });
});
// 🟢 Open modal on View History button click
$(document).on('click', '.history-btn', function() {
    let paymentId = $(this).data('payment-id');

    // 🔹 Abhi ke liye dummy data show karenge
    let dummyData = {
        user_id: 1,
        plan_id: 2,
        payment_type: 'Credit Card',
        amount: '1500.00',
        currency: 'ARS',
        payment_id: 'PMT-123456',
        expire_date: '2025-12-31',
        membership_status: 'Active',
        status: 'Success',
        payment_method: 'Mercado Pago'
    };

    // ✅ Fill modal fields
    $('#ph_user_id').text(dummyData.user_id);
    $('#ph_plan_id').text(dummyData.plan_id);
    $('#ph_payment_type').text(dummyData.payment_type);
    $('#ph_amount').text(dummyData.amount);
    $('#ph_currency').text(dummyData.currency);
    $('#ph_payment_id').text(dummyData.payment_id);
    $('#ph_expire_date').text(dummyData.expire_date);
    $('#ph_membership_status').text(dummyData.membership_status);
    $('#ph_status').text(dummyData.status);
    $('#ph_payment_method').text(dummyData.payment_method);

    // ✅ Show modal
    $('#paymentHistoryModal').removeClass('hidden');
});

// 🟠 Close modal
$('#closeModal').on('click', function() {
    $('#paymentHistoryModal').addClass('hidden');
});

// 🟠 Close on background click
$('#paymentHistoryModal').on('click', function(e) {
    if ($(e.target).is('#paymentHistoryModal')) {
        $(this).addClass('hidden');
    }
});

</script>


@endsection
