@extends('admin.sidebaar')
@section('title', 'Subcategory Management')
@section('content')

<div class="overflow-x-auto bg-white rounded-xl shadow-md p-6">

    <h2 class="text-lg font-semibold mb-4">Add Subcategory</h2>

    <!-- Add Subcategory Form -->
    <form id="add-subcategory-form" class="flex mb-6 space-x-4" enctype="multipart/form-data">
    @csrf

    <!-- Subcategory Name -->
    <input
        type="text"
        id="subcategory-name"
        name="name"
        class="border border-gray-300 rounded px-3 py-2"
        placeholder="Enter your subcategory"
        required
    />

    <!-- Category Select -->
    <select
        id="subcategory-category"
        name="category_id"
        class="border border-gray-300 rounded px-3 py-2"
        required
    >
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <!-- Subcategory Icon -->
    <input
        type="file"
        id="subcategory-icon"
        name="icon"
        class="border border-gray-300 rounded px-3 py-2"
        accept="image/*"
    />

    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition">
        Add
    </button>
</form>

<table id="subcategories-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
    <thead class="bg-gray-50">
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Subcategory Name</th>
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
    var table = $('#subcategories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.subcategory.list") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'category_name', name: 'category.name' }, // Category Name join
            { data: 'name', name: 'name' }, // Subcategory Name
            { data: 'icon', name: 'icon', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });

    let isEditing = false; // Track edit mode
    let editId = null;     // Store subcategory ID for edit

    // ✅ Add / Update Subcategory via AJAX
    $('#add-subcategory-form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        let url = isEditing
            ? '/admin/subcategory/update/' + editId  // update route
            : '{{ route("admin.subcategory.store") }}'; // create route

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res.success){
                    toastr.success(res.message);

                    // Reset form
                    $('#subcategory-name').val('');
                    $('#subcategory-category').val('');
                    $('#subcategory-icon').val('');
                    $('button[type="submit"]').text('Add');

                    isEditing = false;
                    editId = null;

                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.errors?.name?.[0] || 'Something went wrong');
            }
        });
    });

    // ✅ Delete Subcategory with SweetAlert
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
            if(result.isConfirmed){
                $.ajax({
                    url: '/admin/subcategory/delete/' + id,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response){
                        if(response.success){
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
                    error: function(){
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

    // ✅ Edit Subcategory
    $(document).on('click', '.editBtn', function() {
        let id = $(this).data('id');

        $.ajax({
            url: '/admin/subcategory/edit/' + id,
            method: 'GET',
            success: function(res){
                if(res.success){
                    // Fill form with subcategory data
                    $('#subcategory-name').val(res.data.name);
                    $('#subcategory-category').val(res.data.category_id);

                    $('button[type="submit"]').text('Update');
                    isEditing = true;
                    editId = res.data.id;

                    // Optional: show icon preview
                    $('#iconPreview').remove();
                    if(res.data.icon){
                        $('#subcategory-icon').after(

                        );
                    }
                }
            }
        });
    });

});
</script>



@endsection
