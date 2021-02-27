<?php
namespace App\Controllers;

/*

All comments of controller it's in BaseController
If you need any help, contact the author


Controller only for redirect use
*/

class Home extends BaseController
{
	public $data = array();
	public $session;
	public $parser;
	public $module_name = 'Home';
	
	public function index($offset = 0)
	{
		rdct('/especializacao/listar');
	}
}
