
@extends('admin.sidebaar')

@section('content')
@section('title', 'Total Redeemption')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
     <table id="redeemption-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
            <thead class="bg-gray-50">
                <tr>
                    <th>Redemption ID</th>
                    <th>User Name</th>
                    <th>Business Name/Owner Name</th>
                    <th>Offer Name</th>
                    <th>Category / Subcategory</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Discount Price</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
</div>

<script>
$(document).ready(function() {
    $('#redeemption-table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,        // horizontal scroll for many columns
        ajax: '{{ route("admin.redeemption") }}',
        columns: [
            { data: 'redemption_id', name: 'redemption_id' },
            { data: 'user_name', name: 'user_name' },
            { data: 'business_name', name: 'business_name' },
            { data: 'offer_name', name: 'offer_name' },
            { data: 'category', name: 'category' },
            { data: 'price', name: 'price' },
            { data: 'discount', name: 'discount' },
            { data: 'discount_price', name: 'discount_price' },
            { data: 'datetime', name: 'datetime' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
<script>
$(document).on('click', '.deleteRedeem', function(){
    var userId = $(this).data('user');
    var offerId = $(this).data('offer');
    var button = $(this);

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this redemption!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: '{{ route("admin.deleteRedeem") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    offer_id: offerId
                },
                success: function(res){
                    if(res.success){
                        Swal.fire('Deleted!', res.message, 'success');
                        $('#redeemption-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', res.message, 'error');
                    }
                },
                error: function(err){
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
});
</script>
@endsection
