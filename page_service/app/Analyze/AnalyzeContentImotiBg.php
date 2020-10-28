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
    * The html 
    *
    * @var html;
    */
    protected $html;

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

        parent::__construct();

		$this->url = $url;

	}

    /**
     * Analyze content
     *
     * @return void
     */
    public function crawl(){

        if(filter_var($this->url, FILTER_VALIDATE_URL))
            $this->html = Browsershot::url($this->url)
            ->device('iPhone X')
            ->bodyHtml();
        else
            throw new \Exception('Url not valid : ' $this->url);
    }
	
    /**
     * Analyze content
     *
     * @return array
     */
	public function analyze(){

        $this->craw();
        
        // Load curl response as html
        $this->dom->loadHTML(mb_convert_encoding($this->html, 'HTML-ENTITIES', "UTF-8"));

        // Create xpath element
        $this->xpath = new DOMXpath($this->dom);

        $container = $this->xpath->query('//div[@class=""]');
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