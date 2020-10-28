<?php

namespace App\GenerateUrlRequest;

interface GenerateUrlRequest {

	public function analyze();

	public function getResult();

}