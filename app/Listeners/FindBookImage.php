<?php

namespace App\Listeners;

use App\Events\NewBookInserted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FindBookImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewBookInserted  $event
     * @return void
     */
    public function handle(NewBookInserted $event)
    {

        $string = $event->book->title .' '. $event->book->author . ' libro';
        $url = 'https://customsearch.googleapis.com/customsearch/v1?key=AIzaSyB9sWOIWJXF8lsFA2yUsrI72wynkXt8VbE&cx=009864086180255169656%3Abislxiibo84&q='.$string.'&searchType=image&num=10';
        //dd($url) ;

    }
}
