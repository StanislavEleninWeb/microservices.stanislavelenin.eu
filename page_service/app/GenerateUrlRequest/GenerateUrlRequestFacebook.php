<?php

namespace App\GenerateUrlRequest;

use App\Models\Source;
use App\Traits\ValidateUrl;

use Spatie\Browsershot\Browsershot;
use \DOMDocument;
use \DOMXpath;

class GenerateUrlRequestFacebook implements GenerateUrlRequest {

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
     * Analyze content
     *
     * @return void
     */
    public function crawl(){

        // Facebook Market url address
        $url = $this->source->base_url . 'marketplace/110234925673168/propertyforsale?minPrice=80000&daysSinceListed=1&sortBy=creation_time_descend';

        // $url = $this->source->base_url . 'marketplace/110234925673168/search?minPrice=100000&daysSinceListed=1&sortBy=creation_time_descend&query=%D0%B0%D0%BF%D0%B0%D1%80%D1%82%D0%B0%D0%BC%D0%B5%D0%BD%D1%82&exact=false';

        if(filter_var($url, FILTER_VALIDATE_URL))
            return Browsershot::url($url)
            ->waitUntilNetworkIdle(false)
            ->device('iPhone X')
            ->bodyHtml();
        else
            throw new \Exception('Url not valid : ' . $url);
    }

	/**
    * Analyze html
    * Use Goutte to fetch url and analyze
    *
    * @return void;
    */
	public function analyze(){		

        // $this->crawl();
        // die;

        // Create dom element
        $dom = new DOMDocument();

        // Set error handling
        libxml_use_internal_errors (true);

        // Load curl response as html
        $dom->loadHTML(mb_convert_encoding($this->crawl(), 'HTML-ENTITIES', "UTF-8"));

        // Create xpath element
        $xpath = new DOMXpath($dom);

        // Xpath Qyery to fetch a href 
        $array_node = $xpath->query('//div[contains(@class, "bq4bzpyk")]//a//@href');

        foreach($array_node as $node){
            $this->links->push($node->nodeValue);
        }

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