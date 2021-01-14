<?php

namespace App\GenerateUrlRequest;

use Goutte\Client;
use App\Models\Source;
use App\Traits\ValidateUrl;

class GenerateUrlRequestOlxBg implements GenerateUrlRequest {

	use ValidateUrl;

	/**
    * The source 
    *
    * @var source;
    */
	private $source;

	/**
    * The links 
    *
    * @var links;
    */
	private $links;

	public function __construct(Source $source){
		$this->source = $source;
		$this->links = collect([]);
	}

	/**
    * Analyze html
    * Use Goutte to fetch url and analyze
    *
    * @return void;
    */
	public function analyze(){


		return;

		$client = new Client();

		$crawler = $client->request('GET', $this->source->base_url . '';

		$crawler->filter(".listAdv > .box > a")->each(function($node){
			$this->links->push($node->attr('href'));
		});

		// Filter valid urls
		$this->links = $this->links->map(function($url, $key){
			return $this->validateUrl($url, $this->source->base_url);
		})->unique();
	}

	/**
    * The url 
    *
    * @return Illuminate\Support\Collection;;
    */
	public function getResult(){
		return $this->links;
	}

}