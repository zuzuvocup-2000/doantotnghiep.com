<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Libraries\Authentication as Auth;

class ProjectCatalogueService
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;
   protected $nestedsetbie;
   protected $pagination;
   protected $language;
   protected $routerRepository;
   protected $productCatalogueRepository;
   protected $array;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->language = $param['language'];
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'project_catalogue';
   	$this->db = \Config\Database::connect();
      $this->nestedsetbie = service('nestedSetBie', ['table' => $this->module, 'language' => $this->language]);
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->routerRepository = service('RouterRepository', 'router');
      $this->productCatalogueRepository = service('ProjectCatalogueRepository', 'project_catalogue');
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
      'join' =>  [
         [
            'project_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->module.'\'   AND tb2.language = \''.$this->language.'\' ','inner'
         ],
      ],
      'keyword' => $keyword,
      'where' => $where,
      'count' => TRUE
      ]);
      if($config['total_rows'] > 0){
      $config = pagination_config_bt(['url' => convertUrl('backend.product.catalogue.index'),'perpage' => $perpage], $config);

      $this->pagination->initialize($config);
      $pagination = $this->pagination->create_links();
      $totalPage = ceil($config['total_rows']/$config['per_page']);
      $page = ($page <= 0)?1:$page;
      $page = ($page > $totalPage)?$totalPage:$page;
      $page = $page - 1;

      $productCatalogue = $this->model->_get_where([
         'select' => '
            tb1.id,
            tb2.title,
            tb1.lft,
            tb1.rgt,
            tb1.level,
            tb2.canonical,
            (SELECT fullname FROM user WHERE user.id = tb1.userid_created) as creator,
            tb1.userid_updated,
            tb1.publish,
            tb1.order,
            tb1.created_at,
            tb1.updated_at
         ',
         'table' => $this->module.' as tb1',
         'join' =>  [
            [
               'project_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->module.'\'   AND tb2.language = \''.$this->language.'\' ','inner'
            ],
         ],
         'where' => $where,
         'keyword' => $keyword,
         'limit' => $config['per_page'],
         'start' => $page * $config['per_page'],
         'order_by'=> 'lft asc'
      ], TRUE);
      }
      return [
        'list' => ($productCatalogue) ?? null,
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

         if($recordId > 0){
            $storeLanguage = $this->storeLanguage($recordId);
            $recordTranslateId = $this->model->_insert([
               'table' => 'project_translate',
               'data' => $storeLanguage,
            ]);

            if($recordTranslateId > 0){
               $this->insertRouter([
                  'id' => $recordId
               ]);
               $this->nested();
            }
         }

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

   public function update($productCatalogue){
      $this->db->transBegin();
      try{
         $id = $productCatalogue['id'];
         $canonical = $productCatalogue['canonical'];
         $payload = $this->store(['method' => 'update']);
         $payloadTranslate = $this->storeLanguage($id);
         $flag = $this->model->_update([
            'table' => $this->module,
            'where' => ['id' => $id],
            'data' => $payload
         ]);

         if($flag > 0){
            $translateId = $this->model->_update([
               'table' => 'project_translate',
               'where' => ['objectid' => $id, 'module' => $this->module,'language' => $this->language],
               'data' => $payloadTranslate
            ]);
            if($translateId > 0){
               $this->deleteRouter($id, $canonical);
               $this->insertRouter($id);
               $this->nested();
            }
         }

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

   public function delete($productCatalogue){
      $this->db->transBegin();
      try{
         $children = $this->productCatalogueRepository->getAllChildrenNode('id', $productCatalogue['lft'], $productCatalogue['rgt']);
         $children = $this->array->convertArrayById($children, 'id');
         $this->productCatalogueRepository->forceDeleteChildrenNode($children);
         foreach($children as $key => $val){
            $this->routerRepository->deleteByCondition($val, $this->module, $this->language);
         }
         $this->routerRepository->deleteByCondition($productCatalogue['id'], $this->module, $this->language);
         $this->nested();

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
            tb2.title,
            tb2.canonical,
            FROM_BASE64(tb2.description),
            FROM_BASE64(tb2.content),
            tb2.meta_title,
            tb2.meta_description,
            tb1.parentid,
            tb1.image,
            tb1.album,
            tb1.publish,
            tb1.lft,
            tb1.rgt,
            tb1.level,
         ',
         'table' => $this->module.' as tb1',
         'join' =>  [
               [
                  'project_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->module.'\'','inner'
               ]
            ],
         'where' => [
            'tb1.id' => $id,
            'tb1.deleted_at' => 0,
            'tb2.language' => $language

         ]
      ]);
   }

   private function store($param = []){
		helper(['text']);
		$store = [
 			'parentid' => (int)$this->request->getPost('parentid'),
 			'image' => $this->request->getPost('image'),
 			'album' => json_encode($this->request->getPost('album')),
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

   private function storeLanguage($objectid = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('canonical')),
			'description' => base64_encode($this->request->getPost('description')),
			'content' => base64_encode($this->request->getPost('content')),
			'meta_title' => validate_input($this->request->getPost('meta_title')),
			'meta_description' => validate_input($this->request->getPost('meta_description')),
			'language' => $this->language,
			'module' => $this->module,
         'updated_at' => current_time(),
		];
		return $store;
	}

   private function nested(){
      $this->nestedsetbie->Get('level ASC, order ASC');
      $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
      $this->nestedsetbie->Action();
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

   private function deleteRouter($id, $canonical){
      return $this->model->_delete([
         'table' => 'router',
         'where' => [
            'objectid' => $id,
            'module' => $this->module,
            'canonical' => $canonical,
            'language' => $this->language,
         ]
      ]);
   }

	private function insertRouter($id){
		helper(['text']);
		$view = view_cells($this->module);
		$data = [
			'canonical' => slug($this->request->getPost('canonical')),
			'module' => $this->module,
			'objectid' => $id,
			'language' => $this->language,
			'view' => $view
		];
      $insertRouter = $this->model->_insert([
         'table' => 'router',
         'data' => $data,
      ]);
 		return true;
	}

}
