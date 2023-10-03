<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use App\Models\City;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function aboutUs()
    {
        $cities = City::all();
        $city = null;
        return view('about-us', compact('cities', 'city'));
    }

    public function privacy()
    {
        $cities = City::all();
        $city = null;
        return view('privacy', compact('cities', 'city'));
    }

    public function termsConditions()
    {
        $cities = City::all();
        $city = null;
        return view('terms-conditions', compact('cities', 'city'));
    }

    public function contactUs()
    {
        $cities = City::all();
        $city = null;
        return view('contact', compact('cities', 'city'));
    }

    public function contactStore(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        try {
            Mail::to(env('SUPPORT_MAIL_ADDRESS'))->send(new ContactUsMail($contact));
        } catch (\Exception $e) {
            alert()->error('error', 'Something went wrong. Please try again later.');
            return redirect()->back();
        }

        alert()->success('success', 'Your message has been sent successfully.');

        return redirect()->back();
    }
}
