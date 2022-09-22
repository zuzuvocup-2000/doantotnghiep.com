<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Member extends BaseController{

	public function __construct(){
	}


   public function register(){
      helper(['text']);
      $post = $this->request->getPost('post');
      $data = [];
      if(isset($post) && is_array($post) && count($post)){
         foreach($post as $key => $val){
            $data[$val['name']] = $val['value'];
         }
      }
      $error['message'] = '';
      $error['flag'] = 0;

      $member = $this->AutoloadModel->_get_where([
         'select' => 'count(id)',
         'table' => 'member',
         'where' => [
            'email' => $data['email']
         ],
         'count' => TRUE
      ]);

      if($member > 0){
         $error['message'] = 'Email đã được sử dụng! Hãy chọn 1 email khác';
         $error['flag'] = 1;
      }else{
         if($data['password'] != $data['re_password']){
            $error['message'] = 'Mật khẩu nhập lại không khớp';
            $error['flag'] = 1;
         }else{
            unset($data['re_password']);
            $salt = random_string('alnum', 168);
         	$password = password_encode($data['password'], $salt);
            $data['password'] = $password;
            $data['salt'] = $salt;
            $data['publish'] = 1;

            $resultid = $this->AutoloadModel->_insert([
               'data' => $data,
               'table' => 'member'
            ]);

            if($resultid > 0){
               $error['message'] = 'Tạo tài khoản thành công';
            }
         }
      }

      echo json_encode($error);die();
   }

   public function login(){
      helper(['text']);
      $post = $this->request->getPost('post');
      $data = [];
      if(isset($post) && is_array($post) && count($post)){
         foreach($post as $key => $val){
            $data[$val['name']] = $val['value'];
         }
      }
      $error['message'] = '';
      $error['flag'] = 0;

      $member = $this->AutoloadModel->_get_where([
         'select' => '*',
         'table' => 'member',
         'where' => [
            'email' => $data['email']
         ],
      ]);

      if(!isset($member) || is_array($member) == false || count($member) == 0 ){
         $error['message'] = 'Tài khoản hoặc mật khẩu không chính xác';
         $error['flag'] = 1;
      }else{

         $password = password_encode($data['password'], $member['salt']);
         if($password != $member['password']){
            $error['message'] = 'Tài khoản hoặc mật khẩu không chính xác';
            $error['flag'] = 1;
         }else{
            $cookieAuth = [
		 			'id' => $member['id'],
		 			'fullname' => $member['fullname'],
		 			'email' => $member['email'],
		 		];
		 		setcookie('member', json_encode($cookieAuth), time() + 1*24*3600, "/");
		 		$_update = [
		 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
					'user_agent' => $_SERVER['HTTP_USER_AGENT'],
					'remote_addr' => $_SERVER['REMOTE_ADDR']
		 		];
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'member',
		 			'where' => ['id' => $member['id']],
		 			'data' => $_update
		 		]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Đăng nhập Thành Công');
               $error['message'] = 'Đăng nhập thành công';
		 		}
         }

      }

      echo json_encode($error);die();
   }

}
