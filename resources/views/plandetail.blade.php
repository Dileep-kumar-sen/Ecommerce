@extends('landing')

@section('content')
<div style="max-width:800px; margin:40px auto; background:white; border-radius:16px; box-shadow:0 6px 16px rgba(0,0,0,0.15); padding:40px;">

    {{-- Plan Title --}}
    <h1 style="text-align:center; color:#1a237e; font-size:32px; font-weight:800; margin-bottom:30px;">
        {{ ucfirst($plan->plan_tier) }} Plan Details
    </h1>

    {{-- Plan Icon --}}
    <div style="display:flex; justify-content:center; margin-bottom:20px;">
        <img src="{{ asset($plan->plan_icon) }}" alt="Plan Icon"
            style="width:120px; height:120px; object-fit:cover; border-radius:50%; border:5px solid #f5e10e; box-shadow:0 4px 12px rgba(0,0,0,0.2);">
    </div>

    {{-- Price --}}
    <div style="text-align:center; margin-bottom:24px;">
        <span style="font-size:40px; font-weight:700; color:#283593;">₹{{ number_format($plan->plan_price, 2) }}</span>
        <span style="opacity:0.7;">/month</span>
    </div>

    {{-- Description --}}
    <p style="text-align:center; font-size:16px; color:#424242; margin-bottom:32px;">
        {{ $plan->description ?? 'No description available.' }}
    </p>

    {{-- Plan Info Table --}}
    <table style="width:100%; border-collapse:collapse; margin-bottom:32px;">
        <tr style="background:#f5f5f5;">
            <th style="padding:12px; text-align:left;">Trial Period</th>
            <td style="padding:12px;">{{ $plan->trial_period_days }} days</td>
        </tr>
        <tr>
            <th style="padding:12px; text-align:left;">Coupons / Week</th>
            <td style="padding:12px;">{{ $plan->coupons_per_week }}</td>
        </tr>
        <tr style="background:#f5f5f5;">
            <th style="padding:12px; text-align:left;">Discount Limit</th>
            <td style="padding:12px;">{{ $plan->discount_limit }}%</td>
        </tr>
        <tr>
            <th style="padding:12px; text-align:left;">Exclusive Offers (Monthly)</th>
            <td style="padding:12px;">{{ $plan->exclusive_offers_monthly }}</td>
        </tr>
    </table>

    {{-- Features List --}}
    <h3 style="font-size:22px; color:#1a237e; margin-bottom:12px;">Features:</h3>
    <ul style="list-style:none; padding:0; margin-bottom:32px;">
        @foreach (explode(',', $plan->features) as $feature)
            <li style="font-size:16px; margin-bottom:8px;">✔ {{ trim($feature) }}</li>
        @endforeach
    </ul>

    {{-- Actions --}}
    <div style="text-align:center;">
        <a href="/subscribe/{{ $plan->id }}"
            style="display:inline-block; background:#1a237e; color:white; padding:12px 28px; border-radius:8px; font-weight:600; text-decoration:none; box-shadow:0 4px 10px rgba(0,0,0,0.2); transition:0.3s;"
            onmouseover="this.style.background='#3949ab';"
            onmouseout="this.style.background='#1a237e';">
            Join Now
        </a>
    </div>

</div>
@endsection
