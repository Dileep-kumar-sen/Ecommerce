@extends('landing')
@section('title', 'Coupon Usage')

@section('content')
<div class="container mx-auto p-14">
    <h2 class="text-xl font-bold mb-6 text-gray-800 text-center">Membership Coupon Usage</h2>

    <div class="bg-white shadow-lg rounded-xl p-4 overflow-x-auto">
        <table id="membershipTable" class="min-w-full border border-gray-200 rounded-lg display nowrap w-full">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th>ID</th>
                    <th>Membership</th>
                    <th>Weekly Limit</th>
                    <th>Redeemed</th>
                    <th>Left</th>
                    <th>Usage</th>
                    <th>Limit Reset On</th>
                    <th>Expire Plan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- ✅ jQuery + DataTables --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(function () {
    $('#membershipTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('user.coupon') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'membership', name: 'membership'},
            {data: 'weekly_limit', name: 'weekly_limit'},
            {data: 'redeemed', name: 'redeemed'},
            {data: 'left', name: 'left'},
            {data: 'Usage', name: 'Usage', orderable: false, searchable: false},
            {data: 'reset_date', name: 'reset_date'},
            {data: 'expire_date', name: 'expire_date'},
        ],
        pageLength: 5,
        autoWidth: false,
        language: {
            searchPlaceholder: "Search membership...",
            search: "",
            lengthMenu: "_MENU_ entries per page",
            zeroRecords: "No data found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        },
    });
});
</script>
@endsection
