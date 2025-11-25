@extends('admin.sidebaar')
@section('title', 'Category Management')
@section('content')

<div class="overflow-x-auto bg-white rounded-xl shadow-md p-6">

    <h2 class="text-lg font-semibold mb-4">Categories</h2>

    <!-- Add Category Form -->
    <form id="add-category-form" class="flex mb-6 space-x-4" enctype="multipart/form-data">
    @csrf
    <input
        type="text"
        id="category-name"
        name="name"
        class="border border-gray-300 rounded px-3 py-2"
        placeholder="Enter Category Name"
        required
    />

    <input
        type="file"
        id="category-icon"
        name="icon"
        class="border border-gray-300 rounded px-3 py-2"
        accept="image/*"
    />

    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
        Add
    </button>
</form>


    <p id="error-message" class="text-red-500 mb-3 hidden"></p>

    <!-- Categories Table -->
   <table id="categories-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
    <thead class="bg-gray-50">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Icon</th> <!-- Add icon column -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


</div>

<script>
$(document).ready(function() {

    // ✅ Initialize DataTable
   var table = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("admin.category") }}',
    columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        {
            data: 'icon',
            name: 'icon',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                if(data){
                    return `<img src="/uploads/category/${data}" width="50" class="rounded">`;
                }
                return '';
            }
        },
        { data: 'actions', name: 'actions', orderable: false, searchable: false },
    ]
});


    let isEditing = false; // Track whether editing mode is on
    let editId = null;     // Store category ID for edit

    // ✅ Add / Update Category via AJAX
$('#add-category-form').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    if(isEditing){
        formData.append('_method', 'PUT'); // Important for Laravel to recognize PUT
    }

    $.ajax({
        url: isEditing ? '/admin/category/update/' + editId : '{{ route("admin.category.store") }}',
        type: 'POST', // always POST
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.success){
                $('#category-name').val('');
                $('#category-icon').val('');
                table.ajax.reload();
                toastr.success(res.message);
                isEditing = false;
                editId = null;
                $('button[type="submit"]').text('Add');
            }
        },
        error: function(xhr){
            toastr.error(xhr.responseJSON?.errors?.name?.[0] || 'Something went wrong');
        }
    });
});



    // ✅ Delete Category with SweetAlert
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '/admin/category/delete/' + id,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload();

                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Failed!',
                            text: 'Something went wrong while deleting.',
                            icon: 'error',
                        });
                    }
                });

            }
        });
    });

    // ✅ Edit Category
    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');

        $.ajax({
            url: '/admin/category/edit/' + id,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Fill input with category name
                    $('#category-name').val(response.data.name);
                    $('button[type="submit"]').text('Update');
                    isEditing = true;
                    editId = id;
                }
            }
        });
    });

});
</script>


@endsection
