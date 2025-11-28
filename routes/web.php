<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/home',[UserController::class,'index'])->name('user.index');
Route::get('/subcategory/{id}',[UserController::class,'subcategory'])->name('subcategory');
Route::get('/',function(){
  return view('login');
})->name('login');
Route::get('info',function(){
    return phpinfo();
});
Route::post('/report/submit', [UserController::class, 'submitReport']);

Route::post('/redeem/generate', [UserController::class, 'generate']);
Route::get('/redeem/{membership_id}/{offer_id}', [UserController::class, 'redeemuser']);
Route::get('/showcard', [App\Http\Controllers\UserController::class, 'showcard']);
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Logout user
    $request->session()->invalidate(); // Session destroy
    $request->session()->regenerateToken(); // CSRF token regenerate

    return redirect('/'); // Redirect to login page
})->name('logout');
Route::get('/register',function(){
  return view('register');
});
Route::get('verify-user/{membershipId}', action: [UserController::class, 'verifyUser'])->name('verify.user');
Route::get('/membership',function(){
  return view('membership');
});
Route::get('/search-offers', [UserController::class, 'search']);
Route::get('/get-campaign-data/{id}', [BusinessController::class, 'getCampaignData']);
Route::get('/get-subcategories/{categoryId}', [BusinessController::class, 'getSubcategori']);

Route::get('/admin/login',function(){
  return view('admin.login');
})->name('admin.login');
Route::get('/detail/{id}',[UserController::class,'detail'])->name('detail');
//user route
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/registeruser',[UserController::class,'register'])->name('register.store');
Route::post('/loginuser',[UserController::class,'login'])->name('login.user');
Route::get('/get/offer/{category_id}',[UserController::class,'get_offer'])->name('get.offer');
Route::post('/admin/membership-plan/store', [AdminController::class, 'storeMembershipPlan'])
    ->name('admin.membership.store');
    Route::get('/plandetail/{id}', [UserController::class, 'plandetail'])->name('user.plandetail');
Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
Route::post('/redeem-vouchers', [UserController::class, 'redeem'])->name('redeem.vouchers')->middleware('auth');
Route::post('/verify-voucher', [BusinessController::class, 'verifyVoucher'])->name('verify.voucher');
Route::post('/redeem-voucher', [BusinessController::class, 'redeemVoucher'])->name('redeem.voucher');
Route::post('/reviews', [UserController::class, 'reviewstore'])->middleware('auth');
Route::get('/about-us',[UserController::class,'about_us'])->name('about.us');
Route::get('/how-it-works',[UserController::class,'how_work'])->name('how.it.works');
Route::get('/contact',[UserController::class,'contact'])->name('contact');
Route::get('/help-center',[UserController::class,'help_center'])->name('help.center');
// Route::get('/terms-and-conditions', [UserController::class, 'term_condition'])->name('terms.and.conditions');

//business route
Route::get('/business/dashboard', [BusinessController::class, 'dashboard']);
Route::get('/business/createoffer',[BusinessController::class,'createoffer']);
Route::get('/business/activeoffer',[BusinessController::class,'activeoffer']);
Route::get('/active-offer-data', [BusinessController::class, 'activeOfferData'])->name('active.offer.data');

Route::get('/business/expireoffer',[BusinessController::class,'expireoffer']);
Route::get('/expire-offer-data', [BusinessController::class, 'expireOfferData'])->name('expire.offer.data');
Route::get('/business/createnotification',[BusinessController::class,'createnotification'])->name('business.createnotification');
Route::get('/business/notificationhistory',[BusinessController::class,'notificationhistory'])->name('business.notificationhistory');
Route::get('/business/ongoingcampaign',[BusinessController::class,'ongoingcampaign'])->name('business.ongoingcampaign');
Route::get('/business/viewcampaign/{id}',[BusinessController::class,'viewcampaign'])->name('business.viewcampaign');
Route::post('/campaign/join/free', [BusinessController::class, 'joinFree'])->name('campaign.join.free');

Route::get('/business/mycampaign',[BusinessController::class,'mycampaign'])->name('business.mycampaign');
Route::get('/business/analytic',[BusinessController::class,'analytic'])->name('business.analytic');
Route::post('/business/getCampaignMetrics', [BusinessController::class, 'getCampaignMetrics'])->name('business.getCampaignMetrics');
Route::get('/business/verify',[BusinessController::class,'verify'])->name('business.verify');
Route::get('/business/chat',[BusinessController::class,'message']);
Route::get('/business/claim',[BusinessController::class,'reedemption'])->name('business.reedemption');
Route::get('/business/popular',[BusinessController::class,'popular'])->name('business.popular');
Route::get('/business/register',[BusinessController::class,'register'])->name('business.register');
Route::get('/business/category', [AdminController::class, 'category'])->name('admin.category');
Route::get('/business/chooseplan', [BusinessController::class, 'chooseplan'])->name('business.chooseplan');
Route::get('/business/myplan', [BusinessController::class, 'myplan'])->name('business.myplan');
Route::post('/business/store', [BusinessController::class, 'store'])->name('business.store');
Route::post('/business/login', [BusinessController::class, 'login'])->name('business.login');
Route::get('/business/profile',[BusinessController::class,'profile'])->name('business.profile');
Route::put('/business/updateProfile',[BusinessController::class,'updateProfile'])->name('business.profile.update');
Route::post('/business/offer/store', [BusinessController::class, 'storeOffer'])->name('business.offer.store');

Route::post('/offer/toggle-status/{id}', [BusinessController::class, 'toggleOfferStatus'])
    ->name('offer.toggleStatus');
Route::post('/offer/delete/{id}', [BusinessController::class, 'deleteOffer'])
    ->name('offer.delete');
Route::get('/business/editoffer/{id}',[BusinessController::class,'editoffer']);
Route::post('/business/offer/update/{id}', [BusinessController::class, 'updateOffer'])->name('business.offer.update');



// AJAX: get subcategories by category id
Route::get('/ajax/subcategories/{category}', [BusinessController::class, 'getSubcategories'])->name('ajax.subcategories');
//admin route

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/usermanagement',action: [AdminController::class,'usermanagement'])->name('admin.usermanagement');
Route::get('/admin/reports/data',action: [AdminController::class,'reports'])->name('admin.reports.data');
Route::get('/admin/report/view/{id}', [AdminController::class, 'view'])
     ->name('admin.report.view');
        Route::get('/admin/banners', [AdminController::class, 'banner'])->name('admin.banners');
    Route::post('/banners/store', [AdminController::class, 'bannerstore'])->name('admin.banners.store');
Route::delete('/admin/banners/{id}/delete', [AdminController::class, 'bannerDelete'])
     ->name('admin.banners.delete');


Route::get('/admin/businessmanagement',[AdminController::class,'businessmanagement'])->name('admin.businessmanagement');
Route::post('/admin/business/deactivate', [AdminController::class, 'deactivateBusiness'])->name('admin.business.deactivate');
Route::post('/admin/business/delete', [AdminController::class, 'deleteBusiness'])->name('admin.business.delete');
Route::get('/get-subcategories', [AdminController::class, 'getSubcategories'])->name('get.subcategories');
Route::post('/campaigns/store', [AdminController::class, 'store'])->name('campaign.store');

Route::get('/admin/pendinguser',[AdminController::class,'pendinguser']);
Route::get('/admin/pendingbusiness',[AdminController::class,'pendingbusiness'])->name('admin.pendingbusiness');
Route::get('/admin/paymenthistory',[AdminController::class,'paymenthistory'])->name('admin.paymenthistory');
Route::post('/admin/toggle-membership-status/{id}', [AdminController::class, 'togglesMembershipStatus']);
Route::post('/admin/redeem-delete', [AdminController::class, 'deleteRedeem'])->name('admin.deleteRedeem');
Route::get('/admin/profile', [AdminController::class, 'profileedit'])->name('admin.profile.edit');
Route::put('/admin/profile/update', [AdminController::class, 'profileupdate'])->name('admin.profile.update');
Route::get('/admin/chat',[AdminController::class,'chat']);
Route::get('/admin/offer',[AdminController::class,'offer'])->name('admin.offer');
Route::get('/admin/redeemption',[AdminController::class,'redeemption'])->name('admin.redeemption');
Route::get('/admin/membership',[AdminController::class,'membership'])->name('admin.membership');
Route::get('/admin/membershiphistory',[AdminController::class,'membershiphistory'])->name('admin.membershiphistory');
Route::get('/admin/createcampaign',[AdminController::class,'createcampaign'])->name('admin.createcampaign');
Route::get('/admin/campaignhistory',[AdminController::class,'campaignhistory'])->name('admin.campaignhistory');
Route::get('/admin/get-category-names', [AdminController::class, 'getCategoryNames']);
Route::get('/admin/get-subcategory-names', [AdminController::class, 'getSubcategoryNames']);
Route::get('/admin/joincampaign',[AdminController::class,'joincampaign'])->name('admin.joincampaign');
    Route::post('/admin/campaigns/{id}/deactivate', [AdminController::class, 'deactivateCampaign']);
    Route::delete('/admin/campaigns/{id}/delete', [AdminController::class, 'deleteCampaign']);
    Route::get('/admin/campaigns/{id}/edit', [AdminController::class, 'edit'])->name('campaign.edit');
Route::post('/admin/campaigns/{id}/update', [AdminController::class, 'updatec'])->name('campaign.update');
Route::get('/admin/category', [AdminController::class, 'category'])->name('admin.category');
Route::get('/admin/subcategory', [AdminController::class, 'subcategory'])->name('admin.subcategory');
Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.category.store');
Route::delete('/admin/category/delete/{id}', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');
 Route::get('/admin/category/edit/{id}', [AdminController::class, 'editCategory']);
    Route::put('/admin/category/update/{id}', [AdminController::class, 'updateCategory']);
Route::post('/admin/business/approve/{id}', [AdminController::class, 'approveBusiness'])->name('admin.business.approve');
Route::delete('/admin/business/reject/{id}', [AdminController::class, 'rejectBusiness'])->name('admin.business.reject');
Route::post('/admin/storeSubcategory',[AdminController::class,'storeSubcategory'])->name('admin.subcategory.store');
Route::get('/admin/subcategory/list', [AdminController::class, 'subcategoryList'])->name('admin.subcategory.list');
Route::get('/admin/subcategory/edit/{id}', [AdminController::class, 'subcategoryEdit']);
Route::post('/admin/subcategory/update/{id}', [AdminController::class, 'subcategoryUpdate'])->name('admin.subcategory.update');
Route::delete('/admin/subcategory/delete/{id}', [AdminController::class, 'subcategoryDelete']);
Route::post('/admin/offer/delete/{id}', [AdminController::class, 'deleteOffer'])->name('admin.offer.delete');
Route::post('/admin/offer/toggle-status/{id}', [AdminController::class, 'toggleOfferStatus'])->name('admin.offer.toggleStatus');
Route::get('/admin/business_report/{id}',[AdminController::class,'business_report'])->name('admin.business_report');
Route::post('/admin/deactivate-User', [AdminController::class, 'deactivateUser'])
    ->name('admin.deactivateUser');
Route::post('/admin/deleteUser', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
Route::post('/change-password', [App\Http\Controllers\UserController::class, 'update'])
    ->name('password.update.custom');
Route::get('/forgot-password', [App\Http\Controllers\UserController::class, 'forgotPassword'])
    ->name('password.forgot');
    Route::get('/check-plan/{id}', [BusinessController::class, 'view_plan'])->name('check.plan');
    Route::get('/plan', [UserController::class, 'choose_plan'])->name('user.plan');
    Route::post('/direct-join', [PaymentController::class, 'directJoin']);
Route::get('/create-preferences/{price}/{plan}/{id}/{business}/{monthyr}',
    [PaymentController::class, 'createPreferences']);

// web.php (admin routes group ke andar)
Route::post('/admin/membership/toggle-status', [AdminController::class, 'toggleMembershipStatus'])->name('admin.toggleMembershipStatus');
Route::post('/admin/delete-membership', [AdminController::class, 'deleteMembership'])->name('admin.deleteMembership');
Route::get('/admin/editmembership',[AdminController::class,'editmembership'])->name('admin.membership.edit');
Route::post('/admin/membership/update/{id}', [AdminController::class, 'update'])->name('membership.update');
Route::post('/business-plans/store', [AdminController::class, 'businessplanstore'])->name('business.store');
Route::get('/business/view-plan', [BusinessController::class, 'viewPlan'])->name('business.viewPlan');


//user route
Route::get('/account',[UserController::class,'account'])->name('user.account');
Route::get('/activemembership',[UserController::class,'activemembership'])->name('user.activemembership');
Route::get('/coupon',[UserController::class,'coupon'])->name('user.coupon');
Route::get('/paymenthistory',[UserController::class,'paymenthistory'])->name('user.paymenthistory');
Route::get('/myredeem',[UserController::class,'myredeem'])->name('user.myredeem');
Route::get('/mypending',[UserController::class,'mypending'])->name('user.mypending');


//payment marcadopago
Route::post('/create-preference', [PaymentController::class, 'createPreference'])->name('create.preference');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');



Route::get('/payment-failure',[PaymentController::class,'payment_failure'])->name('payment.failure');


Route::get('/payment-pending', function (Request $request) {
    return response()->json([
        'status' => 'pending',
        'message' => 'Payment is pending. Please wait for confirmation.',
    ]);
})->name('payment.pending');
Route::post('/mercadopago/webhook', [PaymentController::class, 'webhook']);
