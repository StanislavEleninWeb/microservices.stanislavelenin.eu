<?php

namespace App\Analyze;

use Spatie\Browsershot\Browsershot;
use \DOMXpath;

class AnalyzeContentBazarBg extends AnalyzeContent {

    private $tableKeyWithValue = [
        'Тип сделка' => 'city',
        'Тип апартамент' => 'type',
        'Квадратура' => 'space',
        'Вид строителство' => 'buildType',
        'Eтаж' => 'floor',
        'Година' => 'year',
    ];

    /**
     * Analyze content
     *
     * @return void
     */
    public function crawl(){

        if(filter_var($this->url, FILTER_VALIDATE_URL))
            return Browsershot::url($this->url)
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

        //----------------------------------------------------------------
        // Title
        //----------------------------------------------------------------
        $this->setTitle($this->xpath->query('//h1[@class="adName"]')[0]->nodeValue);

        //----------------------------------------------------------------
        // Table
        //----------------------------------------------------------------
        $table = $this->xpath->query('//div[contains(@class, "adParameters")]//div[contains(@class, "productInfo")]');

        foreach($table as $table_node){
            $row_node = $this->xpath->query('div', $table_node);
            $key = $this->matchTableKeyWithValue($row_node[0]->nodeValue);

            $key_arr[] = $key;

            if(isset($key)){
                $method = 'set'. ucfirst($key);
                if(method_exists($this, $method))
                    call_user_func([$this, $method], $row_node[1]->nodeValue);
            }
        }

        //----------------------------------------------------------------
        // Price
        //----------------------------------------------------------------
        $this->setPrice($this->xpath->query('//div[@class="adPrice"]//span[@class="price"]')[0]->nodeValue);

        //----------------------------------------------------------------
        // Content
        //----------------------------------------------------------------
        $this->setContent($this->xpath->query('//div[contains(@class, "text")]')[0]->nodeValue);

        //----------------------------------------------------------------
        // Images
        //----------------------------------------------------------------
        $this->setImages($this->xpath->query('//div[@class="bObiavaItem"]//img//@src'));

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
        $this->price = filter_var(trim($price), FILTER_SANITIZE_NUMBER_FLOAT);

        // Currency   
        preg_match('/\D+$/', $price, $matches_currency);
        $this->setCurrency($matches_currency[0]);

        if(isset($this->space) && isset($this->price))
            $this->setPricePerSquare(round(($this->price/$this->space), 2));
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
        preg_match_all('/\S+/', $city, $matches_city);
        $city = $matches_city[0][count($matches_city[0]) - 1];

        $this->city = filter_var(trim($city, FILTER_SANITIZE_STRING));
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

    }

    protected function setContactEmail($email){

    }

    protected function setContactName($name){

    }

    protected function setImages($images){
        foreach($images as $node){
            $this->images[] = $this->validateUrl($node->nodeValue, $this->url);
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