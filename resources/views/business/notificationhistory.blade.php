@extends('business.sidebaar')
@section('title', 'Notification History')
@section('content')

<div class="p-6 bg-white rounded-xl shadow-md mt-6">


    <table id="notification-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Message</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Audience</th>

                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Schedule Time</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Sent</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Opened</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- DataTables Script -->
<script>
$(document).ready(function() {
    $('#notification-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("business.notificationhistory") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'message', name: 'message' },
            { data: 'audience', name: 'audience' },

            { data: 'schedule_time', name: 'schedule_time' },
            { data: 'status', name: 'status' },
            { data: 'sent_count', name: 'sent_count' },
            { data: 'opened_count', name: 'opened_count' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>

@endsection
