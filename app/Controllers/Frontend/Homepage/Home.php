<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;

class Home extends FrontendController{

	public $data = [];
   protected $province;
   protected $typeRepository;
   protected $priceRepository;
   protected $projectRepository;
   protected $productRepository;
   protected $productService;
   protected $memberRepository;
   protected $array;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->typeRepository = service('TypeRepository', 'product_type');
      $this->projectRepository = service('ProjectRepository', 'project');
      $this->priceRepository = service('PriceRepository', 'product_price');
      $this->productRepository = service('ProductRepository', 'product');
      $this->productCatalogueService = service('productCatalogue',['language' => $this->language]);
      $this->memberRepository = service('MemberRepository', 'member');
      $this->array = service('array');
	}


	public function index(){

      $news = $this->news();
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'));
      $productPrice = $this->array->convertArrayByValue($this->priceRepository->all('id, title'));
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $project = $this->projectRepository->getTenProjectByOrder();
      $productSellCatalogue = $this->productCatalogueService->findById(1, $this->language);
      $productSell = $this->productRepository->getProductByParentNode($productSellCatalogue['lft'], $productSellCatalogue['rgt']);
      $productRentCatalogue = $this->productCatalogueService->findById(18, $this->language);
      $productRent = $this->productRepository->getProductByParentNode($productRentCatalogue['lft'], $productRentCatalogue['rgt']);
      $postCare = $this->postCare();
      $broker = $this->memberRepository->getFiveBroker();
      $general = $this->general;
      $og_type = 'website';
   	$canonical = BASE_URL;
      $meta_title = (isset($general['seo_meta_title']) ? $general['seo_meta_title'] : '');
      $meta_description = (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : '');

      $template = convertUrl('frontend.homepage.home.index');
      return view(convertUrl('frontend.homepage.layout.home'), compact(
            'general',
            'og_type',
            'canonical',
            'meta_title',
            'meta_description',
            'template',
            'province',
            'productType',
            'productPrice',
            'project',
            'news',
            'productSell',
            'productRent',
            'postCare',
            'broker'
         )
      );
	}

   public function postCare(){
      return $this->AutoloadModel->_get_where([
         'select' => 'tb1.id, tb2.canonical, tb1.image, tb2.description, tb2.title',
         'table' => 'article as tb1',
         'join' => [
            ['article_translate as tb2','tb1.id = tb2.objectid','inner']
         ],
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'article',
            'tb1.catalogueid' => 5
         ],
         'limit' => 4,
         'order_by' => 'id desc, order desc'
      ], TRUE);
   }

   public function news(){
      return $this->AutoloadModel->_get_where([
         'select' => 'tb1.id, tb2.canonical, tb1.image, tb2.description, tb2.title',
         'table' => 'article as tb1',
         'join' => [
            ['article_translate as tb2','tb1.id = tb2.objectid','inner']
         ],
         'where' => [
            'tb1.publish' => 1,
            'tb1.deleted_at' => 0,
            'tb2.module' => 'article'
         ],
         'limit' => 4,
         'order_by' => 'id desc, order desc'
      ], TRUE);
   }

}
