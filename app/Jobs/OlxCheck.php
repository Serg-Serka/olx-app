<?php

namespace App\Jobs;

use App\Mail\OlxMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Advert;
use App\Services\OlxAdvertService;
use Illuminate\Support\Facades\Mail;

class OlxCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(OlxAdvertService $olxAdvertService): void
    {
        $adverts = Advert::all();

        foreach ($adverts as $advert) {
            $oldPrice = $advert->price;
            $newData = $olxAdvertService->mapOlxUrl($advert->url);

            if ($newData['status'] === 'success' && $newData['value'] != $oldPrice) {
                $subscribers = $advert->subscribers()->get();
                foreach ($subscribers as $subscriber) {
                    Mail::to($subscriber->email)->send(new OlxMail($advert->url, $newData['value']));
                }

                $advert->price = $newData['value'];
                $advert->save();
            }
        }
    }
}
