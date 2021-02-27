<?php
namespace App\Controllers\Admin;

/**
BASE Controller
AUTHOR: LUIS HENRIQUE MINORU SATSUMA
LAST UPDATE: 13/09/2020
 */

use CodeIgniter\Controller;

class AdminBaseController extends \App\Controllers\BaseController
{
	public $template_file = 'template_admin';
	public $access_cfg = array(
		'needs_login' => true, //For access all pages, needs to be logged in
		'admin_only' => true,
		'role_access' => array(), //ToDo, Access with roles
	);
	
	public $pager_cfg = array(
		'per_page' => 20,
		'segment' => 4,
		'template' => 'template_basic',
	);
	
	public function SetMdl()
	{
		//Let's call for MDL (model) for short code in Controllers
		$namespace_call = '\\App\\Models\\Admin\\'.$this->module_name.'\\'.$this->module_name.'model';
		$this->mdl = new $namespace_call();
	}
	
	public function CheckSysAccess()
	{
		$HasAccess = $this->sysLib->CheckSession();
		if($this->access_cfg['needs_login']){
			if(!$HasAccess){
				//User has no session, check for url login
				if(!isset($this->uri[1]) || $this->uri[1] !== 'login'){
					$this->session->setFlashdata('rdct_url', urlencode(current_url()));
					rdct('/admin/login');
				}
			}
		}
		if($this->access_cfg['admin_only'] && $HasAccess){
			$HasAccessAdmin = $this->sysLib->CheckAccessAdmin();
			if(!$HasAccessAdmin){
				header('HTTP/1.0 403 Forbbiden');
				echo '<p>Acesso Negado!</p>';
				echo '<p><a href="'.base_url().'/admin">Voltar para Página Inicial</a></p>';
				exit;
			}
		}
	}
}
