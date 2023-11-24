<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscriberStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribes',
        ]);

        $subscribe = new Subscribe();
        $subscribe->email = $request->email;
        $subscribe->save();

        return redirect()->back()->with('success', 'Thank you for subscribing!');
    }
}
