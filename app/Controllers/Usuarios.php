<?php
namespace App\Controllers;

class Usuarios extends BaseController
{
	public $data = array();
	public $session;
	public $parser;
	public $module_name = 'Usuarios';
	public $pager_cfg = array(
		'per_page' => 12,
		'segment' => 3,
		'template' => 'template_basic',
	);
	
	public function index()
	{
		rdct('/usuarios/entrar');
	}
	
	public function login($offset = 0)
	{
		$this->mdl->select = 'id, nome';
        $this->mdl->where['nome'] = ['EQUAL', ''];
        $results = $this->mdl->search(1)[0];

		$this->data['title'] = 'Sem Titulo';
		$this->data['layout'] = $this->layout->GetAllFieldsDetails($results);

		return $this->display_template($this->view->setData($this->data)->view('pages/Usuarios/Login'));
	}

	public function checkLogin()
	{
		$this->PopulatePost();
		$this->mdl->select = 'id, email';
		$this->mdl->where['nome'] = ['EQUAL', ''];	


        // $saved = $this->mdl->saveRecord();

		echo '<pre>';
		print_r($this->mdl->f);
		echo '</pre>';
		die();
	}
}
