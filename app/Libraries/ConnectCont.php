<?php

namespace App\Libraries;

class ConnectCont {
	
	private $cl; //CurlClass instance
	
	public $auth = [
		'login' => '',
		'pass' => '',
	];
	private $cfg;
	public function __construct()
	{
		$this->cfg = new \Config\ConnectCont();
		$this->cl = new Sys\CurlLib();
		$this->cl->base_url = $this->cfg->url;
		$this->session = \Config\Services::session();
		$token = $this->session->get('connectcont_token');
		if($token){
			$this->cl->SetHeader('Authorization', 'Bearer '.$token['access_token']);
		}
	}

	public function getToken() {
		$data = [
			'grant_type' => 'client_credentials',
			'client_id' => $this->cfg->client_id,
			'client_secret' => $this->cfg->client_secret,
		];

		$this->cl->SetHeader('Content-Type', 'application/x-www-form-urlencoded');
		$this->cl->SetHeader('Accept', 'application/json');

		$result = $this->cl->call('post', $data, 'oauth/token');
		if($result['status']){
			$decoded = json_decode($result['response']['body'], true);

			if($decoded['access_token']){
				$this->cl->SetHeader('Authorization', 'Bearer '.$decoded['access_token']);
				return true;
			}
		}
		return false;

	}

	
	public function login()
	{
		$data = [
			'grant_type' => $this->cfg->grant_type,
			'client_id' => $this->cfg->client_id,
			'client_secret' => $this->cfg->client_secret,
			'username' => $this->auth['login'],
			'password' => $this->auth['pass'],
		];
		$this->cl->SetHeader('Content-Type', 'application/x-www-form-urlencoded');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('post', $data, 'oauth/token');
		if($result['status']){
			$decoded = json_decode($result['response']['body'], true);
			if($decoded['access_token']){
				$this->cl->SetHeader('Authorization', 'Bearer '.$decoded['access_token']);
			}
			return $decoded;
		}
		return false;
	}
	
	public function get_usuario()
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('get', null, 'usuarios/'.$this->auth['login']);

		if($result['status']){
			return json_decode($result['response']['body'], true);
		}
		return false;
	}
	
	public function get_cliente()
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('get', null, 'clientes/self');
		
		if($result['status']){
			return json_decode($result['response']['body'], true);
		}
		return false;
	}
	
	public function get_all_data()
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('get', null, 'usuarios/self/detalhes?sistemaIds=99993');
		
		if($result['status']){
			return json_decode($result['response']['body'], true);
		}
		return false;
	}
	
	public function permissoes($detalhes)
	{
		$permissao = [];
        if(!empty($detalhes['autorizacaoSistemas'])){
            foreach ($detalhes['autorizacaoSistemas'][0]['permissoes'] as $permissoes) {
            	$permissao[] = $permissoes['permissaoId'];
            }
        }

        return $permissao;
	}
	
	public function recuperaConta($codigo, $cpf, $copia)
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('post', [], "usuarios/emails/login?codigoOuApelido={$codigo}&cpf={$cpf}&enviarCopia={$copia}");
		if($result['status']){
			return json_decode($result['response']['body'], true);
		}
		return false;
	}
	
	public function recuperaSenha($login, $copia)
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		
		$result = $this->cl->call('post', [], "usuarios/emails/senha?login={$login}&enviarCopia={$copia}");
		if($result['status']){
			return json_decode($result['response']['body'], true);
		}
		return false;
	}
	
	public function alterarSenha($login, $atual, $nova)
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');
		$this->cl->SetHeader('senhaAtual', $atual);
		$this->cl->SetHeader('novaSenha', $nova);
		
		return $this->cl->call('PUT', [], "usuarios/{$login}/senha");
	}

	public function checkExistCPFAtivo($cpf)
	{
		$this->cl->SetHeader('Content-Type', 'application/json');
		$this->cl->SetHeader('Accept', 'application/json');



		$result = $this->cl->call('get', null, "usuarios/pessoas/{$cpf}/detalhes");
		if($result['status']){
			return json_decode($result['response']['body'], true);
		}

		return false;
	}
	
	/*
	
	FUNCOES PARA ALUNO CURSOS CONTMATIC
	
	*/
	public function calculaVagas($cliente)
	{
        $temmodulos = 0;
		$one_incluse = false;
	    if ($cliente['clienteId'] <= 19713) {
	        $liberaVagas        = 4;
	        $liberaListaespera  = 4;
	    } else {
	        $liberaVagas        = 0;
	        $liberaListaespera  = 0;
	        foreach ($cliente['produtos'] as $key => $value) {
	            if ($value['situacao'] == 'ATIVO') {
	                switch ($value['produtoId']) {
	                	case 1: //G5
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 4: //FOLHA
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 3: //CONTABIL
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 6: //GESCON
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 11: //ORION
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 28: //CND
	                	    $liberaVagas        = $liberaVagas + 1;
	                	    $liberaListaespera  = $liberaListaespera + 1;
	                	    break;
	                	case 17: //LOJA
	                	case 18: //PDV
	                	case 21: //NFCE
	                	case 23: //Financeiro Gestão
	                	case 29: //Estoque Gestão
	                	case 30: //Compras Gestão
	                	case 31: //Vendas Produtos Gestão
	                	case 32: //Serviços Gestão
						case 39: //Produção    
	                	case 33: //CRM Gestão
	                	    $temmodulos++;
	                	    break;
	                	case 10: //POCKET
	                	    $liberaVagas        = 2;
	                	    $liberaListaespera  = 2;
	                	    break;
	                	case 15: //ONE INCLUSIVE
	                	    $liberaVagas        = 4;
	                	    $liberaListaespera  = 4;
	                	    break;
						default:
							break;
	                }
	            }else{
	                if ($value['situacao'] == 'ONE_INCLUSIVE') {
						$one_incluse = true;
	                    $liberaVagas        = 4;
	                    $liberaListaespera  = 4;
	                }
	            }
	        }
	    }

	    if($temmodulos > 0){
	        $liberaVagas        = $liberaVagas + 1;
	        $liberaListaespera  = $liberaListaespera + 1;
	    }
		return [
			'oneinclusive' => $liberaVagas,
			'liberaVagas' => $liberaVagas,
			'liberaListaespera' => $liberaListaespera,
		
		];
	}
	
	public function getDataCursos()
	{
		$dataAll = $this->get_all_data();
		
		$vagas = $this->calculaVagas($dataAll['cliente']);
		$permissoes = $this->permissoes($dataAll);
		
		return [
			'usuario' => $dataAll['usuario'],
			'cliente' => $dataAll['cliente'],
			'vagas' => $vagas,
			'permissoes' => $permissoes,
		];
	}
}