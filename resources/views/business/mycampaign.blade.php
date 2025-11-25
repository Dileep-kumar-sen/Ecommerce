@extends('business.sidebaar')
@section('title', 'My Campaigns')
@section('content')

<div class="p-6 bg-white rounded-xl shadow-md mt-6">
    <table id="campaign-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Campaign Name</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Fees</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Type</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#campaign-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("business.mycampaign") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'campaign_name', name: 'campaign_name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'fees', name: 'fees' },
            { data: 'join_type', name: 'join_type', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>

@endsection
