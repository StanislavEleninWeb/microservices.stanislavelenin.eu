<?php

namespace App\GenerateUrlRequest;

use Spatie\Browsershot\Browsershot;
use Goutte\Client;
use App\Models\Source;
use App\Traits\ValidateUrl;

class GenerateUrlRequestAloBg implements GenerateUrlRequest {

	use ValidateUrl;

	private $source;

	private $html;

	private $links;

	public function __construct(Source $source){
		$this->source = $source;
		$this->links = collect([]);
	}

	public function crawl(){
		return;
        $html = Browsershot::url($this->source->base_url . '/obiavi/imoti-prodajbi/apartamenti-stai/?region_id=16')
        ->device('iPhone X')
        ->bodyHtml();

		return $html;
	}

	public function analyze(){

		$client = new Client();

		$crawler = $client->request('GET', $this->source->base_url . '/obiavi/imoti-prodajbi/apartamenti-stai/?region_id=16');
		
		$crawler->filter(".listtop-image > a")->each(function($node){
			$this->links->push($node->attr('href'));
		});

		// Filter valid urls
		$this->links = $this->links->map(function($url, $key){
			return $this->validateUrl($url, $this->source->base_url);
		})->unique();
	}

	public function getLinks(){
		return $this->links;
	}

}