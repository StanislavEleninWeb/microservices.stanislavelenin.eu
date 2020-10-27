<?php

namespace App\Analyze;

interface AnalyzeContent {
	
	public function crawl();

	public function analyze();

	public function getAnalyzed();

}