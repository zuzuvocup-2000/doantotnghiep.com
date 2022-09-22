<?php
namespace App\Controllers\Backend\Authentication;
use App\Controllers\BaseController;


class Auth extends BaseController{
	protected $data;

	public function __construct(){
		$this->session = session();
      	$this->authService = service('AuthService');
	}

	public function login(){
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email',
				'password' => 'required|min_length[6]|checkAuth['.$this->request->getVar('email').']|checkCatalogueActive['.$this->request->getVar('email').']|checkActive['.$this->request->getVar('email').']',
			];
			$errorValidate = [
				'password' => [
					'checkAuth' => 'Email Hoặc Mật khẩu không chính xác!',
					'checkCatalogueActive' => 'Nhóm tài khoản của bạn đang bị khóa!',
					'checkActive' => 'Tài khoản của bạn đang bị khóa!',
				],
			];

 		 	if ($this->validate($validate, $errorValidate)){
 		 		if($this->authService->login()){
	               $this->session->setFlashdata('message-success', 'Đăng nhập thành công');
	               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
	            }else{
	               $this->session->setFlashdata('message-error', 'Có lỗi xảy ra! Xin vui lòng thử lại.');
	               return redirect()->to(BASE_URL.convertUrl(BACKEND_DIRECTORY));
	            }
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		return view(convertUrl('backend.authentication.login'));
	}

	public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(BACKEND_DIRECTORY);
    }

	public function forgot(){

		helper(['mymail']);
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email|check_email',
			];
			$errorValidate = [
				'email' => [
					'check_email' => 'Email không tồn tại trong hệ thống!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				if($user = $this->authService->forgot()){
	               $this->session->setFlashdata('message-success', 'Gửi mã OTP thành công! Xin vui lòng check mail!');
	               return redirect()->to(BASE_URL.'backend/authentication/auth/verify?token='.base64_encode(json_encode($user)));
	            }else{
	               $this->session->setFlashdata('message-error', 'Có lỗi xảy ra xin vui lòng thử lại!');
	               return redirect()->to(BASE_URL.convertUrl('backend.authentication.auth.forgot'));
	            }
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		return view(convertUrl('backend.authentication.forgot'));
	}

	public function verify(){
		helper('text');
		if($this->request->getMethod() == 'post'){
			$validate = [
				'otp' => 'required|check_otp',
			];
			$errorValidate = [
				'otp' => [
					'check_otp' => 'Mã OTP không chính xác hoặc đã hết thời gian sử dụng!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				if($this->authService->verify()){
	               $this->session->setFlashdata('message-success', 'Đổi mật khẩu thành công! Xin vui lòng check mail để lấy mật khẩu mới!');
	               return redirect()->to(BACKEND_DIRECTORY);
	            }else{
	               $this->session->setFlashdata('message-error', 'Có lỗi xảy ra xin vui lòng thử lại!');
	            }

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		return view(convertUrl('backend.authentication.verify'));
	}
}
