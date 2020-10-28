<?php

namespace App\Traits;

trait ValidateUrl {

	public function validateUrl($url, $source_url){

		$parse_url = parse_url($url);
		$parse_source_url = parse_url($source_url);

		if(!isset($parse_url['scheme'])){
			$parse_url['scheme'] = $parse_source_url['scheme'];
		}

		if(!isset($parse_url['host'])){
			$parse_url['host'] = $parse_source_url['host'];
			$parse_url['path'] = str_replace($parse_source_url['host'], '', $parse_url['path']);
		}

		$new_url = $parse_url['scheme'] . '://' . $parse_url['host'] . '/' . trim($parse_url['path'], '/');


		return $new_url;

	}

}