<?php
namespace App\Controllers\Frontend\Advertise;
use App\Controllers\FrontendController;

class Advertise extends FrontendController{
   public $module;
   protected $language;
   protected $array;
   protected $productService;
   protected $provinceRepository;
   protected $typeRepository;
   protected $priceRepository;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->array = service('array');
      $this->session = session();
		$this->module = 'product';
      $this->productService =  service('ProductService',['language' => $this->language]);
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->typeRepository = service('TypeRepository', 'product_type');
      $this->priceRepository = service('PriceRepository', 'product_price');

	}

	public function sellByCity($cityId = '', $page = 1){
      $cityDetail = $this->provinceRepository->findCityById($cityId);
      $product = $this->productService->sellByCity($cityDetail, $page);
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), '[Chọn Loại BĐS]');
      $productPrice = $this->array->convertArrayByValue($this->priceRepository->all('id, title'), '[Chọn khoảng giá]');
      $canonical = write_url($product['canonical']);
      $general = $this->general;
      $city = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $template = convertUrl('frontend.advertise.advertise.SellByCity');
      $meta_title = 'Cần Bán Bất động sản tại '.$cityDetail['name'];
      $meta_description = 'Cần Bán Bất động sản tại '.$cityDetail['name'].' Cập nhật thông tin mới nhất các dự án tại '.$cityDetail['name'];
      $province = $this->AutoloadModel->_get_where([
        'select' => '*',
        'table' => 'vn_province',
        'order_by' => 'order desc'
     ], TRUE);
      return view(convertUrl('frontend.homepage.layout.home'), compact(
         'general','city','product','template','meta_title','meta_description','canonical','productType','productPrice','cityDetail','province'
         )
      );
	}

   public function sellByDistrictFormType($districtId, $type, $form, $page = 1){
      $districtDetail = $this->provinceRepository->findDistrictById($districtId);
      $product = $this->productService->sellByDistrictFormType($districtDetail, $type, $form, $page);
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), '[Chọn Loại BĐS]');
      $productPrice = $this->array->convertArrayByValue($this->priceRepository->all('id, title'), '[Chọn khoảng giá]');
      $canonical = write_url($product['canonical']);
      $general = $this->general;
      $city = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $productTypeDetail = $this->typeRepository->findById('*', $type);

      $meta_title = 'Cần Bán Bất động sản tại '.$districtDetail['name'];
      $meta_description = 'Cần Bán Bất động sản tại '.$districtDetail['name'].' Cập nhật thông tin mới nhất các dự án tại '.$districtDetail['name'];
      $province = $this->AutoloadModel->_get_where([
        'select' => '*',
        'table' => 'vn_province',
        'order_by' => 'order desc'
      ], TRUE);
      $template = convertUrl('frontend.advertise.advertise.sellByDistrictFormType');
      return view(convertUrl('frontend.homepage.layout.home'), compact(
         'general','city','product','template','meta_title','meta_description','canonical','productType','productPrice','districtDetail','province','form','productTypeDetail'
         )
      );
   }

   public function rentByDistrictFormType($districtId, $type, $form, $page = 1){
      $districtDetail = $this->provinceRepository->findDistrictById($districtId);
      $product = $this->productService->sellByDistrictFormType($districtDetail, $type, $form, $page);
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), '[Chọn Loại BĐS]');
      $productPrice = $this->array->convertArrayByValue($this->priceRepository->all('id, title'), '[Chọn khoảng giá]');
      $canonical = write_url($product['canonical']);
      $general = $this->general;
      $city = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $productTypeDetail = $this->typeRepository->findById('*', $type);

      $meta_title = 'Cần Bán Bất động sản tại '.$districtDetail['name'];
      $meta_description = 'Cần Bán Bất động sản tại '.$districtDetail['name'].' Cập nhật thông tin mới nhất các dự án tại '.$districtDetail['name'];
      $province = $this->AutoloadModel->_get_where([
        'select' => '*',
        'table' => 'vn_province',
        'order_by' => 'order desc'
      ], TRUE);
      $template = convertUrl('frontend.advertise.advertise.sellByDistrictFormType');
      return view(convertUrl('frontend.homepage.layout.home'), compact(
         'general','city','product','template','meta_title','meta_description','canonical','productType','productPrice','districtDetail','province','form','productTypeDetail'
         )
      );
   }



}
