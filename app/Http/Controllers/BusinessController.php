<?php

namespace App\Http\Controllers;
use App\Models\BusinessMembershipPlan;
use App\Models\BusinessPlanjoin;
use App\Models\Campaign;
use App\Models\CampaignJoin;
use App\Models\UserRedeem;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Membership_plan;
use App\Http\Controllers\PaymentController;
use Carbon\Carbon;
use App\Models\Business;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function view_plan(Request $request,$id){
        $plan=Membership_plan::findOrFail($id);
        return view('business.view_plan',compact('plan'));
    }

    public function updateOffer(Request $request, $id)
{
    $offer = Offer::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'expiry_datetime' => 'required|date',
        'stock_limit' => 'required|integer',
        'category' => 'required|exists:categories,id',
        'subcategory' => 'nullable|exists:subcategories,id',
        'price' => 'required|numeric',
        'discount' => 'nullable|numeric|min:0|max:100',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $offer->title = $validated['title'];
    $offer->description = $validated['description'] ?? '';
    $offer->expiry_datetime = $validated['expiry_datetime'];
    $offer->stock_limit = $validated['stock_limit'];
    $offer->category_id = $validated['category'];
    $offer->subcategory_id = $validated['subcategory'] ?? null;
    $offer->price = $validated['price'];
    $offer->discount = $validated['discount'] ?? 0;
    $offer->discount_price = $offer->price - ($offer->price * $offer->discount / 100);

    // Image upload
    if($request->hasFile('image')){
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/offers'), $filename);
        $offer->image = $filename;
    }

    $offer->save();

    return response()->json([
        'success' => true,
        'message' => 'Offer updated successfully!',
        'data' => $offer
    ]);
}

    public function deleteOffer($id)
{
    $offer = Offer::find($id);

    if (!$offer) {
        return response()->json(['success' => false, 'message' => 'Offer not found.']);
    }

    $offer->delete(); // delete the offer

    return response()->json(['success' => true, 'message' => 'Offer deleted successfully.']);
}

  public function toggleOfferStatus($id)
{
    $offer = Offer::find($id);

    if (!$offer) {
        return response()->json(['success' => false, 'message' => 'Offer not found.']);
    }

    // Toggle status
    $offer->status = $offer->status == 1 ? 0 : 1;
    $offer->save();

    $message = $offer->status == 1 ? 'Offer activated successfully.' : 'Offer deactivated successfully.';

    return response()->json(['success' => true, 'message' => $message, 'status' => $offer->status]);
}
public function editoffer($id){
    $categories = Category::where('status',1)->get();
    $offer = Offer::findOrFail($id); // id se offer fetch karo

    return view('business.editoffer', compact('categories', 'offer'));
}

// public function getOffer($id)
// {
//     $offer = Offer::with(['category', 'subcategory'])->find($id);

//     if (!$offer) {
//         return response()->json(['success' => false, 'message' => 'Offer not found']);
//     }

//     return response()->json(['success' => true, 'data' => $offer]);
// }


   public function updateProfile(Request $request)
{
    // Session se business id le lo
    $businessId = session('business_id');
    $business = Business::find($businessId);

    if(!$business){
        return redirect()->back()->with('error', 'Business not found!');
    }

    $request->validate([
        'shop_name' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:businesses,email,'.$business->id,
        'password' => 'nullable|min:3',
        'phone' => 'required|string',
    ]);

    // Database update
    $business->shop_name = $request->shop_name;
    $business->name = $request->name;
    $business->email = $request->email;
    $business->phone = $request->phone;

    if($request->password){
        $business->password = Hash::make($request->password);
    }

    $business->save();

    // Session update
    session([
        'shop_name'   => $business->shop_name,
        'name'        => $business->name,
        'email'       => $business->email,
        'phone'      => $business->phone,
        'business_id' => $business->id,
    ]);

    return redirect()->back()->with('success', 'Business Profile updated successfully!');
}


    public function profile(){
        return view('business.profile');
    }
 public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:3',
    ]);

    $business = Business::where('email', $request->email)->first();

    if (!$business) {
        return response()->json([
            'success' => false,
            'message' => 'Business Email Not Found!'
        ]);
    }

    // Password check
    if (!Hash::check($request->password, $business->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid password!'
        ]);
    }

    // Approval status
    if ($business->status == 0) {
        return response()->json([
            'success' => false,
            'message' => 'Your account is not approved by admin yet!'
        ]);
    }

    // Check if admin deactivated account
    if ($business->status == 2) {
        return response()->json([
            'success' => false,
            'message' => 'Your account has been deactivated by admin!'
        ]);
    }

    // Login business
    Auth::login($business);

    // ✅ Store in session
    session([
        'shop_name' => $business->shop_name,
        'name' => $business->name,
        'email' => $business->email,
        'phone'=>$business->phone,
        'longitude' => $business->longitude,
        'location'=>$business->location,
        'latitude' => $business->latitude,
        'business_id' => $business->id,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Login successful!',
        'redirect' => url('/business/dashboard')
    ]);
}



public function verifyVoucher(Request $request)
{
    $request->validate([
        'voucher_code' => 'required|string|max:50',
    ]);

    $businessId = session('business_id');
    if (!$businessId) {
        return response()->json(['error' => 'Business not found in session'], 400);
    }

    // 🔹 Find all UserRedeem rows matching input voucher code and business
    $userRedeems = UserRedeem::with(['user', 'offer'])
        ->where('vchcode', $request->voucher_code)
        ->whereHas('offer', function($q) use ($businessId) {
            $q->where('business_id', $businessId);
        })
        ->where('status', 'claim')
        ->get();

    if ($userRedeems->isEmpty()) {
        return response()->json([
            'message' => 'Voucher code not claimed by any user yet.',
            'data' => [],
        ]);
    }

    // 🔹 Update status to 'redeem' and prepare response data
    $redeemedData = $userRedeems->map(function ($redeem) {
        $redeem->status = 'redeem';
        $redeem->updated_at = now();
        $redeem->save();

        return [
            'user_id'     => $redeem->user_id,
            'user_name'   => $redeem->user ? $redeem->user->name : 'Unknown User',
            'offer_id'    => $redeem->offer_id,
            'offer_title' => $redeem->offer ? $redeem->offer->title : 'Unknown Offer',
            'discount'    => $redeem->offer ? $redeem->offer->discount : 0,
            'claimeddate' => $redeem->created_at ? $redeem->created_at->format('d-m-Y') : 'N/A',
            'status'      => ucfirst($redeem->status),
        ];
    });

    return response()->json([
        'message' => 'Voucher verified and redeemed successfully.',
        'data' => $redeemedData,
    ]);
}

public function redeemVoucher(Request $request)
{
    $request->validate([
        'voucher_code' => 'required|string|max:50',
        'user_id' => 'required|integer', // ✅ ensure user_id is sent
    ]);

    $businessId = session('business_id');
    if (!$businessId) {
        return response()->json(['error' => 'Business not found in session'], 400);
    }

    // 🔹 Match offer with business
    $offer = Offer::where('voucher_code', $request->voucher_code)
        ->where('business_id', $businessId)
        ->first();

    if (!$offer) {
        return response()->json(['error' => 'Voucher code not valid'], 404);
    }

    // 🔹 Match user_id also
    $userRedeem = UserRedeem::where('offer_id', $offer->id)
        ->where('user_id', $request->user_id)
        ->first();

    if (!$userRedeem) {
        return response()->json(['error' => 'This user has not claimed the voucher'], 404);
    }

    // 🔹 Update status to redeemed
    $userRedeem->status = 'redeem';
    $userRedeem->updated_at = now();
    $userRedeem->save();

    return response()->json(['success' => 'Voucher marked as redeemed successfully']);
}


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:businesses,email',
            'phone' => 'required|string',
            'location' => 'required',
            'password' => 'required|string|min:6|confirmed',
             'profile' => 'required|image|mimes:jpg,jpeg,png,webp' // confirms password_confirmation
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
$imageName = null;

        if ($request->hasFile('profile')) {
            $imageName = time() . '.' . $request->profile->extension();
            $request->profile->move(public_path('business/profiles'), $imageName);
        }
        Business::create([
            'shop_name' => $request->shop_name,
            'name' => $request->name,
            'email' => $request->email,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location' => $request->location,
            'phone' => $request->phone,
            'profile' => $imageName,
            'password' => Hash::make($request->password),

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Business registered successfully!'
        ]);
    }
    public function register(){
        return view('businessregister');
    }
    public function createnotification(){
        return view('business.createnotification');
    }
    public function notificationhistory(Request $request)
{
    $notifications = [
        [
            'id' => 1,
            'title' => 'Big Sale Alert!',
            'message' => 'Get 50% off on all electronics today.',
            'audience' => 'All Users',

            'schedule_time' => '2025-10-10 10:00',
            'status' => 'Sent',
            'sent_count' => 1200,
            'opened_count' => 870,
        ],
        [
            'id' => 2,
            'title' => 'Nearby Food Fest 🍔',
            'message' => 'Enjoy discounts on top food outlets near you!',
            'audience' => 'Nearby Users',

            'schedule_time' => '2025-10-11 17:00',
            'status' => 'Scheduled',
            'sent_count' => 0,
            'opened_count' => 0,
        ],
        [
            'id' => 3,
            'title' => 'Weekend Offer 🎉',
            'message' => 'Buy 1 Get 1 Free on clothing this weekend!',
            'audience' => 'Nearby Users',

            'schedule_time' => '2025-10-12 09:30',
            'status' => 'Sent',
            'sent_count' => 600,
            'opened_count' => 420,
        ],
    ];

    if ($request->ajax()) {
        return DataTables::of(collect($notifications))
            ->addColumn('actions', function ($row) {
                return '
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</button>
&nbsp;
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" style="background:red">Delete</button>
                    </div>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('business.notificationhistory');
}

    public function dashboard()
    {
        return view('business.dashboard');
}
   public function createoffer()
    {
        $categories = Category::where('status',1)->get(); // only active categories
        return view('business.createoffer', compact('categories'));
    }

    // AJAX: return subcategories for a category
    public function getSubcategories($categoryId)
    {
        $subs = Subcategory::where('category_id', $categoryId)->get(['id','name']);
        return response()->json([
            'success' => true,
            'data' => $subs
        ]);
    }



public function storeOffer(Request $request)
{
    $businessId = session('business_id');
    if (!$businessId) {
        return redirect()->back()->with('error', 'You must be logged in as a business to create an offer.');
    }

    // ================================
    // ✅ VALIDATION
    // ================================
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'expiry_datetime' => 'required|date',
        'stock_limit' => 'required|integer|min:0',
        'category' => 'required|exists:categories,id',
        'subcategory' => 'nullable|exists:subcategories,id',
        'price' => 'required|numeric|min:0',
        'discount' => 'nullable|integer|min:0|max:100',

        // 🔥 MULTIPLE IMAGE VALIDATION (max 4)
        'images' => 'nullable|array|max:4',
        'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',

        'campaign_id' => 'nullable|exists:campaigns,id',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // ================================
    // 🔥 Campaign Rule Checks
    // ================================
    if ($request->filled('campaign_id')) {

        $campaign = \App\Models\Campaign::find($request->campaign_id);

        if (!$campaign) {
            return redirect()->back()->withErrors(['campaign_id' => 'Invalid campaign selected.'])->withInput();
        }

        $expiry = Carbon::parse($request->expiry_datetime)->startOfDay();
        $campaignStart = Carbon::parse($campaign->start_date);
        $campaignEnd = Carbon::parse($campaign->end_date)->startOfDay();

        if ($expiry->lt($campaignStart)) {
            return redirect()->back()->withErrors([
                'expiry_datetime' => "Offer expiry date cannot be earlier than campaign start date: {$campaign->start_date}"
            ])->withInput();
        }

        if ($expiry->greaterThan($campaignEnd)) {
            return redirect()->back()->withErrors([
                'expiry_datetime' => "Offer expiry date cannot exceed campaign end date: {$campaign->end_date}"
            ])->withInput();
        }

        if ($request->discount > $campaign->discount_rules) {
            return redirect()->back()->withErrors([
                'discount' => "Maximum allowed discount for this campaign is {$campaign->discount_rules}%"
            ])->withInput();
        }
    }

    // ================================
    // 🔥 UNIQUE VOUCHER CODE
    // ================================
    do {
        $voucherCode = 'VC-' . strtoupper(Str::random(8));
    } while (\App\Models\Offer::where('voucher_code', $voucherCode)->exists());


    // ================================
    // 🔥 DATA ARRAY
    // ================================
    $data = [
        'business_id' => $businessId,
        'title' => $request->title,
        'description' => $request->description,
        'expiry_datetime' => $request->expiry_datetime,
        'stock_limit' => $request->stock_limit,
        'category_id' => $request->category,
        'subcategory_id' => $request->subcategory ?: null,
        'price' => $request->price,
        'discount' => $request->discount ?: 0,
        'discount_price' => $request->discount_price,
        'voucher_code' => $voucherCode,
    ];


    // ================================
    // 🔥 MULTIPLE IMAGE UPLOAD
    // ================================
    $imageNames = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {

            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/offers'), $filename);

            $imageNames[] = $filename;
        }
    }

    // Save as JSON in DB
    $data['image'] = json_encode($imageNames);


    // ================================
    // 🔥 IF CAMPAIGN OFFER
    // ================================
    if ($request->filled('campaign_id')) {
        $data['campaign_id'] = $request->campaign_id;

        \App\Models\CampaignOffer::create($data);

        return redirect()->back()->with('success', 'Campaign Offer created successfully! Voucher Code: '.$voucherCode);
    }


    // ================================
    // 🔥 NORMAL OFFER
    // ================================
    \App\Models\Offer::create($data);

    return redirect()->back()->with('success', 'Offer created successfully! Voucher Code: '.$voucherCode);
}


public function getCampaignData($id)
{
    $campaign = Campaign::find($id);

    return response()->json([
        'category_ids' => json_decode($campaign->category_ids, true),
        'subcategory_ids' => json_decode($campaign->subcategory_ids, true)
    ]);
}
public function getSubcategori($categoryId)
{
    $subcategories = Subcategory::where('category_id', $categoryId)->get();

    return response()->json($subcategories);
}


    public function activeoffer()
    {
        return view('business.active');
}
    public function expireoffer()
    {
        return view('business.expire');
}
public function expireOfferData()
{
    $currentDateTime = Carbon::now(); // current date & time

    // Table se saare offers lo jinke expiry date chuke hain
    $expiredOffers =  DB::table('create_offers')
        ->where(function ($query) use ($currentDateTime) {
            $query->whereDate('expiry_datetime', '<', $currentDateTime->toDateString())
                  ->orWhere(function ($q) use ($currentDateTime) {
                      $q->whereDate('expiry_datetime', '=', $currentDateTime->toDateString())
                        ->whereTime('expiry_datetime', '<', $currentDateTime->toTimeString());
                  });
        })
        ->get();

    // DataTables ke liye array format me badlo
    $data = $expiredOffers->map(function ($offer) {
        return [
            'title' => $offer->title,
            'description' => $offer->description,
            'category' => $offer->category_id, // ya category name join karna ho to join kar sakte ho
            'subcategory' => $offer->subcategory_id,
            'created_date' => \Carbon\Carbon::parse($offer->created_at)->format('d/m/Y H:i'),
            'expiry_date' => \Carbon\Carbon::parse($offer->expiry_datetime)->format('d/m/Y H:i'),
            'price' => $offer->price,
            'discount' => $offer->discount . '%',
            'redeem_count' => 0, // abhi ke liye 0
            'action' => '<button class="px-3 py-1 bg-red-500 text-white rounded" onclick="deleteOffer(' . $offer->id . ')" style="background:red">Delete</button>',
        ];
    });

    return DataTables::of($data)->make(true);
}

public function viewcampaign($id){
    $campaignid=$id;
    $campaign=Campaign::findOrFail($campaignid);
    return view('business.viewcampaign',compact('campaign'));
}
public function ongoingcampaign(Request $request)
    {
        $today = Carbon::today()->toDateString(); // ✅ Get today's date as string

        // 🔹 Get all ongoing campaigns
        $campaigns = Campaign::where('status', 1)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        // 🧪 Debugging (optional)
        // dd($today, $campaigns->toArray());

        // 🔹 If it's an AJAX request for DataTables
        if ($request->ajax()) {
            return DataTables::of($campaigns)
                ->addColumn('days_left', function ($row) use ($today) {
                    $endDate = Carbon::parse($row->end_date);
                    $daysLeft = Carbon::parse($today)->diffInDays($endDate, false);

                    if ($daysLeft < 0) {
                        return '<span class="text-red-500 font-semibold">Expired</span>';
                    } elseif ($daysLeft === 0) {
                        return '<span class="text-yellow-500 font-semibold">Ends Today</span>';
                    } else {
                        return "<span class='text-green-600 font-semibold'>{$daysLeft} Days</span>";
                    }
                })
                ->addColumn('benefit', function ($row) {
                    // ✂️ Show only 15 characters of benefit
                    return strlen($row->benefit) > 15
                        ? substr($row->benefit, 0, 15) . '...'
                        : $row->benefit;
                })
                ->addColumn('actions', function ($row) {
    $viewUrl = route('business.viewcampaign', ['id' => $row->id]);

    // ✅ View Button (using normal PHP string)
    $viewBtn = '
        <a href="' . $viewUrl . '"
           class="viewBtn inline-flex items-center gap-2 px-3 py-1.5 bg-blue-500 text-white text-sm font-medium rounded-lg
                  hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 transition duration-200 shadow-md"
           style="padding:17px">
           View
        </a>';


    // 🔹 Join Button (Paid or Free)
   $businessId = session('business_id');

if ($row->join_fee > 0) {
    // ✅ Check if already joined
    $isJoined = CampaignJoin::where('business_id', $businessId)
        ->where('campaign_id', $row->id)
        ->exists();

    if ($isJoined) {
        $joinBtn = '
            <button disabled
                class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue text-white text-sm font-medium rounded-lg
                       cursor-not-allowed shadow-md" style="padding:17px" style="background: blue;">
                 Joined
            </button>';
    } else {
        $joinBtn = '
            <button data-id="' . $row->id . '"
                class="joinBtn inline-flex items-center gap-2 px-3 py-1.5 bg-blue text-white text-sm font-medium rounded-lg
                       hover:bg-indigo-600 focus:ring-2 focus:ring-indigo-400 transition duration-200 shadow-md" style="padding:17px;background:blue">
                 Join
            </button>';
    }

} else {
    // ✅ Check if already joined
    $isJoined = CampaignJoin::where('business_id', $businessId)
        ->where('campaign_id', $row->id)
        ->exists();

    if ($isJoined) {
        $joinBtn = '
            <button disabled
                class="inline-flex items-center gap-2 px-3 py-1.5  text-white text-sm font-medium rounded-lg
                       cursor-not-allowed shadow-md" style="padding:17px;background:red;">
                 Joined
            </button>';
    } else {
        $joinBtn = '
            <button data-id="' . $row->id . '"
                class="joinBtn inline-flex items-center gap-2 px-3 py-1.5 bg-blue text-white text-sm font-medium rounded-lg
                       hover:bg-green-600 focus:ring-2 focus:ring-green-400 transition duration-200 shadow-md" style="padding:17px;background:blue">
                 Join Free
            </button>';
    }
}


    // 🔹 Return both buttons side by side
    return '<div class="flex gap-3 justify-center">' . $viewBtn .'&nbsp;'. $joinBtn . '</div>';
})
->rawColumns(['days_left', 'actions'])

                ->rawColumns(['days_left', 'actions'])
                ->make(true);
        }

        // 🔹 Return blade view
        return view('business.ongoingcampaign', compact('campaigns'));
    }


    public function joinFree(Request $request)
    {
        $businessId = session('business_id');

        if (!$businessId) {
            return response()->json(['message' => 'Business not found in session'], 400);
        }

        $campaignId = $request->campaign_id;

        // Prevent duplicate join
        $exists = CampaignJoin::where('business_id', $businessId)
            ->where('campaign_id', $campaignId)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'Already joined this campaign!']);
        }

        // Insert new record
        CampaignJoin::create([
            'business_id' => $businessId,
            'campaign_id' => $campaignId,
            'count_offer' => 0
        ]);

        return response()->json(['message' => 'Joined campaign successfully!']);
    }
public function mycampaign(Request $request)
{
    $businessId = session('business_id');

    // Step 1: Get all CampaignJoin records with related campaign
    $joinedCampaigns = CampaignJoin::where('business_id', $businessId)
        ->with('campaign') // assuming relation defined: CampaignJoin belongsTo Campaign
        ->get();

    // Step 2: DataTables response
    if ($request->ajax()) {
        return DataTables::of($joinedCampaigns)
            ->addColumn('id', function ($row) {
                return $row->campaign->id ?? '-';
            })
            ->addColumn('campaign_name', function ($row) {
                return $row->campaign->campaign_name ?? '-';
            })
            ->addColumn('start_date', function ($row) {
                return $row->created_at->format('d M, Y');
            })
            ->addColumn('fees', function ($row) {
                return $row->join_fee == 0 ? '0' : '₹' . number_format($row->join_fee, 2);
            })
            ->addColumn('join_type', function ($row) {
                return $row->join_fee == 0
                    ? '<span class="text-green-600 font-medium">Free</span>'
                    : '<span class="text-blue-600 font-medium">Paid</span>';
            })
            ->addColumn('actions', function ($row) {
                $viewUrl = route('business.viewcampaign', $row->campaign_id);
                return '
                    <a href="' . $viewUrl . '"
                        class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                        View
                    </a>';
            })
            ->rawColumns(['join_type', 'actions'])
            ->make(true);
    }

    return view('business.mycampaign');
}

public function myplan(Request $request)
{
    $plans = [
        [
            'id' => 1,
            'plan_name' => 'Pro',
            'start_date' => '2025-09-01',
            'end_date' => '2025-09-30',
            'status' => 'Active',
            'monthly_fee' => '₹999',
            'visibility' => 'Homepage + City + Category',
            'campaign_limit' => '10 campaigns/month',
            'coupon_limit' => '25 coupons',
        ],
        [
            'id' => 2,
            'plan_name' => 'Free',
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-31',
            'status' => 'Expired',
            'monthly_fee' => '₹0',
            'visibility' => 'Basic (only in category pages)',
            'campaign_limit' => '1 campaign/month',
            'coupon_limit' => '3 coupons',
        ],
    ];

    if ($request->ajax()) {
        return DataTables::of(collect($plans))
            ->addColumn('actions', function ($row) {
                if ($row['status'] === 'Active') {
                    return '<button class="renewBtn bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" style="background:green">Renew</button>';
                } else {
                    return '<button class="upgradeBtn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Upgrade</button>';
                }
            })
            ->editColumn('status', function ($row) {
                return $row['status'] === 'Active'
                    ? '<span class="text-green-600 font-semibold">Active</span>'
                    : '<span class="text-red-600 font-semibold">Expired</span>';
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    return view('business.myplan');
}

public function chooseplan(Request $request)
{
    if ($request->ajax()) {
        // Sirf Active (status = 1) business plans DB se fetch karo
        $plans = Membership_plan::where('status', 1)->get();

        return DataTables::of($plans)
            ->addColumn('plan_name', fn($row) => ucfirst($row->plan_tier))
            ->addColumn('monthly_fee', fn($row) => '$'.$row->plan_price)

            ->addColumn('active_offer_limit', fn($row) => $row->coupons_per_week.'/'.$row->month_year ?? '-')
            ->addColumn('discount_limit', fn($row) => $row->discount_limit?? 'N/A')
           // ya trial_days ko coupon limit me use kar rahe
            ->addColumn('actions', function ($row) {
                $viewBtn = '
<a
    href="'.route('check.plan', $row->id).'"
    class="inline-flex items-center gap-1 px-3 py-1 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition duration-200"
>
    <i class="fa fa-eye"></i> View
</a>
&nbsp;';

                $joinBtn = '<button
    data-id="'.$row->id.'"
    data-price="'.$row->plan_price.'"
    data-plan="'.$row->plan_tier.'"
    data-monthyear="'.$row->month_year.'"
    class="joinBtn inline-flex items-center gap-1 px-3 py-1 text-white rounded hover:bg-green-600 transition" style="background:blue">
    Join
</button>';


                return '<div class="flex items-center space-x-2">'.$viewBtn.$joinBtn.'</div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('business.chooseplan');
}



public function viewPlan(Request $request)
{
    $id = $request->id;
    $plan = BusinessMembershipPlan::find($id);

    if (!$plan) {
        return response()->json(['error' => 'Plan not found'], 404);
    }

    return response()->json($plan);
}



public function analytic()
{
    // Example campaigns for dropdown
    $campaigns = [
        ['id' => 1, 'name' => 'Festive Sale'],
        ['id' => 2, 'name' => 'Weekend Boost'],
        ['id' => 3, 'name' => 'Mega Discount']
    ];

    return view('business.analytic', compact('campaigns'));
}

public function getCampaignMetrics(Request $request)
{
    $campaignId = $request->id;

    $data = [
        1 => [
            'total_views' => 1200,
            'total_redeemed' => 300,
            'expiry_date' => '2025-10-10',
            'daily' => [
                ['date' => '2025-10-01', 'views' => 200, 'redeemed' => 50],
                ['date' => '2025-10-02', 'views' => 400, 'redeemed' => 100],
                ['date' => '2025-10-03', 'views' => 600, 'redeemed' => 150],
            ]
        ],
        2 => [
            'total_views' => 800,
            'total_redeemed' => 150,
            'expiry_date' => '2025-10-12',
            'daily' => [
                ['date' => '2025-10-01', 'views' => 200, 'redeemed' => 50],
                ['date' => '2025-10-02', 'views' => 300, 'redeemed' => 60],
                ['date' => '2025-10-03', 'views' => 300, 'redeemed' => 40],
            ]
        ],
        3 => [
            'total_views' => 1500,
            'total_redeemed' => 400,
            'expiry_date' => '2025-10-15',
            'daily' => [
                ['date' => '2025-10-01', 'views' => 500, 'redeemed' => 100],
                ['date' => '2025-10-02', 'views' => 500, 'redeemed' => 150],
                ['date' => '2025-10-03', 'views' => 500, 'redeemed' => 150],
            ]
        ],
    ];

    return response()->json($data[$campaignId] ?? []);
}




public function activeOfferData()
{
    $now = \Carbon\Carbon::now(); // current date & time

    // ✅ Active offers: expiry date/time abhi se bada ya barabar hai
    $offers = \App\Models\Offer::with(['category', 'subcategory'])
        ->where(function ($query) use ($now) {
            $query->whereDate('expiry_datetime', '>', $now->toDateString())
                  ->orWhere(function ($q) use ($now) {
                      $q->whereDate('expiry_datetime', '=', $now->toDateString())
                        ->whereTime('expiry_datetime', '>=', $now->toTimeString());
                  });
        })
        ->get();

    return \Yajra\DataTables\Facades\DataTables::of($offers)
        ->addColumn('category', function($offer) {
            return $offer->category?->name ?? 'N/A';
        })
        ->addColumn('subcategory', function($offer) {
            return $offer->subcategory?->name ?? 'N/A';
        })
        ->addColumn('created_date', function($offer) {
            return $offer->created_at ? $offer->created_at->format('d/m/Y H:i') : 'N/A';
        })
        ->addColumn('expiry_date', function($offer) {
            return $offer->expiry_datetime
                ? \Carbon\Carbon::parse($offer->expiry_datetime)->format('d/m/Y H:i')
                : 'N/A';
        })
        ->addColumn('stock_remaining', function($offer) {
            return $offer->stock_limit ?? 0;
        })
        ->addColumn('redeem_count', function($offer) {
            return 0; // abhi ke liye static
        })
        ->addColumn('total_stock', function($offer) {
            return $offer->stock_limit ?? 0;
        })
        ->addColumn('action', function($offer) {
            $btnText = $offer->status == 1 ? 'Deactivate' : 'Activate';
            $btnColor = $offer->status == 1 ? 'bg-teal-500' : 'bg-teal-500';

            return '
                <div class="flex space-x-2">
                    <a href="/business/editoffer/'.$offer->id.'">
                        <button class="px-3 py-1 bg-blue-500 text-white rounded">Edit</button>
                    </a>
                    &nbsp;
                    <button class="px-3 py-1 bg-red-500 text-white rounded" onclick="deleteOffer('.$offer->id.')" style="background:red">Delete</button>
                    &nbsp;
                    <button class="px-3 py-1 '.$btnColor.' text-white rounded" onclick="toggleOfferStatus('.$offer->id.')">'.$btnText.'</button>
                </div>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
}

    public function message()
    {
        return view('business.message');
}
 public function reedemption(Request $request)
{
    if ($request->ajax()) {

        // ✅ Get all redeemed vouchers with relationships
        $redemptions = UserRedeem::with(['user', 'offer'])
            ->where('status', 'redeem')
            ->latest('updated_at')
            ->get();

        return DataTables::of($redemptions)
            ->addIndexColumn()

            // 🟢 Redemption ID (Custom format like VCH1001)
            ->addColumn('redemption_id', function ($row) {
                return 'VCH' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
            })

            // 🟢 User Name from users table
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : 'N/A';
            })

            // 🟢 Offer Title from offers table
            ->addColumn('offer_name', function ($row) {
                return $row->offer ? $row->offer->title : 'N/A';
            })

            // 🟢 DateTime from updated_at (when redeemed)
            ->addColumn('datetime', function ($row) {
                return \Carbon\Carbon::parse($row->updated_at)->format('Y-m-d H:i');
            })

            // 🟢 Status (always Redeemed)
            ->addColumn('status', function ($row) {
                return '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700">Redeemed</span>';
            })

            // 🟢 Actions (Delete button)
            ->addColumn('actions', function ($row) {
                return '<button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" style="background:red">Delete</button>';
            })

            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('business.report');
}
public function verify(){
    return view('business.verify');
}
public function campaignhistory()
{
    return view('business.campaignhistory');
}



public function popular(Request $request)
{
    $businessId = session('business_id');

    // 🔹 Step 1: Get all offers belonging to the business
    $offers = Offer::where('business_id', $businessId)->get();

    // 🔹 Step 2: Prepare formatted data array with redeem count and category/subcategory names
    $data = $offers->map(function ($offer) {
        $redeemCount = UserRedeem::where('offer_id', $offer->id)->count();

        $categoryName = Category::where('id', $offer->category_id)->value('name');
        $subcategoryName = Subcategory::where('id', $offer->subcategory_id)->value('name');

        return [
            'title' => $offer->title,
            'description' => $offer->description,
            'category' => $categoryName ?? 'N/A',
            'subcategory' => $subcategoryName ?? 'N/A',
            'redeem_count' => $redeemCount,
        ];
    });

    // 🔹 Step 3: Sort data by redeem_count (desc)
    $sortedData = $data->sortByDesc('redeem_count')->values();

    // 🔹 Step 4: Handle AJAX DataTable request
    if ($request->ajax()) {
        return DataTables::of($sortedData)

            ->rawColumns([])
            ->make(true);
    }

    // 🔹 Step 5: Load Blade view
    return view('business.popular');
}


}
