<?php

use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
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
Route::get('/autocomplete', [HomeController::class, 'autocomplete'])->name('autocomplete');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/checkout', [StripePaymentController::class, 'index'])->name('payment.form')->middleware('auth');
Route::post('/payments/pay', [StripePaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payments/approval', [StripePaymentController::class, 'approval'])->name('payment.approval');
Route::get('/payments/cancelled', [StripePaymentController::class, 'cancelled'])->name('payment.cancelled');

Route::get('/categories', [CategoryController::class, 'allCategories'])->name('all.categories');
Route::get('/category/{slug}', [CategoryController::class, 'categoryBusiness'])->name('category.business');

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

Route::get('/{city_slug}/{category_slug}', [OrganizationController::class, 'cityWiseOrganizations'])->name('city.wise.organizations');
Route::get('/{city_slug}/nls/{organization_slug}', [OrganizationController::class, 'cityWiseOrganization'])->name('city.wise.organization');

Route::get('/cities', [CityController::class, 'index'])->name('city.index');
Route::post('/store-review', [ReviewController::class, 'store'])->name('review.store');

Route::get('/sitemap', [SitemapController::class, 'sitemapStore'])->name('sitemap');

//route for import data
Route::get('/import', [OrganizationController::class, 'import'])->name('import');

//route for import states data
Route::get('/import-states', [StateController::class, 'importStateName'])->name('import.state.name');

//route for image copy past from multiple folder to single folder
Route::get('/copy-past', [OrganizationController::class, 'copyPast'])->name('copy.past');

Route::get('/about-us', [PageController::class, 'aboutUs'])->name('page.about');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/terms-conditions', [PageController::class, 'termsConditions'])->name('terms.conditions');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('page.contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/pricing', [PricingController::class, 'index'])->name('page.pricing');

Route::get('/{slug}', [CategoryController::class, 'index'])->name('category.index');


