<?php

namespace App\Analyze;

use Spatie\Browsershot\Browsershot;
use \DOMXpath;

class AnalyzeContentOlxBg extends AnalyzeContent {

    private $tableKeyWithValue = [
        'Цена на кв.м' => 'pricePerSquare',
        'Тип апартамент' => 'buildingType',
        'Квадратура' => 'space',
        'Строителство' => 'buildType',
        'Етаж' => 'floor',
        'Отопление' => 'keywords',
        'Обзавеждане' => 'keywords',
        'Особености' => 'keywords',
        'Година на строителство' => 'year',
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
        $this->setTitle($this->xpath->query('//p[@data-cy="offer_title"]')[0]->nodeValue);

        //----------------------------------------------------------------
        // Price and currency
        //----------------------------------------------------------------
        $this->setPrice($this->xpath->query('//div[@data-testid="ad-price-container"]//h3')[0]->nodeValue);

        // //----------------------------------------------------------------
        // // Price per square
        // //----------------------------------------------------------------
        // $this->setPricePerSquare($this->xpath->query('//div[contains(@class, "price_for_meter")]')[0]->nodeValue);

        // //----------------------------------------------------------------
        // // Currency
        // //----------------------------------------------------------------
        // $this->setCurrency($this->xpath->query('//div[contains(@class, "price_for_meter")]')[0]->nodeValue);

        // //----------------------------------------------------------------
        // // City and Region
        // //----------------------------------------------------------------
        // $this->setCity($this->xpath->query('//div[contains(@class, "place")]')[0]->nodeValue);

        //----------------------------------------------------------------
        // Table
        //----------------------------------------------------------------

        $table = $this->xpath->query('//div[@class="css-jsfayd"]//div[@class="css-17y17yd"]');

        foreach($table as $table_node){
            $row_node = $this->xpath->query('span', $table_node);

            $key = $this->matchTableKeyWithValue($row_node[0]->nodeValue);
            $key_arr[] = $key;

            if(isset($key)){
                $method = 'set'. ucfirst($key);
                if(method_exists($this, $method))
                    call_user_func([$this, $method], $row_node[1]->nodeValue);
            }
        }

        //----------------------------------------------------------------
        // Content
        //----------------------------------------------------------------
        $this->setContent($this->xpath->query('//div[@data-testid="textContainer"]')[0]->nodeValue);

        // // //----------------------------------------------------------------
        // // // Contacts
        // // //----------------------------------------------------------------
        // // $this->setContactPhone($this->xpath->query('//div[@class="contacts_wrapper"]//div[@class="contact_row"]//a//@href'));

        //----------------------------------------------------------------
        // Images
        //----------------------------------------------------------------
        $this->setImages($this->xpath->query('//ul[@id="descGallery"]//a//@href'));

    }

    protected function setTitle($title){
        $title = trim(strip_tags($title));
        $this->title = filter_var($title, FILTER_SANITIZE_STRING);

        // Try to set building type
        $this->setType($title);
    }

    protected function setType($type){
        $type = trim(strip_tags($type));
        $this->type = filter_var($type, FILTER_SANITIZE_STRING);
    }

    protected function setPrice($price){
        preg_match('/[\d.]+/', $price, $matches_price);

        $this->price = filter_var($matches_price[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $this->setCurrency($price);
    }

    protected function setPricePerSquare($pricePerSquare){
        preg_match('/[\d.]+/', $pricePerSquare, $matches_price_per_square);
        $this->pricePerSquare = filter_var($matches_price_per_square[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    protected function setCurrency($currency){
        preg_match('/\D+$/', $currency, $matches_currency);
        $this->currency = filter_var(trim($matches_currency[0]), FILTER_SANITIZE_STRING);
    }

    protected function setSpace($space){
        preg_match('/^[\d]*/', $space, $matches_space);
        $this->space = filter_var($matches_space[0], FILTER_SANITIZE_NUMBER_INT);
    }

    protected function setCity($city){
        $city = explode('/', $city);

        $this->city = filter_var(trim($city[0], FILTER_SANITIZE_STRING));
        $this->setRegion($city[count($city) - 1]);
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
        if(!isset($this->keywords))
            $this->keywords = [];
        array_push($this->keywords, filter_var(trim($keywords), FILTER_SANITIZE_STRING));
    }

    protected function setContent($content){
        $content = strip_tags(trim($content));
        $this->content = filter_var($content, FILTER_SANITIZE_STRING);
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