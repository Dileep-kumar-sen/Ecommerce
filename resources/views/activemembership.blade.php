@extends('landing')
@section('title', 'Active Memberships')

@section('content')
<div class="container mx-auto p-14">
    <h2 class="text-xl font-bold mb-6 text-gray-800 text-center">Active Membership Plans</h2>

    <div class="bg-white shadow-lg rounded-xl p-4 overflow-x-auto">
        <table id="membershipTable" class="min-w-full border border-gray-200 rounded-lg display nowrap w-full">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th>ID</th>
                    <th>Plan Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- ✅ jQuery + DataTables + Responsive Plugin --}}

@endsection
@section('javascript')
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
        responsive: true, // 👈 Responsive magic
        ajax: "{{ route('user.activemembership') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'plan_name', name: 'plan_name'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
        ],
        pageLength: 5,
        autoWidth: false,
        language: {
            searchPlaceholder: "Search memberships...",
            search: "",
            lengthMenu: "_MENU_ entries per page",
            zeroRecords: "No memberships found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        },
    });
});
</script>
@endsection
