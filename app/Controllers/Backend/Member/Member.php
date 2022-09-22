<?php
namespace App\Controllers\Backend\Member;
use App\Controllers\BaseController;

class Member extends BaseController{
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
      $this->module = 'member';
      $this->memberService = service('MemberService',['language' => $this->language]);
      $this->session = session();
	}

	public function index($page = 1){
      if(!$this->authen->gate('backend.member.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      $member = $this->memberService->pagination($page);
      $config['module'] = $this->module;
		$template = convertUrl('backend.member.member.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('member', 'template', 'config', 'member'));
	}

	public function create(){
      if(!$this->authen->gate('backend.member.member.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->memberService->create()){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.member.member.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $validate = $this->validator->listErrors();
         }
		}
      $config['method'] = 'create';
      $template = convertUrl('backend.member.member.create');
      return view(convertUrl('backend.dashboard.layout.home'), compact('template', 'config', 'validate'));
	}

	public function update($id = 0){

      if(!$this->authen->gate('backend.member.member.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

		$id = (int)$id;
	   $member = $this->memberService->findById($id, $this->language);
		if(!isset($member) || is_array($member) == false || count($member) == 0){
			$session->setFlashdata('message-danger', 'Member không tồn tại');
 			return redirect()->to(convertUrl(BASE_URL.'backend.member.member.index'));
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();

			if ($this->validate($validation['validate'], $validation['errorValidate'])){
            if($this->memberService->update($member)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.member.member.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}

      $config['method'] = 'update';
      $template = convertUrl('backend.member.member.update');
      return view(convertUrl('backend.dashboard.layout.home'), compact('template', 'config', 'validate', 'member'));
	}

	public function delete($id = 0){

      if(!$this->authen->gate('backend.member.member.delete')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $id = (int)$id;
	   $member = $this->memberService->findById($id, $this->language);
		if(!isset($member) || is_array($member) == false || count($member) == 0){
			$session->setFlashdata('message-danger', 'Member không tồn tại');
 			return redirect()->to(convertUrl(BASE_URL.'backend.member.member.index'));
		}

      if(!isset($member) || is_array($member) == false || count($member) == 0){
         $session->setFlashdata('message-danger', 'Member không tồn tại');
         return redirect()->to(convertUrl(BASE_URL.'backend.member.member.index'));
      }

		if($this->request->getPost('delete')){
         if($this->memberService->delete($member)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi mới! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.member.member.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi mới không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
		}

      $config['method'] = 'update';
      $template = convertUrl('backend.member.member.delete');
      return view(convertUrl('backend.dashboard.layout.home'), compact('template', 'config', 'validate', 'member'));
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_member_exist',
			'catalogueid' => 'is_natural_no_zero',
			'fullname' => 'required',
		];
		$errorValidate = [
			'email' => [
				'check_email_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Thành Viên'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
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
		$catalogueid = $this->request->getGet('catalogueid');
		if(isset($catalogueid) && $catalogueid != 0){
			$where['catalogueid'] = $catalogueid;
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
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

}
