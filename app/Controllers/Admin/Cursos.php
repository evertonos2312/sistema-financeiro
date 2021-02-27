<?php
namespace App\Controllers\Admin;

class Cursos extends AdminBaseController
{
	public $module_name = 'Cursos';
	public $data = array();
	public $generic_filter = true;
	
	public function ExtButtonsGenericFilters()
	{
		return array(
			'new' => '<a class="btn btn-success" href="'.$this->base_url.'admin/cursos/editar">Novo +</a>',
		);
	}
	
	public function index($offset = 0)
	{
		$this->data['title'] = 'Lista de Cursos';
		
		$initial_filter = array(
			'nome' => '',
			'tipo' => '',
			'categoria' => '',
		);
		$initial_order_by = array(
			'field' => 'codigo',
			'order' => 'DESC',
		);
		
		$this->filterLib_cfg = array(
			'use' => true,
			'action' => base_url().'/admin/cursos/index',
			'generic_filter' => array(
				'nome',
				'codigo',
			),
		);
		
		$this->PopulateFiltroPost($initial_filter, $initial_order_by);
		
		$total_row = $this->mdl->total_rows();
		$this->data['pagination'] = $this->GetPagination($total_row, $offset);
		
		$result = $this->mdl->search($this->pager_cfg['per_page'], $offset);
		$result = $this->mdl->formatRecordsView($result);
		
		$this->data['records'] = $result;
		$this->data['records_count'] = (count($result)) ? true : false;
		
		return $this->display_template($this->view->setData($this->data)->view('pages/Admin/Cursos/index'));
	}
	
	public function detalhes($id)
	{
		$this->data['title'] = 'Detalhes do Curso';
		
		$this->mdl->f['id'] = $id;
		$result = $this->mdl->get();
		$result = $this->mdl->formatRecordsView($result);
		$this->data['record'] = $result;
		
		$this->data['layout'] = $this->layout->GetAllFieldsDetails($result);
		
		return $this->display_template($this->view->setData($this->data)->view('pages/Admin/Cursos/detalhes'));
	}
	
	public function editar($id = null)
	{
		$this->data['title'] = ($id) ? 'Editar Curso' : 'Criar Curso';
		
		$result = array();
		if($id){
			$this->mdl->f['id'] = $id;
			$result = $this->mdl->get();
			$result = $this->mdl->formatRecordsView($result);
		}
		
		$result = $this->PopulateFromSaveData($result);
		
		$this->data['record'] = $result;
		
		$this->data['layout'] = $this->layout->GetAllFields($result);
		
		return $this->display_template($this->view->setData($this->data)->view('pages/Admin/Cursos/editar'));
	}
	
	public function salvar()
	{
		$this->PopulatePost();
		
		if($this->mdl->f['deletado']){
			if(!empty($this->mdl->f['id'])){
				$deleted = $this->mdl->DeleteRecord();
				if($deleted){
					rdct('/admin/cursos/index');
				}
				$this->validation_errors = array(
					'generic_error' => 'Não foi possível deletar o registro, tente novamente.',
				);
				$this->SetErrorValidatedForm(false);
				rdct('/admin/cursos/editar/'.$this->mdl->f['id']);
			}
			rdct('/admin/cursos/editar');
		}
		
		if(!$this->ValidateFormPost()){
			$this->SetErrorValidatedForm();
			rdct('/admin/cursos/editar/'.$this->request->getPost('id'));
		}
		
		$saved = $this->mdl->saveRecord();
		if($saved){
			rdct('/admin/cursos/detalhes/'.$this->mdl->f['id']);
		}else{
			$this->validation_errors = array(
				'generic_error' => $this->mdl->last_error,
			);
			$this->SetErrorValidatedForm();
			rdct('/admin/cursos/editar/'.$this->request->getPost('id'));
		}
	}
	
	public function sync_mp($id = null)
	{
		$this->mpLib = new \App\Libraries\Micropower();
		$count = 0;
		if(!$id){
			//Sync all
			$result = $this->mpLib->getCursosList();
			if($result['status'] == 'success'){
				foreach($result['detail'] as $curso){

					if($curso->courseType != 'PRC'){
						//Sincronizar somente cursos do tipo Zoom
						continue;
					}
					
					$this->mdl->f = [];
					$this->mdl->where['id_mp'] = $curso->courseID;
					$this->mdl->f['id_mp'] = $curso->courseID;
					$result = $this->mdl->search(1)[0];
					if($result){
						$this->mdl->f['id'] = $result['id'];
					}
					$mdlsubcat = new \App\Models\Admin\Subcategorias\Subcategoriasmodel();
					$mdlsubcat->where['id_mp'] = $curso->subCategoryID;
					$subcat_result = $mdlsubcat->search(1)[0];
					if($subcat_result){
						$this->mdl->f['categoria'] = $subcat_result['categoria'];
						$this->mdl->f['subcategoria'] = $subcat_result['id'];
					}
					$this->mdl->f['nome'] = $curso->name;
					$this->mdl->f['tipo'] = 'zoom';
					$this->mdl->saveRecord();
					$count++;
				}
			}else{
				$this->validation_errors['generic_error'] = "Ocorreu um erro ao buscar os cursos no WebService da Micropower: <br>".substr($result['detail'], 0, 400);
				$this->SetErrorValidatedForm(false);
				rdct('/admin/cursos/');
			}
		}
		$this->validation_errors['generic_error'] = 'Sincronização realizada com sucesso!<br><strong>'.$count.'</strong> registros atualizados/inseridos!';
		$this->SetErrorValidatedForm(false);
		rdct('/admin/cursos/');
	}
	
	public function sync_cat_mp()
	{
		$this->mpLib = new \App\Libraries\Micropower();
		//Sync all
		$mdlcat = new \App\Models\Admin\Categorias\Categoriasmodel();
		
		$result = $this->mpLib->getSubcategoriasList();
		$cats = [];
		if($result['status'] == 'success'){
			foreach($result['detail'] as $subcat){
				if(!in_array($subcat->CategoryID, $cats)){
					$mdlcat->where['id_mp'] = $subcat->CategoryID;
					$mdlcat->f = [];
					$result = $mdlcat->search(1)[0];
					if($result){
						$mdlcat->f['id'] = $result['id'];
					}else{
						$mdlcat->f['status'] = 'ativo';
					}
					$mdlcat->f['nome'] = $subcat->CategoryDescription;
					$mdlcat->f['id_mp'] = $subcat->CategoryID;
					$mdlcat->saveRecord();
					$cats[] = $subcat->CategoryID;
				}
			}
		}
		rdct('/admin/categorias/lista');
	}
	
	public function sync_subcat_mp($id = null)
	{
		$this->mpLib = new \App\Libraries\Micropower();
		//Sync all
		$mdlcat = new \App\Models\Admin\Categorias\Categoriasmodel();
		$mdlsubcat = new \App\Models\Admin\Subcategorias\Subcategoriasmodel();
		
		$result = $this->mpLib->getSubcategoriasList();
		$cats = [];
		if($result['status'] == 'success'){
			foreach($result['detail'] as $subcat){
				if(!in_array($subcat->CategoryID, $cats)){
					$mdlcat->where['id_mp'] = $subcat->CategoryID;
					$mdlsubcat->f = [];
					$result = $mdlcat->search(1)[0];
					$cats[$result['id']] = $subcat->CategoryID;
				}
				$key_cat = array_keys($cats, $subcat->CategoryID);
				if($key_cat){
					$mdlsubcat->where['id_mp'] = $subcat->SubCategoryID;
					$mdlsubcat->f = [];
					$result = $mdlsubcat->search(1)[0];
					if($result){
						$mdlsubcat->f['id'] = $result['id'];
					}else{
						$mdlsubcat->f['status'] = 'ativo';
					}
					$mdlsubcat->f['nome'] = $subcat->SubCategoryDescription;
					$mdlsubcat->f['categoria'] = $key_cat;
					$mdlsubcat->f['id_mp'] = $subcat->SubCategoryID;
					$mdlsubcat->saveRecord();
				}
			}
		}
		rdct('/admin/subcategorias/lista');
	}
}
