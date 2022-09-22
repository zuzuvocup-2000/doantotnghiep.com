<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
	protected $data;
	public $nestedsetbie;
   public $module;
   protected $session;
   protected $language;

	public function __construct(

   ){
      $this->language = $this->currentLanguage();
		$this->module = 'product_catalogue';
      $this->productCatalogueService = service('productCatalogue',['language' => $this->language]);
      $this->nestedsetbie = service('nestedSetBie', ['table' => $this->module, 'language' => $this->language]);
      $this->session = session();
	}


	public function index($page = 1){
      gate('backend.product.catalogue.index');

      $config['module'] = $this->module;
      $productCatalogue = $this->productCatalogueService->pagination($page);
		$template = convertUrl('backend.product.catalogue.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('productCatalogue', 'template', 'config'));
	}

	public function create(){
      gate('backend.product.catalogue.create');
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productCatalogueService->create($this->language)){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.catalogue.create'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }

      }
      $config['dropdown'] = $this->nestedsetbie->dropdown();
		$config['method'] = 'create';
      $config['module'] = $this->module;
		$template = convertUrl('backend.product.catalogue.create');
		return view(convertUrl('backend.dashboard.layout.home'), compact('config', 'template', 'validate'));
	}


	public function update($id = 0){
		gate('backend.product.catalogue.update');
		$id = (int)$id;
      $productCatalogue = $this->productCatalogueService->findById($id, $this->language);

		if(!isset($productCatalogue) || is_array($productCatalogue) == false || count($productCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productCatalogueService->update($productCatalogue)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['method'] = 'update';
      $config['module'] = $this->module;
		$template = convertUrl('backend.product.catalogue.update');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'productCatalogue')
      );
	}

	public function delete($id = 0){
		gate('backend.product.catalogue.update');
		$id = (int)$id;
		$productCatalogue = $this->productCatalogueService->findById($id, $this->language);
      if(!isset($productCatalogue) || is_array($productCatalogue) == false || count($productCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.catalogue.index'));
		}

      if($this->request->getMethod() == 'post'){
         if($this->productCatalogueService->delete($productCatalogue)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.product.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
      }

      $config['method'] = 'delete';
      $config['module'] = $this->module;
      $template = convertUrl('backend.member.catalogue.delete');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'productCatalogue')
      );
	}



   private function validation(){
      $validate = [
         'title' => 'required',
         'canonical' => 'required|check_router['.$this->module.']',
      ];
      $errorValidate = [
         'title' => [
            'required' => 'Bạn phải nhập vào trường tiêu đề'
         ],
         'canonical' => [
            'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
            'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
         ],
      ];
      return [
         'validate' => $validate,
         'errorValidate' => $errorValidate,
      ];
   }




}
