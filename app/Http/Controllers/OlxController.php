<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use App\Models\Subscriber;

class OlxController extends Controller
{
    public function subscribeForm(): Response
    {
        return Inertia::render('Olx/SubscribeForm');
    }

    public function subscribe(Request $request)
    {
        $email = $request->get('email');
        $url = $request->get('url');

        $success = false;
        $subscriber = Subscriber::firstWhere('email', $email);
        $advert = Advert::firstWhere('url', $url);


        if (!$subscriber) {

        }

        if (!$advert) {

        }


        return response()->json(['success' => $success]);
    }
}
