<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\TypeServiceInterface;
use App\Libraries\Authentication as Auth;

class TypeService implements TypeServiceInterface
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;
   protected $pagination;
   protected $language;
   protected $typeRepository;
   protected $array;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->language = $param['language'];
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'product_type';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->typeRepository = service('TypeRepository', 'product_type');
      helper(['mystring']);
   }



   public function pagination($page){
      helper(['mypagination']);
      $page = (int)$page;
      $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $where = $this->condition_where();
      $keyword = $this->condition_keyword();
      $config['total_rows'] = $this->model->_get_where([
      'select' => 'tb1.id',
      'table' => $this->module.' as tb1',
      'keyword' => $keyword,
      'where' => $where,
      'count' => TRUE
      ]);
      if($config['total_rows'] > 0){
      $config = pagination_config_bt(['url' => convertUrl('backend.product.type.index'),'perpage' => $perpage], $config);

      $this->pagination->initialize($config);
      $pagination = $this->pagination->create_links();
      $totalPage = ceil($config['total_rows']/$config['per_page']);
      $page = ($page <= 0)?1:$page;
      $page = ($page > $totalPage)?$totalPage:$page;
      $page = $page - 1;

      $type = $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.title,
            (SELECT fullname FROM user WHERE user.id = tb1.userid_created) as creator,
            tb1.userid_updated,
            tb1.publish,
            tb1.order,
            tb1.created_at,
            tb1.updated_at
         ',
         'table' => $this->module.' as tb1',
         'where' => $where,
         'keyword' => $keyword,
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'order_by'=> 'created_at desc'
      ], TRUE);
      }
      return [
        'list' => ($type) ?? null,
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

   public function update($type){
      $this->db->transBegin();
      try{
         $id = $type['id'];
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

   public function delete($type){
      $this->db->transBegin();
      try{
         $this->typeRepository->deleteById($type['id']);

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
            tb1.id,
            tb1.title,
            tb1.image,
            tb1.publish,
         ',
         'table' => $this->module.' as tb1',
         'where' => [
            'tb1.id' => $id,
            'tb1.deleted_at' => 0,

         ]
      ]);
   }

   private function store($param = []){
		helper(['text']);
		$store = [
 			'title' => $this->request->getPost('title'),
 			'image' => $this->request->getPost('image'),
 			'publish' => $this->request->getPost('publish'),
      ];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$store['created_at'] = current_time();
 			$store['userid_created'] = Auth::id();

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
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}
		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb2.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}


}
