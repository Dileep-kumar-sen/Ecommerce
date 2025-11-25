@extends('business.sidebaar')
@section('title', 'Analytic Campaigns')
@section('content')


<div class="w-full max-w-[800px] mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
<div>
        <label class="block font-semibold text-gray-700 mb-2 text-lg">Select Campaign</label>
        <select id="campaignSelect" class="w-full p-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">-- Select Campaign --</option>
            @foreach($campaigns as $campaign)
                <option value="{{ $campaign['id'] }}">{{ $campaign['name'] }}</option>
            @endforeach
        </select>
    </div>

    <!-- Metrics Cards -->
    <div id="metrics" class="hidden grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Total Views -->
      <div class="max-w-[940px] mx-auto mt-6 overflow-x-auto">
    <div class="flex space-x-2">

        <!-- Total Views -->
        <div class="flex-shrink-0 w-56 bg-indigo-100 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-indigo-600 text-3xl font-bold" id="totalViews">0</div>
            <p class="text-gray-700 font-medium mt-2">Total Views</p>
        </div>

        <!-- Total Redeemed -->
        <div class="flex-shrink-0 w-56 bg-green-100 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div class="text-green-600 text-3xl font-bold" id="totalRedeemed">0</div>
            <p class="text-gray-700 font-medium mt-2">Total Redeemed</p>
        </div>

        <!-- Campaign Status -->
        <div class="flex-shrink-0 w-56 bg-yellow-100 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div id="campaignStatus" class="text-yellow-700 text-1xl font-semibold">Active</div>
            <p class="text-gray-700 font-medium mt-2">Campaign Status</p>
        </div>

        <!-- Expiry Date -->
        <div class="flex-shrink-0 w-56 bg-red-100 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col items-center justify-center">
            <div id="campaignExpiry" class="text-red-600 text-1xl font-semibold">2025-10-10</div>
            <p class="text-gray-700 font-medium mt-2">Expiry Date</p>
        </div>

    </div>
</div>


    </div>

    <!-- Chart Card -->
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <canvas id="campaignChart" height="250"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$('#campaignSelect').on('change', function(){
    var campaignId = $(this).val();
    if(campaignId){
        $.ajax({
            url: '{{ route("business.getCampaignMetrics") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: campaignId
            },
            success: function(res){
                $('#metrics').removeClass('hidden');

                $('#totalViews').text(res.total_views);
                $('#totalRedeemed').text(res.total_redeemed);
                $('#campaignExpiry').text(res.expiry_date);

                // Status: Active or Expired
                var today = new Date();
                var expiry = new Date(res.expiry_date);
                var statusText = expiry >= today ? 'Active' : 'Expired';
                $('#campaignStatus').text(statusText);

                var labels = [];
                var viewsData = [];
                var redeemedData = [];

                res.daily.forEach(function(day){
                    labels.push(day.date);
                    viewsData.push(day.views);
                    redeemedData.push(day.redeemed);
                });

                if(window.myChart) window.myChart.destroy();

                var ctx = document.getElementById('campaignChart').getContext('2d');
                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Views',
                                data: viewsData,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)'
                            },
                            {
                                label: 'Redeemed',
                                data: redeemedData,
                                backgroundColor: 'rgba(75, 192, 192, 0.7)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Daily Views vs Redeemed' }
                        },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        });
    } else {
        $('#metrics').addClass('hidden');
        if(window.myChart) window.myChart.destroy();
    }
});
</script>

@endsection
