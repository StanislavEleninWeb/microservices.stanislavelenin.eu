<?php

namespace App\Analyze;

use Goutte\Client;

class AnalyzeContentAloBg implements AnalyzeContent {

    /**
    * The url 
    *
    * @var source;
    */
	protected $url;

    /**
    * The analyzed content 
    *
    * @var source;
    */
    private $analyzed;

    /**
     * Execute the job.
     *
     * @return void
     */
	public function __construct($url){
		$this->url = $url;
	}

    /**
     * Analyze content and return array 
     *
     * @return array
     */
    public function crawl(){

    }
	
    /**
     * Analyze content
     *
     * @return array
     */
	public function analyze(){

		$client = new Client();

        $crawler = $client->request('GET', $this->url);

        // Get title
        $analyzed['title'] = $crawler->filter('.large-headline')->attr('text');

        $div = $crawler->filter('.ads-params-table > div')->each(function($node){

            $keyword = $node->filter('.ads-param-title')->text();
            dd($node->filter()->text());
            if($this->findKeywordValue($keyword))
                $this->analyzed[$this->findKeywordValue($keyword)] = $node->filter('.ads-param-cell')->text();
        });

        dd($this->analyzed);
        // Get price
        // $prc = $crawler->filter('.ads-params-price');

        // $this->analyzed['price'] = $prc->text();
        // $this->analyzed['currency'] = $prc->text();
        // $this->analyzed['price_per_square'] = floatval($prc->filter('.ads-params-price-sub')->text());
        // // $this->analyzed['city'] = $crawler->filter('');
        // // $this->analyzed['region'] = $crawler->filter('')->text();
        // $this->analyzed['content'] = $crawler->filter('.more-info')->text();

	}

    /**
     * Return analyzed content
     *
     * @return array
     */
    public function getAnalyzed(){
        return $this->analyzed;
    }

}