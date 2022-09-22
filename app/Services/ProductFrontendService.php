<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\ProductServiceInterface;
use App\Libraries\Authentication as Auth;

class ProductFrontendService implements ProductServiceInterface
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;
   protected $nestedsetbie;
   protected $pagination;
   protected $language;
   protected $routerRepository;
   protected $productRepository;
   protected $array;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->language = $param['language'];
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'product';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->routerRepository = service('RouterRepository', 'router');
      $this->productRepository = service('ProductRepository', 'product');
      helper(['mystring']);
   }

   public function create($member_id){
      $this->db->transBegin();
      try{
         $payload = $this->store(['method' => 'create']);

         $recordId = $this->model->_insert([
            'table' => $this->module,
            'data' => $payload,
         ]);

         if($recordId > 0){
            $storeLanguage = $this->storeLanguage($recordId,$member_id);
            $recordTranslateId = $this->model->_insert([
               'table' => 'product_translate',
               'data' => $storeLanguage,
            ]);
            $this->model->_insert([
               'table' => 'object_relationship',
               'data' => [
                  'objectid' => $recordId,
                  'catalogueid' => $this->request->getPost('catalogueid'),
                  'module' => $this->module
               ]
            ]);
            if($recordTranslateId > 0){
               $this->routerRepository->create([
                  'canonical' => slug($this->request->getPost('canonical')),
                  'module' => $this->module,
                  'objectid' => $recordId,
                  'language' => $this->language,
                  'view' => view_cells($this->module),
               ]);
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

   private function storeLanguage($objectid = 0, $member_id = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('title')).'-'.$member_id,
			'content' => $this->request->getPost('content'),
			// 'description' => $this->request->getPost('description'),
			'meta_title' => validate_input($this->request->getPost('title')),
			'meta_description' => validate_input(strip_tags($this->request->getPost('content'))),
			'language' => $this->language,
			'module' => $this->module,
		];
		return $store;
	}

	private function store($param = []){
		helper(['text']);
		$album = $this->request->getPost('album');
      $album_json = json_decode($album,true);
		$image = (isset($album_json) && is_array($album_json) && count($album_json)) ? $album_json[0] : 'public/not-found.png';
		$store = [
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'project_id' => (int)$this->request->getPost('project_id'),
 			'form' => $this->request->getPost('form'),
 			'type' => $this->request->getPost('type'),
 			'area' => $this->request->getPost('area'),
 			'juridical' => $this->request->getPost('juridical'),
 			'direction' => $this->request->getPost('direction'),
 			'horizontal' => $this->request->getPost('horizontal'),
 			'long' => $this->request->getPost('long'),
 			'floor' => $this->request->getPost('floor'),
 			'front' => $this->request->getPost('front'),
 			'bed' => $this->request->getPost('bed'),
 			'dining_room' => (int)$this->request->getPost('dining_room'),
 			'kitchen' => (int)$this->request->getPost('kitchen'),
 			'terrace' => (int)$this->request->getPost('terrace'),
 			'parking' => (int)$this->request->getPost('parking'),
 			'own' => (int)$this->request->getPost('own'),
      	'price' => (int)str_replace('.','', $this->request->getPost('price')),
 			// 'code' => $this->request->getPost('code'),
 			'album' => $album,
         'image' => $image,
 			'publish' => $this->request->getPost('publish'),
 			'city_id' => $this->request->getPost('city_id'),
         'district_id' => $this->request->getPost('district_id'),
         'ward_id' => $this->request->getPost('ward_id'),
         'phone' => $this->request->getPost('phone'),
         'map' => $this->request->getPost('map'),
         'type_post' => $this->request->getPost('type_post'),
         'type_vip_day' => $this->request->getPost('type_vip_day'),
         'vip_type_month' => $this->request->getPost('vip_type_month'),
         // 'commission' => $this->request->getPost('commission'),
         'daynumber' => $this->request->getPost('daynumber'),
 			'fullname' => $this->request->getPost('fullname'),
 			'address' => $this->request->getPost('address'),
         'publish' => 0
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

}
