<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\OlxAdvertService;

class OlxController extends Controller
{
    protected OlxAdvertService $olxService;

    public function __construct(OlxAdvertService $olxService)
    {
        $this->olxService = $olxService;
    }

    public function subscribeForm(): Response
    {
        return Inertia::render('Olx/SubscribeForm');
    }

    public function subscribe(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $url = $request->get('url');

        $success = false;
        $advertData = $this->olxService->mapOlxUrl($url);

        if ($advertData['status'] !== 'success') {
            $message = $advertData['message'];
        } else {
            $advert = $this->olxService->getAdvertByUrl($url, $advertData);
            $subscriber = $this->olxService->getSubscriberByEmail($email);

            $result = $this->olxService->subscribe($advert, $subscriber);
            $message = $result['message'];
            $success = $result['success'];
        }

        return response()->json(['success' => $success, 'message' => $message]);
    }
}
