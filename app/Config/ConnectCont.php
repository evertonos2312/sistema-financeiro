<?php namespace Config;

class ConnectCont extends \CodeIgniter\Config\BaseConfig
{
	/* DEFAULT DEVELOPMENT */
	public $client_id = '0';
	public $grant_type = 'password';
	public $client_secret = '59b3d28c-df8b-4904-a16f-0f5a337e1263';
	public $client_comuns = '99994';
	public $url = 'http://sistemas:8089/v2/';
	public $urlPainel = 'http://sistemas:9280/painel/v1/';
	public $urlWindup = 'http://desenvolvimento:8091/';
}