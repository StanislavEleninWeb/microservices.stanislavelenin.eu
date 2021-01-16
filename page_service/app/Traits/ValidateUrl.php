<?php

namespace App\Traits;

trait ValidateUrl {

	public function validateUrl(string $url, string $source_url, $query = false){

		$parse_url = parse_url($url);
		$parse_source_url = parse_url($source_url);

		if(!isset($parse_url['scheme'])){
			$parse_url['scheme'] = $parse_source_url['scheme'];
		}

		if(!isset($parse_url['host'])){
			$parse_url['host'] = $parse_source_url['host'];
			$parse_url['path'] = str_replace($parse_source_url['host'], '', $parse_url['path']);
		}

		if($query){
			$parse_url['query'] = '?' . trim($parse_url['query']);
		} else {
			$parse_url['query'] = '';
		}

		$new_url = $parse_url['scheme'] . '://' . $parse_url['host'] . '/' . trim($parse_url['path'], '/') . $parse_url['query'];


		return $new_url;

	}

}