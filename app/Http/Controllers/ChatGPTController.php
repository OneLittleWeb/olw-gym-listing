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
        $organizations = Organization::with('reviews')->take(1)->get();
        $results = [];

        foreach ($organizations as $organization) {
            try {
                $reviewsDetails = '';
                $counter = 1;

                foreach ($organization->reviews as $review) {
                    $reviewsDetails .= "\n\n" . ($counter === 1 ? "Organization Review:\n\n" : "") .
                        $counter . '. ' . $review->review_text_original . "\n\n" .
                        'Review rating: ' . $review->review_rate_stars . " star\n\n";
                    $counter++;
                }

                // Construct the query with organization details and appended reviews
                $query = 'After analyzing all business details, write a short description of ' . $organization->organization_name . ' between 140-150 words, with pros in one or two sentences and cons in another one or two sentences.
The format should be:
Description
Pros
Cons
Here are the business details for ' . $organization->organization_name . ' for you to analyze and complete the task.
' . $organization->organization_address . '.
Phone number: ' . $organization->organization_phone_number . ',
Email: ' . $organization->organization_email . ',
Website: ' . $organization->organization_website . ',
Location: ' . $organization->located_in . ',
Opening and Closing Time: ' . $organization->organization_work_time . '.
Category: ' . $organization->organization_category . '.\n\n' . $reviewsDetails;

                $response = Http::withHeaders([
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . config('services.chatgpt.api_key')
                ])->post(config('services.chatgpt.base_uri'), [
                    "model" => "gpt-4",
                    "messages" => [
                        ["role" => "user", "content" => $query]
                    ],
                    "temperature" => 1,
                    "max_tokens" => 2048
                ])->json();

                if (isset($response['choices'][0]['message']['content'])) {
                    $results[] = $response['choices'][0]['message']['content'];
                } else {
                    Log::warning('Unexpected response structure from ChatGPT API.', compact('response'));
                    $results[] = 'An unexpected error occurred while generating the description.';
                }

            } catch (Throwable $e) {
                Log::error("Error calling ChatGPT API: " . $e->getMessage());
                return response()->json([
                    'error' => 'An error occurred while processing your request. Please try again later.',
                ], 500);
            }
        }

        return response()->json($results);
    }

}
