@extends('admin.sidebaar')

@section('title', 'Join Campaign')
@section('content')

<div class="w-full max-w-6xl mx-auto mt-8">



    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table id="campaign-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Business Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Campaign Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Category</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Date</th>

                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Fee (₹)</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Benefit</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>

                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Fake data + DataTable init -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Fake campaign data (replace with real AJAX later) ---
    const fakeCampaigns = [
        {
            id: 1,
            name: 'Rohit Patel',
            business_name: 'ElectroMart',
            campaign_name: 'Diwali Dhamaka 2025',
            category: 'Fashion, Electronics',
            start_date: '2025-11-01',

            join_fee: 499,
            visibility: 'Homepage + City',
            status: 'Active',

        },
        {
            id: 2,
            name: 'Dileep sen',
            business_name: 'Clothes',
            campaign_name: 'Weekend Boost - October',
            category: 'Food, Travel',
            start_date: '2025-10-24',

            join_fee: 199,
            visibility: 'City Page',
            status: 'Active',

        },
        {
            id: 3,
            name: 'Sumit deol',
            business_name: 'Decorations',
            campaign_name: 'Festive Specials',
            category: 'Beauty, Lifestyle',
            start_date: '2025-12-20',

            join_fee: 999,
            visibility: 'Homepage',
            status: 'Active',

        },
        {
            id: 4,
            name: 'Denim Deol',
            business_name: 'Decorations',
            campaign_name: 'Local Market Week',
            category: 'Grocery, Home',
            start_date: '2025-09-10',

            join_fee: 0,
            visibility: 'City Page',
            status: 'Active',

        }
    ];

    // Prepare DataTable (client-side data source)
    const table = $('#campaign-table').DataTable({
        data: fakeCampaigns,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'business_name' },
            { data: 'campaign_name' },

            { data: 'category' },
            { data: 'start_date' },

            {
                data: 'join_fee',
                render: function(data, type, row) {
                    return data && data > 0 ? '₹' + data : 'Free';
                }
            },
            { data: 'visibility' },
            {
                data: 'status',
                render: function(data) {
                    let color = data === 'Active' ? 'text-green-600' : (data === 'Upcoming' ? 'text-yellow-600' : 'text-gray-500');
                    return `<span class="${color} font-medium">${data}</span>`;
                }
            },

            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // actions inline, single-line styling
                    return `
                        <div style="display:flex; gap:6px; align-items:center;">
                           <button style="padding:4px 12px; background:#2563eb; color:white; border-radius:6px; font-size:0.875rem; white-space:nowrap;" onclick="viewCampaign(${row.id})">
    Payment History
</button>

                            <button class="px-2 py-1 bg-yellow-500 text-white rounded text-sm" onclick="editCampaign(${row.id})" style="background:green">Diactive</button>
                            <button class="px-2 py-1" style="background:red;color:white;border-radius:6px;font-size:13px;" onclick="deleteCampaign(${row.id})">Delete</button>
                        </div>
                    `;
                }
            }
        ],
        pageLength: 10,
        lengthMenu: [5,10,25,50],
        responsive: true,
        autoWidth: false,
        language: {
            emptyTable: "No campaigns found"
        }
    });

    // (Optional) simple search placeholder styling
    $('#campaign-table_filter input').addClass('rounded-lg px-3 py-2 border');

    // --- Action handlers (fake) ---
    window.viewCampaign = function(id) {
        const c = fakeCampaigns.find(x => x.id === id);
        if (!c) return alert('Campaign not found');
        // Simple modal-like alert for demo
        alert(`Campaign Details:\n\nName: ${c.name}\nCategory: ${c.category}\nDates: ${c.start_date} to ${c.end_date}\nVisibility: ${c.visibility}\nJoin Fee: ${c.join_fee ? '₹'+c.join_fee : 'Free'}\nStatus: ${c.status}`);
    }

    window.editCampaign = function(id) {
        const c = fakeCampaigns.find(x => x.id === id);
        if (!c) return alert('Campaign not found');
        alert('Open edit modal for: ' + c.name + '\n(Implement edit form / route)');
    }

    window.deleteCampaign = function(id) {
        const c = fakeCampaigns.find(x => x.id === id);
        if (!c) return alert('Campaign not found');
        if (confirm('Are you sure you want to delete "' + c.name + '" ?')) {
            // remove from fake dataset and reload table (demo only)
            const idx = fakeCampaigns.findIndex(x => x.id === id);
            if (idx > -1) {
                fakeCampaigns.splice(idx, 1);
                table.clear().rows.add(fakeCampaigns).draw();
                alert('Campaign deleted (demo).');
            }
        }
    }

});
</script>

@endsection
