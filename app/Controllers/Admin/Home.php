<?php
namespace App\Controllers\Admin;

/*

All comments of controller it's in BaseController
If you need any help, contact the author


Controller only for redirect use
*/

class Home extends AdminBaseController
{
	public $data = array();
	public $session;
	public $parser;
	public $module_name = 'Home';
	public $dummy_controller = true;
	
	public function index()
	{
		rdct('/admin/login');
	}
}
