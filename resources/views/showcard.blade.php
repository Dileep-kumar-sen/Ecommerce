<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Membership Card</title>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #dfe9f3, #ffffff);
        margin: 0;
        padding: 40px 0;
        display: flex;
        justify-content: center;
    }

    .card-container {
        width: 380px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 25px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
        text-align: center;
        transition: 0.3s;
    }

    .card-container:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 45px rgba(0,0,0,0.22);
    }

    .header {
        background: linear-gradient(45deg, #008cff, #00c6ff);
        color: white;
        padding: 18px;
        font-size: 20px;
        border-radius: 15px;
        margin-bottom: 25px;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(0, 140, 255, 0.4);
    }

    .profile-frame {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        margin: auto;
        padding: 6px;
        background: linear-gradient(45deg, #00b7ff, #00ff95);
        box-shadow: 0 5px 18px rgba(0,0,0,0.15);
    }

    .profile-pic {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
    }

    .name {
        font-size: 23px;
        font-weight: bold;
        margin-top: 18px;
        color: #333;
    }

    .member-id {
        color: #666;
        font-size: 14px;
        margin-top: -5px;
    }

    .asset-badge {
        background: #19c568;
        color: white;
        padding: 7px 22px;
        display: inline-block;
        font-size: 15px;
        border-radius: 25px;
        font-weight: bold;
        margin-top: 15px;
        box-shadow: 0 3px 10px rgba(25, 197, 104, 0.4);
    }

    .info {
        text-align: left;
        margin-top: 20px;
        background: #f7f7f7;
        padding: 18px;
        border-radius: 15px;
        box-shadow: inset 0 0 8px rgba(0,0,0,0.08);
    }

    .info p {
        margin: 6px 0;
        font-size: 15px;
        color: #444;
    }

    .qr-box {
        background: white;
        padding: 22px;
        border-radius: 18px;
        margin-top: 25px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }

    .qr-box img {
        width: 200px;
        height: auto;
    }

    .btn {
        width: 100%;
        padding: 13px;
        font-size: 16px;
        border: none;
        border-radius: 12px;
        margin-top: 18px;
        cursor: pointer;
        font-weight: bold;
    }

    .back-btn {
        background: #008cff;
        color: white;
    }

    .print-btn {
        background: #28a745;
        color: white;
    }

    @media print {
        body {
            background: white;
        }
        .btn, .header {
            display: none !important;
        }
        .card-container {
            box-shadow: none;
        }
    }
</style>
</head>
<body>

<div class="card-container">

    <div class="header">💰 CashCash • Membership Card</div>

    <div class="profile-frame">
        <img src="{{ asset('/uploads/profiles/'.auth()->user()->profile) }}" class="profile-pic" alt="Profile">
    </div>

    <div class="name">{{ auth()->user()->name }}</div>
    <br>
    <div class="member-id">Member No. {{ auth()->user()->membership_id }}</div>

    <div class="asset-badge">Asset</div>

    <div class="info">
        <p><strong>Plan:</strong>{{ $planTier }}</p>
        <p><strong>Valid until:</strong> {{ $subscription->current_period_end }}</p>
        <p><strong>Last accessed:</strong>{{ $subscription->updated_at }}</p>
    </div>

    <div class="qr-box">
        <p style="margin-bottom: 10px; font-weight: bold;">Scan to validate</p>
        <img src="{{ asset($qrCode) }}" alt="QR Code" />
    </div>

    <button class="btn back-btn" onclick="history.back()">← Back</button>
    <button id="printBtn" class="btn print-btn">🖨️ Print</button>

</div>

<script>
document.getElementById('printBtn').addEventListener('click', function() {
    window.print();
});
</script>

</body>
</html>
