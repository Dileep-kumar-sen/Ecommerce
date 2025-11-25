@extends('admin.sidebaar')

@section('content')
@section('title', 'Pending Users')

<div class="overflow-x-auto bg-white rounded-xl shadow-md">
    <table id="search-table"
        class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white rounded-xl shadow-md">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment
                    History</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registration
                    Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            <tr>
                <td class="px-6 py-4">U001</td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Rahul Sharma</td>
                <td class="px-6 py-4">rahul@example.com</td>

                <td class="px-6 py-4 text-green-600 font-semibold">Pending</td>
                <td class="px-6 py-4">₹500 - 01/09/2025</td>
                <td class="px-6 py-4">01/01/2025</td>
                <td class="px-6 py-4 flex space-x-2"> <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600" style="background: rgb(9, 209, 235)">Activated</button> <button

                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" >Payment History</button> <button

                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" style="background: red">Reject</button>
                 </td>
            </tr>
            <tr>
                <td class="px-6 py-4">U002</td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Priya Verma</td>
                <td class="px-6 py-4">priya@example.com</td>

                <td class="px-6 py-4 text-green-600 font-semibold">Pending</td>
                <td class="px-6 py-4">₹500 - 01/07/2025</td>
                <td class="px-6 py-4">15/02/2025</td>
                                 <td class="px-6 py-4 flex space-x-2"> <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600" style="background: rgb(9, 209, 235)">Activated</button> <button

                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" >Payment History</button> <button

                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" style="background: red">Reject</button>
                 </td>
            </tr>
            <tr>
                <td class="px-6 py-4">U003</td>
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">Amit Patel</td>
                <td class="px-6 py-4">amit@example.com</td>

               <td class="px-6 py-4 text-green-600 font-semibold">Pending</td>
                <td class="px-6 py-4">₹500 - 01/08/2025</td>
                <td class="px-6 py-4">10/03/2025</td>
                 <td class="px-6 py-4 flex space-x-2"> <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600" style="background: rgb(9, 209, 235)">Activated</button> <button

                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600" >Payment History</button> <button

                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" style="background: red">Reject</button>
                 </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
