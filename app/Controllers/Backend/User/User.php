<?php
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{
	protected $data;
	protected $userService;
	protected $authen;

	public function __construct(){
		$this->data = [];
		$this->module = 'user';
		$this->authen = service('auth');
		$this->session = session();
      	$this->userService = service('UserService');
	}

	public function index($page = 1){
		if(!$this->authen->gate('backend.user.user.index')){
         	$this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         	return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
  		}

  		$user = $this->userService->pagination($page);

		$module = $this->module;
		$template = convertUrl('backend.user.user.index');
		return view(
			convertUrl('backend.dashboard.layout.home'),
			compact(
	         	'template', 'module', 'user'
	     	)
		);
	}

	public function create(){
		if(!$this->authen->gate('backend.user.user.create')){
         	$this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         	return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
  		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				if($this->userService->create()){
	               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
	               return redirect()->to(BASE_URL.convertUrl('backend.user.user.create'));
	            }else{
	               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
	               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
	            }
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$module = $this->module;
      	$method = 'create';
		$template = convertUrl('backend.user.user.store');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         	'template', 'method', 'module'
     	)
      );
	}

	public function update($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->module] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email,job, phone, address, birthday, gender, cityid, districtid, wardid, image',
			'table' => $this->module,
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->module]) || is_array($this->data[$this->module]) == false || count($this->data[$this->module]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$update = $this->store();
		 		$flag = $this->AutoloadModel->_update(['table' => $this->module,'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/user/user/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/user/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->module] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email, phone, address, birthday, gender',
			'table' => $this->module,
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->module]) || is_array($this->data[$this->module]) == false || count($this->data[$this->module]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		if($this->request->getPost('delete')){
			$userID = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $userID],
				'table' => $this->module
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$this->data['template'] = 'backend/user/user/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_exist',
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

	private function store(){
		helper(['text']);
		$salt = random_string('alnum', 168);
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'gender' => (int)$this->request->getPost('gender'),
 			'image' => $this->request->getPost('image'),
 			'job' => $this->request->getPost('job'),
 			'birthday' => $this->request->getPost('birthday'),
 			'address' => $this->request->getPost('address'),
 			'phone' => $this->request->getPost('phone'),
 			'cityid' => $this->request->getPost('cityid'),
 			'districtid' => $this->request->getPost('districtid'),
 			'wardid' => $this->request->getPost('wardid'),
 		];
 		if($this->request->getPost('password')){
 			$store['password'] = password_encode($this->request->getPost('password'), $salt);
 			$store['salt'] = $salt;
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
