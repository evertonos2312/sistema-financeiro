<?php
namespace App\Models\Turmas;

class Turmasmodel extends \App\Models\Basic\Basicmodel
{
	public $db;
	public $table = 'turmas';
	public $f = array();
	public $id_by_name = true;
	public $fields_map = array(
		'id' => array(
			'lbl' => 'ID',
			'type' => 'varchar',
			'max_length' => 36,
			'dont_load_layout' => true,
		),
		'status' => array(
			'lbl' => 'Status',
			'type' => 'dropdown',
			'required' => true,
			'parameter' => 'ativo_inativo_list',
		),
		'imagem' => array(
			'lbl' => 'Imagem',
			'type' => 'related',
			'table' => 'cursos_imagens',
			'link_record' => true,
			'parameter' => array(
				'model' => 'Admin/Cursos_imagens/Cursos_imagensmodel',
				'link_detail' => 'admin/cursos_imagens/detalhes/',
			),
		),
		'nome' => array(
			'lbl' => 'Código',
			'type' => 'varchar',
			'link_record' => true,
		),
		'curso' => array(
			'lbl' => 'Curso',
			'type' => 'related',
			'table' => 'cursos',
			'link_record' => true,
			'parameter' => array(
				'url' => 'ajax_requests/getCursosList',
				'model' => 'Admin/Cursos/Cursosmodel',
				'link_detail' => 'admin/cursos/detalhes/',
				'callback_select' => 'changedCurso',
			),
		),
		'link' => array(
			'lbl' => 'Link',
			'type' => 'link',
		),
		'inicio' => array(
			'lbl' => 'Data Início',
			'type' => 'datetime',
			'required' => true,
		),
		'termino' => array(
			'lbl' => 'Data Término',
			'type' => 'datetime',
			'required' => true,
		),
		'max_cancelamento' => array(
			'lbl' => 'Data Máx. Cancelamento',
			'type' => 'datetime',
			'required' => true,
		),
		'instrutor' => array(
			'lbl' => 'Instrutor',
			'type' => 'related',
			'table' => 'instrutores',
			'link_record' => true,
			'parameter' => array(
				'model' => 'Admin/Instrutores/Instrutoresmodel',
				'link_detail' => 'admin/instrutores/detalhes/',
			),
			'required' => true,
		),
		'moderador' => array(
			'lbl' => 'Moderador',
			'type' => 'related',
			'table' => 'instrutores',
			'link_record' => true,
			'parameter' => array(
				'model' => 'Admin/Instrutores/Instrutoresmodel',
				'link_detail' => 'admin/instrutores/detalhes/',
			),
			'required' => true,
		),
		'local' => array(
			'lbl' => 'Local',
			'type' => 'related',
			'table' => 'locais',
			'link_record' => true,
			'parameter' => array(
				'model' => 'Admin/Locais/Locaismodel',
				'link_detail' => 'admin/locais/detalhes/',
			),
		),
		'periodo' => array(
			'lbl' => 'Período',
			'type' => 'dropdown',
			'parameter' => 'periodo_list',
			'required' => true,
		),
		'carga_horaria' => array(
			'lbl' => 'Carga Horária',
			'type' => 'time',
			'required' => true,
			'ext_attrs' => 'readonly="true"',
			'max_length' => 5,
		),
		'dias_curso' => array(
			'lbl' => 'Dias Curso',
			'type' => 'text',
			'required' => true,
			'ext_attrs' => 'rows="1"',
		),
		'destaque' => array(
			'lbl' => 'Destaque',
			'type' => 'bool',
		),
		'descricao' => array(
			'lbl' => 'Descrição',
			'type' => 'text',
			'required' => true,
			'ext_attrs' => 'rows="5"',
		),
		'pre_requisitos' => array(
			'lbl' => 'Pré Requisitos',
			'type' => 'text',
			'ext_attrs' => 'rows="5"',
		),
		'objetivo' => array(
			'lbl' => 'Objetivo',
			'type' => 'text',
			'ext_attrs' => 'rows="5"',
			'required' => true,
		),
		'aviso' => array(
			'lbl' => 'Aviso',
			'type' => 'text',
			'ext_attrs' => 'rows="5"',
		),
		'vagas_cliente' => array(
			'lbl' => 'Vagas Cliente',
			'type' => 'int',
			'max' => 999,
		),
		'vagas_nao_cliente' => array(
			'lbl' => 'Vagas Visitantes',
			'type' => 'int',
			'max' => 999,
		),
		'vagas_lista_cliente' => array(
			'lbl' => 'Vagas Lista de Espera Cliente',
			'type' => 'int',
			'max' => 999,
		),
		'vagas_lista_nao_cliente' => array(
			'lbl' => 'Vagas Lista de Espera Visitantes',
			'type' => 'int',
			'max' => 999,
		),
		'valor_cliente' => array(
			'lbl' => 'Valor Cliente',
			'type' => 'currency',
		),
		'valor_nao_cliente' => array(
			'lbl' => 'Valor Visitantes',
			'type' => 'currency',
		),
		'capacitora_registro_cfc' => array(
			'lbl' => 'Capacitora Registro CFC',
			'type' => 'varchar',
		),
		'pontuacao_epc' => array(
			'lbl' => 'Pontuação CFC',
			'type' => 'varchar',
		),
		'id_mp' => array(
			'lbl' => 'ID MP',
			'type' => 'varchar',
		),
		'deletado' => array(
			'lbl' => 'Deletado',
			'type' => 'bool',
			'dont_load_layout' => true,
		),
		'data_criacao' => array(
			'lbl' => 'Data Criação',
			'type' => 'datetime',
			'dont_load_layout' => true,
		),
		'usuario_criacao' => array(
			'lbl' => 'Usuário Criação',
			'type' => 'related',
			'table' => 'usuarios',
			'dont_load_layout' => true,
		),
		'data_modificacao' => array(
			'lbl' => 'Data Modificação',
			'type' => 'datetime',
			'dont_load_layout' => true,
		),
		'usuario_modificacao' => array(
			'lbl' => 'Usuário Modificação',
			'type' => 'related',
			'table' => 'usuarios',
			'dont_load_layout' => true,
		),
	);

	public function before_save()
	{
		if(empty($this->f['id']) && !empty($this->f['curso'])){
			$curso = new \App\Models\Cursos\Cursosmodel();
			$curso->f['id'] = $this->f['curso'];
			$curso_result = $curso->get();
			$this->where = array();
			$this->select = "MAX(CAST(SUBSTRING(nome, 4, 99999) as UNSIGNED))+1 as codigo_ult";
			$number = $this->search(1);
			$codigo = $number[0]['codigo_ult'];
			if(is_null($codigo)){
				$codigo = 1;
			}
			$tipo = $curso->getShortType($curso_result['tipo']);
			$this->f['nome'] = $tipo.$codigo;
		}
	}

	public function getDetalhes()
	{
		$this->select = "turmas.*,
		cursos.nome as curso_nome,
		cursos.tipo as curso_tipo,
		categorias.nome as categorias_nome,
		categorias.id as categorias_id,
		subcategorias.nome as subcategorias_nome,
		instrutores.nome as instrutor_nome,
		instrutores.formacao as instrutor_formacao,
		instrutores.foto as instrutor_foto,
		moderadores.nome as moderadores_nome,
		cursos_imagens.nome as cursos_imagens_nome,
		";

		$this->join = [];
		$this->join['cursos'] = 'cursos.id = turmas.curso';
		$this->join['LEFTJOIN_categorias'] = 'categorias.id = cursos.categoria';
		$this->join['LEFTJOIN_subcategorias'] = 'subcategorias.id = cursos.subcategoria';
		$this->join['LEFTJOIN_instrutores'] = 'instrutores.id = turmas.instrutor';
		$this->join['LEFTJOIN_instrutores as moderadores'] = 'moderadores.id = turmas.moderador';
		$this->join['LEFTJOIN_cursos_imagens'] = 'cursos_imagens.id = turmas.imagem';
		
		$this->where = [];
		$this->where['turmas.id'] = ['EQUAL', $this->f['id']];
		$this->where['BEGINORWHERE_cursos.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_cursos.deletado'] = ['IS_NULL', null];

		$this->where['BEGINORWHERE_categorias.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_categorias.deletado'] = ['IS_NULL', null];

		$this->where['BEGINORWHERE_subcategorias.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_subcategorias.deletado'] = ['IS_NULL', null];

		$this->where['BEGINORWHERE_instrutores.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_instrutores.deletado'] = ['IS_NULL', null];

		$this->where['BEGINORWHERE_moderadores.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_moderadores.deletado'] = ['IS_NULL', null];

		$this->where['BEGINORWHERE_cursos_imagens.deletado'] = ['EQUAL', '0'];
		$this->where['ENDORWHERE_cursos_imagens.deletado'] = ['IS_NULL', null];

		return $this->search(1)[0];
	}

	function getDetalhesVagas($id)
	{
		$this->f['id'] = $id;
		$turma = $this->get();
		$return = [];
		if(!$turma){
			return false;
		}

		$return = [
			'cliente' => [
				'vagas' => (int)$turma['vagas_cliente'],
				'preenchido' => 0,
				'disponivel' => 0,
				'vagas_lista' => (int)$turma['vagas_lista_cliente'],
				'preenchido_lista' => 0,
				'disponivel_lista' => 0,
			],
			'nao_cliente' => [
				'vagas' => (int)$turma['vagas_nao_cliente'],
				'preenchido' => 0,
				'disponivel' => 0,
				'vagas_lista' => (int)$turma['vagas_lista_nao_cliente'],
				'preenchido_lista' => 0,
				'disponivel_lista' => 0,
			],
		];
		$mdl_inscritos = new \App\Models\Turmas_inscritos\Turmas_inscritosmodel();
		$mdl_inscritos->select = "
		participantes.tipo,
		count(*) as contagem
		";

		$mdl_inscritos->join['LEFTJOIN_participantes'] = 'participantes.id = turmas_inscritos.participante';

		$mdl_inscritos->where['turmas_inscritos.turma'] = ['EQUAL', $turma['id']];
		$mdl_inscritos->where['turmas_inscritos.status'] = ['DIFF', 'cancelado'];

		$mdl_inscritos->group_by[] = 'participantes.tipo';

		$results = $mdl_inscritos->search(10);

		foreach($results as $result){
			if($result['tipo'] == 'cliente'){
				$return['cliente']['preenchido'] = (int)$result['contagem'];
			}elseif($result['tipo'] == 'nao_cliente'){
				$return['nao_cliente']['preenchido'] = (int)$result['contagem'];
			}
		}


		$mdl_lista_espera = new \App\Models\Cursos_lista_espera\Cursos_lista_esperamodel();

		$mdl_lista_espera->select = 'count(*) as contagem,
		participantes.tipo
		';
		$mdl_lista_espera->join['participantes'] = 'participantes.id = cursos_lista_espera.participante';

		$mdl_lista_espera->where['turma'] = ['EQUAL', $turma['id']];
		$mdl_lista_espera->where['participantes.status'] = ['EQUAL', 'ativo'];

		$mdl_inscritos->group_by[] = 'participantes.tipo';

		$results = $mdl_lista_espera->search(10)[0];

		foreach($results as $result){
			if($result['tipo'] == 'cliente'){
				$return['cliente']['preenchido_lista'] = (int)$result['contagem'];
			}elseif($result['tipo'] == 'nao_cliente'){
				$return['nao_cliente']['preenchido_lista'] = (int)$result['contagem'];
			}
		}

		foreach($return as $key => $val){
			if($val['vagas'] > $val['preenchido']){
				$return[$key]['disponivel'] = (int)$val['vagas'] - $val['preenchido'];
			}
			if($val['vagas_lista'] > $val['preenchido_lista']){
				$return[$key]['disponivel_lista'] = (int)$val['vagas_lista'] - $val['preenchido_lista'];
			}
		}
		return $return;
	}

	public function getURL($cat, $sub, $cod)
	{
		return '/turmas/'.create_slug($cat).'/'.create_slug($sub).'/'.$cod;
	}
}
?>