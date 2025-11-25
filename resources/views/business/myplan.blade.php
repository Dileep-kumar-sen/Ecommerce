@extends('business.sidebaar')
@section('title', 'My Plan')
@section('content')
<div class="container mx-auto p-14">



    <div class="bg-white shadow-lg rounded-xl p-4 overflow-x-auto">
        <table id="myplanTable" class="min-w-full border border-gray-200 rounded-lg display nowrap w-full">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                  <tr>
            <th>Plan Name</th>
            <th>Monthly Fee</th>
            <th>Benefit</th>
            <th>Campaign Limit</th>
            <th>Coupon Limit</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
            </thead>
        </table>
    </div>
</div>

{{-- ✅ jQuery + DataTables + Responsive Plugin --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(function() {
    $('#myplanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('business.myplan') }}",
        columns: [
            { data: 'plan_name', name: 'plan_name' },
            { data: 'monthly_fee', name: 'monthly_fee' },
            { data: 'visibility', name: 'visibility' },
            { data: 'campaign_limit', name: 'campaign_limit' },
            { data: 'coupon_limit', name: 'coupon_limit' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
