@extends('admin.sidebaar')

@section('content')
@section('title', 'User Management')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="user-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>email</th>
                <th>Location</th>
                <th>Status</th>

                {{-- <th>Transaction Id</th>
                <th>Membership Status</th>
                <th>Membership Plan</th>
                <th>Payment History</th> --}}
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script>
$(document).on('click', '.deactivate-btn', function() {
    let paymentId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to change this user’s  status?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.deactivateUser") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: paymentId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#user-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
});
</script>
<script>
$(document).on('click', '.delete-btn', function() {
    let userId = $(this).data('user-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.deleteUser") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#user-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
});
</script>


<script>
$(document).ready(function() {
    $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.usermanagement") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'location', name: 'location' },
            { data: 'status', name: 'status' },
            // { data: 'payment_id', name: 'payment_id' },
            // { data: 'status', name: 'status', orderable: false, searchable: false },
            // { data: 'plan', name: 'plan', orderable: false, searchable: false },
            // { data: 'payment', name: 'payment' },
            { data: 'reg_date', name: 'reg_date' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>

@endsection
