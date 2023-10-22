<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reviewer_name' => 'required',
            'Email' => 'email:rfc,dns',
            'review_rate_stars' => 'required',
        ]);
        $organization = Organization::where('organization_guid', $request->organization_guid)->first();

        if ($organization) {
            $review = new Review();
            $review->organization_guid = $organization->organization_guid;
            $review->organization_gmaps_id = $organization->organization_gmaps_id;
            $review->reviewer_name = $request->reviewer_name;
            $review->review_rate_stars = $request->review_rate_stars;
            $review->reviewer_email = $request->reviewer_email;
            $review->review_text_original = $request->review_text_original;

            if ($request->hasFile('review_photos_files')) {
                $files = [];
                $images = $request->file('review_photos_files');
                foreach ($images as $image) {
                    $name = Str::slug($request->reviewer_name) . '-' . mt_rand(1000000, 9999999) . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/business');
                    $image->move($destinationPath, $name);
                    $files[] = $name;
                }
                $review->review_photos_files = implode(',', $files);
            }
            $review->save();
        }

        alert()->success('success', 'Review submitted successfully.');

        return redirect()->back();
    }

    function diffForHumansToCarbon($current_review_date, $created_at)
    {
        $carbon = Carbon::parse($created_at);

        // Try matching the standard pattern
        $pattern = '/(\d+)\s(\w+)\s(ago|from now)/';

        if (preg_match($pattern, $current_review_date, $matches)) {
            $units = $matches[1];
            $unitType = $matches[2];
            $direction = $matches[3];

            if ($units == 1) {
                // Handle special cases for "a year ago," "a month ago," "a week ago," and "a day ago"
                if (in_array($unitType, ['year', 'month', 'week', 'day'])) {
                    $unitType = rtrim($unitType, 's');
                }
            }

            if ($direction === 'ago') {
                $carbon->sub($units, $unitType);
            } else {
                $carbon->add($units, $unitType);
            }

            return $carbon;
        }

        // If the standard pattern doesn't match, try alternative patterns
        if (preg_match('/a year ago/i', $current_review_date)) {
            $carbon->subYears(1);
            return $carbon;
        } elseif (preg_match('/a month ago/i', $current_review_date)) {
            $carbon->subMonths(1);
            return $carbon;
        } elseif (preg_match('/a week ago/i', $current_review_date)) {
            $carbon->subWeeks(1);
            return $carbon;
        } elseif (preg_match('/a day ago/i', $current_review_date)) {
            $carbon->subDays(1);
            return $carbon;
        }

        return null; // Handle unsupported formats gracefully.
    }

    public function reviewDateDiffFromHumanToDate()
    {
        $reviews = Review::where('review_specified_date', null)->get();

        foreach ($reviews as $review) {
            $created_at = $review->created_at;
            $current_review_date = $review->review_date;
            $converted_review_date = $this->diffForHumansToCarbon($current_review_date, $created_at);

            if ($converted_review_date) {
                $review->review_specified_date = $converted_review_date->toDateTimeString();
            } else {
                $review->review_specified_date = null;
            }

            $review->save(); // Save the review after setting the review date.
        }

        alert()->success('Success', 'Review date converted successfully.');

        return redirect()->back();
    }

//    public function dateFormatCheck()
//    {
//        $created_at = '2023-10-19 09:19:09';
//        $diffForHumans = "5 days ago";
//        $carbon = $this->diffForHumansToCarbon($diffForHumans, $created_at);
//
//        if ($carbon) {
//            echo $carbon->toDateTimeString(); // Output: "2023-03-11 09:19:08"
//        } else {
//            echo "Unsupported format.";
//        }
//    }
}
