<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Catalogue extends FrontendController{

   protected $data;
   protected $city;
   protected $typeRepository;
   protected $priceRepository;
   protected $projectRepository;
   protected $productRepository;
   protected $productService;
   protected $memberRepository;
   protected $array;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'product_catalogue';
        $this->data['language'] = $this->currentLanguage();
        $this->array = service('array');
        $this->provinceRepository = service('ProvinceRepository', 'vn_province');
        $this->typeRepository = service('TypeRepository', 'product_type');
        $this->priceRepository = service('PriceRepository', 'product_price');
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $detailCatalogue = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb1.album',
            'table' => $this->data['module'].' as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ]
        ]);
        $this->data['detailCatalogue'] = $detailCatalogue;

        if(!isset($this->data['detailCatalogue']) || !is_array($this->data['detailCatalogue']) || count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Danh mục không tồn tại!');
            header('location:'.BASE_URL);
        }
        $breadcrumb = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical, tb1.parentid',
            'table' => $this->data['module'].' as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
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

        $this->data['breadcrumb'] = $breadcrumb;

        $seoPage = '';
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
        $keyword = $this->condition_keyword();
        $catalogue = $this->condition_catalogue($id);
        $config['total_rows'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id',
            'table' => $module_extract[0].' as tb1',
            'keyword' => $keyword,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'count' => TRUE
        ]);
        $this->data['count_product'] = $config['total_rows'];

        $config['base_url'] = write_url($this->data['detailCatalogue']['canonical'], FALSE, TRUE);
        if($config['total_rows'] > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();

            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            if($page >= 2){
                $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;

            $order_by = 'tb1.order desc, tb1.id desc';
            if(isset($_GET['order_by']) && $_GET['order_by'] != ''){
                $order_by = $_GET['order_by'];
            }
            $this->data['productList'] = $this->AutoloadModel->_get_where([
                'select' => '
                  tb1.id,
                  tb1.image,
                  tb1.code,
                  tb1.catalogueid,
                  tb1.form,
                  tb1.type,
                  tb1.area,
                  tb1.juridical,
                  tb1.direction,
                  tb1.horizontal,
                  tb1.long,
                  tb1.floor,
                  tb1.front,
                  tb1.bed,
                  tb1.price,
                  tb1.kitchen,
                  tb1.terrace,
                  tb1.parking,
                  tb1.own,
                  tb1.city_id,
                  tb1.district_id,
                  tb1.address,
                  tb1.created_at,
                  tb3.title,
                  tb3.canonical,
                  tb3.description,
               ',
                'table' => $module_extract[0].' as tb1',
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1
                ],
                'where_in' => $catalogue['where_in'],
                'where_in_field' => $catalogue['where_in_field'],
                'keyword' => $keyword,
                'join' => [
                    [
                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                    ],
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "product_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
                    ]
                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=>  $order_by,
                'group_by' => 'tb1.id'
            ], TRUE);
        }

        $this->data['province'] = $this->AutoloadModel->_get_where([
          'select' => '*',
          'table' => 'vn_province',
          'order_by' => 'order desc'
       ], TRUE);

      $this->data['productType'] = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), '[Chọn Loại BĐS]');
      $this->data['city'] = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $this->data['productPrice'] = $this->array->convertArrayByValue($this->priceRepository->all('id, title'), '[Chọn khoảng giá]');
      $this->data['meta_title'] = (!empty( $this->data['detailCatalogue']['meta_title'])? $this->data['detailCatalogue']['meta_title']: $this->data['detailCatalogue']['title']).$seoPage;
      $this->data['meta_description'] = (!empty( $this->data['detailCatalogue']['meta_description'])? $this->data['detailCatalogue']['meta_description']:cutnchar(strip_tags( $this->data['detailCatalogue']['description']), 300)).$seoPage;
      $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

      if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
         $this->data['canonical'] = $config['base_url'].HTSUFFIX;
      }

        $this->data['general'] = $this->general;
        $this->data['perpage'] = $perpage;
        $this->data['template'] = 'frontend/product/catalogue/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }

    public function condition_catalogue($catalogueid = 0){
        $id = [];
        $module_extract = explode("_", $this->data['module']);
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $module_extract[0].'_catalogue as tb1',
                'join' =>  [
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "product_catalogue"','inner'
                    ],
                ],
                'where' => ['tb1.id' => $catalogueid],
            ]);
            $catalogueChildren = $this->AutoloadModel->_get_where([
                'select' => 'id',
                'table' => $module_extract[0].'_catalogue',
                'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
            ], TRUE);

            $id = array_column($catalogueChildren, 'id');
        }
        return [
            'where_in' => $id,
            'where_in_field' => 'tb2.catalogueid'
        ];

    }
}
