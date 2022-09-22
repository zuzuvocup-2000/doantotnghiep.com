<?php
namespace App\Controllers\Frontend\Project;
use App\Controllers\FrontendController;

class Project extends FrontendController{

   protected $data;
   protected $projectService;
   protected $projectCatalogueService;
   protected $projectType;
   protected $language;
   protected $array;
   protected $provinceRepository;
   protected $session;

   public function __construct(){
      $this->session = session();
      $this->data = [];
      $this->module = 'project';
      $this->language = $this->currentLanguage();
      $this->projectService = service('ProjectService',['language' => $this->language]);
      $this->projectCatalogueService = service('ProjectCatalogue',['language' => $this->language]);
      $this->projectType = service('ProjectTypeService',['language' => $this->language]);
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->array = service('array');
   }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $project = $this->projectService->findById($id);
        $this->data['detailCatalogue'] = $this->projectCatalogueService->findById($project['catalogueid'], $this->language);

        $this->data['breadcrumb'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical, tb2.template',
            'table' => $this->module.'_catalogue as tb1',
            'join' => [
                [
                    'project_translate as tb2','tb2.module = \''.$this->module.'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->language.'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.lft <=' => $this->data['detailCatalogue']['lft'],
                'tb1.rgt >=' => $this->data['detailCatalogue']['rgt'],
            ],
            'order_by' => 'tb1.lft asc'
        ], TRUE);


      $this->data['meta_title'] = (!empty( $project['meta_title'])? $project['meta_title']: $project['title']);
      $this->data['meta_description'] = (!empty( $project['meta_description'])? $project['meta_description']:cutnchar(strip_tags( $project['description']), 300));
      $this->data['meta_image'] = !empty( $project['image'])?base_url( $project['image']):((isset($project['album'][0])) ? $project['album'][0] : '');

      $config['base_url'] = write_url($project['canonical'], FALSE, TRUE);
      if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
      $this->data['canonical'] = $config['base_url'].HTSUFFIX;
      }
      $this->data['projectTypeList'] = $this->AutoloadModel->_get_where([
         'select' => '*',
         'table' => 'project_type',
      ], TRUE);
      $this->data['city'] = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $this->data['general'] = $this->general;
      $this->data['project'] = $project;
      $this->data['template'] = 'frontend/project/project/index';
      return view('frontend/homepage/layout/home', $this->data);
    }

}
