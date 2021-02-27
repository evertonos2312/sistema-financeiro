<?php
namespace App\Models\Usuarios;

class Usuariosmodel extends \App\Models\Basic\Basicmodel
{
    public $db;
	public $table = 'usuarios';
	public $f = array();
	public $fields_map = array(
		'id' => array(
			'lbl' => 'ID',
			'type' => 'varchar',
			'max_length' => 36,
			'dont_load_layout' => true,
		),
		'nome' => array(
			'lbl' => 'Nome',
			'type' => 'varchar',
			'required' => true,
			'min_length' => 2,
			'max_length' => 255,
		),
		'email' => array(
			'lbl' => 'Email',
			'type' => 'email',
			'required' => true,
			'min_length' => 10,
			'max_length' => 255,
			'ext_attrs' => 'form_valid_email="true"',
		),
		'usuario' => array(
			'lbl' => 'Usuário',
			'type' => 'varchar',
			'required' => true,
			'min_length' => 5,
			'max_length' => 255,
		),
		'senha' => array(
			'lbl' => 'Senha',
			'type' => 'password',
		),
		'ativo' => array(
			'lbl' => 'Ativo',
			'type' => 'bool',
		),
		'is_admin' => array(
			'lbl' => 'Administrador',
			'type' => 'bool',
		),
		'tipo' => array(
			'lbl' => 'Tipo',
			'type' => 'dropdown',
			'parameter' => 'tipo_usuario',
			'required' => true,
		),
		'hash_esqueci_senha' => array(
			'lbl' => 'Chave Esqueci Senha',
			'type' => 'varchar',
		),
		'ultima_troca_senha' => array(
			'lbl' => 'Data Última Troca de Senha',
			'type' => 'datetime',
			'dont_load_layout' => true,
		),
		'ultimo_acesso' => array(
			'lbl' => 'último Acesso',
			'type' => 'datetime',
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
			'parameter' => array(
				'url' => null,
				'model' => 'Admin/Usuarios/Usuariosmodel',
				'link_detail' => 'admin/usuarios/detalhes/',
			),
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
			'parameter' => array(
				'url' => null,
				'model' => 'Admin/Usuarios/Usuariosmodel',
				'link_detail' => 'admin/usuarios/detalhes/',
			),
			'dont_load_layout' => true,
		),
	);
}