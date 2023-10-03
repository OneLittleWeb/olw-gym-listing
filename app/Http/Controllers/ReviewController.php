<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Review;
use Illuminate\Http\Request;
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
}
