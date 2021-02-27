<?php
namespace App\Libraries;

class GoogleURL {
	
	private $cfg;
	
	function __construct()
	{
		$this->cfg = new \Config\GoogleURL();
		$this->cl = new \App\Libraries\Sys\CurlLib();
		$this->cl->base_url = $this->cfg->url.'?key='.$this->cfg->key;
	}
	
    public function shortURL($url)
	{
		
        $data = array(
         "dynamicLinkInfo" => array(
            "domainUriPrefix" => "https://cursoscontmatic.page.link",
            "link" => $url
         )
        );
		
		
		$this->cl->SetHeader('Content-Type', 'application/json');
		$result = $this->cl->call('post', json_encode($data));
		
		if($result['status']){
			$decoded = json_decode($result['response']['body'], true);
			return $decoded['shortLink'];
		}
		return false;
    }
}