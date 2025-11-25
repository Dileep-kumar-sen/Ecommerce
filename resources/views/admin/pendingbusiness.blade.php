@extends('admin.sidebaar')

@section('content')
@section('title', 'Pending Business')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="pendingbusiness-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th>Business ID</th>
                <th>Name</th>
                <th>Store Name</th>
                <th>Email / Contact Person</th>

                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#pendingbusiness-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.pendingbusiness") }}',
        columns: [
            { data: 'business_id', name: 'business_id' },
            { data: 'name', name: 'name' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'email_contact', name: 'email_contact' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
$(document).on('click', '.approveBtn', function() {
    let id = $(this).data('id');

    $.ajax({
        url: '/admin/business/approve/' + id,
        method: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if(response.success){
                $('#pendingbusiness-table').DataTable().ajax.reload();
                toastr.success(response.message);
            } else {
                toastr.error(response.message);
            }
        }
    });
});

$(document).on('click', '.rejectBtn', function() {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: '/admin/business/reject/' + id,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response){
                    if(response.success){
                        $('#pendingbusiness-table').DataTable().ajax.reload();
                        Swal.fire('Rejected!', response.message, 'success');
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                }
            });
        }
    });
});

</script>

@endsection
