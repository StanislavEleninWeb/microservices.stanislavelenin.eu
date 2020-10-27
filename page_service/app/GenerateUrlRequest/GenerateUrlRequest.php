<?php

namespace App\GenerateUrlRequest;

interface GenerateUrlRequest {

	public function crawl();

	public function analyze();

	public function getLinks();

}