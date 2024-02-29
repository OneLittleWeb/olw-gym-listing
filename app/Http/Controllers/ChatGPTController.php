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
//        $organization = Organization::first();
//dd($organization->reviews);
//        foreach ($organization->reviews as $review)
//        {
//            dd($review);
//        }

        try {

            $query = 'After analysis all business details give me a short description of the business name as Club Pilates, Mainly it is gym. address Address: 3159 Green Valley Rd, Birmingham, AL 35243, United States. Their phone number is +1 205-777-7976, email is operations@clubpilates.com, website is clubpilates.com, located in Market Square Shopping Center, opening and closing time is Sunday, 1 to 5 PM; Monday, 8:30 AM to 7:30 PM; Tuesday, 8:30 AM to 7:30 PM; Wednesday, 8:30 AM to 7:30 PM; Thursday, 8:30 AM to 7:30 PM; Friday, 8:30 AM to 7:30 PM; Saturday, 8 AM to 12 PM. Hide open hours for the week, the category is Pilates studio as
organization review 1. I love Club Pilates! Their instructors are all encouraging and knowledgeable. I have never had a bad class there, and there are plenty of times available to fit my changing schedule. I feel so much stronger than when I started a few months ago!, review rate star is 5
Ellen is the absolute best Pilates instructor, bar none. She has a super positive vibe and her classes are always fresh, challenging, and enjoyable. Ellen has the uncanny ability to kick your *ss but make you have fun while she’s doing it! It’s always a joy to be in one of her classes., review rate star is 5
3.I absolutely adore Kristi and all her classes! I specifically book my classes around her schedule! I have back issues and I can do almost everything in her classes. She is sweet, calm and I always feel better on the way out!!, review rate star is 5
4.I’ve been taking classes with Ellen for 5 years now and still feel challenged by her every.single.time! She’s knowledgeable and detailed in her instruction. She finds {safe} ways to push us to try new things and get stronger every class!, review rate star is 4
5.I’ve been going to Club Pilates for 3 months. It is such a wonderful experience. Amy Liscomb and Maggie Hillhouse make each class fun, engaging, and physically challenging in the best way. I look forward to each day I have Pilates on my calendar!, review rate star is 4
6.Kenyele energy always picks me up and inspires me to work harder. Her enthusiasm is contagious and her workouts build on previous while always being varied. Great workouts, look forward to each session, thanks!, review rate star is 4
7.Ellen is absolutely the best!!! She challenges every client regardless of the class level. I personally appreciate that she is constantly watching form to prevent injury yet maximize results. Her enthusiasm is contagious!, review rate star is 5
8.Club Pilates is by far one of the best things I’ve done for myself I’m my adult life! The instructors are so great. I really love Maggie!, review rate star is 4
9.I ve been searching to incorporate a fitness activity into my daily routine for a while. I tried all of the high intensity workouts that I loved in my teens and 20s, but none of them felt right. I thought to try something different with Club Pilates, and honestly, I didn t know I needed this in my life until I tried it. Got hooked from day 1. I feel stronger, more balanced, and I even feel mentally refreshed after each class. It s a great way to reset your body after being in front of the computer for long periods of time. All the instructors are amazing! Definitely recommend. review rate star is 5
10.I always look forward to my classes at club Pilates. All of the instructors are knowledgeable, supportive, and make exercise fun!, review rate star is 5.';

            /** @var array $response */
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY')
            ])->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-4",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $query
                    ]
                ],
                "temperature" => 1,
                "max_tokens" => 2048
            ])->json();

            dd($response['choices'][0]['message']['content']);
        } catch (Throwable $e) {
            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
        }
    }
}
