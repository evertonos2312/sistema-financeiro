<?php

namespace App\Libraries;

class Windup {
	
	private $cl; //CurlClass instance
	
	public $client_id = '';
	private $cfg;
	public function __construct()
	{
		$this->cfg = new \Config\Windup();
		$this->cl = new Sys\CurlLib();
		$this->cl->base_url = $this->cfg->url;
	}
	
	public function login()
	{
		$result = $this->cl->call('post', null, 'login.php?cliid='.$this->client_id);
		
		if($result['status']){
			$decoded = $this->xmlToArray($result['response']['body']);
			return $decoded['cliente']['@attributes'];
		}
		return false;
	}
	
	public function xmlToArray($string)
	{
		$xml = simplexml_load_string($string);
		$json = json_encode($xml);
		return json_decode($json,TRUE);
	}
	
	public function checkInadimplente($cliente)
	{
		return (
		$cliente['INADIMPLENTE'] >= '2'
		||
		$cliente['DESISTENTE'] == 'T'
		)
		||
		(
		$cliente['INADIMPLENTE'] == '1'
		&&
		date('j') <= '15'
		);
	}
}