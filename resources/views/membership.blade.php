@extends('landing')
@section('content')
<section style="background:white; padding:64px 0;">
  <div style="max-width:1120px; margin:0 auto; padding:0 24px; display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:32px;">

    <!-- Card 1 -->
    <div style="background:#f5e10e; border-radius:16px; box-shadow:0 6px 16px rgba(0,0,0,0.15); padding:32px; text-align:center; color:blue; transition:0.3s;">
      <div style="display:flex; justify-content:center; margin-bottom:16px;">
        <img src="{{ asset('plans/basic.jpg') }}" alt="Basic Plan"
             style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:4px solid white; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
      </div>
      <h2 style="font-size:24px; font-weight:bold;">Basic Plan</h2>
      <div style="margin-top:20px;">
        <span style="font-size:32px; font-weight:800;">$9.99</span>
        <span style="opacity:0.8;">/month</span>
      </div>
      <ul style="font-size:14px; margin-top:24px; text-align:left; list-style:none; padding:0;">
        <li style="margin-bottom:12px;">✔ Exclusive Restaurant Discounts</li>
        <li>✔ Travel & Hotel Offers</li>
      </ul>
      <div style="margin-top:32px;">
        <a href="/subscribe"
           style="display:inline-block; background:white; color:blue; font-weight:600; padding:12px 24px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.2); text-decoration:none; transition:0.3s;"
           onmouseover="this.style.background='blue'; this.style.color='#f5e10e';"
           onmouseout="this.style.background='white'; this.style.color='blue';">
          Join Now
        </a>
      </div>
    </div>

    <!-- Card 2 -->
    <div style="background:#f5e10e; border-radius:16px; box-shadow:0 6px 16px rgba(0,0,0,0.15); padding:32px; text-align:center; color:blue; transition:0.3s;">
      <div style="display:flex; justify-content:center; margin-bottom:16px;">
        <img src="{{ asset('plans/gold.jpg') }}" alt="Premium Plan"
             style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:4px solid white; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
      </div>
      <h2 style="font-size:24px; font-weight:bold;">Premium Plan</h2>
      <div style="margin-top:20px;">
        <span style="font-size:32px; font-weight:800;">$19.99</span>
        <span style="opacity:0.8;">/month</span>
      </div>
      <ul style="font-size:14px; margin-top:24px; text-align:left; list-style:none; padding:0;">
        <li style="margin-bottom:12px;">✔ All Basic Benefits</li>
        <li>✔ Beauty & Wellness Deals</li>
      </ul>
      <div style="margin-top:32px;">
        <a href="/subscribe"
           style="display:inline-block; background:white; color:blue; font-weight:600; padding:12px 24px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.2); text-decoration:none; transition:0.3s;"
           onmouseover="this.style.background='blue'; this.style.color='#f5e10e';"
           onmouseout="this.style.background='white'; this.style.color='blue';">
          Join Now
        </a>
      </div>
    </div>

    <!-- Card 3 -->
    <div style="background:#f5e10e; border-radius:16px; box-shadow:0 6px 16px rgba(0,0,0,0.15); padding:32px; text-align:center; color:blue; transition:0.3s;">
      <div style="display:flex; justify-content:center; margin-bottom:16px;">
        <img src="{{ asset('plans/vip.jpg') }}" alt="VIP Plan"
             style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:4px solid white; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
      </div>
      <h2 style="font-size:24px; font-weight:bold;">VIP Plan</h2>
      <div style="margin-top:20px;">
        <span style="font-size:32px; font-weight:800;">$29.99</span>
        <span style="opacity:0.8;">/month</span>
      </div>
      <ul style="font-size:14px; margin-top:24px; text-align:left; list-style:none; padding:0;">
        <li style="margin-bottom:12px;">✔ All Premium Benefits</li>
        <li>✔ Entertainment & Shopping</li>
      </ul>
      <div style="margin-top:32px;">
        <a href="/subscribe"
           style="display:inline-block; background:white; color:blue; font-weight:600; padding:12px 24px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.2); text-decoration:none; transition:0.3s;"
           onmouseover="this.style.background='blue'; this.style.color='#f5e10e';"
           onmouseout="this.style.background='white'; this.style.color='blue';">
          Join Now
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
