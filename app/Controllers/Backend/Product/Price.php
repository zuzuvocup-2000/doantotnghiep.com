<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Price extends BaseController{
	protected $data;
   public $module;
   protected $session;
   protected $language;
   protected $authen;

	public function __construct(

   ){
      $this->language = $this->currentLanguage();
		$this->module = 'price';
      $this->priceService = service('PriceService',['language' => $this->language]);
      $this->authen = service('auth');
      $this->session = session();
	}


	public function index($page = 1){
      if(!$this->authen->gate('backend.product.price.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $config['module'] = $this->module;
      $price = $this->priceService->pagination($page);
		$template = convertUrl('backend.product.price.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('price', 'template', 'config'));
	}

	public function create(){
      if(!$this->authen->gate('backend.product.price.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->priceService->create($this->language)){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.price.create'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }
		$config['method'] = 'create';
      $config['module'] = $this->module;
		$template = convertUrl('backend.product.price.create');
		return view(convertUrl('backend.dashboard.layout.home'), compact('config', 'template', 'validate'));
	}


	public function update($id = 0){
      if(!$this->authen->gate('backend.product.price.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $price = $this->priceService->findById($id, $this->language);

		if(!isset($price) || is_array($price) == false || count($price) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.price.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->priceService->update($price)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.price.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}
      $config['method'] = 'update';
      $config['module'] = $this->module;
		$template = convertUrl('backend.product.price.update');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'price')
      );
	}

	public function delete($id = 0){
      if(!$this->authen->gate('backend.product.price.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
		$price = $this->priceService->findById($id, $this->language);
      if(!isset($price) || is_array($price) == false || count($price) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.price.index'));
		}

      if($this->request->getMethod() == 'post'){
         if($this->priceService->delete($price)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.product.price.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
      }

      $config['method'] = 'update';
      $config['module'] = $this->module;
      $template = convertUrl('backend.product.price.delete');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'price')
      );
	}



   private function validation(){
      $validate = [
         'title' => 'required',
      ];
      $errorValidate = [
         'title' => [
            'required' => 'Bạn phải nhập vào trường tiêu đề'
         ],
      ];
      return [
         'validate' => $validate,
         'errorValidate' => $errorValidate,
      ];
   }




}
