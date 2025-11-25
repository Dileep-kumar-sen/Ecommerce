@extends('landing')

@section('content')
<div class="container mx-auto p-14">
    <h2 class="text-xl font-bold mb-6 text-gray-800 text-center">Payment History</h2>

    <div class="bg-white shadow-lg rounded-xl p-4 overflow-x-auto">
        <table id="paymentTable" class="min-w-full border border-gray-200 rounded-lg display nowrap w-full">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th>ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Membership Plan</th>
                    <th>Transaction ID</th>
                    <th>Expire Date</th>
                    <th>Status</th>
                    {{-- <th>Invoice</th>
                    <th>Action</th> --}}
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- 🔹 Toaster -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {
    $('#paymentTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('user.paymenthistory') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'payment_date', name: 'payment_date'},
            {data: 'amount', name: 'amount'},
            {data: 'membership_plan', name: 'membership_plan'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'expire_date', name: 'expire_date'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            // {data: 'invoice', name: 'invoice', orderable: false, searchable: false},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        pageLength: 5,
        autoWidth: false,
        language: {
            searchPlaceholder: "Search payments...",
            search: "",
            lengthMenu: "_MENU_ entries per page",
            zeroRecords: "No payments found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        },
    });

    // 🔹 Toaster for session
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
    @endif
});
</script>
@endsection
