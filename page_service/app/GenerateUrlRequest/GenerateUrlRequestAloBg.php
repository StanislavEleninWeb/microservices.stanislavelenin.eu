<?php

namespace App\GenerateUrlRequest;

use Spatie\Browsershot\Browsershot;
use App\Models\Source;

class GenerateUrlRequestAloBg implements GenerateUrlRequest {

	public function __construct(Source $source){

	}

	public function getHtml(){
		// Html
        $html = Browsershot::url($this->url)
        ->device('iPhone X')
        ->bodyHtml();

		return $html;
	}

}