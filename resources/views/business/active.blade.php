@extends('business.sidebaar')

@section('content')
@section('title', 'Active Offer')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="datatable" class="min-w-full display">
        <thead>
            <tr>
                <th class="whitespace-nowrap">Title</th>
                <th class="whitespace-nowrap">Description</th>
                <th class="whitespace-nowrap">Category</th>
                <th class="whitespace-nowrap">Subcategory</th>
                <th class="whitespace-nowrap">Created Date</th>
                <th class="whitespace-nowrap">Expiry Date</th>
                <th class="whitespace-nowrap">Price</th>
                <th class="whitespace-nowrap">Discount</th>
                <th class="whitespace-nowrap">User Redeem count</th>
                <th class="whitespace-nowrap">Total Stock</th>
                <th class="whitespace-nowrap">Stock Remaining</th>
                <th class="whitespace-nowrap">Action</th>
            </tr>
        </thead>
    </table>
</div>


<script>
$(function () {
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('active.offer.data') }}",
        columns: [
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'category', name: 'category'},
            {data: 'subcategory', name: 'subcategory'},
            {data: 'created_date', name: 'created_date'},
            {data: 'expiry_date', name: 'expiry_date'},
            {data: 'price', name: 'price'},
            {data: 'discount', name: 'discount'},
            {data: 'redeem_count', name: 'redeem_count'},
            {data: 'total_stock', name: 'total_stock'},
            {data: 'stock_remaining', name: 'stock_remaining'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});

</script>
<script>
function toggleOfferStatus(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to change the status of this offer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/offer/toggle-status/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Success!',
                            response.message,
                            'success'
                        );
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Oops!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}
function deleteOffer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the offer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/offer/delete/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );
                        $('#datatable').DataTable().ajax.reload(); // reload table
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Oops!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}
</script>


@endsection
