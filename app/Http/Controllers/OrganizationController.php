<?php

namespace App\Http\Controllers;

use App\Imports\ImportOrganization;
use App\Jobs\ExcelImportJob;
use App\Mail\ClaimBusinessMail;
use App\Mail\ClaimedBusiness;
use App\Mail\ClaimedNotificationToAdmin;
use App\Mail\ContactForClaimToAdmin;
use App\Mail\ContactForClaimToUser;
use App\Mail\ContactUsMail;
use App\Models\AwardCertificateRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\ContactForClaimBusiness;
use App\Models\Organization;
use App\Models\State;
use App\Models\SuggestAnEdit;
use Butschster\Head\Facades\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class OrganizationController extends Controller
{
    public function cityWiseOrganizations($city_slug, $category_slug)
    {
        $city_check = City::where('slug', $city_slug)->exists();
        $category_check = Category::where('slug', $category_slug)->exists();

        if ($city_check && $category_check) {
            $city = City::where('slug', $city_slug)->first();
            $category = Category::where('slug', $category_slug)->first();

            $categories = Category::all();
            $cities = City::all();

            $organizations = Organization::where('city_id', $city->id)
                ->where('category_id', $category->id)
                ->where('permanently_closed', 0)
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->paginate(10)
                ->onEachSide(0);

            $organization_badge = '';

            if ($organizations[0]) {
                $files = File::files(public_path('images/badges'));
                $images = [];

                foreach ($files as $file) {
                    $images[] = $file->getRelativePathname();

                    foreach ($images as $image) {
                        if ($image == $organizations[0]->category->name . ' - ' . $organizations[0]->city->name . '.png') {
                            $organization_badge = $image;
                        }
                    }
                }
            }

            $organization_count = Organization::where('city_id', $city->id)
                ->where('category_id', $category->id)->count();

            if ($organizations->onFirstPage()) {
                $category->meta_title = 'Top 10 Best ' . Str::title($category->name) . ' near ' . Str::title($city->name) . ', Nebraska';
            } else {
                $category->meta_title = Str::title($category->name) . ' near ' . Str::title($city->name) . ', Nebraska';
            }

            Meta::setPaginationLinks($organizations);
            return view('organization.index', compact('organizations', 'cities', 'city', 'category', 'categories', 'organization_badge', 'organization_count'));
        }
        return abort(404);
    }

//    public function cityWiseOrganizations($city_slug, $category_slug)
//    {
//        if ($city_slug && $category_slug) {
//            $city = City::where('slug', $city_slug)->first();
//            $category = Category::where('slug', $category_slug)->first();
//
//            if ($city && $category) {
//                $category->meta_title = Str::title($category->name) . ' in ' . Str::title($city->name) . ', NE | nebraskalisting.com';
//
//                $categories = Category::select('id', 'name', 'slug', 'icon', 'background', 'background_image')->get();
//                $cities = City::select('id', 'name', 'slug', 'is_major', 'population', 'background_image')->get();
//
//                $organizations = Organization::withCount('reviews')
//                    ->where('city_id', $city->id)
//                    ->where('category_id', $category->id)
//                    ->leftJoin('reviews', 'organizations.organization_guid', '=', 'reviews.organization_guid') // Left join to include reviews table
//                    ->select('organizations.*', DB::raw('COUNT(reviews.id) AS reviews_count')) // Calculate the reviews_count
//                    ->groupBy('organizations.id') // Group by organization to avoid duplicates
//                    ->orderBy('reviews_count', 'DESC') // Order by the reviews_count
//                    ->paginate(10);
//
//                Meta::setPaginationLinks($organizations);
//                return view('organization.index', compact('organizations', 'cities', 'city', 'category', 'categories'));
//            }
//        }
//        return abort(404);
//    }

    public function cityWiseOrganization($city_slug, $organization_slug)
    {
        $city = City::where('slug', $city_slug)->first();
        $organization = Organization::where('slug', $organization_slug)->where('permanently_closed', 0)->first();

        if ($city && $organization) {

            $cities = City::all();

            $organization->incrementViewCount();
            $five_star_reviews = $organization->reviews()->where('review_rate_stars', 5)->count();
            $four_star_reviews = $organization->reviews()->where('review_rate_stars', 4)->count();
            $three_star_reviews = $organization->reviews()->where('review_rate_stars', 3)->count();
            $two_star_reviews = $organization->reviews()->where('review_rate_stars', 2)->count();
            $one_star_reviews = $organization->reviews()->where('review_rate_stars', 1)->count();

            if ($organization->organization_address) {
                $meta = explode(',', $organization->organization_address);
                $organization->meta_title = $organization->organization_name . ' -' . $meta[1] . ',' . $meta[2];
            } else {
                $organization->meta_title = $organization->organization_name . ' - ' . $city->name . ', ' . 'NE';
            }

            //For Restaurants/Resorts/Hotels
            $restaurant_type = [22, 21, 12];


            //For Gyms/Nail Salons/Hair Salons/Beauty Salons
            $gym_type = [10, 16, 11, 1];

            //For Landscapers/Physical Therapists/Dentists/Car Wash/Car Detailing/Car Rental
            $landscaper_type = [14, 19, 6, 4, 2, 3];

            if (in_array($organization->category_id, $restaurant_type)) {
                if ($organization->organization_address) {
                    $address_line = explode(',', $organization->organization_address);
                    $organization->about1 = 'Sitting at the Breathtaking spot of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at' . $address_line[1] . ',' . $address_line[2] . '.';
                } else {
                    $organization->about1 = 'Sitting at the Breathtaking spot of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at ' . Str::title($organization->city->name) . ', NE.';
                }
            } elseif (in_array($organization->category_id, $gym_type)) {
                if ($organization->organization_address) {
                    $address_line = explode(',', $organization->organization_address);
                    $organization->about1 = 'Sitting at the bustling city-center of ' . Str::title($organization->city->name) . ', ' . "<strong>$organization->organization_name</strong>" . ' is located at' . $address_line[1] . ',' . $address_line[2] . '.';
                } else {
                    $organization->about1 = 'Sitting at the bustling city-center of ' . Str::title($organization->city->name) . ', ' . "<strong>$organization->organization_name</strong>" . ' is located at ' . Str::title($organization->city->name) . ', NE.';
                }
            } elseif (in_array($organization->category_id, $landscaper_type)) {
                if ($organization->organization_address) {
                    $address_line = explode(',', $organization->organization_address);
                    $organization->about1 = 'Sitting at the graceful service center of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at' . $address_line[1] . ',' . $address_line[2] . '.';
                } else {
                    $organization->about1 = 'Sitting at the graceful service center of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at ' . Str::title($organization->city->name) . ', NE.';
                }
            } else {
                if ($organization->organization_address) {
                    $address_line = explode(',', $organization->organization_address);
                    $organization->about1 = 'Positioned at the neighborhood of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at' . $address_line[1] . ',' . $address_line[2] . '.';
                } else {
                    $organization->about1 = 'Positioned at the neighborhood of ' . Str::title($organization->city->name) . ' city, ' . "<strong>$organization->organization_name</strong>" . ' is located at ' . Str::title($organization->city->name) . ', NE.';
                }
            }

            if ($organization->organization_phone_number) {
                $organization->about2 = 'Get a reservation or know necessary information by contacting them at ' . "<a href='tel:$organization->organization_phone_number'>$organization->organization_phone_number</a>" . '.';
            } elseif ($organization->organization_email) {
                $organization->about2 = 'Get a reservation or know necessary information by contacting them at ' . "<strong>$organization->organization_email</strong>" . '.';
            } elseif ($organization->organization_address) {
                $organization->about2 = 'Get a reservation or know necessary information by contacting them at ' . "<strong>$organization->organization_address</strong>" . '.';
            } elseif ($organization->organization_website) {
                $organization->about2 = 'Get a reservation or know necessary information by contacting them at ' . "<strong>$organization->organization_website</strong>" . '.';
            } else {
                $organization->about2 = null;
            }

            $organization->rate_stars = $organization->rate_stars ?? 0;
            $organization->reviews_total_count = $organization->reviews_total_count ?? 0;

            $organization->about3 = "<strong>$organization->organization_name</strong>" . ' has a ' . "<strong>$organization->rate_stars</strong>" . '-star rating and ' . "<strong>$organization->reviews_total_count</strong>" . ' reviews. Check out the photos and customer reviews to make an image in your mind about what to expect there.';

            $organization->reviews_paginator = $organization->reviews()->whereNotNull('review_id')->orderByDesc('id')->paginate(10)->onEachSide(0);
            $organization->nebraska_reviews_paginator = $organization->reviews()->whereNull('review_id')->orderByDesc('id')->paginate(10)->onEachSide(0);

            Meta::setPaginationLinks($organization->reviews_paginator);

            $select_hours = ['Open 24 Hours', 'Closed', '12 AM', '12:15 AM', '12:30 AM', '12:45 AM', '1 AM', '1:15 AM', '1:30 AM', '1:45 AM', '2 AM', '2:15 AM', '2:30 AM', '2:45 AM', '3 AM', '3:15 AM', '3:30 AM', '3:45 AM', '4 AM', '4:15 AM', '4:30 AM', '4:45 AM', '5 AM', '5:15 AM', '5:30 AM', '5:45 AM', '6 AM', '6:15 AM', '6:30 AM', '6:45 AM', '7 AM', '7:15 AM', '7:30 AM', '7:45 AM', '8 AM', '8:15 AM', '8:30 AM', '8:45 AM', '9 AM', '9:15 AM', '9:30 AM', '9:45 AM', '10 AM', '10:15 AM', '10:30 AM', '10:45 AM', '11 AM', '11:15 AM', '11:30 AM', '11:45 AM', '12 PM', '12:15 PM', '12:30 PM', '12:45 PM', '1 PM', '1:15 PM', '1:30 PM', '1:45 PM', '2 PM', '2:15 PM', '2:30 PM', '2:45 PM', '3 PM', '3:15 PM', '3:30 PM', '3:45 PM', '4 PM', '4:15 PM', '4:30 PM', '4:45 PM', '5 PM', '5:15 PM', '5:30 PM', '5:45 PM', '6 PM', '6:15 PM', '6:30 PM', '6:45 PM', '7 PM', '7:15 PM', '7:30 PM', '7:45 PM', '8 PM', '8:15 PM', '8:30 PM', '8:45 PM', '9 PM', '9:15 PM', '9:30 PM', '9:45 PM', '10 PM', '10:15 PM', '10:30 PM', '10:45 PM', '11 PM', '11:15 PM', '11:30 PM', '11:45 PM'];

            //badges

            $files = File::files(public_path('images/badges'));
            $images = [];

            foreach ($files as $file) {
                $images[] = $file->getRelativePathname();

                foreach ($images as $image) {
                    if ($image == $organization->category->name . ' - ' . $organization->city->name . '.png') {
                        $organization->organization_badge = $image;
                    }
                }
            }

            if ($organization->organization_work_time) {
                $organization_work_time_exploded = explode(';', $organization->organization_work_time);
                $organization_work_time_exploded = str_replace('. Hide open hours for the week', '', $organization_work_time_exploded);
                $organization_work_time_exploded = str_ireplace(' (Washington\'s Birthday)', '', $organization_work_time_exploded);
                $organization->organization_work_time_modified = str_replace(', Hours might differ', '', $organization_work_time_exploded);

                $modified_work_time = $organization->organization_work_time_modified;

                //First day
                $first_day_work_time = explode(',', $modified_work_time[0]);
                $first_day = ltrim($first_day_work_time[0]);
                $first_day_work_hours = explode(' to ', $first_day_work_time[1]);
                if (count($first_day_work_hours) == 1) {
                    $first_day_work_hours[1] = $first_day_work_hours[0];
                }
                $first_day_opening_hours = ltrim($first_day_work_hours[0]);
                $first_day_closing_hours = ltrim($first_day_work_hours[1]);

                //  Second day
                $second_day_work_time = explode(',', $modified_work_time[1]);
                $second_day = ltrim($second_day_work_time[0]);
                $second_day_work_hours = explode(' to ', $second_day_work_time[1]);
                if (count($second_day_work_hours) == 1) {
                    $second_day_work_hours[1] = $second_day_work_hours[0];
                }
                $second_day_opening_hours = ltrim($second_day_work_hours[0]);
                $second_day_closing_hours = ltrim($second_day_work_hours[1]);

                //  Third day
                $third_day_work_time = explode(',', $modified_work_time[2]);
                $third_day = ltrim($third_day_work_time[0]);
                $third_day_work_hours = explode(' to ', $third_day_work_time[1]);
                if (count($third_day_work_hours) == 1) {
                    $third_day_work_hours[1] = $third_day_work_hours[0];
                }
                $third_day_opening_hours = ltrim($third_day_work_hours[0]);
                $third_day_closing_hours = ltrim($third_day_work_hours[1]);

                //  Fourth day
                $fourth_day_work_time = explode(',', $modified_work_time[3]);
                $fourth_day = ltrim($fourth_day_work_time[0]);
                $fourth_day_work_hours = explode(' to ', $fourth_day_work_time[1]);
                if (count($fourth_day_work_hours) == 1) {
                    $fourth_day_work_hours[1] = $fourth_day_work_hours[0];
                }
                $fourth_day_opening_hours = ltrim($fourth_day_work_hours[0]);
                $fourth_day_closing_hours = ltrim($fourth_day_work_hours[1]);

                //  Fifth day
                $fifth_day_work_time = explode(',', $modified_work_time[4]);
                $fifth_day = ltrim($fifth_day_work_time[0]);
                $fifth_day_work_hours = explode(' to ', $fifth_day_work_time[1]);
                if (count($fifth_day_work_hours) == 1) {
                    $fifth_day_work_hours[1] = $fifth_day_work_hours[0];
                }
                $fifth_day_opening_hours = ltrim($fifth_day_work_hours[0]);
                $fifth_day_closing_hours = ltrim($fifth_day_work_hours[1]);

                //  Sixth day
                $sixth_day_work_time = explode(',', $modified_work_time[5]);
                $sixth_day = ltrim($sixth_day_work_time[0]);
                $sixth_day_work_hours = explode(' to ', $sixth_day_work_time[1]);
                if (count($sixth_day_work_hours) == 1) {
                    $sixth_day_work_hours[1] = $sixth_day_work_hours[0];
                }
                $sixth_day_opening_hours = ltrim($sixth_day_work_hours[0]);
                $sixth_day_closing_hours = ltrim($sixth_day_work_hours[1]);

                //  Seventh day
                $seventh_day_work_time = explode(',', $modified_work_time[6]);
                $seventh_day = ltrim($seventh_day_work_time[0]);
                $seventh_day_work_hours = explode(' to ', $seventh_day_work_time[1]);
                if (count($seventh_day_work_hours) == 1) {
                    $seventh_day_work_hours[1] = $seventh_day_work_hours[0];
                }
                $seventh_day_opening_hours = ltrim($seventh_day_work_hours[0]);
                $seventh_day_closing_hours = ltrim($seventh_day_work_hours[1]);

                return view('organization.show', compact('organization', 'city', 'cities', 'five_star_reviews', 'four_star_reviews', 'three_star_reviews', 'two_star_reviews', 'one_star_reviews', 'restaurant_type', 'gym_type', 'landscaper_type', 'select_hours', 'first_day', 'first_day_opening_hours', 'first_day_closing_hours', 'second_day', 'second_day_opening_hours', 'second_day_closing_hours', 'third_day', 'third_day_opening_hours', 'third_day_closing_hours', 'fourth_day', 'fourth_day_opening_hours', 'fourth_day_closing_hours', 'fifth_day', 'fifth_day_opening_hours', 'fifth_day_closing_hours', 'sixth_day', 'sixth_day_opening_hours', 'sixth_day_closing_hours', 'seventh_day', 'seventh_day_opening_hours', 'seventh_day_closing_hours'));
            } else {
                return view('organization.show', compact('organization', 'city', 'cities', 'five_star_reviews', 'four_star_reviews', 'three_star_reviews', 'two_star_reviews', 'one_star_reviews', 'restaurant_type', 'gym_type', 'landscaper_type', 'select_hours'));
            }
        }

        abort(404);
    }

    public function claimBusiness($slug)
    {
        $cities = City::all();
        $city = null;
        $organization = Organization::where('slug', $slug)->firstOrFail();

        return view('organization.claim-business', compact('cities', 'city', 'organization'));
    }

    public function claimBusinessProfile(Request $request, $slug)
    {
        $organization = Organization::where('slug', $slug)->firstOrFail();

        if ($organization) {
            if ($organization->city_id == $request->organization_city) {
                $business_mail = $request->business_email . '@' . $organization->organization_website;

                try {
                    Mail::to($business_mail)->send(new ClaimBusinessMail($organization));

                    $organization->claimed_mail = $business_mail;
                    $organization->update();
                    alert()->success('success', 'An email has been sent to your business mail. Please check and confirm your business.');

                    return redirect()->back();

                } catch (\Exception $e) {
                    alert()->error('error', 'Something went wrong. Please try again later.');
                    return redirect()->back();
                }
            } else {
                alert()->warning('No Found', 'This business is not available in this state!');
                return redirect()->back();
            }
        }
        abort(404);
    }

    public function confirmClaimBusiness($slug)
    {
        $organization = Organization::where('slug', $slug)->firstOrFail();
        if ($organization) {
            $organization->is_claimed = 1;
            $organization->update();

            try {
                Mail::to($organization->claimed_mail)->send(new ClaimedBusiness($organization));
                Mail::to(env('SUPPORT_MAIL_ADDRESS'))->send(new ClaimedNotificationToAdmin($organization));
                alert()->success('success', 'Your business has been claimed successfully. You may now sign up using the same email associated with your business and log in to your account.');

                return redirect()->route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]);

            } catch (\Exception $e) {
                alert()->error('error', 'Something went wrong. Please try again later.');
                return redirect()->back();
            }
        }

        abort(404);
    }

    public function contactForClaimBusiness($slug)
    {
        $cities = City::all();
        $city = null;
        $organization = Organization::where('slug', $slug)->firstOrFail();

        return view('organization.contact-for-claim-business', compact('cities', 'city', 'organization'));
    }

    public function storeContactForClaimBusiness(Request $request, $slug)
    {
        $request->validate([
            'contact_email' => 'required|email',
            'editable_information' => 'required',
            'validation_images.*' => 'required|mimes:jpg,jpeg,png'
        ]);

        $organization = Organization::where('slug', $slug)->firstOrFail();

        if ($organization) {
            $claimed_contact = ContactForClaimBusiness::where('organization_id', $organization->id)->exists();

            if ($claimed_contact) {
                alert()->warning('warning', 'You have already submitted a request for this business. Please wait for the admin to contact you.')->autoClose(50000);
                return redirect()->back();
            }

            if ($request->hasFile('validation_images')) {
                $images = [];
                foreach ($request->file('validation_images') as $image) {
                    $path = $image->store('public/images/claim-business');
                    $images[] = [
                        'url' => Storage::url($path),
                        'name' => $image->getClientOriginalName(),
                        'mime_type' => $image->getClientMimeType(),
                    ];
                }
            }

            $contact_for_claim_business = new ContactForClaimBusiness();
            $contact_for_claim_business->organization_id = $organization->id;
            $contact_for_claim_business->contact_email = $request->contact_email;
            $contact_for_claim_business->contact_number = $request->contact_number;
            $contact_for_claim_business->editable_information = $request->editable_information;
            if ($request->hasFile('validation_images')) {
                $contact_for_claim_business->validation_images = json_encode($images);
            }
            $contact_for_claim_business->save();

            try {
                Mail::to($request->contact_email)->send(new ContactForClaimToUser($organization));
                Mail::to(env('SUPPORT_MAIL_ADDRESS'))->send(new ContactForClaimToAdmin($organization));
            } catch (\Exception $e) {
                alert()->error('error', 'Something went wrong. Please try again later.');
                return redirect()->back();
            }

            alert()->success('success', 'Your request has been submitted successfully. the administrator will contact you soon.')->autoClose(50000);

            return redirect()->back();
        }

        abort(404);
    }

    public function awardCertificateRequest(Request $request, $slug)
    {
        $request->validate([
            'requested_user_name' => 'required',
            'requested_user_email' => 'required|email',
        ]);

        $organization = Organization::where('slug', $slug)->firstOrFail();

        if ($organization) {

            $requested_organization = AwardCertificateRequest::where('organization_id', $organization->id)->whereNull('deleted_at')->exists();

            if ($requested_organization) {
                alert()->warning('warning', 'You have already submitted a request for this business. Please wait for the admin to contact you.')->autoClose(50000);
                return redirect()->back();
            }

            $award_certificate_request = new AwardCertificateRequest();
            $award_certificate_request->organization_id = $organization->id;
            $award_certificate_request->requested_user_name = $request->requested_user_name;
            $award_certificate_request->requested_user_email = $request->requested_user_email;
            $award_certificate_request->is_affiliated = $request->is_affiliated ?? 0;
            $award_certificate_request->save();

            alert()->success('success', 'Your request has been submitted successfully. the administrator will contact you soon.')->autoClose(50000);

            return redirect()->back();
        }

        abort(404);
    }

    public function storeSuggestAnEdit(Request $request, $slug)
    {
        $request->validate([
            'organization_name' => 'required',
            'organization_address' => 'required',
        ]);

        $organization = Organization::where('slug', $slug)->firstOrFail();

        if ($organization) {

            $suggest_an_edit_organization = SuggestAnEdit::where('organization_id', $organization->id)->exists();

            if ($suggest_an_edit_organization) {
                $suggest_an_edit = SuggestAnEdit::where('organization_id', $organization->id)->first();
            } else {
                $suggest_an_edit = new SuggestAnEdit();
            }

            $suggest_an_edit->organization_id = $organization->id;
            $suggest_an_edit->is_it_closed = $request->is_it_closed ?? 0;
            $suggest_an_edit->temporarily_closed = $request->temporarily_closed ?? 0;
            $suggest_an_edit->are_you_the_owner = $request->are_you_the_owner ?? 0;
            $suggest_an_edit->organization_name = $request->organization_name;
            $suggest_an_edit->organization_address = $request->organization_address;
            $suggest_an_edit->organization_phone_number = $request->organization_phone_number;
            $suggest_an_edit->organization_website = $request->organization_website;
            $suggest_an_edit->price_list_url = $request->price_list_url;
            $suggest_an_edit->organization_short_description = $request->organization_short_description;
            $suggest_an_edit->message = $request->message;
            $suggest_an_edit->edit_status = 0;


            if ($request->first_day_open == 'Closed' || $request->first_day_open == 'Open 24 Hours') {
                $first_day = $request->first_day . ', ' . $request->first_day_open;
            } else {
                $first_day = $request->first_day . ', ' . $request->first_day_open . ' to ' . $request->first_day_close;
            }

            if ($request->second_day_open == 'Closed' || $request->second_day_open == 'Open 24 Hours') {
                $second_day = $request->second_day . ', ' . $request->second_day_open;
            } else {
                $second_day = $request->second_day . ', ' . $request->second_day_open . ' to ' . $request->second_day_close;
            }

            if ($request->third_day_open == 'Closed' || $request->third_day_open == 'Open 24 Hours') {
                $third_day = $request->third_day . ', ' . $request->third_day_open;
            } else {
                $third_day = $request->third_day . ', ' . $request->third_day_open . ' to ' . $request->third_day_close;
            }

            if ($request->fourth_day_open == 'Closed' || $request->fourth_day_open == 'Open 24 Hours') {
                $fourth_day = $request->fourth_day . ', ' . $request->fourth_day_open;
            } else {
                $fourth_day = $request->fourth_day . ', ' . $request->fourth_day_open . ' to ' . $request->fourth_day_close;
            }

            if ($request->fifth_day_open == 'Closed' || $request->fifth_day_open == 'Open 24 Hours') {
                $fifth_day = $request->fifth_day . ', ' . $request->fifth_day_open;
            } else {
                $fifth_day = $request->fifth_day . ', ' . $request->fifth_day_open . ' to ' . $request->fifth_day_close;
            }

            if ($request->sixth_day_open == 'Closed' || $request->sixth_day_open == 'Open 24 Hours') {
                $sixth_day = $request->sixth_day . ', ' . $request->sixth_day_open;
            } else {
                $sixth_day = $request->sixth_day . ', ' . $request->sixth_day_open . ' to ' . $request->sixth_day_close;
            }

            if ($request->seventh_day_open == 'Closed' || $request->seventh_day_open == 'Open 24 Hours') {
                $seventh_day = $request->seventh_day . ', ' . $request->seventh_day_open;
            } else {
                $seventh_day = $request->seventh_day . ', ' . $request->seventh_day_open . ' to ' . $request->seventh_day_close;
            }
            $opening_hours = $first_day . '; ' . $second_day . '; ' . $third_day . '; ' . $fourth_day . '; ' . $fifth_day . '; ' . $sixth_day . '; ' . $seventh_day;

            $suggest_an_edit->organization_work_time = $opening_hours;


            if ($suggest_an_edit_organization) {
                $suggest_an_edit->update();
            } else {
                $suggest_an_edit->save();
            }

            alert()->success('success', 'Your request has been submitted successfully. the administrator will contact you soon.')->autoClose(50000);

            return redirect()->back();
        }

        abort(404);
    }

    public function import()
    {
        try {
            $state_directories = File::directories('H:\gym');

            foreach ($state_directories as $state_directory) {
                $state_name = trim(basename($state_directory), " ");
                $state = State::where('name', Str::lower($state_name))->first();

                if ($state) {
                    $state_id = $state->id;

                    foreach (File::directories($state_directory) as $city_directory) {
                        $city_name = trim(basename($city_directory), " ");
                        $city = City::where('name', Str::lower($city_name))->first();

                        if ($city) {
                            $city_id = $city->id;
                            $files = File::files($city_directory);

                            if (count($files) > 0) {
                                ExcelImportJob::dispatch($state_id, $city_id, $files[0]->getRealPath());
                            } else {
                                alert()->error('Error', "No Excel files found in the '$city_name' directory.");
                            }
                        } else {
                            alert()->error('Error', "City '$city_name' not found in the database.");
                        }
                    }
                } else {
                    alert()->error('Error', "State '$state_name' not found in the database.");
                }
            }

            alert()->success('Success', 'Organization data import job dispatched successfully.');
        } catch (\Exception $e) {
            alert()->error('Error', 'An error occurred during the import process.');
            \Log::error('Import Error: ' . $e->getMessage());
        }

        return redirect()->back();
    }

//    public function import()
//    {
//        try {
//            $state_directories = File::directories('H:\gym');
//            $successCount = 0;
//
//            foreach ($state_directories as $state_directory) {
//                $state_name = trim(basename($state_directory), " ");
//                $state = State::where('name', Str::lower($state_name))->first();
//
//                if ($state) {
//                    $state_id = $state->id;
//
//                    foreach (File::directories($state_directory) as $city_directory) {
//                        $city_name = trim(basename($city_directory), " ");
//                        $city = City::where('name', Str::lower($city_name))->first();
//
//                        if ($city) {
//                            $city_id = $city->id;
//                            $files = File::files($city_directory);
//
//                            if (count($files) > 0) {
//                                Excel::import(new ImportOrganization($state_id, $city_id), $files[0]);
//                                $successCount++; // Increment the success count
//                            } else {
//                                // Handle the case where no files were found in the city directory
//                                alert()->error('Error', "No Excel files found in the '$city_name' directory.");
//                            }
//                        } else {
//                            // Handle the case where the city is not found in the database
//                            alert()->error('Error', "City '$city_name' not found in the database.");
//                        }
//                    }
//                } else {
//                    // Handle the case where the state is not found in the database
//                    alert()->error('Error', "State '$state_name' not found in the database.");
//                }
//            }
//
//            if ($successCount > 0) {
//                alert()->success('Success', "{$successCount} files imported successfully.");
//            } else {
//                alert()->info('Info', 'No files were imported.');
//            }
//        } catch (\Exception $e) {
//            // Handle exceptions, log errors, and provide user feedback
//            alert()->error('Error', 'An error occurred during the import process.');
//            \Log::error('Import Error: ' . $e->getMessage());
//        }
//
//        return redirect()->back();
//    }

//    public function import()
//    {
//        $state_directories = File::directories('H:\gym');
//
//        foreach ($state_directories as $state_directory) {
//            $state_name = trim(basename($state_directory), " ");
//            $state_id = State::where('name', Str::lower($state_name))->first()->id;
//
//            foreach (File::directories($state_directory) as $city_directory) {
//
//                $city_name = trim(basename($city_directory), " ");
//                $city_id = City::where('name', Str::lower($city_name))->first()->id;
//
//                $files = File::files($city_directory);
//
//                Excel::import(new ImportOrganization($state_id, $city_id), $files[0]);
//            }
//        }
//
//        alert()->success('success', 'Organization data imported successfully.');
//
//        return redirect()->back();
//    }

    public function copyPast()
    {
        $state_directories = File::directories('H:\gym');

        foreach ($state_directories as $category_directory) {
            foreach (File::directories($category_directory) as $category) {
                $sourcePath = File::glob($category . '/media/*');

                foreach ($sourcePath as $source) {

                    $destinationPath = 'H:\gymnearx-images';
                    $file = basename($source);
                    $destinationPath = $destinationPath . '/' . $file;
                    File::copy($source, $destinationPath);
                }
            }
        }

        alert()->success('success', 'Images copy and past successfully completed.');

        return redirect()->back();
    }
}
