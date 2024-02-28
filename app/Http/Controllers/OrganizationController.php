<?php

namespace App\Http\Controllers;

use App\Mail\ClaimBusinessMail;
use App\Mail\ClaimedBusiness;
use App\Mail\ClaimedNotificationToAdmin;
use App\Mail\ContactForClaimToAdmin;
use App\Mail\ContactForClaimToUser;
use App\Models\AwardCertificateRequest;
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
use Stevebauman\Location\Facades\Location;

class OrganizationController extends Controller
{
    public function cityWiseOrganization($city_slug, $organization_slug)
    {
        $g_reviews_page = request()->get('g_reviews', 1);

        $cacheKey = 'city_wise_organization_' . $city_slug . '_' . $organization_slug . '_' . $g_reviews_page;

        // Attempt to retrieve the view as a string from the cache.
        $cachedView = Cache::get($cacheKey);

        if ($cachedView === null) {
            // If the view is not found in the cache, generate and store it.
            $cachedView = $this->generateCityWiseOrganizationView($city_slug, $organization_slug);
            Cache::forever($cacheKey, $cachedView);
        }

        $organization = Organization::where('slug', $organization_slug)->where('permanently_closed', 0)->first();

        if ($organization) {
            $organization->incrementViewCount();
        }

        return response($cachedView);
    }

    public function generateCityWiseOrganizationView($city_slug, $organization_slug)
    {
        $organization = Organization::with(['state', 'city', 'reviews', 'category'])
            ->where('slug', $organization_slug)
            ->where('permanently_closed', 0)
            ->first();

        if ($organization) {

            $city = City::where('state_id', $organization->state_id)->where('slug', $city_slug)->first();

            $organization->incrementViewCount();

            // Cache key for also viewed organizations
            $cacheKey = 'also_viewed_organizations_' . $organization->id;

            // Retrieve cached value if available
            $also_viewed = cache()->remember($cacheKey, now()->addHours(24), function () use ($organization) {
                return $this->getAlsoViewedOrganizations($organization);
            });

            $reviewCounts = $organization->reviews()->select('review_rate_stars', DB::raw('COUNT(*) as count'))->groupBy('review_rate_stars')->pluck('count', 'review_rate_stars')->toArray();

            [
                $five_star_reviews,
                $four_star_reviews,
                $three_star_reviews,
                $two_star_reviews,
                $one_star_reviews,
            ] = array_values($reviewCounts + [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]);


            $meta = explode(',', $organization->organization_address);
            $metaTitle = $organization->organization_address
                ? $organization->organization_name . ' -' . $meta[1] ?? '' . ',' . $meta[2] ?? ''
                : $organization->organization_name . ' - ' . $city->name . ', ' . $city->State->name;

            $organization->meta_title = $metaTitle;

            if ($organization->organization_address && $organization->located_in) {
                $address_line = explode(',', $organization->organization_address);
                $organization->about1 = 'Join the beacon of health and wellness at ' . "<strong>$organization->organization_name</strong>" . ', located at the ' . $organization->located_in . ',' . ($address_line[1] ?? '') . ',' . ($address_line[2] ?? '') . '.' . ' Experience a holistic fitness center providing unparalleled access to diverse workouts, personal training, and wellness facilities.';
            } elseif ($organization->organization_address) {
                $address_line = explode(',', $organization->organization_address);
                $organization->about1 = 'Join the beacon of health and wellness at <strong>' . $organization->organization_name . '</strong>, located in ' . ($address_line[1] ?? '') . ', ' . ($address_line[2] ?? '') . '. Experience a holistic fitness center providing unparalleled access to diverse workouts, personal training, and wellness facilities.';
            } else {
                $organization->about1 = 'Join the beacon of health and wellness at ' . "<strong>$organization->organization_name</strong>" . ', located in ' . Str::title($organization->State->name) . ', ' . Str::title($organization->city->name) . '.' . ' Experience a holistic fitness center providing unparalleled access to diverse workouts, personal training, and wellness facilities.';
            }

            $contactInfo =
                "<a href='tel:$organization->organization_phone_number'>$organization->organization_phone_number</a>" ??
                "<strong>$organization->organization_email</strong>" ??
                "<strong>$organization->organization_website</strong>" ??
                "<strong>$organization->organization_address</strong>";

            $organization->about2 = "<strong>$organization->organization_name</strong>" .
                ' has earned a ' . "<strong>$organization->rate_stars</strong>" .
                '-star rating with ' . "<strong>$organization->reviews_total_count</strong>" .
                ' reviews. ' . 'You can contact them at ' . $contactInfo . ' for more information.';

            $emailProperties = ['organization_email', 'organization_facebook', 'organization_twitter', 'organization_instagram', 'organization_youTube'];

            foreach ($emailProperties as $property) {
                $value = $organization->$property;

                // Check if the value is not null before using explode
                $organization->{"exploded_$property"} = $value !== null ? explode(',', $value) : [];
            }

            $organization->rate_stars = $organization->rate_stars ?? 0;
            $organization->reviews_total_count = $organization->reviews_total_count ?? 0;

            $organization->reviews_paginator = $this->getOrganizationReviews($organization, 'g_reviews');
            $organization->own_reviews_paginator = $this->getOrganizationReviews($organization, 'own_reviews');

            Meta::setPaginationLinks($organization->reviews_paginator);

            $select_hours = ['Open 24 Hours', 'Closed', '12 AM', '12:15 AM', '12:30 AM', '12:45 AM', '1 AM', '1:15 AM', '1:30 AM', '1:45 AM', '2 AM', '2:15 AM', '2:30 AM', '2:45 AM', '3 AM', '3:15 AM', '3:30 AM', '3:45 AM', '4 AM', '4:15 AM', '4:30 AM', '4:45 AM', '5 AM', '5:15 AM', '5:30 AM', '5:45 AM', '6 AM', '6:15 AM', '6:30 AM', '6:45 AM', '7 AM', '7:15 AM', '7:30 AM', '7:45 AM', '8 AM', '8:15 AM', '8:30 AM', '8:45 AM', '9 AM', '9:15 AM', '9:30 AM', '9:45 AM', '10 AM', '10:15 AM', '10:30 AM', '10:45 AM', '11 AM', '11:15 AM', '11:30 AM', '11:45 AM', '12 PM', '12:15 PM', '12:30 PM', '12:45 PM', '1 PM', '1:15 PM', '1:30 PM', '1:45 PM', '2 PM', '2:15 PM', '2:30 PM', '2:45 PM', '3 PM', '3:15 PM', '3:30 PM', '3:45 PM', '4 PM', '4:15 PM', '4:30 PM', '4:45 PM', '5 PM', '5:15 PM', '5:30 PM', '5:45 PM', '6 PM', '6:15 PM', '6:30 PM', '6:45 PM', '7 PM', '7:15 PM', '7:30 PM', '7:45 PM', '8 PM', '8:15 PM', '8:30 PM', '8:45 PM', '9 PM', '9:15 PM', '9:30 PM', '9:45 PM', '10 PM', '10:15 PM', '10:30 PM', '10:45 PM', '11 PM', '11:15 PM', '11:30 PM', '11:45 PM'];

            $reviews = $organization->reviews()->get();

            $review_pros = $this->getReviewPros($reviews);
            $review_cons = $this->getReviewCons($reviews);

            if ($organization->organization_work_time && $organization->organization_work_time != ". Hide open hours for the week") {
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

                return view('organization.show', compact('organization', 'city', 'five_star_reviews', 'four_star_reviews', 'three_star_reviews', 'two_star_reviews', 'one_star_reviews', 'select_hours', 'also_viewed', 'first_day', 'first_day_opening_hours', 'first_day_closing_hours', 'second_day', 'second_day_opening_hours', 'second_day_closing_hours', 'third_day', 'third_day_opening_hours', 'third_day_closing_hours', 'fourth_day', 'fourth_day_opening_hours', 'fourth_day_closing_hours', 'fifth_day', 'fifth_day_opening_hours', 'fifth_day_closing_hours', 'sixth_day', 'sixth_day_opening_hours', 'sixth_day_closing_hours', 'seventh_day', 'seventh_day_opening_hours', 'seventh_day_closing_hours', 'review_pros', 'review_cons'));
            } else {
                return view('organization.show', compact('organization', 'city', 'five_star_reviews', 'four_star_reviews', 'three_star_reviews', 'two_star_reviews', 'one_star_reviews', 'select_hours', 'also_viewed', 'review_pros', 'review_cons'));
            }
        }

        abort(404);
    }

    public function getReviewPros($reviews)
    {
        $all_pros = [
            'great gym', 'recommend', '24 hour', 'the best gym', 'down to earth', 'friendly environment', 'friendly', 'great environment',
            'friendly staff', 'love this place', 'great staff', 'love this gym', 'very friendly',
            'great atmosphere', 'absolutely fantastic', 'definitely come back', 'nice staff', 'love the place', 'recommended',
            'friendly and professional', 'helpful and knowledgeable', 'very helpful', 'friendly and welcoming', 'great experience',
            'so convenient', 'great people', 'great place', 'price was very reasonable', '24 hours',
            'well organized', 'great management', 'helped me', 'affordable', 'good people', 'will be back',
            'very welcoming', 'highly recommend', 'wonderful staff', 'best place', 'feel comfortable', 'reasonable price', 'fair price'
        ];

        $matched_pros_count = [];

        // Initialize count for each keyword to 0
        foreach ($all_pros as $keyword) {
            $matched_pros_count[$keyword] = 0;
        }

        foreach ($reviews as $review) {
            $review_text = strtolower($review->review_text_original); // Convert text to lowercase for case-insensitive comparison
            $review_stars = $review->review_rate_stars; // Retrieve review stars

            // Check if review stars are greater than 2
            if ($review_stars > 2) {
                // Loop through the keywords array to find matches in the review text
                foreach ($all_pros as $keyword) {
                    if (stripos($review_text, strtolower($keyword)) !== false) {
                        // Increment count for the matched keyword
                        $matched_pros_count[$keyword]++;
                    }
                }
            }
        }

        // Remove duplicate keywords and create a single array containing keywords and their respective counts
        $matched_pros = [];
        foreach ($matched_pros_count as $keyword => $count) {
            if ($count > 0 && !in_array($keyword, array_keys($matched_pros))) {
                $matched_pros[$keyword] = $count;
            }
        }

        arsort($matched_pros);

        return $matched_pros;
    }

    public function getReviewCons($reviews)
    {
        $all_cons = [
            'not a safe environment', 'not a good gym', 'not a good place', 'not a good experience', 'not a good deal', 'not a good value', 'forced us to pay',
            'poor customer service', 'horrible', 'horrible place', 'stay away', 'bad business', 'frustrating', 'not friendly', 'not helpful', 'poor communication',
            'disappointed', 'not happy', 'not satisfied', 'not worth it', 'not worth the money', 'not worth the price', 'not worth the cost', 'not worth the membership',
            'no response', 'rude', 'overcharged', 'not impressed', 'overpriced', 'very sad', ' take my business elsewhere', 'not recommend', 'go elsewhere', 'disrespectful', 'not great',
            'unprofessional', 'slow', 'horrible customer service', 'will not return', 'uncomfortable', 'bad experience', 'annoying', 'shame'
        ];

        $matched_cons_count = [];

        // Initialize count for each keyword to 0
        foreach ($all_cons as $keyword) {
            $matched_cons_count[$keyword] = 0;
        }

        foreach ($reviews as $review) {
            $review_text = strtolower($review->review_text_original); // Convert text to lowercase for case-insensitive comparison
            $review_stars = $review->review_rate_stars; // Retrieve review stars

            // Check if review stars are greater than 4
            if ($review_stars < 4) {
                // Loop through the keywords array to find matches in the review text
                foreach ($all_cons as $keyword) {
                    if (stripos($review_text, strtolower($keyword)) !== false) {
                        // Increment count for the matched keyword
                        $matched_cons_count[$keyword]++;
                    }
                }
            }
        }

        // Remove duplicate keywords and create a single array containing keywords and their respective counts
        $matched_cons = [];
        foreach ($matched_cons_count as $keyword => $count) {
            if ($count > 0 && !in_array($keyword, array_keys($matched_cons))) {
                $matched_cons[$keyword] = $count;
            }
        }

        arsort($matched_cons);

        return $matched_cons;
    }

    public function getAlsoViewedOrganizations($organization)
    {
        return Organization::with('city:id,name,slug', 'category:id,name,icon')->where('id', '!=', $organization->id)
            ->where('state_id', $organization->state_id)
            ->where('city_id', $organization->city_id)
            ->where('permanently_closed', 0)
            ->orderByDesc('views')
            ->limit(4)
            ->get();
    }

    private function getOrganizationReviews($organization, $reviewIdColumn)
    {
        return $organization->reviews()
            ->when($reviewIdColumn === 'g_reviews', function ($query) {
                return $query->whereNotNull('review_id');
            })
            ->when($reviewIdColumn === 'own_reviews', function ($query) {
                return $query->whereNull('review_id');
            })
            ->orderByDesc('review_specified_date')
            ->paginate(10, ['*'], $reviewIdColumn)
            ->withQueryString();
    }

    public function getProsConsReviews($slug, $keyword, $type)
    {
        try {
            $organization = Organization::where('slug', $slug)->where('permanently_closed', 0)->first();

            $reviewsQuery = $organization->reviews()
                ->select('reviewer_name', 'review_rate_stars', 'review_specified_date', 'created_at', 'review_text_original')
                ->where('review_text_original', 'LIKE', "%{$keyword}%")
                ->orderBy('created_at', 'desc');

            if ($type === 'pros') {
                $reviewsQuery->where('review_rate_stars', '>', 2);
            } else {
                $reviewsQuery->where('review_rate_stars', '<', 4);
            }

            $reviews = $reviewsQuery->get();

            return response()->json([
                'reviews' => $reviews
            ]);
        } catch (\Exception $e) {
            // Handle the exception here
            return response()->json(['error' => 'An error occurred while fetching reviews.'], 500);
        }
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
                alert()->warning('No Found', 'This business is not available in this location!');
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
                Mail::to(config('app.support_mail'))->send(new ClaimedNotificationToAdmin($organization));
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
                Mail::to(config('app.support_mail'))->send(new ContactForClaimToAdmin($organization));
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

    public function gymNearMe($organization_category_slug = null, $suffix = null)
    {
        $client_ip_address = $this->getClientIP();

//        $client_ip_address = '172.69.59.14';

//        $client_ip_address = '138.26.72.17';

        $user_location = Location::get($client_ip_address);

        $states = Cache::rememberForever('states_data_near_me', function () {
            return State::select('id', 'name', 'slug', 'background_image')
                ->withCount(['cities as cities_count'])
                ->groupBy('id', 'name', 'slug', 'background_image')
                ->get();
        });

        $stateIds = $states->pluck('id');
        $cities = City::with('state')->whereIn('state_id', $stateIds)->select('id', 'state_id', 'name', 'slug')->get();

        $states->each(function ($state) use ($cities) {
            $state->cities = $cities->where('state_id', $state->id)->all();
        });

        $organizations = [];
        $location_data = [];
        $organization_category_count = [];
        $meta_title = 'Top Gyms near me - Best Fitness Center near me - Gymnearx';
        $meta_description = 'Gyms near me - Gymnearx';
        $meta_keyword = 'Gyms near me, Popular Gyms near me, Local Gyms nearby, Body Building Classes, Reviews, Ratings, Map, Address, Phone number, Contact Number';

        if ($user_location) {
            $state = State::where('name', Str::lower($user_location->regionName))->first();
            $city = City::where('name', Str::lower($user_location->cityName))->first();

            if ($state && $city) {
                $state_id = $state->id;
                $city_id = $city->id;

                $user_latitude = $user_location->latitude;
                $user_longitude = $user_location->longitude;

                $organizations_query = Organization::with('state', 'city')->where('state_id', $state_id)
                    ->where('city_id', $city_id)
                    ->where('permanently_closed', 0);

                if ($organization_category_slug !== null && $suffix !== null) {
                    $organizations_query = $organizations_query->where('organization_category_slug', $organization_category_slug);
                }

                $organizations = $organizations_query->get();

                if (count($organizations) > 0){
                    $organizations = $organizations->map(function ($organization) use ($user_latitude, $user_longitude) {
                        $org_latitude = $organization->organization_latitude;
                        $org_longitude = $organization->organization_longitude;

                        $distance = $this->calculateDistance($user_latitude, $user_longitude, $org_latitude, $org_longitude);
                        $organization->distance = $distance;

                        return $organization;
                    });

                    $organization_category_count = Organization::where('state_id', $state_id)
                        ->where('city_id', $city_id)
                        ->where('permanently_closed', 0)
                        ->where('organization_category_slug', $organization_category_slug)->count();


                    $organizations = $organizations->sortBy('distance');

                    $organizations->organization_categories = $this->organizationCategories($state_id, $city_id);

                    foreach ($organizations as $organization) {
                        $location_data[] = [
                            'name' => $organization->organization_name,
                            'lat' => $organization->organization_latitude,
                            'lng' => $organization->organization_longitude,
                            'city_slug' => $organization->city->slug,
                            'slug' => $organization->slug,
                            'distance' => $organization->distance,
                            'address' => $organization->organization_address,
                            'rate_stars' => $organization->rate_stars,
                            'reviews_total_count' => $organization->reviews_total_count,
                            'direction' => $organization->gmaps_link,
                            'head_photo' => $organization->organization_head_photo_file ?? 'default.jpg',
                        ];
                    }

                    $meta_title = $this->generateMetaTitle($organizations, $city);

                    $meta_description = $this->generateMetaDescription($organizations, $city);

                    $meta_keyword = $this->generateMetaKeyWord($organizations, $city);
                }
            }
        }

        return view('organization.gym-near-me', ['locations' => json_encode($location_data), 'organizations' => $organizations, 'organization_category_slug' => $organization_category_slug, 'states' => $states, 'organization_category_count' => $organization_category_count, 'meta_description' => $meta_description, 'meta_title' => $meta_title, 'meta_keyword' => $meta_keyword]);
    }

    public function getClientIP()
    {
        $ip = request()->ip();

        // Check if the request is coming through a proxy
        $headersToCheck = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR', 'x-forwarded-for', 'cf-connecting-ip', 'client-ip', 'x-real-ip'];

        foreach ($headersToCheck as $key) {
            if (request()->header($key)) {
                $ip = request()->header($key);
                if (strpos($ip, ',') !== false) {
                    // Multiple IPs found, taking the first one
                    $ip = explode(',', $ip)[0];
                }
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }

        return $ip;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371;

        $delta_lat = deg2rad($lat2 - $lat1);
        $delta_lon = deg2rad($lon2 - $lon1);

        $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($delta_lon / 2) * sin($delta_lon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c;
    }

    public function organizationCategories($state_id, $city_id)
    {
        return Organization::select('organization_category', 'organization_category_slug', 'state_id', 'city_id', DB::raw('COUNT(*) as category_count'))
            ->where('state_id', $state_id)
            ->where('city_id', $city_id)
            ->groupBy('organization_category', 'state_id', 'city_id', 'organization_category_slug')
            ->orderBy('category_count', 'desc')
            ->get();
    }

    private function generateMetaTitle($organizations, $city)
    {
        return 'Top ' . Str::plural($organizations[0]->organization_category, $organizations->count()) . ' in ' . $city->name . ' - Best ' . Str::plural($organizations[0]->organization_category, $organizations->count()) . ' near me - Gymnearx';
    }


    private function generateMetaDescription($organizations, $city)
    {
        return Str::plural($organizations[0]->organization_category, $organizations->count()) . " near me - Gymnearx.";
    }

    private function generateMetaKeyWord($organizations, $city)
    {
        return Str::plural($organizations[0]->organization_category, $organizations->count()) . ' in ' . $city->name . ', Popular ' . Str::plural($organizations[0]->organization_category, $organizations->count()) . ' in ' . $city->name . ', Local ' . Str::plural($organizations[0]->organization_category, $organizations->count()) . ' nearby, Body Building Classes, Reviews, Ratings, Map, Address, Phone number, Contact Number';
    }
}
