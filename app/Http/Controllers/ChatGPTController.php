<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatGPTController extends Controller
{
    public function getAboutUs()
    {
        $organizations = Organization::with(['reviews', 'city', 'state'])->take(10)->get();

        foreach ($organizations as $organization) {
            try {
                $queryInstructions = $this->prepareQueryInstructions($organization);

                $response = Http::withHeaders([
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . config('services.chatgpt.api_key'),
                ])->post(config('services.chatgpt.base_uri'), [
                    "model" => "gpt-4",
                    "messages" => [["role" => "user", "content" => $queryInstructions]],
                    "temperature" => 1,
                    "max_tokens" => 1024,
                ])->json();

                if (isset($response['choices'][0]['message']['content'])) {
                    // Format the response with HTML
                    $structuredResult = $response['choices'][0]['message']['content'];

                    // Update the organization with the generated description
                    $organization->update(['organization_description' => $structuredResult]); // Use strip_tags if you need to remove HTML for storage

                } else {
                    Log::warning('Unexpected response structure from ChatGPT API.', compact('response'));
                    $results[] = 'An unexpected error occurred while generating the description.';
                }
            } catch (Throwable $e) {
                Log::error("Error calling ChatGPT API: " . $e->getMessage());
                $results[] = 'An error occurred while processing your request. Please try again later.';
            }
        }

        // Assuming you return results to a view or redirect back with a success message
        return redirect()->back()->with('success', 'Organizations updated with generated descriptions.');
    }


    protected function prepareQueryInstructions($organization)
    {
        $reviewsAvailable = !$organization->reviews->isEmpty();
        $reviewsDetails = '';
        $counter = 1;

        // Compile review details if available
        if ($reviewsAvailable) {
            foreach ($organization->reviews as $review) {
                $reviewsDetails .= ($counter === 1 ? "Organization Reviews:\n\n" : "") .
                    $counter . '. Review: ' . $review->review_text_original . "\n" .
                    'Rating: ' . $review->review_rate_stars . " stars\n\n";
                $counter++;
            }
        }

        // Assemble organization details, only including if available
        $details = [
            'Address' => $organization->organization_address ?: ucfirst($organization->city->name ?? 'unknown') . ', ' . ucfirst($organization->state->name ?? 'unknown') . ', US',
            'Phone' => $organization->organization_phone_number ? "Phone number: " . $organization->organization_phone_number : '',
            'Email' => $organization->organization_email ? "Email: " . $organization->organization_email : '',
            'Website' => $organization->organization_website ? "Website: " . $organization->organization_website : '',
            'Location' => $organization->located_in ? "Located in: " . $organization->located_in : '',
            'Working Hours' => $organization->organization_work_time ? "Working hours: " . $organization->organization_work_time : '',
            'Category' => $organization->organization_category ? "Category: " . $organization->organization_category : '',
            'Rating' => isset($organization->rate_stars) ? "Rating: " . $organization->rate_stars . " stars" : '',
            'Total Reviews' => isset($organization->reviews_total_count) ? "Total reviews: " . $organization->reviews_total_count : '',
        ];

        // Filter out empty details
        $details = array_filter($details);

        // Start constructing the query
        $queryInstructions = "After analyzing all business details, ";
        $queryInstructions .= $reviewsAvailable ? "write a short description of " . $organization->organization_name . " between 140-150 words, with pros in one or two sentences and cons in another one or two sentences. " : "write a short description of " . $organization->organization_name . ". ";
//        $queryInstructions .= "The format should be:\nDescription\n";
//        if ($reviewsAvailable) {
//            $queryInstructions .= "Pros\nCons\n";
//        }
        $queryInstructions .= "The results should include 'Description', 'Pros', and 'Cons'. They should be presented as an array, where index 0 contains the 'Description', index 1 contains 'Pros', and index 2 contains 'Cons', dont include pros cons label in the response.\n";
        $queryInstructions .= "Here are the business details for " . $organization->organization_name . " to analyze and complete the task:\n";

        // Append each detail
        foreach ($details as $key => $value) {
            $queryInstructions .= $value . "\n";
        }

        // Append reviews details if available
        if (!empty($reviewsDetails)) {
            $queryInstructions .= "\n" . $reviewsDetails;
        }

        return $queryInstructions;
    }


//    public function getAboutUs()
//    {
//        $organizations = Organization::with(['reviews', 'city', 'state'])->take(10)->get();
//        $results = [];
//
//        foreach ($organizations as $organization) {
//            try {
//                // Initialize variables for the details sections
//                $reviewsDetails = '';
//                $counter = 1;
//
//                // Check if reviews are available and append details accordingly
//                $reviewsAvailable = !$organization->reviews->isEmpty();
//                if ($reviewsAvailable) {
//                    foreach ($organization->reviews as $review) {
//                        $reviewsDetails .= "\n\n" . ($counter === 1 ? "Organization Review:\n\n" : "") .
//                            $counter . '. ' . $review->review_text_original . "\n\n" .
//                            'Review rating: ' . $review->review_rate_stars . " star\n\n";
//                        $counter++;
//                    }
//                }
//
//                // Prepare other organization details with conditional inclusion
//                $address = $organization->organization_address ?: ucfirst($organization->city->name ?? '') . ', ' . ucfirst($organization->state->name ?? '') . ', US';
//                $phoneSection = $organization->organization_phone_number ? "Phone number: " . $organization->organization_phone_number . ',' : '';
//                $emailSection = $organization->organization_email ? "Email: " . $organization->organization_email : '';
//                $websiteSection = $organization->organization_website ? "Website: " . $organization->organization_website : '';
//                $locationSection = $organization->located_in ? "Location: " . $organization->located_in : '';
//                $workTimeSection = $organization->organization_work_time ? "Opening and Closing Time: " . $organization->organization_work_time : '';
//                $categorySection = $organization->organization_category ? "Category: " . $organization->organization_category : '';
//                $rateStarsSection = $organization->rate_stars ? "Overall Organization Rating: " . $organization->rate_stars : '';
//                $totalReviewsSection = $organization->reviews_total_count ? "Organization Total Reviews: " . $organization->reviews_total_count : '';
//
//                // Compiling all the details into the queryInstructions
//                $queryParts = [
//                    'After analyzing all business details, ' . $prosConsSection = $reviewsAvailable ? 'write a short description of ' . $organization->organization_name . ' between 140-150 words, with pros in one or two sentences and cons in another one or two sentences.' : 'write a short description of ' . $organization->organization_name . '.',
//                    'The format should be:',
//                    $reviewsAvailable ? "Description\nPros\nCons" : "Description",
//                    'Here are the business details for ' . $organization->organization_name . ' for you to analyze and complete the task:',
//                    $address,
//                    $phoneSection,
//                    $emailSection,
//                    $websiteSection,
//                    $locationSection,
//                    $workTimeSection,
//                    $categorySection,
//                    $rateStarsSection,
//                    $totalReviewsSection,
//                    $reviewsAvailable ? "\n\n" . $reviewsDetails : ''
//                ];
//
//                // Filtering out empty sections
//                $queryInstructions = implode("\n", array_filter($queryParts, function($value) { return !empty($value); }));
//
//                // Make the API request
//                $response = Http::withHeaders([
//                    "Content-Type" => "application/json",
//                    "Authorization" => "Bearer " . config('services.chatgpt.api_key'),
//                ])->post(config('services.chatgpt.base_uri'), [
//                    "model" => "gpt-4",
//                    "messages" => [["role" => "user", "content" => $queryInstructions]],
//                    "temperature" => 1,
//                    "max_tokens" => 2048,
//                ])->json();
//
//                // Process the response
//                if (isset($response['choices'][0]['message']['content'])) {
//                    $results[] = $response['choices'][0]['message']['content'];
//                } else {
//                    Log::warning('Unexpected response structure from ChatGPT API.', compact('response'));
//                    $results[] = 'An unexpected error occurred while generating the description.';
//                }
//
//                foreach ($results as $result)
//                {
//                    $organization->organization_description = $result;
//                    $organization->update();
//                }
//
//                alert()->success('success', 'An email has been sent to your business mail. Please check and confirm your business.');
//
//            } catch (Throwable $e) {
//                Log::error("Error calling ChatGPT API: " . $e->getMessage());
//                return response()->json(['error' => 'An error occurred while processing your request. Please try again later.'], 500);
//            }
//        }
//
//        return redirect()->back();
//    }
}
