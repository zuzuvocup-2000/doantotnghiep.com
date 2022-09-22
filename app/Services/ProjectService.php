<?php

namespace App\Services;
use App\Models\AutoloadModel;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Libraries\Authentication as Auth;

class ProjectService
{

   protected $model;
   protected $request;
   protected $module;
   protected $db;
   protected $nestedsetbie;
   protected $pagination;
   protected $language;
   protected $routerRepository;
   protected $projectRepository;
   protected $array;

   public function __construct($param){
      $this->request = \Config\Services::request();
      $this->language = $param['language'];
      $this->model = model('App\Models\AutoloadModel');
      $this->module = 'project';
   	$this->db = \Config\Database::connect();
   	$this->pagination = service('pagination');
   	$this->array = service('array');
      $this->routerRepository = service('RouterRepository', 'router');
      $this->projectRepository = service('ProjectRepository', 'project');
      helper(['mystring']);
   }



   public function pagination($page){

      helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$join = $this->condition_join();
		$catalogue = $this->condition_catalogue();
		$config['total_rows'] = $this->model->_get_where([
			'select' => 'tb1.id',
			'table' => $this->module.' as tb1',
			'join' => $join,
			'where_in' => $catalogue['where_in'],
			'where_in_field' => $catalogue['where_in_field'],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => convertUrl('backend.project.project.index'),'perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$pagination = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$project = $this->model->_get_where([
				'select' => '
               tb1.id,
               tb1.catalogueid as cat_id,
               tb1.address,
               tb1.order,
               tb1.album,
               tb1.image,
               tb1.publish,
               tb1.catalogue,
               tb3.title,
               tb3.canonical,
               tb3.meta_title,
               tb3.meta_description,
               tb4.title as cat_title',
				'table' => $this->module.' as tb1',
				'where' => $where,
				'where_in' => $catalogue['where_in'],
				'where_in_field' => $catalogue['where_in_field'],
				'keyword' => $keyword,
				'join' => $join,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.order desc, tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);

		}


      return [
        'list' => ($project) ?? null,
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

   public function update($project){
      $this->db->transBegin();
      try{
         $id = $project['id'];
         $canonical = $project['canonical'];
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
               $this->routerRepository->deleteByCondition($id, $this->module, $this->language);
               $this->routerRepository->create([
                  'canonical' => slug($this->request->getPost('canonical')),
                  'module' => $this->module,
                  'objectid' => $project['id'],
                  'language' => $this->language,
                  'view' => view_cells($this->module),
               ]);
               $this->model->_delete([
                  'table' => 'object_relationship',
                  'where' => [
                     'module' => $this->module,
                     'objectid' => $project['id'],
                  ]
               ]);
               $this->model->_insert([
                  'table' => 'object_relationship',
                  'data' => [
                     'objectid' => $project['id'],
                     'catalogueid' => $this->request->getPost('catalogueid'),
                     'module' => $this->module
                  ]
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

   public function delete($project){
      $this->db->transBegin();
      try{
         $children = $this->projectRepository->getAllChildrenNode('id', $project['lft'], $project['rgt']);
         $children = $this->array->convertArrayById($children, 'id');
         $this->projectRepository->forceDeleteChildrenNode($children);
         foreach($children as $key => $val){
            $this->routerRepository->deleteByCondition($val, $this->module, $this->language);
         }
         $this->routerRepository->deleteByCondition($project['id'], $this->module, $this->language);
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

   public function findById($id){
      return $this->model->_get_where([
         'select' => '
            tb1.id,
            tb1.catalogueid,
            tb1.type,
            tb1.code,
            tb1.city_id,
            tb1.district_id,
            tb1.address,
            tb1.image,
            tb1.album,
            tb1.publish,
            tb2.title,
            tb2.canonical,
            tb2.description,
            tb2.content,
            tb2.meta_title,
            tb2.meta_description,
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
            'tb2.language' => $this->language

         ]
      ]);
   }


   private function storeLanguage($objectid = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('canonical')),
			'content' => $this->request->getPost('content'),
			'description' => $this->request->getPost('description'),
			'meta_title' => validate_input($this->request->getPost('meta_title')),
			'meta_description' => validate_input($this->request->getPost('meta_description')),
			'language' => $this->language,
			'module' => $this->module,
		];
		return $store;
	}

	private function store($param = []){
		helper(['text']);
		$album = $this->request->getPost('album');
		$image = (isset($album) && is_array($album) && count($album)) ? $album[0] : 'public/not-found.png';
		$store = [
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'type' => (int)$this->request->getPost('type'),
 			'code' => ($this->request->getPost('code')) ?? time(),
 			'album' => json_encode($this->request->getPost('album'), TRUE),
         'image' => $image,
 			'publish' => $this->request->getPost('publish'),
 			'city_id' => $this->request->getPost('city_id'),
 			'district_id' => $this->request->getPost('district_id'),
 			'address' => $this->request->getPost('address'),
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

   private function condition_keyword($keyword = ''): string{
      if(!empty($this->request->getGet('keyword'))){
         $keyword = $this->request->getGet('keyword');
         $keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
      }
      return $keyword;
   }

   private function condition_join(){
		$join = [
			[
				'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->module.'\' ', 'inner'
			],
			[
				'project_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "project" AND tb3.language = \''.$this->language.'\' ','inner'
			],
			[
				'project_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "project_catalogue" AND tb3.language = \''.$this->language.'\' ','inner'
			],
		];

		return $join;
	}

   public function condition_catalogue(){
		$catalogueid = $this->request->getGet('catalogueid');
		$id = [];
		if($catalogueid > 0){
			$catalogue = $this->model->_get_where([
				'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
				'table' => $this->module.'_catalogue as tb1',
				'join' =>  [
					[
						'project_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->language.'\' ','inner'
					],
									],
				'where' => ['tb1.id' => $catalogueid],
			]);

			$catalogueChildren = $this->model->_get_where([
				'select' => 'id',
				'table' => $this->module.'_catalogue',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}
		return [
			'where_in' => $id,
			'where_in_field' => 'tb2.catalogueid'
		];
	}

   private function condition_where(){
      $where = [];

      $publish = $this->request->getGet('publish');
      if(isset($publish)){
         $where['tb1.publish'] = $publish;
      }

      $id = $this->request->getGet('id');
      if(isset($id)){
         $where['tb1.id'] = $id;
      }


      $deleted_at = $this->request->getGet('deleted_at');
      if(isset($deleted_at)){
         $where['tb1.deleted_at'] = $deleted_at;
      }else{
         $where['tb1.deleted_at'] = 0;
      }
      $priceFrom = $this->request->getGet('priceFrom');
      $priceFrom = str_replace('.', '', $priceFrom);
      $priceFrom = (float)$priceFrom;
      $priceTo = $this->request->getGet('priceTo');
      $priceTo = str_replace('.', '', $priceTo);
      $priceTo = (float)$priceTo;
      if(isset($priceFrom) && $priceFrom != 0){
         $where['tb1.price >='] = $priceFrom;
      }
      if(isset($priceTo) && $priceTo != 0){
         $where['tb1.price <='] = $priceTo;
      }

      $attr = $this->request->getGet('attr');
      if(isset($attr) && $attr != 0){
         $where['tb5.attributeid'] = $attr;
      }
      return $where;
   }

   public function findProjectByType($projectTypeDetail, $cityid, $districtid ,$page){

      $where = [
         'tb1.deleted_at' => 0,
         'tb1.publish' => 1,
         'tb1.type' => $projectTypeDetail['id']
      ];

      if(!empty($cityid) && $cityid != 0 ){
         $where['city_id'] = $cityid;
      }

      if(!empty($districtid) && $districtid != 0 ){
         $where['district_id'] = $districtid;
      }

      $keyword = $this->condition_keyword();
      $config['total_rows'] = $this->model->_get_where([
          'select' => 'tb1.id',
          'table' => 'project as tb1',
          'where' => $where,
          'keyword' => $keyword,
          'join' => [
             [
                  'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "project" ', 'inner'
             ],
             [
                  'project_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "project" AND tb3.language = \''.$this->language.'\' ','inner'
             ],
             [
                  'project_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "project_catalogue" AND tb4.language = \''.$this->language.'\' ','inner'
             ]
          ],
          'count' => TRUE
     ]);
      $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $canonical = project_type_url($projectTypeDetail['title'], $projectTypeDetail['id'], TRUE);
      $config['base_url'] = write_url($canonical, FALSE, TRUE);
     if($config['total_rows'] > 0){
         $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
         $this->pagination->initialize($config);
         $this->data['pagination'] = $this->pagination->create_links();
         $totalPage = ceil($config['total_rows']/$config['per_page']);
         $page = ($page <= 0)?1:$page;
         $page = ($page > $totalPage)?$totalPage:$page;
         $seoPage = ($page >= 2)?(' - Trang '.$page):'';
         if($page >= 2){
            $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
         }
         $page = $page - 1;
         $project = $this->model->_get_where([
             'select' => '
               tb1.id,
               tb1.created_at,
               tb1.viewed,
               tb1.image,
               tb3.title,
               tb3.canonical,
               tb3.meta_title,
               tb3.meta_description,
               tb3.viewed,
               tb3.description,
               tb3.content,
               tb4.title as cat_title,
               tb1.catalogueid,
               tb4.title as cat_title,
               tb4.canonical as cat_canonical,
               tb4.description as cat_description,
               tb4.template as cat_template,
               tb1.address,
               (SELECT name FROM vn_district WHERE districtid = tb1.district_id) as district,
               (SELECT name FROM vn_province WHERE provinceid  = tb1.city_id) as city',
             'table' => 'project as tb1',
             'where' => [
                 'tb1.deleted_at' => 0,
                 'tb1.publish' => 1,
                 'tb1.type' => $projectTypeDetail['id']
             ],
             'join' => [
                 [
                     'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "project" ', 'inner'
                 ],
                 [
                     'project_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "project" AND tb3.language = \''.$this->language.'\' ','inner'
                 ],
                 [
                     'project_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "project_catalogue" AND tb4.language = \''.$this->language.'\' ','inner'
                 ]
             ],
             'keyword' => $keyword,
             'limit' => $config['per_page'],
             'start' => $page * $config['per_page'],
             'order_by'=> 'tb1.order desc, tb1.id desc',
             'group_by' => 'tb1.id'
         ], TRUE);
     }

     return [
      'list' => ($project) ?? null,
      'pagination' => ($pagination) ?? null,
      'canonical' => $canonical,
     ];
   }

   public function projectByCity($city, $page){

      $keyword = $this->condition_keyword();
      $config['total_rows'] = $this->model->_get_where([
          'select' => 'tb1.id',
          'table' => 'project as tb1',
          'where' =>[
             'tb1.deleted_at' => 0,
             'tb1.publish' => 1,
             'tb1.city_id' => $city['provinceid']
          ],
          'keyword' => $keyword,
          'join' => [
             [
                  'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "project" ', 'inner'
             ],
             [
                  'project_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "project" AND tb3.language = \''.$this->language.'\' ','inner'
             ],
             [
                  'project_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "project_catalogue" AND tb4.language = \''.$this->language.'\' ','inner'
             ]
          ],
          'count' => TRUE
     ]);
      $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
      $canonical = project_city_url($city['name'], $city['provinceid'], TRUE);
      $config['base_url'] = write_url($canonical, FALSE, TRUE);
     if($config['total_rows'] > 0){
         $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
         $this->pagination->initialize($config);
         $this->data['pagination'] = $this->pagination->create_links();
         $totalPage = ceil($config['total_rows']/$config['per_page']);
         $page = ($page <= 0)?1:$page;
         $page = ($page > $totalPage)?$totalPage:$page;
         $seoPage = ($page >= 2)?(' - Trang '.$page):'';
         if($page >= 2){
            $canonical = $config['base_url'].'/trang-'.$page.HTSUFFIX;
         }
         $page = $page - 1;
         $project = $this->model->_get_where([
             'select' => '
               tb1.id,
               tb1.created_at,
               tb1.viewed,
               tb1.image,
               tb3.title,
               tb3.canonical,
               tb3.meta_title,
               tb3.meta_description,
               tb3.viewed,
               tb3.description,
               tb3.content,
               tb4.title as cat_title,
               tb1.catalogueid,
               tb4.title as cat_title,
               tb4.canonical as cat_canonical,
               tb4.description as cat_description,
               tb4.template as cat_template,
               tb1.address,
               (SELECT name FROM vn_district WHERE districtid = tb1.district_id) as district,
               (SELECT name FROM vn_province WHERE provinceid  = tb1.city_id) as city',
             'table' => 'project as tb1',
                'where' =>[
                 'tb1.deleted_at' => 0,
                 'tb1.publish' => 1,
                  'tb1.city_id' => $city['provinceid']
           ],
             'join' => [
                 [
                     'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = "project" ', 'inner'
                 ],
                 [
                     'project_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "project" AND tb3.language = \''.$this->language.'\' ','inner'
                 ],
                 [
                     'project_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "project_catalogue" AND tb4.language = \''.$this->language.'\' ','inner'
                 ]
             ],
             'keyword' => $keyword,
             'limit' => $config['per_page'],
             'start' => $page * $config['per_page'],
             'order_by'=> 'tb1.order desc, tb1.id desc',
             'group_by' => 'tb1.id'
         ], TRUE);

     }

     return [
      'list' => ($project) ?? null,
      'pagination' => ($pagination) ?? null,
      'canonical' => $canonical,
     ];
   }

}
