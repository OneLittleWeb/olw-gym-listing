<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class ChatGPTController extends Controller
{
    public function getAboutUs()
    {
        $organization = Organization::first();
dd($organization->reviews);
        foreach ($organization->reviews as $review)
        {
            dd($review);
        }

//        try {
//
//            $query = 'tell me something about Laravel';
//
//            /** @var array $response */
//            $response = Http::withHeaders([
//                "Content-Type" => "application/json",
//                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
//            ])->post('https://api.openai.com/v1/chat/completions', [
//                "model" => "gpt-3.5-turbo",
//                "messages" => [
//                    [
//                        "role" => "user",
//                        "content" => $query
//                    ]
//                ],
//                "temperature" => 0,
//                "max_tokens" => 2048
//            ])->json();
//
//            dd($response['choices'][0]['message']['content']);
//        } catch (Throwable $e) {
//            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
//        }
    }
}
