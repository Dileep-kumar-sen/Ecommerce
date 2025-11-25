@extends('admin.sidebaar')

@section('title', 'Campaign History')

@section('content')
<div class="w-full max-w-6xl mx-auto mt-8">
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table id="campaign-table" class="min-w-full divide-y divide-gray-200 bg-white rounded-xl shadow-md">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">#</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Campaign Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Categories</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Subcategories</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Start Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">End Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Join Fee (₹)</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Benefit</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Created At</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $index => $campaign)
                    @php
                        $today = \Carbon\Carbon::today();
                        $start = \Carbon\Carbon::parse($campaign->start_date);
                        $end = \Carbon\Carbon::parse($campaign->end_date);

                        if ($today->between($start, $end)) {
                            $status = 'Active';
                            $statusColor = 'text-green-600';
                        } elseif ($today->lt($start)) {
                            $status = 'Upcoming';
                            $statusColor = 'text-yellow-600';
                        } else {
                            $status = 'Expired';
                            $statusColor = 'text-red-600';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $campaign->campaign_name }}</td>

                        {{-- Category Button --}}
                        <td class="px-4 py-3 text-sm">
                            <button
                                class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition"
                                onclick='showCategories(@json($campaign->categories ?? []))'>
                                View Categories
                            </button>
                        </td>

                        {{-- Subcategory Button --}}
                        <td class="px-4 py-3 text-sm">
                            <button
                                class="bg-purple-600 text-white px-3 py-1 rounded-lg hover:bg-purple-700 transition"
                                onclick='showSubcategories(@json($campaign->subcategories ?? []))'>
                                View Subcategories
                            </button>
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-600">{{ $campaign->start_date }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $campaign->end_date }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $campaign->join_fee > 0 ? '₹' . $campaign->join_fee : 'Free' }}
                        </td>


                        <td class="px-4 py-3 text-sm text-gray-600">
    {{ Str::limit($campaign->benefit ?? '—', 15, '...') }}
</td>


                        {{-- Status --}}
                        <td class="px-4 py-3 text-sm font-semibold {{ $statusColor }}">{{ $status }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $campaign->created_at->format('Y-m-d') }}</td>

                        {{-- Actions --}}
                       <td class="px-4 py-3 flex items-center gap-3">
    <!-- ✏️ Edit Button -->
   <!-- ✏️ Edit Button -->
<button
    onclick="editCampaign({{ $campaign->id }})"
    class="flex items-center gap-1 px-3 py-1.5 text-sm font-semibold rounded-lg text-white bg-blue-500 hover:bg-blue-600 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5"
    style="padding: 14px">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
    </svg>
    Edit
</button>

&nbsp;
    <!-- 🚫 Deactivate Button -->
   <button
        onclick="deactivateCampaign({{ $campaign->id }})"
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5" style="background:green">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
        </svg>
        @if ($campaign->status==0)
            Activated
        @else
            Deactivate
        @endif
    </button>
&nbsp;
    <!-- ❌ Delete Button -->
    <button
        onclick="deleteCampaign({{ $campaign->id }})"
        class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg text-white bg-red-500 hover:bg-red-600 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5"  style="background:red">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />
        </svg>
        Delete
    </button>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-5 text-gray-500">No campaigns found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 🟢 Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden transition">
    <div class="bg-white rounded-2xl shadow-2xl w-96 p-6 relative animate-fadeIn">
        <button onclick="closeModal('categoryModal')" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl" style="right: 2px">&times;</button>
        <h2 class="text-xl font-semibold mb-3 text-gray-800 border-b pb-2">Categories</h2>
        <ul id="categoryList" class="list-disc list-inside text-gray-700 space-y-1 max-h-64 overflow-y-auto"></ul>
        <div class="mt-5 text-right">
            <button onclick="closeModal('categoryModal')" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Close</button>
        </div>
    </div>
</div>

<!-- 🟣 Subcategory Modal -->
<div id="subcategoryModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center hidden transition">
    <div class="bg-white rounded-2xl shadow-2xl w-96 p-6 relative animate-fadeIn">
        <button onclick="closeModal('subcategoryModal')" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl" style="right: 2px">&times;</button>
        <h2 class="text-xl font-semibold mb-3 text-gray-800 border-b pb-2">Subcategories</h2>
        <ul id="subcategoryList" class="list-disc list-inside text-gray-700 space-y-1 max-h-64 overflow-y-auto"></ul>
        <div class="mt-5 text-right">
            <button onclick="closeModal('subcategoryModal')" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Close</button>
        </div>
    </div>
</div>

<!-- 🧠 JS Section -->
<script>
    function editCampaign(id) {
    window.location.href = `/admin/campaigns/${id}/edit`;
}
function parseIds(ids) {
    if (!ids) return [];
    if (typeof ids === 'string') {
        try {
            ids = JSON.parse(ids);
        } catch {
            return [];
        }
    }
    return Array.isArray(ids) ? ids : [];
}

function showCategories(ids) {
    const parsedIds = parseIds(ids);
    const list = document.getElementById('categoryList');
    list.innerHTML = '';

    if (!parsedIds.length) {
        list.innerHTML = '<li class="text-gray-500">No categories found</li>';
        document.getElementById('categoryModal').classList.remove('hidden');
        return;
    }

    fetch(`/admin/get-category-names?ids=${parsedIds.join(',')}`)
        .then(res => res.json())
        .then(data => {
            list.innerHTML = data.length
                ? data.map(cat => `<li>${cat.name}</li>`).join('')
                : '<li class="text-gray-500">No categories found</li>';
            document.getElementById('categoryModal').classList.remove('hidden');
        })
        .catch(() => alert('Error loading categories.'));
}

function showSubcategories(ids) {
    const parsedIds = parseIds(ids);
    const list = document.getElementById('subcategoryList');
    list.innerHTML = '';

    if (!parsedIds.length) {
        list.innerHTML = '<li class="text-gray-500">No subcategories found</li>';
        document.getElementById('subcategoryModal').classList.remove('hidden');
        return;
    }

    fetch(`/admin/get-subcategory-names?ids=${parsedIds.join(',')}`)
        .then(res => res.json())
        .then(data => {
            list.innerHTML = data.length
                ? data.map(sub => `<li>${sub.name} <span class="text-sm text-gray-500">(Category: ${sub.category_name ?? '-'})</span></li>`).join('')
                : '<li class="text-gray-500">No subcategories found</li>';
            document.getElementById('subcategoryModal').classList.remove('hidden');
        })
        .catch(() => alert('Error loading subcategories.'));
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.jQuery && $.fn.DataTable) {
        $('#campaign-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            autoWidth: false,
            language: { emptyTable: "No campaigns found" }
        });
        $('#campaign-table_filter input').addClass('rounded-lg px-3 py-2 border');
    }
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }
</style>
<script>
    // ✅ Deactivate Campaign
    function deactivateCampaign(id) {
        if (confirm("Are you sure you want to deactivate this campaign?")) {
            fetch(`/admin/campaigns/${id}/deactivate`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                location.reload(); // refresh after update
            })
            .catch(err => console.error(err));
        }
    }

    // 🗑️ Delete Campaign
    function deleteCampaign(id) {
        if (confirm("Are you sure you want to delete this campaign?")) {
            fetch(`/admin/campaigns/${id}/delete`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                location.reload(); // refresh after deletion
            })
            .catch(err => console.error(err));
        }
    }
</script>

@endsection
