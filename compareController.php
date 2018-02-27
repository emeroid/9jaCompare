<?php

namespace App\Http\Controllers;
use App\Compare;
use Illuminate\Http\Request;
use Goutte\Client;

class compareController extends Controller
{
	//@var $base_url 
	//@var $input_first 
	//@var $input_sec

	public function __construct(){


	$db = Compare::all();
    $base_urls = db->urls;
    $input = array('left'=> request()->word1, 'right'=> request()->word2);
    $selectors = array('contents'=>array('links'=>$db->link,
    								'images'=>$db->img,
    								'names'=>$db->name,
                                    'brands'=>$db->brand
									'prices'=>$db->price),
    					'category'=>array('cate_link'=>$db->cate_link,
    								'cate_name'=>$db->cate_name,
    								'cate_label'=>$db->cate_label,
    								'cate_total'=>$db->cate_total),
    					'compared'=>array('img'=>$db->img,
    								'spec'=>$db->spec,
    								'desc'=>$db->desc,
    								'more'=>$db->more));


	}

    
	//@return $base_url


	public function getUrls()

	{
		return this->$base_urls;
	}
	
	/* Used to get Goutte Client for scrapping 
    */
	// @void 

	public function client()
	{

	
		$client = new Client();
		$guzzleclient = new \GuzzleHttp\Client([
    	'timeout' => 90,
    	'verify' => false,
		]);
		//  Hackery to allow HTTPS
		//===============================================
		//connection to database include file
		$client->setClient($guzzleclient);
		return $client;
	}

    /* Use this method to get base url and merge the url with user input
    */
    //@return $input

    public function getMergedUrl()
    {
    	$url_val = array();
    	//$inputs = this->$input;
    	foreach ($this->$base_urls as $k => $v) {
    	
    		foreach (this->$input as $key => $value) {
    			
    				$url_val[$k][$key] = $v.str_replace(' ','+',$value).'/';
		
				}

		}
			return $url_val;
    }
    

    /* Use this method to scrap and get lists of contents from  
		web address.
    */

    //@return $da

    public function getContents()
    {

    $urls = this->getMergedUrl();

    $client = this->client();

    $da = array();

    foreach ($urls as $k => $v) {

    $crawler = $client->request('GET', $v);
    	for($i = 0; $i < 10; $i++ ) {
    		foreach (this->$selectors['contents'] as $key => $value) {
    			
    			$count = $crawler->filter($value)->count();

    			if($count > 0)
    			{

				$da[$key]['url'] = $crawler->filter(this->$value['links'])->each(function ($urls) {
					//storing the scrapped data in an array
   				return $urls->attr('href');
					});
	
				$da[$key]['img'] = $crawler->filter(this->$value['images'])->each(function ($urls) {
					//storing the scrapped data in an array
   				return $urls->attr('src');
					});
	
				$da[$key]['brand'] = $crawler->filter(this->$value['brands'])->each(function ($urls) {
					//storing the scrapped data in an array
   				return $urls->text();
				});
	
				$da[$key]['name'] = $crawler->filter(this->$value['names'])->each(function ($urls) {
					//storing the scrapped data in an array
   				return $urls->text();
				});
	
				$da[$key]['price'] = $crawler->filter(this->$value['prices'])->each(function ($urls) {
					//storing the scrapped data in an array
   				return $urls->text();
				});
				
				}
				else {Error Scrapping Data! No such Inputed data was found.}
			}
		}
	}
		
	return $da;

  }


    /* Use this method to scrap and get two contents for  
		comparism. Which contains images, specification, descriptions,
		price and more information about the product
    */

    //@return $da

    publc function getComparisms()
    {

    $items = getContents();
	$client = this->client();

    $da = array();

    foreach ($items['links'] as $k => $v) {

    $crawler = $client->request('GET', $v);

    for($i = 0; $i < 2; $i++ ) {

    		foreach ($selectors['category'] as $key => $value) {
    			
    			$count = $crawler->filter($value)->count();

    			if($count > 0)
    			{
	
	$da['img'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->attr('data-src');
	});
	
	$da['spec'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->html();
	});
	
	$da['desc'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->html();
	});
	
	$da['more'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->html();
	});
			
					}
				}
			}
		}

	return $da;
    }

    

    /* Use this method to scrap and get contents of category  
		from web address
    */

	//@return $cat

    public function getCategory($url)
    {

    $client = this->client();

    $cat = array();

    foreach ($urls as $k => $v) {

    $crawler = $client->request('GET', $v);

    for($i = 0; $i < 10; $i++ ) {
    		foreach ($selectors as $key => $value) {
    			
    			$count = $crawler->filter($value)->count();

    			if($count > 0)
    			{

    $cat['cate_link'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->attr('href');
	});
	
	$cat['cate_label'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->text();
	});
	
	$cat['cate_name'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->text();
	});
	
	$cat['cate_total'] = $crawler->filter($value)->each(function ($urls) {
	//storing the scrapped data in an array
   	return $urls->text();
	});

					}
				}
			}
		}

	return $cat;

    }


    /* Used to display contents on the client web browser
    */
    //@return vals

    public function execContents($data)
    {

    	$counts = 0;
		$nums = 0;
		$vals = array();

    	foreach($data as $dz){
	
	 				$urz =  $dz['url'];
	 				$imz = $dz['img'];
	 				$brz = $dz['brand'];
	 				$naz = $dz['name'];
	 				$prz = $dz['price'];
	
		
		foreach($imz as $datz){
					$counts++;
				
				if($counts % 2 == 0 && $counts <= 20){
					$nums++;

					$vals['images'] = $datz;
					$vals['urls'] = $urz[$nums];
					$vals['brands'] = $brz[$nums];
					$vals['names'] = $naz[$nums];
					$vals['prices'] = $prz[$nums];
					}
    		}
    	}

    	return $vals;

  	}

	/* Used to display compared contents on the client web browser
    */
    //@return vals

  	public function execCompared($data)

  	{

  		$img = "";
		$desc = "";
		$spec = "";
		$mor = "";

		$vals = array(); 

		foreach($data as $d) 
			
		{

			$img = $d['img'];
			$desc = $d['desc'];
			$spec = $d['spec'];
			$mor = $d['more'];
				
			foreach($d as $k){
						
				$vals['images'] = $img;
				$vals['desc'] = $desc;
				$vals['spec'] = $spec;
				$vals['more'] = $mor;
					
			}
		}
		return $vals;
  	}


  	/* Used to display categories contents on the client web browser
    */
    //@return vals

  	public function execCategory($data)
  	{

  		$az = "";
		$bz = "";
		$cz = "";

		$cate = "";
		$cate_la = "";
		$cate_na = "";
		$cate_no = "";
		
		$vals = array();				
		
		foreach($data as $d){
		
//=============Category =================//
		$cate = $d['cate_link'];
		$cate_la = $d['cate_label'];
		$cate_na = $d['cate_name'];
		$cate_no = $d['cate_total'];

			for($x=0; $x < count($cate); $x++){
				$vals['cate'] = $cate[$x];
				$vals['cate_name'] = $cate_na[$x];
				$vals['cate_no'] = $cate_no[$x];
										
								 
				}
		}
		return $vals;
	}			
  	

	/* Used to remove unwanted scrapped category string from the client web browser
    */
    //@return vals

  	public function removeStrings($data)
  	{

  		for($x=0; $x < count($data['çate']); $x++){
						
				$index = array_search('Jumia Global',$data['cate_name']);
				//$index2 = array_search('Categories',$cate_na);
				if($index !== FALSE){
				array_splice($data['cate_name'], $index, 1);
    						
				}
  		}

  		return true;
	}
}
