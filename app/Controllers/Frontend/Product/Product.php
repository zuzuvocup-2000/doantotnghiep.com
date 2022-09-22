<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Product extends FrontendController{

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
      $this->data['module'] = 'product';
      $this->data['language'] = $this->currentLanguage();
      $this->array = service('array');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->typeRepository = service('TypeRepository', 'product_type');
      $this->priceRepository = service('PriceRepository', 'product_price');
      $this->projectRepository = service('ProjectRepository', 'project');
   }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $id = (int)$id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $keyword = $this->condition_keyword();
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => '
               tb1.id,
               tb1.image,
               tb1.album,
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
               tb1.dining_room,
               tb1.parking,
               tb1.own,
               tb1.viewed,
               tb1.city_id,
               tb1.district_id,
               tb1.address,
               tb1.created_at,
               tb1.userid_created,
               tb1.memberid_created,
               tb2.title,
               tb2.canonical,
               tb2.description,
               tb2.content,
               tb2.meta_title,
               tb2.meta_description,
               (SELECT title FROM product_type WHERE product_type.id = tb1.type) as product_type,
               (SELECT name FROM vn_province WHERE vn_province.provinceid = tb1.city_id) as city_name,
               (SELECT name FROM vn_district WHERE vn_district.districtid = tb1.district_id) as district_name
            '
            ,
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ],
            ],
        ]);
        // $this->data['object'] = $this->convert_data($this->data['object']);
        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id,tb1.lft, tb1.rgt, tb1.level, tb1.parentid, tb1.image,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $this->data['object']['catalogueid']
            ]
        ]);
        $cookie = $this->set_cookie($id, $this->data['object']);

        if(!isset($this->data['detailCatalogue']) || is_array($this->data['detailCatalogue']) == false && count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            header('location:'.BASE_URL);
        }


      $this->data['product_general'] = $this->product_general($module_extract, $id);
      $breadcrumb = $this->breadcrumb($module_extract);
      $this->data['breadcrumb'] = $breadcrumb;
      $this->data['meta_title'] = (!empty( $this->data['object']['meta_title']) ? $this->data['object']['meta_title']: $this->data['object']['title']);
      $this->data['meta_description'] = (!empty( $this->data['object']['meta_description'])? $this->data['object']['meta_description']:cutnchar(strip_tags( $this->data['object']['description']), 300));
      $this->data['meta_image'] = !empty( $this->data['object']['image'])?base_url( $this->data['object']['image']):((isset($this->data['object']['album'][0])) ? $this->data['object']['album'][0] : '');

      $config['base_url'] = write_url($this->data['object']['canonical'], FALSE, TRUE);
      if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
         $this->data['canonical'] = $config['base_url'].HTSUFFIX;
      }

      $this->data['member'] = [];
      if($this->data['object']['memberid_created'] > 0){

         $this->data['member']['owner'] = 'member';
      }else{
         $this->data['member'] = $this->AutoloadModel->_get_where([
            'select' => 'id, fullname, phone',
            'table' => 'user',
            'where' => [
               'id' => $this->data['object']['userid_created']
            ]
         ]);
         $this->data['member']['owner'] = 'admin';
      }

      $this->data['province'] = $this->AutoloadModel->_get_where([
        'select' => '*',
        'table' => 'vn_province',
        'order_by' => 'order desc'
      ], TRUE);


      $this->data['projectByDistrict'] = $this->projectRepository->getProjectByDistrict($this->data['object']['district_id']);
      // dd($this->data['projectByDistrict']);
      $this->data['district'] = $this->getDistrictByCityId($this->data['object']['city_id'], $this->data['object']['type']);
      $this->data['productType'] = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), '[Chọn Loại BĐS]');
      $this->data['city'] = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $this->data['productPrice'] = $this->array->convertArrayByValue($this->priceRepository->all('id, title'), '[Chọn khoảng giá]');
      $this->data['general'] = $this->general;
      $this->data['template'] = 'frontend/product/product/index';
      return view('frontend/homepage/layout/home', $this->data);
    }

    private function getDistrictByCityId($id, $type){
      return $this->AutoloadModel->_get_where([
         'select' => '*, (SELECT COUNT(id) FROM product WHERE product.district_id = vn_district.districtid AND product.type = '.$type.' ) as count_product',
         'table' => 'vn_district',
         'where' => [
            'provinceid' => $id
         ],
         'order_by' => 'name asc'
      ], TRUE);
   }

    private function product_general($module_extract = [], $id = []){
        $product_general = $this->AutoloadModel->_get_where([
            'select' => '
               tb3.id,
               tb3.image,
               tb3.album,
               tb3.code,
               tb3.catalogueid,
               tb3.form,
               tb3.type,
               tb3.area,
               tb3.juridical,
               tb3.direction,
               tb3.horizontal,
               tb3.long,
               tb3.floor,
               tb3.front,
               tb3.bed,
               tb3.price,
               tb3.kitchen,
               tb3.terrace,
               tb3.dining_room,
               tb3.parking,
               tb3.own,
               tb3.viewed,
               tb3.city_id,
               tb3.district_id,
               tb3.address,
               tb3.created_at,
               tb2.title,
               tb2.canonical,
               tb2.description,
               tb2.content,
               tb2.meta_title,
               tb2.meta_description,
               (SELECT title FROM product_type WHERE product_type.id = tb3.type) as product_type
            ',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$module_extract[0].'\' AND tb2.objectid = tb1.objectid AND tb2.language = \''.$this->currentLanguage().'\'','inner'
                ],
                [
                    $module_extract[0].' as tb3', 'tb1.objectid = tb3.id AND tb3.deleted_at = 0','inner'
                ]
            ],
            'where' => [
                'tb1.module' => $module_extract[0],
            ],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'group_by' => 'tb3.id',
            'order_by' => 'tb3.order desc, tb3.id desc',
            'limit' => 12
         ],TRuE);
         return $product_general;
    }
    private function category(){
        $category = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.canonical, tb2.title',
            'table' => 'product_catalogue as tb1',
            'join' => [
                ['product_translate as tb2', 'tb2.objectid = tb1.id', 'inner']
            ],
            'where' => [
                'tb1.publish' => 1,
                'tb1.level' => 2,
                'tb2.module' => 'product_catalogue'
            ]
        ], TRUE);
        return $category;
    }
    private function breadcrumb($module_extract = []){
        $breadcrumb = $this->AutoloadModel->_get_where([
            'select' => 'tb1.lft, tb1.rgt, tb1.id, tb1.parentid,  tb2.title, tb2.canonical',
            'table' => $this->data['module'].'_catalogue as tb1',
            'join' => [
                [
                    $module_extract[0].'_translate as tb2','tb2.module = \''.$this->data['module'].'_catalogue\' AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
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
        return $breadcrumb;
    }

    private function get_list_wholesale($id = 0){
        $check = $this->AutoloadModel->_get_where([
            'select' => 'number_start, number_end, price',
            'table' => 'product_wholesale',
            'where' => ['objectid' => $id, 'module' => $this->data['module']]
        ]);
        if(isset($check) && is_array($check) && count($check)){
            $array = [
                'number_start' => json_decode($check['number_start']),
                'number_end' => json_decode($check['number_end']),
                'price_wholesale' => json_decode($check['price']),
            ];
            $data = [];
            foreach ($array as $key => $value) {
                foreach ($value as $keyChild => $valChild) {
                    $data[$keyChild][$key] = $valChild;
                }
            }
            return $data;
        }

    }

    private function data_rate($param = []){
        $full = $this->AutoloadModel->_get_where([
            'select' => 'fullname, comment, rate, created_at, phone, email, id, created_at, publish, url, module, image, album',
            'table' => 'comment',
            'where' => [
                'deleted_at' => 0,
                'module' => $param['module'],
                'url' => $param['canonical'],
                'parentid' => 0
            ],
            'order_by' => 'created_at asc'
        ], TRUE);
        $calculator = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        ];
        $rate = [];
        if(isset($full) && is_array($full) && count($full)){
            foreach ($full as $key => $value) {
                $full[$key]['comment'] = base64_decode($value['comment']);
                foreach ($calculator as $keyCal => $valueCal) {
                    if($value['rate'] == $keyCal && $value['publish'] == 1){
                        $calculator[$keyCal] = $calculator[$keyCal] + 1;
                    }
                }
            }
            foreach ($full as $key => $value) {
               if($value['publish'] == 1){
                    array_push($rate, $value);
                }
            }
        }
        $sum_star = 0;
        $sum_comment = 0;
        foreach ($calculator as $key => $value) {
            $sum_star = $sum_star + ($key * $value);
            $sum_comment = $sum_comment + $value;
        }
        if($sum_comment == 0){
            $result['total'] = 0;
        }else{
            $result['total'] = round($sum_star/$sum_comment,1);
        }
        $result['sum'] = $sum_comment;
        $result['all_comment'] = $full;
        $result['comment_publish_1'] = $rate;
        $result['calculator'] = $calculator;
        return $result;
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(title LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }

    private function set_cookie($id = 0, $param = []){
        $idList = [];
        if(!isset($_COOKIE['COUNT_'.$this->data['module']]) || empty($_COOKIE['COUNT_'.$this->data['module']])){
            array_push($idList, $id);
            setcookie('COUNT_'.$this->data['module'], json_encode($idList), time() + 1*24*3600, "/");
            $cookie = $this->AutoloadModel->_update([
                'table' => $this->data['module'],
                'where' => [
                    'id' => $id,
                    'deleted_at' => 0,
                    'publish' => 1
                ],
                'data' => [
                    'viewed' => $param['viewed'] + 1,
                    'created_at' => $this->currentTime
                ]
            ]);
        }else{
            $getCookie = $this->request->getCookie('COUNT_'.$this->data['module']);
            $getCookie = json_decode($getCookie);
            $count = 0;
            foreach ($getCookie as $key => $value) {
                if($id == $value){
                    $count++;
                }
            }
            if($count == 0){
                array_push($getCookie, $id);
                setcookie('COUNT_'.$this->data['module'], json_encode($getCookie), time() + 1*24*3600, "/");
                $cookie = $this->AutoloadModel->_update([
                    'table' => $this->data['module'],
                    'where' => [
                        'id' => $id,
                        'deleted_at' => 0,
                        'publish' => 1
                    ],
                    'data' => [
                        'viewed' => $param['viewed'] + 1,
                        'created_at' => $this->currentTime
                    ]
                ]);
            }
        }
        return true;
    }

    private function rewrite_album($param = []){
        $sub_album = json_decode($param['sub_album'],TRUE);
        $sub_album_title = json_decode($param['sub_album_title'],TRUE);
        $album = [];
        if(isset($sub_album) && is_array($sub_album) && count($sub_album)){
            foreach ($sub_album as $key => $value) {
                foreach ($sub_album_title as $keyTitle => $valTitle) {
                    if($key == $keyTitle){
                        $album[$key]['title'] = $valTitle;
                        $album[$key]['album'] = $value;
                    }
                }
            }

        }
        return $album;
    }

    private function convert_data($param = []){
        if(isset($param['album']) && $param['album'] != ''){
            $param['album'] = json_decode($param['album']);
        }
        if(isset($param['info']) && $param['info'] != ''){
            $param['info'] = json_decode($param['info'], TRUE);
        }
        if(isset($param['brand']) && $param['brand'] != ''){
            $param['brand'] = json_decode($param['brand'], TRUE);
        }
        if(isset($param['description']) && $param['description'] != ''){
            $param['description'] = validate_input(base64_decode($param['description']));
        }
        if(isset($param['content']) && $param['content'] != ''){
            $param['content'] = validate_input(base64_decode($param['content']));
        }
        if(isset($param['sub_content']) && $param['sub_content'] != ''){
            $param['sub_content'] = json_decode(base64_decode($param['sub_content']));
        }
        if(isset($param['sub_title']) && $param['sub_title'] != ''){
            $param['sub_title'] = json_decode(base64_decode($param['sub_title']));
        }

        return $param;
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
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "product"','inner'
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
