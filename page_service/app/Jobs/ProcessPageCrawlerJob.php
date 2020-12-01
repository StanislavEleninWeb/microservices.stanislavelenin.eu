<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Events\PageCreatedEvent;

use App\Models\Source;
use App\Models\Page;
use App\Models\PageInfo;
use App\Models\BuildingType;
use App\Models\BuildType;
use App\Models\Currency;
use App\Models\Region;

class ProcessPageCrawlerJob extends Job
{
    /**
    * The url address 
    *
    * @var url;
    */
    protected $url;

    /**
    * The source 
    *
    * @var source;
    */
    protected $source;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, Source $source)
    {
        $this->url = $url;
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Validate url and check if unique
        $page_validator = Validator::make(get_object_vars($this), [
            'url' => 'required|url|unique:pages',
        ]);


        if ($page_validator->fails()) {

            if(isset($page_validator->failed()['url']['Unique']))
                return;

            throw new Exception($page_validator->errors()->first(), 1);
        }

        //Generate source url get/post http request
        $analyzer = new $this->source->analyze_content_class($this->url);

        $analyzer->analyze();

        $results = $analyzer->getResult();

        $page_info_validator = Validator::make($results, [
            'title' => 'required|string',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'pricePerSquare' => 'required|numeric',
            'currency' => 'required|string',
            'space' => 'required|numeric',
            'city' => 'required|string',
            'region' => 'required|string',
            'buildType' => 'required|string',
            'floor' => 'required|numeric',
            'keywords.*' => 'nullable|string',
            'content' => 'required|string',
        ])->validate();

        $page_id = DB::transaction(function() use ($page_validator, $page_info_validator){
            // Page Model
            $page = new Page;
            $page->url = $page_validator['url'];
            $page->source_id = $this->source->id;
            $page->save();

            // Page Info Model
            $page_info = new PageInfo;
            $page_info->page()->associate($page);
            $page_info->title = $page_info_validator['title'];
            $page_info->buildingType()->associate(BuildingType::where('title', $page_info_validator['type'])->orWhere('keywords', 'like', '%' . $page_info_validator['type'] . '%')->firstOrFail());
            $page_info->buildType()->associate(BuildType::where('title', $page_info_validator['buildType'])->orWhere('keywords', 'like', '%' . $page_info_validator['buildType'] . '%')->firstOrFail());
            $page_info->currency()->associate(Currency::where('title', $page_info_validator['currency'])->orWhere('slug', $page_info_validator['currency'])->orWhere('keywords', 'like', '%' . $page_info_validator['currency'] . '%')->firstOrFail());
            $page_info->price = $page_info_validator['price'];
            $page_info->price_per_square = $page_info_validator['pricePerSquare'];
            $page_info->space = $page_info_validator['space'];
            $page_info->region_id = '1';
            $page_info->floor = $page_info_validator['floor'];
            $page_info->keywords = implode(', ', $page_info_validator['keywords']);
            $page_info->content = $page_info_validator['content'];
            $page_info->save();

            return $page->id;
        });

        // Send post http request and process image urls
        Http::post(env('IMAGE_SERVICE_URL') . '/images', [
            'page' => $page_id,
            'images' => $results['images'],
        ]);

        event(new PageCreatedEvent($page_id));        
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Http::post(env('NOTIFICATION_SERVICE_URL') . '/notify/admin', [
            'url' => $this->url,
            'object' => $this->source,
            'exception' => $exception,
        ]);
    }
}
