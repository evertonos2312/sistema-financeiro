<?php
namespace App\Libraries;
class Micropower
{
	private $token;
	private $config = [];
	public $soapLib;
	public function __construct()
	{
		$configMP = new \Config\Micropower();
		$this->config['user'] = $configMP->login;
		$this->config['pass'] = $configMP->password;
		$this->config['baseUrl'] = $configMP->urlService;
		$this->soapLib = new Sys\Soap();
		$this->soapLib->base_url = $this->config['baseUrl'];
		
		//Setar opções para as requisições
		$this->soapLib->SetOption('connection_timeout', 5);
		$this->soapLib->SetOption('keep_alive', false);
		$this->soapLib->SetOption('timeout', 10);
	}
	
	public function getAuthToken()
	{
		if(empty($this->token)){
			$data = [
				'getTicket' => [
					'ID' => $this->config['user'],
					'password' => $this->config['pass'],
					'authField' => 'ID',
				],
			
			];
			$this->token_time = strtotime(date("Y-m-d H:i:s"));
			$return = $this->soapLib->call('securitysvc.asmx', 'getTicket', $data);
			if($return['status']){
				if($return['response']['body']->getTicketResult){
					$this->token = $return['response']['body']->getTicketResult;
					return ['status' => 'success', 'detail' => $this->token];
				}
			}
		}else{
			return true;
		}
		return ['status' => 'error', 'error' => 'Cannot get token from WebService'];
	}
	
	public function checkUser($idCheck)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = [
			'exportUser' => [
				'ID' => $idCheck,
				'authField' => 'ID',
				'ticket' => $this->token,
			],
		];
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('mplsws.asmx', 'exportUser', $data);
		
		if($return['status']){
			if($return['response']['body']->exportUserResult){
				return ['status' => 'success', 'detail' => $return['response']['body']->exportUserResult];
			}
		}else{
			if(strpos($return['msg'], 'User Not Found!') !== false){
				return ['status' => 'success', 'detail' => null ];
			}
		}
		return ['status' => 'error', 'error' => $return['msg']];
	}
	
	public function getAuthLoginToken($id, $pass)
	{
		$data = [
			'getAuthLoginTicket' => [
				'ID' => $id,
				'password' => $pass,
				'authField' => 'ID',
			],
		
		];
		$this->token_time = strtotime(date("Y-m-d H:i:s"));
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('securitysvc.asmx', 'getAuthLoginTicket', $data);
		if($return['status']){
			if($return['response']['body']->getAuthLoginTicketResult){
				return $return['response']['body']->getAuthLoginTicketResult;
			}
		}
		return false;
		
	}
	
	public function getToken()
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		return $this->token;
	}
	
	public function createUser($dataUser)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = $this->mountUserFields($dataUser);
		
		$data['importUser']['user']['operationCode'] = 1;
		
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('mplsws.asmx', 'importUser', $data);
		
		if($return['status']){
			if($return['response']['body']->importUserResult){
				if($return['response']['body']->importUserResult->ID == -1){
					return ['status' => 'error', 'error' => $return['response']['body']->importUserResult->message];
				}
				return ['status' => 'success', 'detail' => $return['response']['body']->importUserResult->ID];
			}
		}else{
			if(strpos($return['msg'], 'User Not Found!') !== false){
				return ['status' => 'success', 'detail' => null ];
			}
		}
		return ['status' => 'error', 'error' => $return['msg']];
	}
	
	public function updateUser($dataUser)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = $this->mountUserFields($dataUser);
		
		$data['importUser']['user']['userID'] = $dataUser['userID'];
		$data['importUser']['user']['operationCode'] = 2;
		
		
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('mplsws.asmx', 'importUser', $data);
		if($return['status']){
			if($return['response']['body']->importUserResult){
				return ['status' => 'success', 'detail' => $return['response']['body']->importUserResult];
			}
		}else{
			if(strpos($return['msg'], 'User Not Found!') !== false){
				return ['status' => 'success', 'detail' => null ];
			}
		}
		return ['status' => 'error', 'error' => $return['msg']];
	}
	
	private function mountUserFields($dataUser)
	{
		return [
			'importUser' => [
				'user' => [
					'userID' => '',
					'password' => $dataUser['pass'],
					'passwordExpiration' => '2099-12-31',
					'userName' => substr($dataUser['userName'], 0, 20),
					'displayName' => substr($dataUser['userName'], 0, 20),
					'email' => $dataUser['email'],
					'isBlocked' => false,
					'isActive' => true,
					'countryID' => '247',
					'timeZoneID' => '1',
					'cultureName' => 'pt-BR',
					'systemRoleID' => 'RLDS01',
					'preferredDomain' => '',
					'preferredPortal' => '',
					'preferredArea' => '',
					'waitListPriority' => '',
					'showEmail' => '',
					'showFacebook' => '',
					'showSkype' => '',
					'maritalStatusID' => '',
					'occupationID' => '',
					'positionID' => '',
					'admissionDate' => '2000-01-01',
					'managerID' => '',
					'sendNotify' => true,
					'birthdate' => '2000-01-01',
					'corpID' => '',
					'departmentID' => '',
					'ChangeJobGradeAndSalary' => '',
					'jobGradeId' => '',
					'salary' => '',
					'listCurrentPage' => '',
					'listTotalPages' => '',
					'listTotalRecords' => '',
					'documents' => [
						[
							'docTypeID' => 'ID',
							'DocNumber' => $dataUser['id'],
						],
					
					],
					'operationCode' => 1,
				],
				'ticket' => $this->token,
			],
		];
		
	}
	
	public function insertIntoDomains($userID, $cliente = 0, $nao_cliente = 0)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$successCliente = false;
		$successNaoCliente = false;
		
		$data = [
			'importUserDomainAccess' => [
				'domAccess' => [
					'domainID' => '5',
					'includeSubDomains' => false,
					'roleID' => 'RLDS01',
					'userID' => $userID,
					'operationCode' => 1,
				],
				'ticket' => $this->token,
			],
		];
		if($cliente){
			$data['importUserDomainAccess']['domAccess']['domainID'] = '4';
			
			$return = $this->soapLib->call('mplsws.asmx', 'importUserDomainAccess', $data);
			if($return['status']){
				if($return['response']['body']->importUserDomainAccessResult->error == -1){
					$successCliente = true;
				}
			}
		}
		if($nao_cliente){
			$data['importUserDomainAccess']['domAccess']['domainID'] = '5';
			
			$return = $this->soapLib->call('mplsws.asmx', 'importUserDomainAccess', $data);
			if($return['status']){
				if($return['response']['body']->importUserDomainAccessResult->error == -1){
					$successNaoCliente = true;
				}
			}
		}
		return ['status' => 'success', 'detail' => ['cliente' => $successCliente, 'nao_cliente' => $successNaoCliente]];
	}
	
	public function getCursosList($type = 'ALL_CLASS', $page = 1)
	{
		
		$hasNextPage = false;
		$cursos = [];
		$valid = true;
		$msg = '';
		do {
			$return = $this->callCoursesList($page);
			if($return['status']){
				if($return['response']['body']->exportCoursesResult){
					foreach($return['response']['body']->exportCoursesResult->WSCourse as $curso){
						if($curso->courseType == $type || $type == 'ALL_CLASS'){
							$cursos[] = $curso;
						}
						if($curso->listTotalPages > $curso->listCurrentPage){
							$hasNextPage = true;
							$page++;
						}else{
							$hasNextPage = false;
						}
					}
				}
			}else{
				$hasNextPage = false;
				$valid = false;
				$msg = $return['msg'];
				break;
			}
		} while($hasNextPage);
		
		return ['status' => ($valid) ? 'success' : 'error', 'detail' => ($valid) ? $cursos : $msg];
	}
	
	private function callCoursesList($page)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = [
			'exportCourses' => [
				'page' => $page,
				'ticket' => $this->token,
			],
		];
		
		$this->soapLib->DestroyClient();
		
		return $this->soapLib->call('mplsws.asmx', 'exportCourses', $data);
	}
	
	public function getTurmasList($type = 'ALL_CLASS', $page = 1)
	{
		
		$hasNextPage = false;
		$turmas = [];
		$valid = true;
		do {
			$return = $this->callTurmasList($page);
			if($return['status']){
				if($return['response']['body']->exportClassesResult){
					foreach($return['response']['body']->exportClassesResult->WSClassDetail as $turma){
						if($turma->courseType == $type || $type == 'ALL_CLASS'){
							$turmas[] = $turma;
						}
						if($turma->listTotalPages > $turma->listCurrentPage){
							$hasNextPage = true;
							$page++;
						}else{
							$hasNextPage = false;
						}
					}
				}
			}else{
				$hasNextPage = false;
				$valid = false;
				$msg = $return['msg'];
				break;
			}
		} while($hasNextPage);
		
		return ['status' => ($valid) ? 'success' : 'error', 'detail' => ($valid) ? $turmas : $msg];
	}
	
	private function callTurmasList($page)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = [
			'exportClasses' => [
				'cultureName' => 'pt-BR',
				'page' => $page,
				'ticket' => $this->token,
			],
		];
		
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('mplsws.asmx', 'exportClasses', $data);
		
		return $return;
	}
	
	public function getSubcategoriasList()
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		$data = [
			'exportCourseSubCategories' => [
				'cultureName' => 'pt-BR',
				'ticket' => $this->token,
			],
		];
		
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('mplsws.asmx', 'exportCourseSubCategories', $data);
		
		if($return['status']){
			if($return['response']['body']->exportCourseSubCategoriesResult){
				return ['status' => 'success', 'detail' => $return['response']['body']->exportCourseSubCategoriesResult->WSCourseSubCategory];
			}
		}
		return ['status' => 'error', 'detail' => $return['msg']];
	}
	
	public function insertUserClass($userID, $class)
	{
		$tokenValidated = $this->getAuthToken();
		if($tokenValidated['status'] == 'error'){
			return $tokenValidated;
		}
		
		$data = [
			'createEnrollmentByClassID' => [
				'classID' => $class,
				'user' => $userID,
				'userAuthField' => 'ID',
				'masterEnrollment' => '0',
				'ticket' => $this->token,
			],
		];
		$this->soapLib->DestroyClient();
		$return = $this->soapLib->call('directsvc.asmx', 'createEnrollmentByClassID', $data);
		if($return['status']){
			if($return['response']['body']->createEnrollmentByClassIDResult !== -1){
				return ['status' => 'success', 'detail' => $return['response']['body']->createEnrollmentByClassIDResult];
			}
		}
		return ['status' => 'error', 'detail' => $return['msg']];
	}
}
?>