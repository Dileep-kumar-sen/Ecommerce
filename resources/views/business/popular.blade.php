@extends('business.sidebaar')
@section('title', 'Popular Offers')

@section('content')
<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="popular-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>User Redeem Count</th>

            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#popular-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("business.popular") }}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'category', name: 'category' },
            { data: 'subcategory', name: 'subcategory' },
            { data: 'redeem_count', name: 'redeem_count' },

        ]
    });
});
</script>
@endsection
