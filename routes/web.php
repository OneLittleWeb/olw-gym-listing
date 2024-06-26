<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\admin\ReviewController as AdminReviewController;
use App\Http\Controllers\admin\OrganizationController as AdminOrganizationController;
use App\Http\Controllers\admin\HomeController as AdminHomeController;
use App\Http\Controllers\admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\admin\CityController as AdminCityController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\PlanManageController;
use App\Http\Controllers\admin\AwardController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\AdminController;

//Admin Panel
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard', [AdminHomeController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('category', AdminCategoryController::class)->except(['show', 'edit', 'create']);
    Route::resource('city', AdminCityController::class)->except(['show', 'edit', 'create']);
    Route::resource('organization', AdminOrganizationController::class)->except(['show']);
    Route::resource('settings', SettingController::class)->except(['show']);
    Route::resource('plan', PlanManageController::class)->except(['show']);
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('business/review', [AdminReviewController::class, 'reviewBusiness'])->name('reviews.business');
    Route::get('review/{slug}', [AdminReviewController::class, 'reviews'])->name('reviews');
    Route::get('contacts', [ContactUsController::class, 'index'])->name('contact.index');
    Route::get('contacts/claim', [ContactUsController::class, 'contactForClaimBusiness'])->name('contact.for.claim');
    Route::post('contacts/claim/update/{id}/{status}', [ContactUsController::class, 'ClaimStatusUpdate'])->name('claim.status.update');

    Route::get('reviews', [AdminReviewController::class, 'allReviews'])->name('all.reviews');
//    Route::get('reviews/show/{id}', [AdminReviewController::class, 'show'])->name('reviews.show');
//    Route::get('reviews/edit/{id}', [AdminReviewController::class, 'edit'])->name('reviews.edit');
    Route::get('reviews/delete/{id}', [AdminReviewController::class, 'deleteReview'])->name('reviews.destroy');

    Route::get('suggest/edit/request', [AdminOrganizationController::class, 'suggestEditRequest'])->name('suggest.edit.request');
    Route::post('suggest/request/update/{id}/{status}', [AdminOrganizationController::class, 'editRequestUpdate'])->name('edit.request.update');
    Route::get('award/certificate/request', [AwardController::class, 'awardCertificateRequest'])->name('award.certificate.request');
    Route::post('award/certificate/update/{id}/{status}', [AwardController::class, 'awardCertificateUpdate'])->name('award.certificate.update');

});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/generate-description', [ChatGPTController::class, 'getAboutUs'])->name('get.about.us');
Route::get('/autocomplete', [HomeController::class, 'autocomplete'])->name('autocomplete');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/remove-unknown-categories', [HomeController::class, 'removeUnknownCategory'])->name('remove.unknown.category');

Route::get('/checkout', [StripePaymentController::class, 'index'])->name('payment.form')->middleware('auth');
Route::post('/payments/pay', [StripePaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payments/approval', [StripePaymentController::class, 'approval'])->name('payment.approval');
Route::get('/payments/cancelled', [StripePaymentController::class, 'cancelled'])->name('payment.cancelled');

//search routes
Route::get('/search-states', [StateController::class, 'searchStates'])->name('search-states');

//Ajax request for get pros and cons
Route::get('/get-pros-cons-reviews/{slug}/{keyword}/{type}', [OrganizationController::class, 'getProsConsReviews'])->name('get.pros.cons.reviews');

//claim business
Route::get('/claim-your-business/{slug}', [OrganizationController::class, 'claimBusiness'])->name('claim.business');
Route::post('/claim-your-business/{slug}', [OrganizationController::class, 'claimBusinessProfile'])->name('claim.business.profile');
Route::get('/confirm/claim-business/{slug}', [OrganizationController::class, 'confirmClaimBusiness'])->name('confirm.claim.business');
Route::get('/contact-for/claim-your-business/{slug}', [OrganizationController::class, 'contactForClaimBusiness'])->name('contact.for.claim.business');
Route::post('/contact-for/claim-business/{slug}', [OrganizationController::class, 'storeContactForClaimBusiness'])->name('store.contact.for.claim.business');

//get your award certificate
Route::post('/get-your-award-certificate/{slug}', [OrganizationController::class, 'awardCertificateRequest'])->name('get.award.certificate');

//Suggest an edit
Route::post('/suggest-an-edit/store/{slug}', [OrganizationController::class, 'storeSuggestAnEdit'])->name('store.suggest.edit');

//state / category wise organization
Route::get('/{state_slug}/{organization_category_slug}', [CategoryController::class, 'categoryWiseBusiness'])->name('category.wise.business');
Route::get('/organization-category-slug-from-organization-category', [CategoryController::class, 'organizationCategorySlugFromOrganizationCategory']);

//city wise organization
Route::get('/{city_slug}/gnx/{organization_slug}', [OrganizationController::class, 'generateCityWiseOrganizationView'])->name('city.wise.organization');
Route::get('/{state_slug}/{city_slug}/{organization_category_slug}', [CityController::class, 'generateCityWiseOrganizationsView'])->name('city.wise.organizations');

Route::post('/store-review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/sitemap', [SitemapController::class, 'sitemapStore'])->name('sitemap');

Route::get('/about-us', [PageController::class, 'aboutUs'])->name('page.about');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/terms-conditions', [PageController::class, 'termsConditions'])->name('terms.conditions');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('page.contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/pricing', [PricingController::class, 'index'])->name('page.pricing');

//route for import data
Route::get('/import-organizations', [ImportController::class, 'importOrganizationData'])->name('import.organizations');

//route for import states data
Route::get('/import-states', [ImportController::class, 'importStateName'])->name('import.state.name');

//route for import cities data
Route::get('/import-cities', [ImportController::class, 'importCityName'])->name('import.city.data');

//route for image copy past from multiple folder to single folder
Route::get('/copy-paste', [ImportController::class, 'imageCopyPasteFromOneFolderToAnother'])->name('copy.past');

//review date diff from human to date route
Route::get('/get-original-review-date', [ReviewController::class, 'reviewDateDiffFromHumanToDate'])->name('get.original.review.date');

//route for subscriber store
Route::post('/subscriber-store', [SubscribeController::class, 'subscriberStore'])->name('subscriber.store');

// The wildcard route
Route::get('/{category_slug}-{suffix}', [OrganizationController::class, 'gymNearMe'])->where(['category_slug' => '.*', 'suffix' => 'near-me'])->name('gym.near.me');


