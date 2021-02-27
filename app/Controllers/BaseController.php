<?php
namespace App\Controllers;

/**
BASE Controller
AUTHOR: LUIS HENRIQUE MINORU SATSUMA
LAST UPDATE: 13/09/2020
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['Sys_helper'];
	
	/*
	@var array
	An array for pass data in view parser
	*/
	public $data;
	
	/*
	@var string
	String to store base_url of app, just in case
	*/
	public $base_url;
	
	/*
	@var array
	An array of filter
	*/
	public $filter = array();
	
	/*
	Session core service of CI
	*/
	public $session;
	
	/*
	@class of Smarty
	Smarty it's a TPL Engine for PHP
	Because the Parser of CI4 it's limited for functions and vars display
	*/
	public $view;
	
	/*
	Initial lib for system
	Not sure what to do here yet
	*/
	public $sysLib;
	
	/*
	Lib for layout HTML for generic inputs/select/textarea etc...
	*/
	public $layout;
	
	/*
	@var string
	Generic template for views
	*/
	public $template = 'template';
	
	/*
	@var string
	Generic template for views
	*/
	public $template_file = 'template';
	
	/*
	Dummy controller is a variable to set if has to call all initials vars and libs
	*/
	
	public $dummy_controller = false;
	
	/*
	Check if this controller is only for admin
	*/
	
	public $access_cfg = array(
		'needs_login' => false, //For access all pages, needs to be logged in
		'admin_only' => false,
		'role_access' => array(), //ToDo, Access with roles
	);
	
	/*
	@array
	Sets var for pagination config
	*/
	public $pager_cfg = array(
		'per_page' => 20,
		'segment' => 3,
		'template' => 'template_basic',
	);
	
	/*
	@namespace
	Sets namespace for call model
	*/
	public $ns_model;
	
	/*
	@Array
	Sets if it's gonna use the Generic Filter
	*/
	public $filterLib_cfg = array(
		'use' => false,
		'action' => '',
		'generic_filter' => array(
			'nome',
			'email',
		
		),
	);
	
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->uri = current_url(true)->getSegments();
		$this->routes = \Config\Services::router();
		$this->request = \Config\Services::request();
	}
	
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->base_url = base_url().'/';
		
		//Check dummy controller
		if($this->dummy_controller === false){
			
			$this->SetSysLib();
			$this->SetMdl();
			$this->SetView();
			$this->SetLayout();
			$this->SetInitialData();
			
		}
	}
	
	public function SetView()
	{
		$this->view = new \App\Libraries\Sys\SmartyCI();
	}
	
	public function SetMdl()
	{
		//Let's call for MDL (model) for short code in Controllers
		$namespace_call = ($this->ns_model) ? $this->ns_model : '\\App\\Models\\'.$this->module_name.'\\'.$this->module_name.'model';
		if(class_exists($namespace_call)){
			$this->mdl = new $namespace_call();
		}
	}
	
	public function SetSysLib()
	{
		//Initialize all system vars for models and session data
		$this->sysLib = new \App\Libraries\Sys\InitAppLib($this->access_cfg['needs_login'], $this->module_name);
		$this->CheckSysAccess();
	}
	
	public function rdctLogin()
	{
		$this->session->setFlashdata('rdct_url', urlencode(current_url()));
		rdct('/login');
	}
	
	public function CheckSysAccess()
	{
		$HasAccess = $this->sysLib->CheckSession();
		if($this->access_cfg['needs_login']){
			if(!$HasAccess){
				//User has no session, check for url login
				if(!isset($this->uri[0]) || $this->uri[0] !== 'login'){
					$this->rdctLogin();
				}
			}
		}
		if($this->access_cfg['admin_only']){
			$HasAccess = $this->sysLib->CheckAccessAdmin();
			if(!$HasAccess){
				header('HTTP/1.0 403 Forbbiden');
				echo '<p>Acesso Negado!</p>';
				echo '<p><a href="'.$this->base_url.'">Voltar para Página Inicial</a></p>';
				exit;
			}
		}
	}
	
	public function SetLayout()
	{
		
		$this->layout = new \App\Libraries\Sys\LayoutLib($this->mdl->fields_map);
		$this->layout->template = $this->template;
	}
	public function SetBreadCrumbArr()
	{
		/*
		2020-02-12 FINALLY I'VE GOT TO DO THIS!!!!!!!!!!!!!!!!!!!
		*/
		$breadcrumb = array();
		
		
		$controllerName = strtolower(str_replace('App\\Controllers\\', '', get_class($this)));
		
		if(count($this->uri) == 0){
			//For cases like app_url/
			$breadcrumb[$controllerName][$this->routes->methodName()] = null;
		}elseif(count($this->uri) == 1){
			if($this->uri[0] == 'admin'){
				//For cases like app_url/admin/
				$breadcrumb['admin'][$this->routes->methodName()] = null;
			}else{
				//For cases like app_url/home
				$breadcrumb[$controllerName][$this->routes->methodName()] = null;
			}
		}else{
			//For cases like app_url/home/index/2/test
			$temp = &$breadcrumb;
			foreach($this->uri as $val => $key) {
				$temp = &$temp[$key];
			}
		}
		return $breadcrumb;
	}
	
	public function SetInitialData()
	{
		//Initial data for view, assuming this it's gonna be used in all pages
		$msg_type = '';
		if($this->session->getFlashdata('msg_type') == 'success'){
			$msg_type = 'msg-success';
		}elseif($this->session->getFlashdata('msg_type') == 'alert'){
			$msg_type = 'alert';
		}
		$dataArr = array(
			'app_url' => base_url().'/',
			'ch_ver' => GetCacheVersion(),
			'msg' => $this->session->getFlashdata('msg'),
			'msg_type' => $msg_type,
			'title' => '',
			'auth_user' => $this->session->get('auth_user'),
			'save_data_errors' => $this->session->getFlashdata('save_data_errors'),
			'auth_connectcont' => ($this->session->get('auth_connectcont')) ? $this->session->get('auth_connectcont') : null,
			'auth_part' => ($this->session->get('auth_part')) ? $this->session->get('auth_part') : null,
			'breadcrumb' => $this->SetBreadCrumbArr(),
			'auto_redirect_after_to' => $this->request->getPost('auto_redirect_after_to'),
		);
		$this->view->setData($dataArr);
		
	}
	
	public function PopulatePost($encode = false)
	{
		//Just a generic function for populate all mdl->f with incoming post
		foreach($this->mdl->fields_map as $field => $options){
			if($options['type'] == 'file'){
				//Old value for model update
				$this->mdl->f[$field] = $this->request->getPost($field);
			}else{
				$value = $this->request->getPost($field);
				if(!is_null($value)){
					if($encode){
						if($options['type'] == 'password'){
							$value = md5($value);
						}
					}
					$this->mdl->f[$field] = $value;
				}
			}
		}
	}
	
	public function PopulateFiltroPost($initial_filter=array(), $initial_order=array())
	{
		//Just a generic function for populate all mdl->f with incoming post
		foreach($this->mdl->fields_map as $field => $options){
			$value = (!is_null($this->request->getPost('search_'.$field))) ? $this->request->getPost('search_'.$field) : null;
			if(is_null($value)){
				if(isset($initial_filter[$field]) && !empty($initial_filter[$field])){
					$value = $initial_filter[$field];
				}
			}
			$old_value = '';
			if(!is_null($value)){
				$old_value = $value;
				if($value == '|ASSIGNED_ONLY|'){
					$value = $this->session->get('auth_user')['id'];
				}
				if($options['type'] == 'password'){
					$value = md5($value);					
				}
				$this->mdl->where[$field] = $value;
				$this->data['search_'.$field] = $old_value;
				$this->filter[$field] = array(
					'options' => $options,
					'value' => $old_value,
				);
			}
			if(isset($initial_filter[$field])){
				$this->filter[$field] = array(
					'options' => $options,
					'value' => $old_value,
				);
			}
		}
		if($this->filterLib_cfg['generic_filter']){
			if(!is_null($this->request->getPost('search_generic_filter'))){
				$value = $this->request->getPost('search_generic_filter');
				foreach($this->filterLib_cfg['generic_filter'] as $key => $field){
					$key_where = "";
					if(count($this->filterLib_cfg['generic_filter']) > 1){
						if($key == 0){
							$key_where = 'BEGINORWHERE_';
						}elseif($key == count($this->filterLib_cfg['generic_filter']) - 1){
							$key_where = 'ENDORWHERE_';
						}else{
							$key_where = 'MIDORWHERE_';
						}
					}else{
						$key_where = 'BEGINENDORWHERE_';
					}
					if(empty($this->filter[$field]['value'])){
						$this->mdl->where[$key_where.$field] = $value;
					}
				}
			}
		}
		if(!empty($this->body['order_by_field'])){
			$order_by_field = $this->body['order_by_field'];
		}else{
			$order_by_field = $this->request->getPost('order_by_field');
		}
		if(!empty($this->body['order_by_order'])){
			$order_by_order = $this->body['order_by_order'];
		}else{
			$order_by_order = $this->request->getPost('order_by_order');
		}
		if(!empty($order_by_field) && !empty($order_by_order)){
			$this->mdl->order_by[$order_by_field] = $order_by_order;
		}elseif(!empty($initial_order)){
			$order_by_field = $initial_order['field'];
			$order_by_order = $initial_order['order'];
			$this->mdl->order_by[$order_by_field] = $order_by_order;
			
		}
		$this->data['order_by_field'] = $order_by_field;
		$this->data['order_by_order'] = $order_by_order;
		
		if($this->filterLib_cfg['use']){
			$this->data['filter_template'] = $this->GenerateGenericFilter();
			
		}
	}
	
	public function GenerateGenericFilter()
	{
		$this->filterLib = new \App\Libraries\Sys\FilterLib($this->request, $this->filter);
		$this->filterLib->action = $this->filterLib_cfg['action'];
		$this->filterLib->generic_filter = $this->filterLib_cfg['generic_filter'];
		$this->filterLib->id_filter = $this->filterLib_cfg['id_filter'];
		if($this->filterLib_cfg['template_name']){
			$this->filterLib->template_name = $this->filterLib_cfg['template_name'];
			$this->filterLib->template = '';
		}else{
			$this->filterLib->template = $this->template;
		}
		$this->filterLib->ext_buttons = $this->ExtButtonsGenericFilters();
		$this->filterLib->order_by = array('field'=>$this->data['order_by_field'], 'order'=>$this->data['order_by_order']);
		return $this->filterLib->display();
	}
	
	public function ExtButtonsGenericFilters()
	{
		return array();
	}
	
	public function GetPagination($total, $offset=0, $group = 'default')
	{
		
		$pager = \Config\Services::pagerext();
		$page = ($offset > 1) ? ($offset) : 1;
		return $pager->makeLinks($page, $this->pager_cfg['per_page'], $total, $this->pager_cfg['template'], $this->pager_cfg['segment'], $group);
		
	}
	
	public function display_template($content)
	{
		return $this->display($this->view->setData(array('content'=>$content))->view($this->template.'/'.$this->template_file));
	}
	
	public function display($content)
	{
		global $AppVersion;
		
		/*
		Compressing HTML to output to consume less memory
		*/
		if($AppVersion->compress_output){
			$content = str_replace(array("    ", "\t", "\n", "\r"), "", $content);
		}
		return $content;
	}
	
	public function displayNew($tpl)
	{
		return $this->display_template($this->view->setData($this->data)->view($tpl));
	}
	
	public function PopulateFromSaveData($result)
	{
		
		$save_data = $this->session->getFlashdata('save_data');
		if(is_null($save_data)){
			///Let's try from POST params
			foreach($this->mdl->fields_map as $field => $attrs){
				$value = $this->request->getPost('save_data_'.$field);
				if(!empty($value)){
					if($attrs['type'] == 'related'){
						$save_data[$field.'_nome'] = $this->request->getPost('save_data_'.$field);
						$save_data[$field] = $this->request->getPost('save_data_'.$field.'_nome');
					}else{
						$save_data[$field] = $value;
					}
				}
			}
		}
		if(!is_null($save_data)){
			$result = array_merge($result, $save_data);
		}
		return $result;
	}
	
	public function ValidateFormPost()
	{
		
		$this->validation = \Config\Services::validation();
		foreach($this->mdl->fields_map as $field => $attrs){
			if($field == 'id'){
				continue;
			}
			$validation_str = '';
			$c_validation_str = '';
			if($attrs['type'] == 'file'){
				$value = $this->request->getFile($field);
				if($value){
					if($attrs['required']){
						$validation_str .= $c_validation_str.'uploaded['.$field.']';
						$c_validation_str = '|';
					}
					if($attrs['parameter']['max_size']){
						$validation_str .= $c_validation_str.'max_size['.$field.','.$attrs['parameter']['max_size'].']';
						$c_validation_str = '|';
					}
				}
			}else{
				if($attrs['required']){
					$validation_str .= $c_validation_str.'required';
					$c_validation_str = '|';
				}
				if(isset($attrs['min_length'])){
					$validation_str .= $c_validation_str.'min_length['.$attrs['min_length'].']';
					$c_validation_str = '|';
				}
				if(isset($attrs['max_length'])){
					$validation_str .= $c_validation_str.'max_length['.$attrs['max_length'].']';
					$c_validation_str = '|';
				}
				if($attrs['type'] == 'email' && $attrs['required']){
					$validation_str .= $c_validation_str.'valid_email';
					$c_validation_str = '|';
				}
				if(!empty($attrs['validations'])){
					$validation_str .= $c_validation_str.$attrs['validations'];
					$c_validation_str = '|';
				}
			}
			if(!empty($validation_str)){
				$this->validation->setRule($field, $attrs['lbl'], $validation_str);
			}
		}
		if(!$this->validation->withRequest($this->request)->run()){
			$this->validation_errors = $this->validation->getErrors();
			return false;
		}
		return true;
	}
	
	public function SetErrorValidatedForm($set_save_data = true)
	{
		$this->session->setFlashdata('save_data_errors', $this->validation_errors);
		if($set_save_data){
			$this->session->setFlashdata('save_data', $this->request->getPost());
		}
	}

	public function setMsgData($type, $msg){
		$this->session->setFlashdata('msg_type', $type);
		$this->session->setFlashdata('msg', $msg);
	}
}
