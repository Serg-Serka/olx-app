<?php

namespace App\Services;

use App\Models\Advert;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OlxAdvertService
{

    public function getAdvertByUrl($url, $data = []): Advert
    {
        try {
            $advert = Advert::where('url', $url)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
                $advert = new Advert();
                $advert->url = $url;
                $advert->price = $data['value'];
                $advert->currency = $data['currency'];
                $advert->save();
        }

        return $advert;
    }

    public function mapOlxUrl($url): array
    {
        if (str_contains($url, 'olx.ua')) {
            $html = file_get_contents($url);
            if (preg_match("/<h3 class=\"css-12vqlj3\">(.*)<\/h3>/", $html, $matches)) {
                $priceString = substr($matches[0], 24);
                preg_match("/\d*/", str_replace(' ', '', $priceString), $priceStringMatches);
                $priceValue = $priceStringMatches[0];
                $priceCurrency = substr($priceString, -6, 1) === '$' ? 'us' : 'ua';
                return ['status' => 'success', 'value' => $priceValue, 'currency' => $priceCurrency];
            } else {
                return ['status' => 'failed', 'message' => 'Something went wrong when parsing olx page'];
            }
        } else {
            return ['status' => 'failed', 'message' => 'Seems like the provided url is not an olx page'];
        }
    }

    public function getSubscriberByEmail($email): Subscriber
    {
        try {
            $subscriber = Subscriber::where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            $subscriber = new Subscriber();
            $subscriber->email = $email;
            $subscriber->email_verified = false;

            $subscriber->save();
        }

        return $subscriber;
    }

    public function subscribe($advert, $subscriber): array
    {
        $subscriptions = $subscriber->adverts()->get();

        foreach ($subscriptions as $subscription) {
            if ($subscription['pivot']->advert_id === $advert->id) {
                return ['message' => 'The subscription already exist!', 'success' => false];
            }
        }

        $subscriber->adverts()->attach($advert->id);
        return ['message' => 'Successfully created a subscription!', 'success' => true];
    }

}
