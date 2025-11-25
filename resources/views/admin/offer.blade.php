@extends('admin.sidebaar')

@section('content')
@section('title', 'Offer/discount')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="offer-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th>Voucher Name</th>
                <th>Name</th>
                <th>Store Name</th>
                <th>Offer Title</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Price</th>
                <th>Discount %</th>
                <th>Discount Price</th>
                <th>Validity Period</th>
                <th>Status</th>
                <th>Total Redemptions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#offer-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.offer") }}',
        columns: [
            { data: 'voucher_name', name: 'voucher_name' },
            { data: 'name', name: 'name' },
            { data: 'business_name', name: 'business_name' },
            { data: 'offer_title', name: 'offer_title' },
            { data: 'category', name: 'category' },
            { data: 'subcategory', name: 'subcategory' },
            { data: 'price', name: 'price' },
            { data: 'discount', name: 'discount' },
            { data: 'discount_price', name: 'discount_price' },
            { data: 'validity', name: 'validity' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'total_redemptions', name: 'total_redemptions' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
<script>
function deleteOffer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/offer/delete/' + id, // route to delete
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success){
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );
                        $('#offer-table').DataTable().ajax.reload(); // reload table
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    })
}
function deactiveOffer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to toggle the status of this offer?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/offer/toggle-status/' + id, // route to toggle status
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if(response.success){
                        Swal.fire(
                            'Updated!',
                            response.message,
                            'success'
                        );
                        $('#offer-table').DataTable().ajax.reload(); // reload table
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    })
}
</script>
@endsection
