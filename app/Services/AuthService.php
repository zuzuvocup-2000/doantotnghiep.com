<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\AuthServiceInterface;
use App\Libraries\Authentication as Auth;
use App\Models\UserModel;
use App\Libraries\Mailbie as Mailbie;

class AuthService
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->model = model('App\Models\AutoloadModel');
      $this->user = model('App\Models\UserModel');
      $this->db = \Config\Database::connect();
      $this->module = 'user';
      $this->session = session();
   }

   public function login(){
      try{
         $data = $this->model->_get_where([
            'select' => 'tb1.id, tb1.image, tb1.fullname, tb1.email, tb2.title',
            'table' => 'user as tb1',
            'where' => [
               'tb1.email' => $this->request->getPost('email'),
               'tb1.publish' => 1,
               'tb1.deleted_at' => 0,
               'tb2.publish' => 1,
               'tb2.deleted_at' => 0,
            ],
            'join' => [
               [
                  'user_catalogue as tb2', 'tb1.catalogueid = tb2.id', 'inner'
               ]
            ]
         ]);
         $ses_data = [
            'id' => $data['id'],
            'fullname' => $data['fullname'],
            'image' => $data['image'],
            'email' => $data['email'],
            'job' => $data['title'],
            'isLoggedIn' => TRUE
         ];
         $this->session->set($ses_data);

         $_update = [
            'last_login' => current_time(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'remote_addr' => $_SERVER['REMOTE_ADDR']
         ];
         $flag = $this->model->_update([
            'table' => 'user',
            'where' => ['id' => $ses_data['id']],
            'data' => $_update
         ]);
         return true;
      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function forgot(){
      $user = $this->user->where('email', $this->request->getPost('email'))->where('deleted_at', 0)->where('publish', 1)->first();
      $otp = $this->otp(); 
      $otp_live = $this->otp_time();
      $mailbie = new MailBie();
      $otpTemplate = otp_template([
         'fullname' => $user['fullname'],
         'otp' => $otp,
      ]);

      $flag = $mailbie->send([
         'to' => $user['email'],
         'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
         'messages' => $otpTemplate,
      ]);

      $update = [
         'otp' => $otp,
         'otp_live' => $otp_live,
      ];
      $countUpdate = $this->model->_update([
         'table' => 'user',
         'data' => $update,
         'where' => ['id' => $user['id']],
      ]);

      if($countUpdate > 0 && $flag == true){
         return $user;
      }
   }

   public function verify(){
      $user = json_decode(base64_decode($_GET['token']), TRUE);
      $password = random_string('numeric', 6);

      $update = [
         'password' => password_hash($password, PASSWORD_DEFAULT),
      ];


      $flag = $this->model->_update([
         'table' => 'user',
         'data' => $update,
         'where' => ['id' => $user['id']]
      ]);
      if($flag > 0){
         $mailbie = new Mailbie();
         $mailFlag = $mailbie->send([
            'to' => $user['email'],
            'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
            'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url(BACKEND_DIRECTORY).'">Click vào đây để tiến hành đăng nhập</a></div>',
         ]);
         if($mailFlag == true){
            return true;
         }
      }
      return false;
   }

   private function otp(){
      helper(['text']);
      $otp = random_string('numeric', 6);
      return $otp;
   }

   private function otp_time(){
      $timeToLive = gmdate('Y-m-d H:i:s', time() + 7*3600 + 300);
      return $timeToLive;
   }
}
