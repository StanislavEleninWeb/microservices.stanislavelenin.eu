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

		$client = new Client();

		$crawler = $client->request('GET', $this->source->base_url . '/bg/adv/act:sell/keywords:/oblast:plovdiv/cities:2982/price_from:/price_to:/currency:EUR/area_from:/area_to:/pic:all/options:YTowOnt9/types:YTo2OntpOjA7czoxMzoiMDgzM2JiMWI4OTNiNyI7aToxO3M6MTM6IjI4YTgyODM0NzUyY2MiO2k6MjtzOjEzOiI0MzZhZGYzYWEzNDNmIjtpOjM7czoxMzoiOTY5Y2I2NTZiNjdmZSI7aTo0O3M6MTM6IjllNTA5YmQwMWUxYjIiO2k6NTtzOjEzOiIxZDEyYmRkNzQwNmIyIjt9/quarters:YTowOnt9');

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