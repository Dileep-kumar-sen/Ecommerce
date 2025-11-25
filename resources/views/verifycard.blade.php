<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Verified</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('https://images.unsplash.com/photo-1557682250-33bd709cbe85?w=800&q=80') center/cover no-repeat;
            opacity: 0.07;
            z-index: -1;
        }

        .card {
            width: 100%;
            max-width: 390px;
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            color: white;
            border-radius: 34px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            position: relative;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        .header-wave {
            height: 120px;
            background: linear-gradient(135deg, #00c853, #64dd17);
            clip-path: ellipse(120% 100% at 50% 0%);
            position: relative;
        }

        .profile-container {
            position: relative;
            margin-top: -64px;
            text-align: center;
        }

        .profile-circle {
            width: 128px;
            height: 128px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 6px solid white;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            z-index: 2;
            position: relative;
        }

        .profile-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name {
            font-size: 26px;
            font-weight: 800;
            margin: 20px 0 6px;
            letter-spacing: 0.5px;
        }

        .plan {
            font-size: 18px;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 24px;
            color: #94fabc;
        }

        .status-badge {
            background: linear-gradient(90deg, #00c853, #64dd17);
            color: white;
            font-weight: 800;
            font-size: 17px;
            padding: 14px 40px;
            border-radius: 50px;
            display: inline-block;
            box-shadow: 0 8px 25px rgba(0, 200, 83, 0.4);
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .details {
            margin: 30px 32px;
            background: rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 14px 0;
            font-size: 15px;
        }

        .label {
            opacity: 0.8;
            font-weight: 500;
        }

        .value {
            font-weight: 700;
            color: #a0f8c4;
        }

        .verified-box {
            margin: 25px 32px 30px;
            background: rgba(0, 200, 83, 0.15);
            border: 1px solid #00c853;
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
        }

        .verified-box::before {
            content: "✓";
            display: inline-block;
            width: 32px;
            height: 32px;
            background: #00c853;
            color: white;
            border-radius: 50%;
            font-size: 18px;
            line-height: 32px;
            margin-right: 10px;
        }

        .return-btn {
            width: calc(100% - 64px);
            margin: 0 auto 30px;
            padding: 16px;
            background: white;
            color: #1e293b;
            border: none;
            border-radius: 50px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s;
            display: block;
        }

        .return-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }

        .footer {
            text-align: center;
            padding-bottom: 20px;
            font-size: 13px;
            opacity: 0.7;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="header-wave"></div>

        <div class="profile-container">
            <div class="profile-circle">
                <img src="{{ asset('uploads/profiles/' . $user->profile) }}" alt="{{ $user->name }}">
            </div>

            <div class="name">{{ $user->name }}</div>
            <div class="plan">Silver Plan • Premium Member</div>

            <div class="status-badge">Asset</div>

            <div class="details">
                <div class="detail-row">
                    <span class="label">Member Since</span>
                    <span class="value">May 2025</span>
                </div>
                <div class="detail-row">
                    <span class="label">Valid Until</span>
                    <span class="value">01 Dec 2025</span>
                </div>
                <div class="detail-row">
                    <span class="label">Status</span>
                    <span class="value">Active & Verified</span>
                </div>
            </div>

            <div class="verified-box">
                Active member – Full benefits unlocked
            </div>

            <button class="return-btn" onclick="window.location.href='/login'">Return to App</button>

            <div class="footer">
                © 2025 CashCash • Premium Membership
            </div>
        </div>
    </div>

</body>
</html>
