@extends('business.sidebaar')

@section('title', 'Redemption List')

@section('content')
<div class="p-4">

  <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
      <h2 class="text-lg font-semibold text-gray-700">Voucher Redemption Report</h2>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto bg-white rounded-xl shadow-md">
      <table id="redeemption-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
          <thead class="bg-gray-50">
              <tr>
                  <th>Redemption ID</th>
                  <th>User Name</th>
                  <th>Offer Name</th>
                  <th>Date & Time</th>
                  <th>Status</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody></tbody>
      </table>
  </div>

</div>

<script>
$(document).ready(function() {
    $('#redeemption-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("business.reedemption") }}',
        columns: [
            { data: 'redemption_id', name: 'redemption_id' },
            { data: 'user_name', name: 'user_name' },
            { data: 'offer_name', name: 'offer_name' },
            { data: 'datetime', name: 'datetime' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
