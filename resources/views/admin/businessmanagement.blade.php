@extends('admin.sidebaar')

@section('title', 'Business Management')

@section('content')
<div class="overflow-x-auto bg-white rounded-xl shadow-md p-5">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Business Management</h2>

    <table id="business-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Shop Name</th>
                <th class="px-4 py-2 text-left">Email</th>
                <th class="px-4 py-2 text-left">Location</th>

                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Offers Created</th>
                <th class="px-4 py-2 text-left">Total Redemptions</th>
                <th class="px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function () {
    $('#business-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.businessmanagement") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'shop_name', name: 'shop_name' },
            { data: 'email', name: 'email' },
            { data: 'location', name: 'location' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'offers_created', name: 'offers_created' },
            { data: 'total_redemptions', name: 'total_redemptions' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
function toggleBusinessStatus(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to change the status of this business?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // ✅ AJAX call to toggle status
            $.ajax({
                url: "{{ route('admin.business.deactivate') }}",
                type: "POST",
                data: { id: id, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        $('#business-table').DataTable().ajax.reload(); // Table refresh
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        }
    });
}



</script>
<script>
function deleteBusiness(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to Delete !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // ✅ AJAX call
            $.ajax({
                url: "{{ route('admin.business.delete') }}",
                type: "POST",
                data: { id: id, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        $('#business-table').DataTable().ajax.reload(); // refresh table
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        }
    })
}
</script>
@endsection

