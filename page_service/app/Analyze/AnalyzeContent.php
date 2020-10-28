<?php

namespace App\Analyze;

use \DOMDocument;
use App\Traits\ValidateUrl;

abstract class AnalyzeContent {

	use ValidateUrl;

	protected $url;

	protected $dom;

	protected $xpath;

	protected $title;

	protected $type;

	protected $price;

	protected $pricePerSquare;

	protected $currency;

	protected $space;

	protected $city;

	protected $region;

	protected $buildType;

	protected $floor;

	protected $keywords;

	protected $content;

	protected $contact_phone;

	protected $contact_email;

	protected $contact_name;

	protected $images;

	/**
     * Constructor
     *
     * @return void
     */
	public function __construct($url){

        $this->url = $url;

        // Create dom element
        $this->dom = new DOMDocument();

        // Set error handling
        libxml_use_internal_errors (true);

	}

	/**
	|-----------------------------------------------------------
	| Public methods
	|-------------------------------------------------------------
	*/

	abstract public function analyze();

	/**
	|-----------------------------------------------------------
	| Setters
	|-------------------------------------------------------------
	*/
	abstract protected function crawl();

	abstract protected function setTitle($title);

	abstract protected function setType($type);

	abstract protected function setPrice($price);

	abstract protected function setPricePerSquare($pricePerSquare);

	abstract protected function setCurrency($currency);

	abstract protected function setSpace($space);

	abstract protected function setCity($city);

	abstract protected function setRegion($region);

	abstract protected function setBuildType($buildType);

	abstract protected function setFloor($floor);

	abstract protected function setKeywords($keywords);

	abstract protected function setContent($content);

	abstract protected function setContactPhone($phone);

	abstract protected function setContactEmail($email);

	abstract protected function setContactName($name);

	abstract protected function setImages($images);

	/**
     * Return analyzed content
     *
     * @return array
     */
    public function getResult(){
        return get_object_vars($this);
    }

}