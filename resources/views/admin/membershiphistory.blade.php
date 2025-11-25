@extends('admin.sidebaar')

@section('title', 'Membership History')
@section('content')

<!-- Filter Card -->
<div class="flex items-center mb-6">
    <label for="typeFilter" class="font-medium mr-2 text-gray-700">Show Membership For:</label>
    <select id="typeFilter" class="px-4 py-2 border rounded-lg shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <option value="user" selected>User</option>
        <option value="business">Business</option>
    </select>
</div>

<!-- Membership Table -->
<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="membership-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Plan Tier</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Trial (Days)</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600" id="extra1">Coupons/Week</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600" id="extra2">Exclusive/Active Offers</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Features</th>

                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Referral / Banner</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Plan Price</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Duration / Description</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    let table = $('#membership-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.membershiphistory") }}',
            data: function(d) {
                d.type = $('#typeFilter').val();
            }
        },
        columns: [
            { data: 'plan_tier' },
            { data: 'trial_period_days' },
            {
                data: null,
                render: function(row) {
                    return row.coupons_per_week ?? row.discount ?? '-';
                }
            },
            {
                data: null,
                render: function(row) {
                    return row.exclusive_offers ?? row.active_offers_limit ?? '-';
                }
            },
            {
                data: null,
                render: function(row) {
                    return row.features ?? row.metrics_access ?? '-';
                }
            },
            {
                data: null,
                render: function(row) {
                    return row.referral_bonus ?? row.highlight_banner ?? row.marketing_campaigns ?? '-';
                }
            },
            { data: 'plan_price' },
            {
                data: null,
                render: function(row) {
                    return row.duration_months
                        ? `${row.duration_months} month(s) — ${row.description}`
                        : row.description;
                }
            },
            { data: 'status' },
            { data: 'date' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(row) {
                    // Status button
                    let statusBtn = '';
                    let type = $('#typeFilter').val(); // user or business

                    if(row.status === 'Active'){
                        statusBtn = `<button class="px-2 py-1 text-white rounded"
                                        onclick="toggleStatus('${row.id}', '${type}', 'Deactivate')"
                                        style="background:green">Deactivate</button>`;
                    } else if(row.status === 'Deactive'){
                        statusBtn = `<button class="px-2 py-1 text-white rounded"
                                        onclick="toggleStatus('${row.id}', '${type}', 'Activate')"
                                        style="background:blue">Activate</button>`;
                    }

                    return `
                        <div style="display:flex; gap:5px;">
                            <button class="px-2 py-1 bg-blue-500 text-white rounded"
                                onclick="editMembership('${row.id}', '${type}')">Edit</button>
                            ${statusBtn}
                            <button onclick="deleteMembership('${row.id}', '${type}')"
                                style="background-color:#dc2626; color:white; padding:4px 8px; border:none; border-radius:4px; cursor:pointer; transition:0.2s;"
                                onmouseover="this.style.backgroundColor='#b91c1c'"
                                onmouseout="this.style.backgroundColor='#dc2626'">
                                Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });

    $('#typeFilter').change(function() {
        let type = $(this).val();
        if(type === 'user') {
            $('#extra1').text('Coupons/Week');
            $('#extra2').text('Exclusive Offers');
        } else {
            $('#extra1').text('Discount (%)');
            $('#extra2').text('Active Offers');
        }
        table.ajax.reload();
    });
});

// Fake edit/delete/toggle actions
function editMembership(id, type) {
    // Redirect to admin/editmembership with query params
    window.location.href = `/admin/editmembership?id=${id}&type=${type}`;
}


function deleteMembership(id, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete Membership?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to delete
            $.ajax({
                url: '{{ route("admin.deleteMembership") }}', // route name
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    type: type
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    );
                    // Reload table if DataTable is used
                    $('#membership-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}

function toggleStatus(id, type, action) {
    $.ajax({
        url: '{{ route("admin.toggleMembershipStatus") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            type: type,
            action: action
        },
        success: function(response) {
            toastr.success(response.message);
            // Table reload karna
            $('#membership-table').DataTable().ajax.reload();
        },
        error: function(xhr) {
            alert(xhr.responseJSON.error || 'Something went wrong');
        }
    });
}

</script>


@endsection
