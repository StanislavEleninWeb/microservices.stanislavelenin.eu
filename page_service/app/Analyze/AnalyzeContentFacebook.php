<?php

namespace App\Analyze;

use Spatie\Browsershot\Browsershot;
use \DOMXpath;

class AnalyzeContentFacebook extends AnalyzeContent {

    private $tableKeyWithValue = [
        'Цена:' => 'price',
        'Местоположение:' => 'city',
        'Вид на имота:' => 'type',
        'Квадратура:' => 'space',
        'Вид строителство:' => 'buildType',
        'Година на строителство:' => '',
        'Номер на етажа:' => 'floor',
        'Особености:' => 'keywords',
    ];

    /**
     * Analyze content
     *
     * @return void
     */
    public function crawl(){

        if(filter_var($this->url, FILTER_VALIDATE_URL))
            return Browsershot::url($this->url)
            ->waitUntilNetworkIdle(false)
            ->device('iPhone X')
            ->bodyHtml();
        else
            throw new \Exception('Url not valid : ' . $this->url);
    }
	
    /**
     * Analyze content
     *
     * @return array
     */
	public function analyze(){
        
        // Load curl response as html
        $this->dom->loadHTML(mb_convert_encoding($this->crawl(), 'HTML-ENTITIES', "UTF-8"));

        // Create xpath element
        $this->xpath = new DOMXpath($this->dom);

        // //----------------------------------------------------------------
        // // Title
        // //----------------------------------------------------------------
        // $this->setTitle($this->xpath->query('//div[contains(@class, "big-info")]//h1')[0]->nodeValue);

        // //----------------------------------------------------------------
        // // Table
        // //----------------------------------------------------------------
        // $table = $this->xpath->query('//div[contains(@class, "ads-params-table")]//div[contains(@class, "ads-params-row")]');

        // foreach($table as $table_node){
        //     $row_node = $this->xpath->query('div', $table_node);
        //     $key = $this->matchTableKeyWithValue($row_node[0]->nodeValue);

        //     $key_arr[] = $key;

        //     if(isset($key)){
        //         $method = 'set'. ucfirst($key);
        //         if(method_exists($this, $method))
        //             call_user_func([$this, $method], $row_node[1]->nodeValue);
        //     }
        // }

        // //----------------------------------------------------------------
        // // Content
        // //----------------------------------------------------------------
        // $this->setContent($this->xpath->query('//div[@class="more-info"]//p')[0]->nodeValue);

        // //----------------------------------------------------------------
        // // Contacts
        // //----------------------------------------------------------------
        // $this->setContactPhone($this->xpath->query('//div[@class="contacts_wrapper"]//div[@class="contact_row"]//a//@href'));

        //----------------------------------------------------------------
        // Images
        //----------------------------------------------------------------
        $this->setImages($this->xpath->query('//div[contains(@class, "bp9cbjyn")]//img//@src'));

	}

    protected function setTitle($title){
        $title = trim(strip_tags($title));
        $this->title = filter_var($title, FILTER_SANITIZE_STRING);
    }

    protected function setType($type){
        $type = trim(strip_tags($type));
        $this->type = filter_var($type, FILTER_SANITIZE_STRING);
    }

    protected function setPrice($price){
        $price = filter_var(trim($price), FILTER_SANITIZE_STRING);

        // Currency   
        preg_match('/[A-Z]{2,3}/', $price, $matches_currency);
        $this->setCurrency($matches_currency[0]);

        // Split string by currency
        $split = explode($matches_currency[0], $price);

        $this->price = filter_var($split[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->setPricePerSquare($split[1]);
    }

    protected function setPricePerSquare($pricePerSquare){
        $this->pricePerSquare = filter_var($pricePerSquare, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    protected function setCurrency($currency){
        $this->currency = filter_var(trim($currency), FILTER_SANITIZE_STRING);
    }

    protected function setSpace($space){
        preg_match('/^[\d]*/', $space, $matches_space);
        $this->space = filter_var($matches_space[0], FILTER_SANITIZE_NUMBER_INT);
    }

    protected function setCity($city){
        $city = explode(',', $city);

        $this->city = filter_var(trim($city[1], FILTER_SANITIZE_STRING));
        $this->setRegion($city[0]);
    }

    protected function setRegion($region){
        $this->region = filter_var(trim($region), FILTER_SANITIZE_STRING);
    }

    protected function setBuildType($buildType){
        $this->buildType = filter_var(trim($buildType), FILTER_SANITIZE_STRING);
    }

    protected function setFloor($floor){
        preg_match('/^[\d]*/', $floor, $matches_floor);
        $this->floor = filter_var($matches_floor[0], FILTER_SANITIZE_NUMBER_INT);
    }

    protected function setKeywords($keywords){
        $this->keywords = explode(' ', trim($keywords));
    }

    protected function setContent($content){
        $this->content = filter_var(trim($content), FILTER_SANITIZE_STRING);
    }

    protected function setContactPhone($phone){
        foreach($phone as $node){
            $this->phone[] = filter_var($node->nodeValue, FILTER_SANITIZE_NUMBER_INT);
        }
    }

    protected function setContactEmail($email){

    }

    protected function setContactName($name){

    }

    protected function setImages($images){
        foreach($images as $node){
            $this->images[] = $this->validateUrl($node->nodeValue, $this->url, true);
        }
    }

    /**
     * Analyze content
     *
     * @param string
     * @return string
     */
    public function matchTableKeyWithValue($key){
        $key = filter_var(trim($key), FILTER_SANITIZE_STRING);

        return isset($this->tableKeyWithValue[$key]) ? $this->tableKeyWithValue[$key] : null;
    }
}