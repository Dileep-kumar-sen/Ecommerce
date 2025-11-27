<?php

namespace App\Http\Controllers;
use App\Models\CampaignOffer;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Report;
use App\Models\Review;
use App\Models\Subcategory;
use App\Models\Subscription;
use App\Models\UserRedeem;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Membership_plan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Carbon\Carbon;



class UserController extends Controller
{
    public function submitReport(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'offer_id' => 'required',
            'description' => 'required|string|max:500',
        ]);

        Report::create([
            'user_id' => $request->user_id,
            'offer_id' => $request->offer_id,
            'description' => $request->description,
        ]);

        return response()->json([
            "success" => true,
            "message" => "Report submitted"
        ]);
    }
public function generate(Request $request)
{
    $membership_id = $request->membership_id;
    $offer_id = $request->offer_id;

    // 🔹 Check if entry already exists
    $existing = UserRedeem::where('membership_id', $membership_id)
                ->where('offer_id', $offer_id)
                ->first();

    // 1️⃣ Already REDEEMED
    if ($existing && $existing->status === 'redeem') {
        return response()->json([
            "success" => false,
            "type" => "redeemed",
            "message" => "This offer is already redeemed!"
        ]);
    }

    // 2️⃣ Already CLAIMED but NOT redeemed
    if ($existing && $existing->status === 'claim') {
        return response()->json([
            "success" => true,
            "type" => "claimed",
            "message" => "Already claimed but not redeemed!"
        ]);
    }

    // 3️⃣ NEW ENTRY → Generate QR
    $qrUrl = url("redeem/$membership_id/$offer_id");

    $dir = public_path('qrcodes');
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }

    $fileName = Str::random(10) . ".png";
    $filePath = $dir . '/' . $fileName;

    // Generate QR
    QrCode::format('png')->size(300)->generate($qrUrl, $filePath);

    // Save DB
    $save = UserRedeem::create([
        'membership_id' => $membership_id,
        'offer_id' => $offer_id,
        'qr_code' => "qrcodes/$fileName",
        'status' => 'claim',
    ]);

    return response()->json([
        "success" => true,
        "type" => "new",
        "qr_url" => $qrUrl,
        "qr_image" => asset("qrcodes/$fileName")
    ]);
}



    public function forgotPassword()
    {
        return view('forgot_password');
    }

public function reviewstore(Request $request)
{
    $campaignId = $request->campaign_id;
    $offerId = $campaignId ? null : $request->offer_id;

    // Validate
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ]);

    // Check existing
    $existingReview = Review::where('user_id', auth()->id())
        ->when($campaignId, fn($q) => $q->where('campaign_id', $campaignId))
        ->when(!$campaignId, fn($q) => $q->where('offer_id', $offerId))
        ->first();

    if ($existingReview) {
        return response()->json([
            'success' => false,
            'message' => 'You have already reviewed this.',
        ], 400);
    }

    // Store review
    $review = Review::create([
        'user_id' => auth()->id(),
        'offer_id' => $offerId,
        'campaign_id' => $campaignId,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Review added successfully!',
        'data' => $review,
    ]);
}





public function index()
{
    // ⚡ All offers (jitne bhi)
    $allget = Offer::orderBy('id', 'DESC')->get();

    // ⚡ Trending Offers (redeem count > 5)
    $trendingOfferIds = UserRedeem::select('offer_id', DB::raw('COUNT(*) as total'))
        ->groupBy('offer_id')
        ->having('total', '>', 5)
        ->orderByDesc('total')
        ->pluck('offer_id');

    $offersForBlade = collect();
    if ($trendingOfferIds->isNotEmpty()) {
        $offersForBlade = Offer::whereIn('id', $trendingOfferIds)
            ->orderByRaw("FIELD(id, " . $trendingOfferIds->implode(',') . ")")
            ->get();
    }

    // ⚡ All categories
    $category = Category::all();

    return view('landing.home', compact('category','offersForBlade','allget'));
}




    public function subcategory($id)
{
    // ✅ Get category info
    $category = Category::findOrFail($id);

    // ✅ Get subcategories related to this category
    $subcategories = Subcategory::where('category_id', $id)->get();

    return view('subcategory', compact('category', 'subcategories','id'));
}
public function redeem(Request $request)
{
    $hasCampaign = $request->campaign_id ? true : false;

    $request->validate([
        'voucher_code' => 'required|string'
    ]);

    $userId = Auth::id();

    // CASE 1: Campaign mode
    if ($hasCampaign) {

        // Already claimed check
        $existing = UserRedeem::where('user_id', $userId)
                              ->where('campaign_id', $request->campaign_id)
                              ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already claimed this campaign voucher!'], 400);
        }

        // SAVE — offer_id = NULL, campaign_id = real value
        UserRedeem::create([
            'user_id' => $userId,
            'offer_id' => null,
            'campaign_id' => $request->campaign_id,
            'status' => 'claim',
            'vchcode' => $request->voucher_code,
        ]);

    }
    else
    {
        // CASE 2: Normal offer mode
        $request->validate([
            'offer_id' => 'required|exists:create_offers,id'
        ]);

        // Already claimed check
        $existing = UserRedeem::where('user_id', $userId)
                              ->where('offer_id', $request->offer_id)
                              ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already claimed this voucher!'], 400);
        }

        // SAVE — normal
        UserRedeem::create([
            'user_id' => $userId,
            'offer_id' => $request->offer_id,
            'campaign_id' => null,
            'status' => 'claim',
            'vchcode' => $request->voucher_code,
        ]);
    }

    return response()->json([
        'message' => 'Voucher claimed successfully!',
        'voucher_code' => $request->voucher_code,
    ]);
}


public function about_us(){
    return view('about_us');
}
public function contact(){
    return view('contact');
}

public function help_center(){
    return view('help_center');
}
public function term_condition(){
    return view('termandcondition');
}
public function choose_plan(){
    return view('choose_plan');
}
public function how_work(){
    return view('how_work');
}
 public function search(Request $request)
    {
        $query = $request->get('q');

        // Title ke basis pe search karega
        $offers = Offer::where('title', 'like', "%{$query}%")
            ->select('id', 'title')
            ->limit(10)
            ->get();

        return response()->json($offers);
    }
public function detail(Request $request,$id)
{
    $campaignoffer=$request->campaign_id;
    if($campaignoffer){
        $offeridcheck=$campaignoffer;
        $offer=CampaignOffer::with('business')->findOrFail($campaignoffer);
    }
    else{
$offeridcheck=$id;
    $offer = Offer::with('business')->findOrFail($id); // Offer + Business dono
    }

    return view('detail', compact('offer','offeridcheck'));
}

public function get_offer($category_id)
{
    $subcategory_id = request()->query('subcategory'); // URL se subcategory id

    $offersQuery = Offer::with('subcategory')
        ->where('category_id', $category_id)
        ->where('status', 1);

    // Agar subcategory select hui ho to filter kar do
    if ($subcategory_id) {
        $offersQuery->where('subcategory_id', $subcategory_id);
    }

    $offers = $offersQuery->latest()->get();

    // Category ka naam show karne ke liye (breadcrumb & heading me use hoga)
    $category = Category::select('id', 'name')->findOrFail($category_id);

    return view('get_offer', compact('offers', 'category'));
}






    public function plandetail($id){
        $plan = Membership_plan::find($id);
        return view('plandetail', compact('plan'));
    }
    public function updateProfile(Request $request)
{
    // Validation
    $validator = Validator::make($request->all(), [
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|max:255|unique:users,email,' . Auth::id(),
        'phone'     => 'required|min:10|max:15',
        'location'  => 'required|string',
        'latitude'  => 'required',
        'longitude' => 'required',
        'profile'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('error', 'Please fix the errors.');
    }

    $user = Auth::user();

    // Profile Image Upload
    if ($request->hasFile('profile')) {
        $file = $request->file('profile');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profiles/'), $filename);

        // old delete
        if ($user->profile && file_exists(public_path('uploads/profiles/' . $user->profile))) {
            unlink(public_path('uploads/profiles/' . $user->profile));
        }

        $user->profile = $filename;
    }

    // Update other fields
    $user->name      = $request->name;
    $user->email     = $request->email;
    $user->phone     = $request->phone;
    $user->location  = $request->location;
    $user->latitude  = $request->latitude;
    $user->longitude = $request->longitude;

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}

    public function account(){
    // Sirf active plans (status = 1) fetch kar rahe hain
    $membership_plans = Membership_plan::where('status', 1)->get();

    return view('account', compact('membership_plans'));
}
public function update(Request $request)
{
    // Validate inputs
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();

    // Current password check
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Current password is incorrect'
        ]);
    }

    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('password_success', 'Password updated successfully!');
}

 public function activemembership(Request $request)
{
    if ($request->ajax()) {

        // ✅ Get payments for logged-in user with related plan
        $payments = Payment::with('plan')
            ->where('user_id', Auth::id())
            ->whereNotNull('membership_status')
            ->orderBy('created_at', 'desc')

            ->get();

        return DataTables::of($payments)
            ->addIndexColumn()

            // 🟢 Plan name from MembershipPlan relation
            ->addColumn('plan_name', function ($row) {
                return $row->plan ? $row->plan->plan_tier : 'N/A';
            })

            // 🗓 Start and End Dates
            ->addColumn('start_date', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d') : 'N/A';
            })
            ->addColumn('end_date', function ($row) {
                return $row->expire_date
                    ? \Carbon\Carbon::parse($row->expire_date)->format('Y-m-d')
                    : 'N/A';
            })

            // 🧩 Status based on membership_status
            ->editColumn('status', function ($row) {
                switch ($row->membership_status) {
                    case 1:
                        return '<span class="text-green-600 font-semibold">Active</span>';
                    case 2:
                        return '<span class="text-orange-600 font-semibold">Deactive</span>';
                    case 3:
                        return '<span class="text-red-600 font-semibold">Expired</span>';
                    default:
                        return '<span class="text-gray-600 font-semibold">Unknown</span>';
                }
            })

            ->rawColumns(['status'])
            ->make(true);
    }

    return view('activemembership');
}
public function paymentHistory(Request $request)
    {
        if ($request->ajax()) {
            $payments = Payment::with('plan')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($payments)
                ->addIndexColumn()
                ->editColumn('payment_date', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->editColumn('amount', function ($row) {
                    return '$' . number_format($row->amount, 2);
                })
                ->editColumn('transaction_id', function ($row) {
                    return $row->payment_id;
                })
                ->addColumn('membership_plan', function ($row) {
    // 🔹 plan_tier column dikhayega
    return $row->plan ? $row->plan->plan_tier : 'N/A';
})
                ->addColumn('expire_date', function ($row) {
    // 🔹 plan_tier column dikhayega
    return $row->expire_date ? $row->expire_date : 'N/A';
})

                ->editColumn('status', function ($row) {
                    return $row->status == 'success'
                        ? '<span class="text-green-600 font-semibold">Success</span>'
                        : '<span class="text-red-600 font-semibold">Failed</span>';
                })
                // ->addColumn('invoice', function ($row) {
                //     return '<a href="#" class="text-blue-600 underline">Download</a>';
                // })
                // ->addColumn('action', function ($row) {
                //     return '<a href="#" class="text-purple-600 underline">View</a>';
                // })
                ->rawColumns(['status', 'invoice', 'action'])
                ->make(true);
        }

        return view('paymenthistory');
    }

public function myredeem(Request $request)
{
    if ($request->ajax()) {
        $userId = auth()->id();

        $data = UserRedeem::with([
            'offer' => function($q){
                $q->with(['category', 'subcategory']);
            }
        ])
        ->where('user_id', $userId)
        ->where('status', 'redeem')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('coupon_name', function($row){
                return $row->offer->title ?? 'N/A';
            })
            ->addColumn('category', function($row){
                $category = $row->offer->category->name ?? 'N/A';
                $subcategory = $row->offer->subcategory->name ?? '';
                return $subcategory ? "$category / $subcategory" : $category;
            })
            ->addColumn('discount', function($row){
                return $row->offer->discount ?? '0%';
            })
            ->addColumn('discount_price', function($row){
                return $row->offer->discount_price ?? $row->offer->price ?? '0';
            })
            ->addColumn('price', function($row){
                return $row->offer->price ?? '0';
            })
            ->addColumn('voucher_code', function($row){
                return $row->offer->voucher_code ?? 'N/A';
            })
            ->addColumn('redeem_date', function($row){
                return $row->updated_at ? $row->updated_at->format('Y-m-d') : '-';
            })


            ->make(true);
    }

    return view('myredeem');
}
public function mypending(Request $request)
{
    if ($request->ajax()) {
        $userId = auth()->id();

        $data = UserRedeem::with([
            'offer' => function($q){
                $q->with(['category', 'subcategory']);
            }
        ])
        ->where('user_id', $userId)
        ->where('status', 'claim')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('coupon_name', function($row){
                return $row->offer->title ?? 'N/A';
            })
            ->addColumn('category', function($row){
                $category = $row->offer->category->name ?? 'N/A';
                $subcategory = $row->offer->subcategory->name ?? '';
                return $subcategory ? "$category / $subcategory" : $category;
            })
            ->addColumn('discount', function($row){
                return $row->offer->discount ?? '0%';
            })
            ->addColumn('discount_price', function($row){
                return $row->offer->discount_price ?? $row->offer->price ?? '0';
            })
            ->addColumn('price', function($row){
                return $row->offer->price ?? '0';
            })
            ->addColumn('voucher_code', function($row){
                return $row->offer->voucher_code ?? 'N/A';
            })
            ->addColumn('redeem_date', function($row){
                return $row->updated_at ? $row->updated_at->format('Y-m-d') : '-';
            })


            ->make(true);
    }

    return view('mypending');
}
public function register(Request $request)
{
    try {

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        // PROFILE IMAGE UPLOAD
        $imageName = null;

        if ($request->hasFile('profile')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->profile->extension();
            $request->profile->move(public_path('uploads/profiles'), $imageName);
        }

        // MEMBERSHIP ID GENERATE
        $latestUser = User::latest('id')->first();
        $nextId = $latestUser ? $latestUser->id + 1 : 1;

        $membershipId = 'MBR-' . date('Y') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT) . '-' . strtoupper(Str::random(6));

        // CREATE USER
        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'phone'         => $validated['phone'],
            'location'      => $validated['location'],
            'latitude'      => $validated['latitude'],
            'longitude'     => $validated['longitude'],
            'profile'       => $imageName,
            'membership_id' => $membershipId,
        ]);

        // --------------------------------------------------
        // ✔ Create FREE TRIAL Subscription (7 days)
        // --------------------------------------------------

        Subscription::create([
            'user_id'              => $user->id,
            'plan_id'              => 1, // Free trial plan
            'status'               => 'active',
            'mp_subscription_id'   => null,
            'current_period_start' => now(),
            'current_period_end'   => now()->addDays(7),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful with free trial!',
            'membership_id' => $membershipId
        ], 200);

    } catch (ValidationException $e) {

        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function showcard(Request $request)
{
    $offerId = $request->query('offerid'); // Query parameter ?offerid=123
    $user = auth()->user();

    // 🔹 Get active subscription for this user
    $subscription = Subscription::where('user_id', $user->id)
                        ->where('status', 'active')
                        ->latest('id')
                        ->first();

    if (!$subscription) {
        return redirect('/plan')->with('error', 'No active subscription found. Please purchase a plan.');
    }

    // 🔹 Get plan tier from MembershipPlan model
    $plan = Membership_plan::find($subscription->plan_id);
    $planTier = $plan ? $plan->plan_tier : null;

    // 🔹 Check UserRedeem for matching QR code
    $redeem = UserRedeem::where('membership_id', auth()->user()->membership_id)
                ->where('offer_id', $offerId)
                ->where('status', 'claim')
                ->first();

    $qrCode = $redeem ? $redeem->qr_code : null;

    // 🔹 Pass data to Blade
    return view('showcard', [
        'subscription' => $subscription,
        'planTier' => $planTier,
        'offerId' => $offerId,
        'qrCode' => $qrCode
    ]);
}


public function verifyUser($membershipId)
{
    // Search user by membership_id
    $user = User::where('membership_id', $membershipId)->first();

    if (!$user) {
        return view('verify.error'); // optional error page
    }

    return view('verifycard', compact('user'));
}


public function redeemuser($membership_id, $offer_id)
{
    // 🔹 Find UserRedeem entry
    $redeem = \App\Models\UserRedeem::where('membership_id', $membership_id)
                ->where('offer_id', $offer_id)
                ->first();

    if (!$redeem) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid membership or offer!',
        ]);
    }

    // 🔹 Get user by membership_id
    $user = \App\Models\User::where('membership_id', $membership_id)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found for this membership ID!',
        ]);
    }

    // 🔹 Check active subscription for this user
    $subscription = \App\Models\Subscription::where('user_id', $user->id)
                        ->where('status', 'active')
                        ->latest('id')
                        ->first();

    if (!$subscription) {
        return view('verifycard', [
            'user' => $user,
            'message' => 'No active subscription found. Cannot redeem!'
        ]);
    }

    // 🔹 Get plan details from MembershipPlan
    $plan = Membership_plan::find($subscription->plan_id);

    // 🔹 Already redeemed?
    if ($redeem->status === 'redeem') {
        return view('verifycard', [
            'user' => $user,
            'subscription' => $subscription,
            'plan' => $plan,
            'error' => 'Already claimed!'
        ]);
    }

    // 🔹 Update status to redeem if not already redeemed
    $redeem->update(['status' => 'redeem']);

    return view('verifycard', [
        'user' => $user,
        'subscription' => $subscription,
        'plan' => $plan,
        'message' => 'Redeem claim successfully!'
    ]);
}





public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();
        $user = Auth::user();

        // 🔹 If user is deactivated
        if ($user->status == 0) {
            Auth::logout();
            return response()->json([
                'errors' => ['approved' => ['You are deactivated by admin.']]
            ], 200);
        }

        // 🔥 Get ALL active subscriptions of the user
        $subscriptions = Subscription::where('user_id', $user->id)
                        ->where('status', 'active')
                        ->orderBy('id', 'desc')
                        ->get();

        // 🔹 If no subscriptions
        if ($subscriptions->isEmpty()) {
            return response()->json([
                'errors' => ['subscription' => ['Please purchase a plan to continue.']]
            ], 200);
        }

        $validSubscriptionFound = false;

        // 🔥 Loop through all subscriptions
        foreach ($subscriptions as $sub) {

            $endDate = Carbon::parse($sub->current_period_end);

            if (now()->greaterThan($endDate)) {
                // Subscription expired
                $sub->update(['status' => 'expired']);
            } else {
                // Found a valid active subscription
                $validSubscriptionFound = true;
            }
        }

        // 🔥 After loop — check if any valid subscription exists
        if (!$validSubscriptionFound) {
            return response()->json([
                'errors' => ['subscription' => ['Your subscription has expired. Please renew your plan.']]
            ], 200);
        }

        // 🔥 Valid subscription → success login
        return response()->json(['success' => true, 'redirect' => '/home']);
    }

    // 🔹 Invalid login
    return response()->json([
        'errors' => ['email' => ['The provided credentials do not match our records.']]
    ], 422);
}





public function coupon(Request $request)
{
    if ($request->ajax()) {
        // 🧩 Fake data array (Membership + Stats)
        $data = collect([
            [
                'id' => 1,
                'membership' => 'Basic',
                'weekly_limit' => 3,
                'redeemed' => 2,
                'left' => 1,
                'Usage' => '66%',
                'reset_date' => now()->startOfWeek()->addDays(7)->format('Y-m-d'),
                'expire_date'=> '21/06/2026'
            ],
            [
                'id' => 2,
                'membership' => 'Plus',
                'weekly_limit' => 10,
                'redeemed' => 5,
                'left' => 5,
                'Usage' => '50%',
                'reset_date' => now()->startOfWeek()->addDays(7)->format('Y-m-d'),
                'expire_date'=> '21/06/2026'
            ],
            [
                'id' => 3,
                'membership' => 'Premium',
                'weekly_limit' => 'Unlimited',
                'redeemed' => 12,
                'left' => 'No Left',
                'Usage' => 'No Limit',
                'reset_date' => 'N/A',
                'expire_date'=> '21/06/2026'
            ],
        ]);

        // Send data to DataTables
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('Usage', function ($row) {
                // Color styling for progress
                if (str_contains($row['Usage'], 'No Limit')) {
                    return '<span class="text-black-600 font-semibold">' . $row['Usage'] . '</span>';
                } elseif (str_contains($row['Usage'], 'Progress')) {
                    return '<span class="text-green-600 font-semibold">' . $row['Usage'] . '</span>';
                } else {
                    return $row['Usage'];
                }
            })
            ->rawColumns(['Usage'])
            ->make(true);
    }

    return view('coupon');
}

}
