@extends('admin.sidebaar')

@section('content')
@section('title', 'Report')

<div class="overflow-x-auto bg-white rounded-xl shadow-md" >
    <table id="search-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white rounded-xl shadow-md">

    <thead class="bg-gray-50 dark:bg-gray-800">
    <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Active Users</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Active Businesses</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Most Popular Offers</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failed Redemptions</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue Reports</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Export</th>
    </tr>
</thead>
<tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
    <tr>
        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">12,540</td>
        <td class="px-6 py-4 whitespace-nowrap">1,230</td>
        <td class="px-6 py-4 whitespace-nowrap">Flat 50% on Food</td>
        <td class="px-6 py-4 whitespace-nowrap text-red-600 font-semibold">320</td>
        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">$45,000</td>
        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
            <button class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition">CSV</button>
            <button class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600 transition">PDF</button>
        </td>
    </tr>
    <tr>
        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">9,870</td>
        <td class="px-6 py-4 whitespace-nowrap">980</td>
        <td class="px-6 py-4 whitespace-nowrap">Buy 1 Get 1 Coffee</td>
        <td class="px-6 py-4 whitespace-nowrap text-red-600 font-semibold">150</td>
        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">$32,800</td>
        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
            <button class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition">CSV</button>
            <button class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600 transition">PDF</button>
        </td>
    </tr>
</tbody>



    </table>
</div>

@endsection
