@extends('admin.sidebaar')

@section('content')
@section('title', 'Reports')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
   <table id="report-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
    <thead class="bg-gray-50">
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Business Name</th>
            <th>Offer Name</th>
            <th>Report Description</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

</div>
<script>
    $('#report-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("admin.reports.data") }}',
    columns: [
        { data: 'DT_RowIndex' },
        { data: 'user_name' },
        { data: 'business_name' },
        { data: 'offer_name' },
        { data: 'description' },
        { data: 'date' },
        { data: 'actions', orderable: false, searchable: false }
    ]
});
$(document).on('click', '.view-report', function() {
    let id = $(this).data('id');

    $.ajax({
         url: "{{ url('admin/report/view') }}/" + id,
        method: "GET",
        success: function(res) {
            Swal.fire({
                title: "Report Details",
               html: `
    <div style="text-align:left; font-size:16px;">

        <!-- USER SECTION -->
        <h2 style="text-align:center; margin-bottom:8px; font-weight:bold;">User Details</h2>
        <hr style="margin-bottom:10px;">
        <b>Name:</b> ${res.user}<br>
        <b>Phone:</b> ${res.user_phone ?? 'N/A'}<br>
        <b>Email:</b> ${res.user_email ?? 'N/A'}<br>
        <b>location:</b> ${res.user_location ?? 'N/A'}<br>

        <br>

        <!-- BUSINESS SECTION -->
        <h2 style="text-align:center; margin-bottom:8px; font-weight:bold;">Business Details</h2>
        <hr style="margin-bottom:10px;">
        <b>Business:</b> ${res.business}<br>
        <b>Category:</b> ${res.business_email ?? 'N/A'}<br>
        <b>Phone:</b> ${res.business_phone ?? 'N/A'}<br>
        <b>location:</b> ${res.business_location ?? 'N/A'}<br>

        <br>

        <!-- OFFER SECTION -->
        <h2 style="text-align:center; margin-bottom:8px; font-weight:bold;">Offer Details</h2>
        <hr style="margin-bottom:10px;">
        <b>Offer Name:</b> ${res.offer}<br>
        <b>Price:</b> ${res.offer_price ?? 'N/A'}<br>
        <b>Discount:</b> ${res.offer_discount ?? 'N/A'}<br>
        <b>After Discount price:</b> ${res.offer_after_discount ?? 'N/A'}<br>

        <br>

        <!-- DESCRIPTION SECTION -->
        <h2 style="text-align:center; margin-bottom:8px; font-weight:bold;">Report Description</h2>
        <hr style="margin-bottom:10px;">
        <p style="margin-top:5px; line-height:1.6;">
            ${res.description}
        </p>
    </div>
`,

                icon: "info"
            });
        }
    });
});

</script>



@endsection
