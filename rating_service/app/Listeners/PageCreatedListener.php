<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Events\PageCreatedEvent as Event;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageCreatedListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ExampleEvent  $event
     * @return void
     */
    public function handle(Event $event)
    {
        $response = Http::post(env('PAGE_SERVICE_URL') . '/pages/last/quarter/rating', [
            'city_id' => $event->page['city_id'],
        ]);

        if($response->failed())
            throw new \Exception("Error Processing Request. Http Request Failed", 403);
        
        // Fetch response json 
        $array = $response->json();

        $price = $this->rate($array['price'], $event->page['price']);
        $price_per_square = $this->rate($array['price_per_square'], $event->page['price_per_square']);
        $space = $this->rate($array['space'], $event->page['space']);

        DB::table('rating')->insert([
            'page_id' => $event->page['page_id'],
            'avg' => ($price + $price_per_square + $space)/3,
            'price' => $price,
            'price_per_square' => $price_per_square,
            'space' => $space,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }

    public function rate($array, $value) {
        $rating = 0;

        if($value <= $array['min'])
            return 10;

        if($value >= $array['max'])
            return 0;

        if($value <= $array['avg']){
            $rate_per_point = ($array['avg'] - $array['min'])/5;
            $rating = 10 - ($value - $array['min'])/$rate_per_point;
        } else {
            $rate_per_point = ($array['max'] - $array['avg'])/5;
            $rating = ($array['max'] - $value)/$rate_per_point;
        }

        return $rating;
    }

}
