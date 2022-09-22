<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\UserServiceInterface;
use App\Libraries\Authentication as Auth;
use App\Models\UserModel;

class UserService
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;
   protected $pagination;
   protected $language;
   protected $memberRepository;
   protected $array;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'user';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->userRepository = service('UserRepository', 'user');
   }

   public function pagination($page){
      helper(['mypagination']);
      $page = (int)$page;
      $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $where = $this->condition_where();
      $keyword = $this->condition_keyword();
      $config['total_rows'] = $this->model->_get_where([
         'select' => 'id',
         'table' => $this->module,
         'keyword' => $keyword,
         'where' => $where,
         'count' => TRUE
      ]);
      if($config['total_rows'] > 0){
         $config = pagination_config_bt(['url' => convertUrl('backend.user.user.index'),'perpage' => $perpage], $config);

         $this->pagination->initialize($config);
         $pagination = $this->pagination->create_links();


         $totalPage = ceil($config['total_rows']/$config['per_page']);
         $page = ($page <= 0)?1:$page;
         $page = ($page > $totalPage)?$totalPage:$page;
         $page = $page - 1;

         $user = $this->model->_get_where([
            'select' => 'id, fullname, image, email, phone, address, created_at, image, gender, userid_created, userid_updated, publish',
            'table' => $this->module,
            'where' => $where,
            'keyword' => $keyword,
            'limit' => $config['per_page'],
            'start' => $page * $config['per_page'],
         ], TRUE);

      }

      return [
        'list' => ($user) ?? null,
        'pagination' => ($pagination) ?? null,
      ];
   }

   public function create(){
      try{
         $userModel = new UserModel();
         $insert = $this->store();
         $userModel->save($insert);

         return true;
      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   private function store(){
      helper(['text']);
      $store = [
         'email' => $this->request->getPost('email'),
         'fullname' => $this->request->getPost('fullname'),
         'catalogueid' => (int)$this->request->getPost('catalogueid'),
         'gender' => (int)$this->request->getPost('gender'),
         'image' => $this->request->getPost('image'),
         'job' => $this->request->getPost('job'),
         'birthday' => $this->request->getPost('birthday'),
         'address' => $this->request->getPost('address'),
         'phone' => $this->request->getPost('phone'),
         'cityid' => $this->request->getPost('cityid'),
         'districtid' => $this->request->getPost('districtid'),
         'wardid' => $this->request->getPost('wardid'),
      ];
      if($this->request->getPost('password')){
         $store['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
         $store['created_at'] = current_time();
         $store['userid_created'] = Auth::id();
         $store['publish'] = 1;
      }else{
         $store['updated_at'] = current_time();
         $store['userid_updated'] = Auth::id();
      }
      return $store;
   }

   private function condition_where(){
      $where = [];
      $gender = $this->request->getGet('gender');
      if($gender != -1 && $gender != '' && isset($gender)){
         $where['gender'] = $this->request->getGet('gender');
      }

      $publish = $this->request->getGet('publish');
      if(isset($publish)){
         $where['publish'] = $publish;
      }
      $catalogueid = $this->request->getGet('catalogueid');
      if(isset($catalogueid) && $catalogueid != 0){
         $where['catalogueid'] = $catalogueid;
      }

      $deleted_at = $this->request->getGet('deleted_at');
      if(isset($deleted_at)){
         $where['deleted_at'] = $deleted_at;
      }else{
         $where['deleted_at'] = 0;
      }

      return $where;
   }

   private function condition_keyword($keyword = ''): string{
      if(!empty($this->request->getGet('keyword'))){
         $keyword = $this->request->getGet('keyword');
         $keyword = '(fullname LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
      }
      return $keyword;
   }

}
