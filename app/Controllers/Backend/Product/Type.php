<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Type extends BaseController{
	protected $data;
   public $module;
   protected $session;
   protected $language;
   protected $authen;

	public function __construct(

   ){
      $this->language = $this->currentLanguage();
		$this->module = 'type';
      $this->typeService = service('TypeService',['language' => $this->language]);
      $this->authen = service('auth');
      $this->session = session();
	}


	public function index($page = 1){
      if(!$this->authen->gate('backend.product.type.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $config['module'] = $this->module;
      $type = $this->typeService->pagination($page);
		$template = convertUrl('backend.product.type.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('type', 'template', 'config'));
	}

	public function create(){
      if(!$this->authen->gate('backend.product.type.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->typeService->create($this->language)){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.type.create'));
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
		$template = convertUrl('backend.product.type.create');
		return view(convertUrl('backend.dashboard.layout.home'), compact('config', 'template', 'validate'));
	}


	public function update($id = 0){
      if(!$this->authen->gate('backend.product.type.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $type = $this->typeService->findById($id, $this->language);

		if(!isset($type) || is_array($type) == false || count($type) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.type.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->typeService->update($type)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.type.index'));
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
		$template = convertUrl('backend.product.type.update');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'type')
      );
	}

	public function delete($id = 0){
      if(!$this->authen->gate('backend.product.type.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
		$type = $this->typeService->findById($id, $this->language);
      if(!isset($type) || is_array($type) == false || count($type) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.product.type.index'));
		}

      if($this->request->getMethod() == 'post'){
         if($this->typeService->delete($type)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.product.type.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
      }

      $config['method'] = 'update';
      $config['module'] = $this->module;
      $template = convertUrl('backend.product.type.delete');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'type')
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
