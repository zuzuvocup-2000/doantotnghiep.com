<?php
namespace App\Controllers\Backend\Member;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
   protected $module;
   protected $session;
   protected $language;
   protected $authen;
   protected $array;
   protected $memberCatalogueService;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->authen = service('auth');
      $this->array = service('array');
		$this->module = 'member_catalogue';
      $this->memberCatalogueService = service('MemberCatalogue',['language' => $this->language]);
      $this->session = session();
	}

	public function index($page = 1){
      if(!$this->authen->gate('backend.member.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      $memberCatalogue = $this->memberCatalogueService->pagination($page);
      $config['module'] = $this->module;
		$template = convertUrl('backend.member.catalogue.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('member', 'template', 'config', 'memberCatalogue'));
	}

	public function create(){
      if(!$this->authen->gate('backend.member.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm thành viên!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
            if($this->memberCatalogueService->create()){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.member.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}
      $config['method'] = 'create';
      $template = convertUrl('backend.member.catalogue.create');
      return view(convertUrl('backend.dashboard.layout.home'), compact('template', 'config', 'validate'));
	}

	public function update($id = 0){

      if(!$this->authen->gate('backend.member.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
		$memberCatalogue = $this->memberCatalogueService->findById($id, $this->language);
      if(!isset($memberCatalogue) || is_array($memberCatalogue) == false || count($memberCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.member.catalogue.index'));
		}
		if($this->request->getMethod() == 'post'){
			$validate = [
				'title' => 'required',
			];
			$errorValidate = [
				'title' => [
					'required' => 'Bạn bắt buộc phải nhập vào ô Tiêu đề nhóm thành viên!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
            if($this->memberCatalogueService->update($memberCatalogue)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.member.catalogue.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
	        	$this->data['validate'] = $this->validator->listErrors();
        }
		}
      $config['method'] = 'update';
      $template = convertUrl('backend.member.catalogue.update');
      return view(convertUrl('backend.dashboard.layout.home'), compact('template', 'config', 'validate', 'memberCatalogue'));
	}

	public function delete($id = 0){
      if(!$this->authen->gate('backend.member.catalogue.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
		$memberCatalogue = $this->memberCatalogueService->findById($id, $this->language);
      if(!isset($memberCatalogue) || is_array($memberCatalogue) == false || count($memberCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.member.catalogue.index'));
		}

      if($this->request->getMethod() == 'post'){
         if($this->memberCatalogueService->delete($memberCatalogue)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.member.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
      }

      $config['method'] = 'update';
      $config['module'] = $this->module;
      $template = convertUrl('backend.member.catalogue.delete');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'memberCatalogue')
      );

	}

	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != -1 && $gender != '' && isset($gender)){
			$where['gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'title' => $this->request->getPost('title'),
 			'permission' => json_encode($this->request->getPost('permission')),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

}
