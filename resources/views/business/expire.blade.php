@extends('business.sidebaar')

@section('content')
@section('title', 'Expire Offer')

<div class="overflow-x-auto bg-white rounded-xl shadow-md p-6">
    <table id="expire-table" class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Created Date</th>
                <th>Expiry Date</th>
                <th>Price</th>
                <th>Discount</th>
                <th>User Redeem Count</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script>
$(function() {
    $('#expire-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('expire.offer.data') }}",
        columns: [
            { data: 'title' },
            { data: 'description' },
            { data: 'category' },
            { data: 'subcategory' },
            { data: 'created_date' },
            { data: 'expiry_date' },
            { data: 'price' },
            { data: 'discount' },
            { data: 'redeem_count' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});

// Delete function (sweet alert bhi lag sakta hai)
function deleteOffer(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this offer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/offer/delete/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#expire-table').DataTable().ajax.reload();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                }
            });
        }
    });
}

</script>
@endsection
