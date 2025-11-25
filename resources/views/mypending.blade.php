@extends('landing')

@section('title', 'My Pending Coupon')

@section('content')
<div class="container mx-auto p-14">
    <h2 class="text-xl font-bold mb-6 text-gray-800 text-center">My Pending Coupons</h2>

    <div class="bg-white shadow-lg rounded-xl p-4 overflow-x-auto">
        <table id="redeemTable" class="min-w-full border border-gray-200 rounded-lg display nowrap w-full">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th>ID</th>
                    <th>Coupon Name</th>
                    <th>Category / Subcategory</th>
                    <th>Redeem Date</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Discount Price</th>
                    <th>Voucher Code</th>

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

<script>
$(function () {
    $('#redeemTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('user.mypending') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'coupon_name', name: 'coupon_name'},
            {data: 'category', name: 'category'},
            {data: 'redeem_date', name: 'redeem_date'},
            {data: 'price', name: 'price'},
            {data: 'discount', name: 'discount'},
            {data: 'discount_price', name: 'discount_price'},
            {data: 'voucher_code', name: 'voucher_code'},

        ],
        pageLength: 5,
        autoWidth: false,
        language: {
            searchPlaceholder: "Search redeemed coupons...",
            search: "",
            lengthMenu: "_MENU_ entries per page",
            zeroRecords: "No Pending coupons found",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
        },
    });
});
</script>
@endsection
