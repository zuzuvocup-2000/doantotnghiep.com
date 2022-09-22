<?php
namespace App\Libraries;

class MemberAuthentication{

	public $auth;
	protected $AutoloadModel;

	public function __construct(){
		$this->auth = ((isset($_COOKIE['member'])) ? $_COOKIE['member'] : '');
	}

   public static function id(){
      $authLogin = ((isset($_COOKIE['member'])) ? $_COOKIE['member'] : '');
      $auth = json_decode($authLogin, TRUE);
      return $auth['id'];
   }


}
