@extends('business.sidebaar')

@section('title', 'Verify Voucher')

@section('content')
<div class="w-full max-w-[900px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">

    <!-- Input -->
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <input id="voucherInput"
            type="text"
            maxlength="20"
            placeholder="Enter your voucher code"
            class="w-full md:w-1/2 px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        &nbsp;&nbsp;
        <button id="checkBtn"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Verify
        </button>
    </div>

    <p id="inputMsg" class="mt-3 text-sm text-red-500 hidden"></p>

    <!-- Results Table -->
    <div id="resultWrap" class="mt-6 bg-white rounded-xl shadow-inner border p-4 hidden">
        <h3 class="text-lg font-medium text-gray-700 mb-3">Voucher Details</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">User Name</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Voucher Code</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Offer Name</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Discount</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Claimed Date</th>
                        <th class="px-4 py-2 text-left font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody id="resultBody" class="divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function() {
    const inputMsg = $('#inputMsg');
    const resultWrap = $('#resultWrap');
    const resultBody = $('#resultBody');

    function showError(msg) {
        inputMsg.text(msg).removeClass('hidden');
    }

    function hideError() {
        inputMsg.text('').addClass('hidden');
    }

    function clearResult() {
        resultBody.empty();
        resultWrap.addClass('hidden');
    }

    function renderRow(index, userName, code, offerName, discount, claimeddate, status) {
        return `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">${index}</td>
                <td class="px-4 py-3">${userName ?? '-'}</td>
                <td class="px-4 py-3 font-mono text-sm">${code}</td>
                <td class="px-4 py-3">${offerName}</td>
                <td class="px-4 py-3">${discount}%</td>
                <td class="px-4 py-3">${claimeddate}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ${status === 'Redeem' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800'}">
                        ${status}
                    </span>
                </td>
            </tr>
        `;
    }

    $('#checkBtn').on('click', function() {
        hideError();
        clearResult();

        const code = $('#voucherInput').val().trim();
        if (!code) {
            showError('Please enter voucher code');
            return;
        }

        $.ajax({
            url: '{{ route("verify.voucher") }}', // route pointing to verifyAndRedeem
            type: 'POST',
            data: { voucher_code: code },
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            dataType: 'json',
            success: function(res) {
                if (res.error) {
                    showError(res.error);
                    return;
                }

                if (!res.data || res.data.length === 0) {
                    showError('No users have claimed this voucher yet.');
                    return;
                }

                res.data.forEach((item, i) => {
                    const row = renderRow(
                        i + 1,
                        item.user_name,
                        code,
                        item.offer_title,
                        item.discount,
                        item.claimeddate,
                        item.status
                    );
                    resultBody.append(row);
                });

                resultWrap.removeClass('hidden');
            },
            error: function() {
                showError('Something went wrong, try again');
            }
        });
    });

    // Press Enter to Verify
    $('#voucherInput').on('keyup', function(e) {
        if (e.key === 'Enter') $('#checkBtn').click();
    });
})();
</script>
@endsection
