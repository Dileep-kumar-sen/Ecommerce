@extends('business.sidebaar')
@section('title', 'Ongoing Campaigns')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md mt-6">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Ongoing Campaigns</h2>

    <table id="campaign-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Campaign Name</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Start Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">End Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Days Left</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Benefit</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Fee (₹)</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Max Offers</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- ✅ DataTables Script -->
<script>
$(document).ready(function() {
    $('#campaign-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("business.ongoingcampaign") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'campaign_name', name: 'campaign_name' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'days_left', name: 'days_left', orderable: false, searchable: false },
            { data: 'benefit', name: 'benefit' },
            { data: 'join_fee', name: 'join_fee' },
            { data: 'max_offer', name: 'max_offer' },
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data == 1
                        ? '<span class="text-green-600 font-semibold">Active</span>'
                        : '<span class="text-red-600 font-semibold">Inactive</span>';
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
<script>
$(document).on('click', '.joinBtn', function () {
    let campaignId = $(this).data('id');

    $.ajax({
        url: "{{ route('campaign.join.free') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            campaign_id: campaignId
        },
        success: function (response) {
            alert(response.message);
        },
        error: function (xhr) {
            alert('Something went wrong!');
        }
    });
});
</script>
@endsection
