<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\TypeServiceInterface;
use App\Libraries\Authentication as Auth;

class MemberCatalogueService
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
      $this->module = 'member_catalogue';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->memberCatalogueRepository = service('memberCatalogueRepository', 'member_catalogue');
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
         $config = pagination_config_bt(['url' => convertUrl('backend.user.catalogue.index'),'perpage' => $perpage], $config);

         $this->pagination->initialize($config);
         $this->data['pagination'] = $this->pagination->create_links();
         $totalPage = ceil($config['total_rows']/$config['per_page']);
         $page = ($page <= 0)?1:$page;
         $page = ($page > $totalPage)?$totalPage:$page;
         $page = $page - 1;
         $memberCatalogue = $this->model->_get_where([
            'select' => '
               id,
               title,
               userid_created,
               userid_updated,
               publish,
               (SELECT COUNT(id) FROM member WHERE member.catalogueid = member_catalogue.id) as total_member,
               (SELECT COUNT(id) FROM member WHERE member.catalogueid = member_catalogue.id AND member.publish = 0) as de_active,
               (SELECT COUNT(id) FROM member WHERE member.catalogueid = member_catalogue.id AND member.publish = 1) as active',
            'table' => $this->module,
            'where' => $where,
            'keyword' => $keyword,
            'limit' => $config['per_page'],
            'start' => $page * $config['per_page'],
         ], TRUE);


      }
      return [
        'list' => ($memberCatalogue) ?? null,
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
         $this->memberCatalogueRepository->deleteById($type['id']);

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
 			'publish' => 1,
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
		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}


}
