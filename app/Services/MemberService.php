<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\PriceServiceInterface;
use App\Libraries\Authentication as Auth;

class MemberService
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
      $this->language = $param['language'];
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'member';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->memberRepository = service('memberRepository', 'member');
      helper(['mystring']);
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
			$member = $this->model->_get_where([
				'select' => '
               id,
               fullname,
               image,
               email,
               phone,
               address,
               created_at,
               image,
               gender,
               userid_created,
               userid_updated,
               publish
            ',
				'table' => $this->module,
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

      return [
        'list' => ($member) ?? null,
        'pagination' => ($pagination) ?? null,
      ];
   }

   public function create(){
      $this->db->transBegin();
      try{
         $payload = $this->store(['method' => 'create']);
         $recordId = $this->model->_insert([
            'table' => $this->module,
            'data' => $payload,
         ]);
         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function update($member){
      $this->db->transBegin();
      try{
         $id = $member['id'];
         $payload = $this->store(['method' => 'update']);
         $flag = $this->model->_update([
            'table' => $this->module,
            'where' => ['id' => $id],
            'data' => $payload
         ]);

         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function changePassword($member){
      helper(['text']);
      $this->db->transBegin();
      try{
         $id = $member['id'];
         $salt = random_string('alnum', 168);
         $payload = [
            'salt' => $salt,
            'password' => password_encode($this->request->getPost('password'), $salt),
         ];

         $flag = $this->model->_update([
            'table' => $this->module,
            'where' => ['id' => $id],
            'data' => $payload
         ]);

         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function delete($member){
      $this->db->transBegin();
      try{
         $this->memberRepository->deleteById($member['id']);

         $this->db->transCommit();
         $this->db->transComplete();
         return true;

      }catch(\Exception $e ){
         $this->db->transRollback();
         $this->db->transComplete();
         echo $e->getMessage();die();
         return false;
      }
   }

   public function findById($id, $language){
      return $this->model->_get_where([
         'select' => '
            tb1.*
         ',
         'table' => $this->module.' as tb1',
         'where' => [
            'tb1.id' => $id,
            'tb1.deleted_at' => 0,

         ]
      ]);
   }

   private function store(){
		helper(['text']);
		$salt = random_string('alnum', 168);
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'gender' => (int)$this->request->getPost('gender'),
 			'image' => $this->request->getPost('image'),
 			'birthday' => $this->request->getPost('birthday'),
 			'address' => $this->request->getPost('address'),
 			'phone' => $this->request->getPost('phone'),
 			'cityid' => $this->request->getPost('cityid'),
 			'districtid' => $this->request->getPost('districtid'),
 			'wardid' => $this->request->getPost('wardid'),
 			'description' => $this->request->getPost('description'),
 		];
 		if($this->request->getPost('password')){
 			$store['password'] = password_encode($this->request->getPost('password'), $salt);
 			$store['salt'] = $salt;
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
		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['tb1.publish'] = $publish;
		}
		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}


}
