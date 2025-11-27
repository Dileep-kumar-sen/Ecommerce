<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BusinessMembershipPlan;
use App\Models\Campaign;
use App\Models\Payment;
use App\Models\Report;
use App\Models\User;
use App\Models\UserRedeem;
use Carbon\Carbon;

use App\Models\Banner;
use App\Models\Membership_plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Business;
use App\Models\Subcategory;
use App\Models\Offer;

class AdminController extends Controller
{

    public function profileedit(Request $request)
    {
        $adminId = session('admin_id');

        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $admin = Admin::find($adminId);

        return view('admin.profile', compact('admin'));
    }
public function profileupdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . session('admin_id'),
        ]);

        $admin = Admin::find(session('admin_id'));

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found.');
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        // ✅ Update session values
        session([
            'name' => $admin->name,
            'email' => $admin->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
public function approveBusiness($id)
{
    $business = Business::find($id);
    if ($business) {
        $business->status = 1;
        $business->save();
        return response()->json(['success' => true, 'message' => 'Business approved successfully']);
    }
    return response()->json(['success' => false, 'message' => 'Business not found']);
}

public function rejectBusiness($id)
{
    $business = Business::find($id);
    if ($business) {
        $business->delete();
        return response()->json(['success' => true, 'message' => 'Business rejected and deleted']);
    }
    return response()->json(['success' => false, 'message' => 'Business not found']);
}

public function update(Request $request, $id)
{

    $membershipType = $request->input('membership_type');

    if ($membershipType === 'user') {
        // ================== User membership update ==================
        $validator = Validator::make($request->all(), [
            'membership_type' => 'required|in:user',
            'plan_tier' => 'required|string',
            'trial_period_days' => 'nullable|integer',
            'coupons_per_week' => 'nullable|integer',
            'discount_limit' => 'nullable|string',
            'exclusive_offers_monthly' => 'nullable|integer',
            'features' => 'nullable|string',
            'achievements' => 'nullable|string',
            'referral_bonus' => 'nullable|string',
            'plan_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'plan_icon' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $plan = Membership_plan::find($id);
        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Plan not found'
            ], 404);
        }

        $plan->plan_tier = $request->input('plan_tier');
        $plan->trial_period_days = $request->input('trial_period_days');
        $plan->coupons_per_week = $request->input('coupons_per_week');
        $plan->discount_limit = $request->input('discount_limit');
        $plan->exclusive_offers_monthly = $request->input('exclusive_offers_monthly');
        $plan->features = $request->input('features');
        $plan->achievements = $request->input('achievements');
        $plan->referral_bonus = $request->input('referral_bonus');
        $plan->plan_price = $request->input('plan_price');
        $plan->description = $request->input('description');

        if ($request->hasFile('plan_icon')) {
            $file = $request->file('plan_icon');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/membership_icons'), $filename);
            $plan->plan_icon = 'uploads/membership_icons/'.$filename;
        }

        $plan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User membership plan updated successfully'
        ]);
    }
    elseif ($membershipType === 'business') {
        // ================== Business membership update ==================
        $validator = Validator::make($request->all(), [
            'membership_type' => 'required|in:business',
            'plan_tier' => 'required|string',
            'trial_days' => 'nullable|integer',
            'discount' => 'nullable|string',
            'active_offers' => 'nullable|integer',
            'plan_price' => 'nullable|numeric',
            'duration_months' => 'nullable|integer',
            'visibility_level' => 'nullable|string',
            'metrics_access' => 'nullable|string',
            'highlight_banner' => 'nullable|boolean',
            'push_notifications' => 'nullable|boolean',
            'marketing_campaigns' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $plan = BusinessMembershipPlan::find($id);
        if (!$plan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Business plan not found'
            ], 404);
        }

        // Fill business fields
        $plan->plan_tier = $request->input('plan_tier');
        $plan->trial_days = $request->input('trial_days');
        $plan->discount = $request->input('discount');
        $plan->active_offers = $request->input('active_offers');
        $plan->plan_price = $request->input('plan_price');
        $plan->duration_months = $request->input('duration_months');
        $plan->visibility_level = $request->input('visibility_level');
        $plan->metrics_access = $request->input('metrics_access');
        $plan->highlight_banner = $request->input('highlight_banner');
        $plan->push_notifications = $request->input('push_notifications');
        $plan->marketing_campaigns = $request->input('marketing_campaigns');
        $plan->description = $request->input('description');
        $plan->status = $request->input('status', 1);

        $plan->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Business membership plan updated successfully'
        ]);
    }
    else {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid membership type'
        ], 400);
    }
}


    public function storeMembershipPlan(Request $request)
{
    // ✅ Validate input fields
    $request->validate([
        'plan_tier' => 'required|string|max:100',
        'trial_period_days' => 'nullable|integer',
        'coupons_per_week' => 'nullable|integer',
        'discount_limit' => 'nullable|string|max:50',
        'exclusive_offers_monthly' => 'nullable|integer',
        'features' => 'nullable|string',
        'achievements' => 'nullable|string',
        'referral_bonus' => 'nullable|string',
        'plan_price' => 'nullable|numeric',
        'description' => 'nullable|string',
        'plan_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg',
        'month_year'=>'required'

    ]);

    // ✅ Handle image upload
    $iconPath = null;
    if ($request->hasFile('plan_icon')) {
        $file = $request->file('plan_icon');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/membership_icons'), $filename);
        $iconPath = 'uploads/membership_icons/' . $filename;
    }

    // ✅ Save record in database using your model
    \App\Models\Membership_plan::create([
        'plan_tier' => $request->plan_tier,
        'trial_period_days' => $request->trial_period_days,
        'coupons_per_week' => $request->coupons_per_week,
        'discount_limit' => $request->discount_limit,
        'exclusive_offers_monthly' => $request->exclusive_offers_monthly,
        'features' => $request->features,
        'achievements' => $request->achievements,
        'referral_bonus' => $request->referral_bonus,
        'plan_price' => $request->plan_price,
        'description' => $request->description,
        'plan_icon' => $iconPath,
        'month_year'=>$request->month_year,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Membership plan created successfully!',
    ]);
}

public function businessplanstore(Request $request)
    {
        $request->validate([
            'plan_tier' => 'required|string',
            'trial_days' => 'nullable|integer',
            'discount' => 'required|integer',
            'active_offers' => 'required|integer',
            'plan_price' => 'required|numeric',
            'duration_months' => 'required|integer',
            'visibility_level' => 'required|string',
            'metrics_access' => 'required|string',
            'highlight_banner' => 'required|boolean',
            'push_notifications' => 'required|boolean',
            'marketing_campaigns' => 'nullable|string',
            'description' => 'required|string',
        ]);

        $plan = BusinessMembershipPlan::create([
            'plan_tier' => $request->plan_tier,
            'trial_days' => $request->trial_days,
            'discount' => $request->discount,
            'active_offers' => $request->active_offers,
            'plan_price' => $request->plan_price,
            'duration_months' => $request->duration_months,
            'visibility_level' => $request->visibility_level,
            'metrics_access' => $request->metrics_access,
            'highlight_banner' => $request->highlight_banner,
            'push_notifications' => $request->push_notifications,
            'marketing_campaigns' => $request->marketing_campaigns,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Business Plan saved successfully!', 'data' => $plan]);
    }
     public function dashboard()
    {
        return view('admin.dashboard');
}
public function login(Request $request)
{
$request->validate([
'email' => 'required|email',
'password' => 'required|string'
]);


$admin = Admin::where('email', $request->email)->first();


if (!$admin || !Hash::check($request->password, $admin->password)) {
return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}


// set session
$request->session()->put('admin_id', $admin->id);



return redirect()->intended('/admin/dashboard');
}
public function logout(Request $request)
{
$request->session()->forget(['admin_id']);
$request->session()->invalidate();
$request->session()->regenerateToken();


return redirect()->route('admin.login');
}
public function store(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'categories' => 'required|array',
            'subcategories' => 'required|array',
            'join_fee' => 'required|numeric',
            'discount_rules' => 'required|string|max:255',
            'benefit' => 'required|string|max:255',
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string',
        ]);

        // 🖼️ Image Upload
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $bannerName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/campaigns'), $bannerName); // store in public/uploads/campaigns
            $bannerPath = 'uploads/campaigns/' . $bannerName;
        }

        // 💾 Save Campaign
        Campaign::create([
            'campaign_name' => $request->campaign_name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'categories' => json_encode($request->categories),
            'subcategories' => json_encode($request->subcategories),
            'join_fee' => $request->join_fee,
            'discount_rules' => $request->discount_rules,
            'benefit' => $request->benefit,
            'max_offer' => $request->max_offer,
            'banner' => $bannerPath,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Campaign created successfully!');
    }

public function getSubcategories(Request $request)
{
    $categoryIds = $request->category_ids;

    $subcategories = Subcategory::whereIn('category_id', $categoryIds)->get(['id', 'name']);

    return response()->json($subcategories);
}

public function createcampaign()
    {
        $categories = Category::all();
        return view('admin.createcampaign', compact('categories'));
}
public function campaignhistory()
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.campaignhistory', compact('campaigns'));
    }

   public function getCategoryNames(Request $request)
{
    $ids = explode(',', $request->ids);
    $categories = Category::whereIn('id', $ids)->select('id', 'name')->get();
    return response()->json($categories);
}

public function getSubcategoryNames(Request $request)
{
    $ids = explode(',', $request->ids);
    $subcategories = Subcategory::whereIn('id', $ids)
        ->with('category:id,name')
        ->get()
        ->map(fn($sub) => [
            'id' => $sub->id,
            'name' => $sub->name,
            'category_name' => $sub->category->name ?? 'N/A'
        ]);
    return response()->json($subcategories);
}
public function deactivateCampaign($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) {
            return response()->json(['message' => 'Campaign not found'], 404);
        }

        if($campaign->status==0){
            $campaign->status=1;
             $campaign->save();

        return response()->json(['message' => 'Campaign Aactivated successfully!']);
        }
        else{
            $campaign->status=0;
             $campaign->save();

        return response()->json(['message' => 'Campaign Deactivated successfully!']);
        }

    }
    public function edit($id)
{
    $campaign = Campaign::findOrFail($id);
    $categories = Category::all();
    $subcategories = SubCategory::all();

    return view('admin.editcampaign', compact('campaign', 'categories', 'subcategories'));
}

public function updatec(Request $request, $id)
{
    $campaign = Campaign::findOrFail($id);

    $campaign->update([
        'campaign_name' => $request->campaign_name,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'categories' => json_encode($request->categories),
        'subcategories' => json_encode($request->subcategories),
        'join_fee' => $request->join_fee,
        'discount_rules' => $request->discount_rules,
        'benefit' => $request->benefit,
        'max_offer' => $request->max_offer,
        'description' => $request->description,
    ]);

    if ($request->hasFile('banner')) {
        $image = $request->file('banner');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/campaigns'), $filename);
        $campaign->banner = $filename;
        $campaign->save();
    }

    return redirect()->route('admin.campaignhistory')->with('success', 'Campaign updated successfully!');
}


    // 🔴 Delete Campaign
    public function deleteCampaign($id)
    {
        $campaign = Campaign::find($id);

        if (!$campaign) {
            return response()->json(['message' => 'Campaign not found'], 404);
        }

        $campaign->delete();

        return response()->json(['message' => 'Campaign deleted successfully!']);
    }

public function joincampaign(){
    return view('admin.joincampaign');
}
public function usermanagement(Request $request)
{
    if ($request->ajax()) {
        // ✅ Get all users whose membership_status is NOT null
        $users = User::orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()

            // ✅ User ID with prefix
            ->editColumn('id', function ($row) {
                return $row->id ? "US00{$row->id}" : 'N/A';
            })

            // ✅ User Name
            ->editColumn('name', function ($row) {
                return $row->name ?? 'N/A';
            })

            // ✅ User Email
            ->editColumn('email', function ($row) {
                return $row->email ?? 'N/A';
            })

            // ✅ User Location
            ->editColumn('location', function ($row) {
                return $row->location ?? 'N/A';
            })

            // ✅ Membership Status
            ->editColumn('status', function ($row) {
                if ($row->status === 1) {
                    return '<span class="text-green-600 font-semibold">Active</span>';
                } elseif ($row->status === 0) {
                    return '<span class="text-yellow-600 font-semibold">Deactivated</span>';
                } else {
                    return '<span class="text-gray-600 font-semibold">N/A</span>';
                }
            })

            // ✅ Registration Date
            ->editColumn('reg_date', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y') : 'N/A';
            })

            // ✅ Action Buttons
            ->addColumn('actions', function ($row) {
                $buttonText = $row->status == 1 ? 'Deactivate' : 'Activate';
                $buttonColor = $row->status == 1 ? 'background:black;' : 'background:green;';
                return '
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1 text-white rounded deactivate-btn"
                            style="' . $buttonColor . '"
                            data-id="' . $row->id . '">
                            ' . $buttonText . '
                        </button>
                        &nbsp;
                        <button
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 delete-btn"
                            style="background:red"
                            data-user-id="' . $row->id . '">
                            Delete
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('admin.usermanagement');
}
public function reports(Request $request)
    {
        if ($request->ajax()) {

            $reports = Report::with(['user', 'offer.business'])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($reports)
                ->addIndexColumn()

                // User Name
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? 'N/A';
                })

                // Business Name
                ->addColumn('business_name', function ($row) {
                    return $row->offer->business->name ?? 'N/A';
                })

                // Offer Name
                ->addColumn('offer_name', function ($row) {
                    return $row->offer->offer_name ?? $row->offer->title ?? 'N/A';
                })

                // Description
                ->addColumn('description', function ($row) {
                    return $row->description ?? 'N/A';
                })

                // Date
                ->addColumn('date', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M, Y') : 'N/A';
                })

                // Action Buttons
                ->addColumn('actions', function ($row) {
                    return '
                        <button class="px-3 py-1 bg-blue-600 text-white rounded view-report"
                                data-id="' . $row->id . '">
                            View
                        </button>
                    ';
                })

                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.reports');
    }
public function view($id)
{
    $report = Report::with(['user', 'offer.business'])
                    ->findOrFail($id);

    return response()->json([
        // USER INFO
        'user'          => $report->user->name ?? 'N/A',
        'user_phone'    => $report->user->phone ?? 'N/A',
        'user_email'    => $report->user->email ?? 'N/A',
        'user_location'    => $report->user->location ?? 'N/A',

        // BUSINESS INFO
        'business'              => $report->offer->business->name ?? 'N/A',
        'business_email'     => $report->offer->business->email ?? 'N/A',
        'business_phone'        => $report->offer->business->phone ?? 'N/A',
        'business_location'        => $report->offer->business->location ?? 'N/A',

        // OFFER INFO
        'offer'             => $report->offer->title ?? 'N/A',
        'offer_discount'    => $report->offer->discount ?? 'N/A',
        'offer_price'    => $report->offer->price ?? 'N/A',
        'offer_after_discount'    => $report->offer->discount_price ?? 'N/A',

        // REPORT DESCRIPTION
        'description' => $report->description ?? 'N/A',
    ]);
}

public function banner()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner', compact('banners'));
    }

    public function bannerstore(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if (!$request->hasFile('images') || count($request->file('images')) < 2) {
            return back()->with('error', 'Minimum 2 banner photos required.');
        }

        $imageNames = [];

        foreach ($request->file('images') as $img) {
            $name = uniqid() . "." . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/banners'), $name);
            $imageNames[] = $name;
        }

        Banner::create([
            'images' => $imageNames
        ]);

        return back()->with('success', 'Banners uploaded successfully!');
    }
public function deactivateUser(Request $request)
{
    try {
        $user = User::find($request->id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        // ✅ Toggle user status: 1 -> 0, 0 -> 1
        $newStatus = $user->status == 1 ? 0 : 1;
        $user->update([
            'status' => $newStatus
        ]);

        $statusText = $newStatus == 1 ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "User  {$statusText} successfully."
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ]);
    }
}

public function deleteUser(Request $request)
{
    try {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ]);
    }
}





public function businessmanagement(Request $request)
{
    // ✅ Sirf status 1 (Active) ya 2 (Inactive)
    $businesses = Business::whereIn('status', [1,2])->get();

    if ($request->ajax()) {
        return DataTables::of($businesses)
            ->addColumn('name', fn($row) => $row->name)
            ->addColumn('location', fn($row) => $row->location)
            ->addColumn('email', fn($row) => $row->email)
            ->addColumn('offers_created', fn($row) => Offer::where('business_id', $row->id)->count())
            ->addColumn('total_redemptions', function ($row) {
                $offerIds = Offer::where('business_id', $row->id)->pluck('id');
                return UserRedeem::whereIn('offer_id', $offerIds)->where('status', 'redeem')->count();
            })
            ->editColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="text-green-600 font-semibold">Active</span>'
                    : '<span class="text-red-600 font-semibold">Inactive</span>';
            })
            ->addColumn('actions', function ($row) {
                $btnText = $row->status == 1 ? 'Deactivate' : 'Activate';
                $btnColor = $row->status == 1 ? 'bg-black' : 'bg-black';

                return '
                    <div class="flex space-x-2 justify-center">
                        <button onclick="toggleBusinessStatus(' . $row->id . ')" class="px-3 py-1 ' . $btnColor . ' text-white rounded-md hover:opacity-90 transition">'.$btnText.'</button>
                        &nbsp;
<button onclick="deleteBusiness(' . $row->id . ')" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</button>                    </div>
                ';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('admin.businessmanagement');
}

public function deleteBusiness(Request $request)
{
    $business = Business::find($request->id);

    if (!$business) {
        return response()->json(['status' => false, 'message' => 'Business not found!']);
    }

    $business->delete();

    return response()->json(['status' => true, 'message' => 'Business deleted successfully!']);
}


public function deactivateBusiness(Request $request)
{
    $business = Business::find($request->id);

    if (!$business) {
        return response()->json(['status' => false, 'message' => 'Business not found!']);
    }

    // ✅ Toggle status 1 <-> 2
    $business->status = $business->status == 1 ? 2 : 1;
    $business->save();

    $msg = $business->status == 1 ? 'Business activated successfully!' : 'Business deactivated successfully!';

    return response()->json(['status' => true, 'message' => $msg]);
}


public function pendinguser()
    {
        return view('admin.pendinguser');
}
public function editCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function updateCategory(Request $request, $id)
{
    $request->validate(['name' => 'required|unique:categories,name,'.$id]);
    $category = Category::findOrFail($id);

    // Optional: icon bhi update karna ho
    if($request->hasFile('icon')){
        $iconName = time().'.'.$request->icon->extension();
        $request->icon->move(public_path('uploads/category'), $iconName);
        $category->icon = $iconName;
    }

    $category->name = $request->name;
    $category->save();

    return response()->json(['success' => true, 'message' => 'Category updated successfully!']);
}
public function subcategory() {
    $categories = Category::all(); // sabhi categories fetch
    return view('admin.subcategory', compact('categories'));
}
public function storeSubcategory(Request $request) {
    $request->validate([
        'name' => 'required|unique:subcategories,name',
        'category_id' => 'required|exists:categories,id',
        'icon' => 'nullable|required',
    ]);

    $data = $request->only('name', 'category_id');

    if ($request->hasFile('icon')) {
        $file = $request->file('icon');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/subcategory'), $filename);
        $data['icon'] = $filename;
    }

    Subcategory::create($data);

    return response()->json(['success' => true, 'message' => 'Subcategory added successfully!']);
}
public function subcategoryDelete($id)
{
    try {
        $subcategory = Subcategory::findOrFail($id); // Subcategory ko find karo
        // Agar icon upload hai toh file delete kar do
        if($subcategory->icon && file_exists(public_path('uploads/subcategory/' . $subcategory->icon))){
            unlink(public_path('uploads/subcategory/' . $subcategory->icon));
        }

        $subcategory->delete(); // Delete from DB

        return response()->json([
            'success' => true,
            'message' => 'Subcategory deleted successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Subcategory not found or something went wrong!'
        ], 400);
    }
}

public function subcategoryList(Request $request)
{
    if($request->ajax()) {
        $data = Subcategory::with('category')->latest()->get(); // eager load category

        return DataTables::of($data)
            ->addColumn('category_name', function($row) {
                return $row->category ? $row->category->name : '';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <div class="flex space-x-2">
                        <button data-id="'.$row->id.'" class="editBtn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</button>
                        &nbsp;
                        <button data-id="'.$row->id.'" class="deleteBtn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" style="background:red">Delete</button>
                    </div>
                ';
            })
            ->editColumn('icon', function($row){
                if($row->icon){
                    return '<img src="/uploads/subcategory/'.$row->icon.'" width="50" class="rounded">';
                }
                return '';
            })
            ->rawColumns(['icon','actions'])
            ->make(true);
    }

    return view('admin.subcategory'); // Blade file
}
// SubcategoryController.php

public function subcategoryEdit($id)
{
    $subcategory = Subcategory::with('category')->find($id);

    if(!$subcategory){
        return response()->json(['success' => false, 'message' => 'Subcategory not found']);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $subcategory->id,
            'name' => $subcategory->name,
            'category_id' => $subcategory->category_id,
            'icon' => $subcategory->icon,
        ]
    ]);
}


public function subcategoryUpdate(Request $request, $id)
{
    $subcategory = Subcategory::findOrFail($id);

    $subcategory->name = $request->name;
    $subcategory->category_id = $request->category_id;

    if($request->hasFile('icon')){
        $file = $request->file('icon');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/subcategory'), $filename);
        $subcategory->icon = $filename;
    }

    $subcategory->save();

    return response()->json(['success' => true, 'message' => 'Subcategory updated successfully']);
}

// public function category(Request $request)
// {
//     $categories = [
//         ['id' => 1, 'name' => 'Electronics'],
//         ['id' => 2, 'name' => 'Clothing'],
//         ['id' => 3, 'name' => 'Books'],
//         ['id' => 4, 'name' => 'Sports'],
//     ];

//     if ($request->ajax()) {
//         return DataTables::of(collect($categories))
//             ->addColumn('actions', function ($row) {
//                 return '
//                 <div class="flex space-x-2">
//                     <button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</button>
//                     &nbsp;
//                     <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" style="background:red">Delete</button>
//                 </div>
//                 ';
//             })
//             ->rawColumns(['actions'])
//             ->make(true);
//     }

//     return view('admin.category');
// }
public function category(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();

            return DataTables::of($data)
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="flex space-x-2">
                            <button data-id="'.$row->id.'" class="editBtn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</button>
                            &nbsp;

                            <button data-id="'.$row->id.'" class="deleteBtn px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition" style="background:red" >Delete</button>
                        </div>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.category');
    }

    // Store category via Ajax
    public function storeCategory(Request $request)
{
    $request->validate([
        'name' => 'required|unique:categories,name',
        'icon' => 'nullable|required',
    ]);

    $iconName = null;
    if($request->hasFile('icon')){
        $file = $request->file('icon');
        $iconName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/category'), $iconName);
    }

    Category::create([
        'name' => $request->name,
        'icon' => $iconName,
        'status' => 1
    ]);

    return response()->json(['success' => true, 'message' => 'Category added successfully']);
}


    // Delete category
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }

        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);
    }
public function pendingbusiness(Request $request)
{
    if ($request->ajax()) {
        $businesses = Business::where('status', 0)->get();

        return DataTables::of($businesses)
            ->addColumn('business_id', function($row){
                return 'BIZ-' . str_pad($row->id, 3, '0', STR_PAD_LEFT);
            })
            ->addColumn('email_contact', function($row){
                // email / contact person
                return $row->email ;
            })
            ->addColumn('shop_name', function($row){
    return $row->shop_name;
})
            ->addColumn('actions', function($row){
                return '
                    <div class="flex space-x-2">
                        <button data-id="'.$row->id.'" class="approveBtn px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition" style="background:green">Approve</button>
                        &nbsp;
                        <button data-id="'.$row->id.'" class="rejectBtn px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition" style="background:red">Reject</button>

                    </div>
                ';
            })
            ->editColumn('status', function($row){
                return $row->status == 0 ? 'Pending' : 'Approved';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    return view('admin.pendingbusiness');
}
public function membership()
{
    return view('admin.membership');
}

public function deleteOffer($id)
{
    $offer = Offer::find($id);

    if(!$offer){
        return response()->json([
            'success' => false,
            'message' => 'Offer not found!'
        ]);
    }

    $offer->delete();

    return response()->json([
        'success' => true,
        'message' => 'Offer has been deleted successfully.'
    ]);
}



public function membershiphistory(Request $request)
{
    if ($request->ajax()) {
        $type = $request->get('type');

        // ===== User Membership Data (Real DB) =====
        if ($type === 'user') {
            $userPlans = Membership_plan::all()->map(function($plan) {
                return [
                    'id' => $plan->id,
                    'plan_tier' => $plan->plan_tier,
                    'trial_period_days' => $plan->trial_period_days,
                    'coupons_per_week' => $plan->coupons_per_week,
                    'exclusive_offers' => $plan->exclusive_offers_monthly,
                    'features' => $plan->features,
                    'achievements' => $plan->achievements,
                    'referral_bonus' => $plan->referral_bonus,
                    'plan_price' => $plan->plan_price,
                    'description' => $plan->description,
                    'status' => $plan->status,
                    'created_at' => $plan->created_at,
                ];
            });

            return DataTables::of($userPlans)
                ->addColumn('status', fn($row) => $row['status'] == 1 ? 'Active' : ($row['status'] == 0 ? 'Deactive' : ($row['status'] == 2 ? 'Expire' : 'Unknown')))

                ->addColumn('plan_price', fn($row) => '₹'.$row['plan_price'])
                ->addColumn('id', fn($row) => $row['id'])
                ->addColumn('date', fn($row) => $row['created_at']->format('d M Y'))
                ->make(true);
        }

        // ===== Business Membership Data (Fake) =====
        if ($type === 'business') {
            $businessPlans = BusinessMembershipPlan::all()->map(function($plan) {
                return [
                    'id' => $plan->id,
                    'plan_tier' => $plan->id,
                    'trial_period_days' =>  $plan->trial_days,
                    'discount' =>  $plan->discount,
                    'active_offers_limit' =>  $plan->active_offers,
                    'metrics_access' =>  $plan->metrics_access,
                    'highlight_banner' =>  $plan->highlight_banner,
                    'marketing_campaigns' =>  $plan->marketing_campaigns,
                    'plan_price' =>  $plan->plan_price,
                    'duration_months' =>  $plan->plan_price,
                    'description' =>  $plan->description,
'status'=>$plan->status == 1 ? 'Active' : ($plan->status == 0 ? 'Deactive' : 'Expired'),

                    'created_at' => now()->subDays(2),
                ];
            });


            return DataTables::of($businessPlans)
                ->addColumn('plan_price', fn($row) => '₹'.$row['plan_price'])
                ->addColumn('date', fn($row) => $row['created_at']->format('d M Y'))
                ->make(true);
        }

        return response()->json(['error' => 'Invalid type'], 400);
    }

    return view('admin.membershiphistory');
}
public function toggleMembershipStatus(Request $request)
{
    $id = $request->id;
    $action = $request->action;
    $type = $request->type;

    if ($type === 'user') {
        $plan = Membership_plan::find($id);

        if (!$plan) {
            return response()->json(['error' => 'Membership plan not found'], 404);
        }

        if ($action === 'Activate') {
            $plan->status = 1;
        } elseif ($action === 'Deactivate') {
            $plan->status = 0;
        } else {
            return response()->json(['error' => 'Invalid action'], 400);
        }

        $plan->save();

        return response()->json([
            'success' => true,
            'id' => $id,
            'new_status' => $plan->status,
            'message' => "Membership $action successfully"
        ]);
    } elseif ($type === 'business') {
        $plan = BusinessMembershipPlan::find($id);

        if (!$plan) {
            return response()->json(['error' => 'Business membership plan not found'], 404);
        }

        if ($action === 'Activate') {
            $plan->status = 1;
        } elseif ($action === 'Deactivate') {
            $plan->status = 0;
        } else {
            return response()->json(['error' => 'Invalid action'], 400);
        }

        $plan->save();

        return response()->json([
            'success' => true,
            'id' => $id,
            'new_status' => $plan->status,
            'message' => "Business Membership $action successfully"
        ]);
    }

    return response()->json(['error' => 'Invalid membership type'], 400);
}


public function deleteMembership(Request $request)
{
    $id = $request->id;
    $type = $request->type;

    if($type === 'user'){
        $membership = Membership_plan::find($id);
        if($membership){
            $membership->delete();
            return response()->json(['message' => 'Membership deleted successfully']);
        }
        return response()->json(['message' => 'Membership not found'], 404);
    } elseif($type === 'business'){
        $membership = BusinessMembershipPlan::find($id);
        if($membership){
            $membership->delete();
            return response()->json(['message' => 'Business membership deleted successfully']);
        }
        return response()->json(['message' => 'Business membership not found'], 404);
    }

    return response()->json(['message' => 'Invalid type or action not allowed'], 400);
}

public function editmembership(Request $request)
{
    $id = $request->id;
    $type = $request->type;

    $data = null;

    if($type === 'user') {
        $data = Membership_plan::find($id);
    } elseif($type === 'business') {
        $data = BusinessMembershipPlan::find($id);
    }

    return view('admin.editmembership', compact('data', 'type'));
}


public function paymenthistory(Request $request)
{
    if ($request->ajax()) {
        $type = $request->get('type', 'user'); // Default user type

        // ✅ Fetch payments with user and plan
        $payments = Payment::with(['user', 'plan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($payments)
            ->addColumn('name', function ($row) use ($type) {
                return $type === 'user'
                    ? ($row->user->name ?? 'N/A')
                    : ($row->user->business_name ?? 'N/A'); // assuming business_name exists in user table
            })
            ->addColumn('email', function ($row) {
                return $row->user->email ?? 'N/A';
            })
            ->addColumn('amount', function ($row) {
                return '$' . ($row->amount ?? 0);
            })
            ->addColumn('membership_status', function ($row) {
    if ($row->membership_status === 1) {
        return '<span class="text-green-600 font-semibold">Active</span>';
    } elseif ($row->membership_status === 2) {
        return '<span class="text-yellow-600 font-semibold">Deactivated</span>';
    } elseif ($row->membership_status === 3) {
        return '<span class="text-red-600 font-semibold">Expired</span>';
    } else {
        return '<span class="text-gray-600 font-semibold">N/A</span>';
    }
})
            ->addColumn('plan', function ($row) {
                return $row->plan->plan_tier ?? 'N/A';
            })
            ->addColumn('date', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y') : 'N/A';
            })
            ->addColumn('txn_id', function ($row) {
                return $row->payment_id ?? 'N/A';
            })
           ->addColumn('actions', function ($row) {
    // ✅ Toggle text based on membership_status
    $toggleText = $row->membership_status == 1 ? 'Deactivate' : 'Activate';
    $toggleColor = $row->membership_status == 1 ? 'bg-blue-500 hover:bg-indigo-600' : 'bg-blue-500 hover:bg-green-600';

    return '
        <div class="flex space-x-2">

            &nbsp;
            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition delete-btn" data-payment-id="' . $row->id . '" style="background:red">Delete</button>
            &nbsp;
            <button class="px-3 py-1 text-white rounded transition toggle-status-btn ' . $toggleColor . '" data-id="' . $row->id . '" data-status="' . $row->membership_status . '">' . $toggleText . '</button>
        </div>
    ';
})

            ->editColumn('status', function ($row) {
                return $row->status === 'success'
                    ? '<span class="text-green-600 font-semibold">Success</span>'
                    : '<span class="text-yellow-600 font-semibold">Failed</span>';
            })
            ->rawColumns(['status', 'actions','membership_status'])
            ->make(true);
    }

    return view('admin.paymenthistory');
}
public function togglesMembershipStatus(Request $request, $id)
{
    $payment = Payment::find($id);

    if (!$payment) {
        return response()->json(['message' => 'Payment record not found'], 404);
    }

    // ✅ Toggle status: if 1 → 2, if 2 → 1
    $payment->membership_status = $request->current_status == 1 ? 2 : 1;
    $payment->save();

    $statusText = $payment->membership_status == 1 ? 'activated' : 'deactivated';

    return response()->json([
        'message' => "Membership successfully {$statusText}."
    ]);
}


public function chat()
    {
        return view('admin.chat');
}
public function offer(Request $request)
{
    if ($request->ajax()) {
        // Fetch all offers with business, category, subcategory
        $offers = Offer::with(['business', 'category', 'subcategory'])->get();

        return DataTables::of($offers)
            ->addColumn('voucher_name', function ($offer) {
                return $offer->voucher_code ?? 'N/A';
            })
            ->addColumn('name', function ($offer) {
                return $offer->business?->name ?? 'N/A'; // ✅ yaha shop_name liya
            })
            ->addColumn('business_name', function ($offer) {
                return $offer->business?->shop_name ?? 'N/A'; // ✅ yaha shop_name liya
            })
            ->addColumn('offer_title', function ($offer) {
                return $offer->title ?? 'N/A';
            })
            ->addColumn('category', function ($offer) {
                return $offer->category?->name ?? 'N/A';
            })
            ->addColumn('subcategory', function ($offer) {
                return $offer->subcategory?->name ?? 'N/A';
            })
            ->addColumn('price', function ($offer) {
                return $offer->price ?? '0';
            })
            ->addColumn('discount', function ($offer) {
                return $offer->discount ? $offer->discount . '%' : '0%';
            })
            ->addColumn('discount_price', function ($offer) {
                return $offer->discount_price ?? '0';
            })
            ->addColumn('validity', function ($offer) {
                $created = $offer->created_at ? Carbon::parse($offer->created_at)->format('Y-m-d') : 'N/A';
                $expiry = $offer->expiry_datetime ? Carbon::parse($offer->expiry_datetime)->format('Y-m-d') : 'N/A';
                return "$created → $expiry";
            })
            ->addColumn('status', function ($offer) {
    // Pehle expiry check karo
    $isExpired = $offer->expiry_datetime <= Carbon::now();

    // Status check karo
    if ($isExpired) {
        $text = 'Expired';
        $color = 'red-600';
    } else {
        // Active / Deactive based on status column
        if ($offer->status == 1) {
            $text = 'Active';
            $color = 'green-600';
        } else {
            $text = 'Deactive';
            $color = 'yellow-600';
        }
    }

    return '<span class="text-' . $color . ' font-semibold">' . $text . '</span>';
})

            ->addColumn('total_redemptions', function ($offer) {
                return 0; // abhi ke liye static
            })
            ->addColumn('actions', function ($offer) {
    // Button text based on status
    $btnText = $offer->status == 1 ? 'Deactivate' : 'Activate';
    $btnColor = $offer->status == 1 ? 'bg-blue-500 hover:bg-yellow-600' : 'bg-blue-500 hover:bg-green-600';

    return '
        <div class="flex space-x-2">
            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                onclick="deleteOffer('.$offer->id.')" style="background:red">Delete</button>
            &nbsp;
            <button class="px-3 py-1 '.$btnColor.' text-white rounded transition"
                onclick="deactiveOffer('.$offer->id.')">'.$btnText.'</button>
            &nbsp;
            <a href="/admin/business_report/'.$offer->id.'"><button class="px-3 py-1 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition" style="background:indigo">Reports</button></a>
        </div>
    ';
})

            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('admin.offer');
}
public function business_report($id){
    // Offer fetch karo
    $offer = \App\Models\Offer::findOrFail($id);

    // Business fetch karo offer ke business_id se
    $business = \App\Models\Business::find($offer->business_id);

    // Blade me bhejne ke liye data
    return view('admin.business_report', [
        'owner_name' => $business->name ?? 'N/A',
        'shop_name' => $business->shop_name ?? 'N/A',
        'email' => $business->email ?? 'N/A',
        'plan_name' => $business->plan_name ?? 'N/A',
        'location' => $business->location ?? 'N/A',
        // agar plan_name business model me hai
        'offer_name' => $offer->title ?? 'N/A',
        'stock_limit' => $offer->stock_limit ?? 0,
        'id'=>$id
    ]);
}

public function toggleOfferStatus($id)
{
    $offer = Offer::find($id);

    if(!$offer){
        return response()->json([
            'success' => false,
            'message' => 'Offer not found!'
        ]);
    }

    // Toggle status: agar 1 hai toh 0, agar 0 hai toh 1
    $offer->status = $offer->status == 1 ? 0 : 1;
    $offer->save();

    return response()->json([
        'success' => true,
        'message' => 'Offer status updated successfully.'
    ]);
}


public function redeemption(Request $request)
{
    if ($request->ajax()) {
        // Fetch only redeemed records
        $redeemptions = UserRedeem::with([
            'user',                  // relation to User model
            'offer.business',        // Offer -> Business
            'offer.category',        // Offer -> Category
            'offer.subcategory'      // Offer -> Subcategory
        ])
        ->where('status', 'redeem')
        ->get();

        return DataTables::of($redeemptions)
            ->addColumn('redemption_id', function($row){
                return 'RDM00'.$row->id;
            })
            ->addColumn('user_name', function($row){
                return $row->user->name ?? 'N/A';
            })
            ->addColumn('business_name', function($row){
                $business = $row->offer->business ?? null;
                return $business ? $business->shop_name .' / '. $business->name : 'N/A';
            })
            ->addColumn('offer_name', function($row){
                return $row->offer->title ?? 'N/A';
            })
            ->addColumn('category', function($row){
                $cat = $row->offer->category->name ?? '';
                $subcat = $row->offer->subcategory->name ?? '';
                return $subcat ? "$cat / $subcat" : $cat;
            })
            ->addColumn('price', function($row){
                return $row->offer->price ?? '0';
            })
            ->addColumn('discount', function($row){
                return $row->offer->discount.'%' ?? '0%';
            })
            ->addColumn('discount_price', function($row){
                return $row->offer->discount_price ?? $row->offer->price ?? '0';
            })
            ->addColumn('datetime', function($row){
                return $row->updated_at ? $row->updated_at->format('Y-m-d H:i') : '-';
            })
            ->addColumn('status', function($row){
                return '<span class="text-green-600 font-semibold">'. ucfirst($row->status) .'</span>';
            })
           ->addColumn('actions', function ($row) {
    return '<button class="deleteRedeem px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
        data-user="'.$row->user_id.'" data-offer="'.$row->offer_id.'" style="background:red">Delete</button>';
})
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    return view('admin.redeemption');
}
public function deleteRedeem(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'offer_id' => 'required|exists:offers,id',
    ]);

    $deleted = UserRedeem::where('user_id', $request->user_id)
        ->where('offer_id', $request->offer_id)
        ->delete();

    if($deleted){
        return response()->json(['success' => true, 'message' => 'Redemption deleted successfully']);
    } else {
        return response()->json(['success' => false, 'message' => 'Record not found or already deleted']);
    }
}
}
