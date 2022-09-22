<?php
namespace App\Libraries;
use App\Models\AutoloadModel;

class Authentication{

	public $auth;
	protected $AutoloadModel;

	public function __construct(){
		$this->session = session();
		$this->auth = $this->session->get('isLoggedIn');
		$this->AutoloadModel = new AutoloadModel();
	}

	public function check_auth(){
 		return $this->session->get();
	}

   public static function id(){
      return $this->session->get('id');
   }

	public function check_permission(array $param = []){
		$user = $this->AutoloadModel->_get_where([
			'select' => 'tb2.permission',
			'table' => 'user as tb1',
			'join' => [
				['user_catalogue as tb2', 'tb1.catalogueid = tb2.id', 'inner']
			],
			'where' => ['tb1.id' => $this->session->get('id')]
		]);

		$permission = json_decode($user['permission'], TRUE);
		if(in_array($param['routes'], $permission) == false){
			return false;
		}
		return true;

	}

   public function gate(string $allowUrl = ''){
      $session = session();
      $flag = $this->check_permission([
         'routes' => convertUrl($allowUrl),
      ]);
      return $flag;
   }
}
