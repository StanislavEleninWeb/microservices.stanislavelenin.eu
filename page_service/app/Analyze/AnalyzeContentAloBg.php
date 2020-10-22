<?php

namespace App\Analyze;

use Goutte\Client;

class AnalyzeContentAloBg implements AnalyzeContent {

	protected $html;

    /**
     * Execute the job.
     *
     * @return void
     */
	public function __construct($html){
		$this->html = $html;
	}

	
    /**
     * Analyze content and return array 
     *
     * @return array
     */
	public function analyze(){

		$client = new Client($html);

		return $analyzed;

	}

}