<?php
namespace App\Controllers\Frontend\Member;
use App\Controllers\FrontendController;
use App\Libraries\MemberAuthentication as Member;

class Profile extends FrontendController{

	public $data = [];
   protected $province;
   protected $memberService;
   protected $memberRepository;
   protected $language;
   protected $provinceRepository;
   protected $array;
   protected $session;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->memberRepository = service('MemberRepository', 'member');
      $this->memberService = service('MemberService',['language' => $this->language]);
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->array = service('array');
      $this->session = session();
	}


	public function index(){

      $province = $this->AutoloadModel->_get_where([
        'select' => '*',
        'table' => 'vn_province',
        'order_by' => 'order desc'
      ], TRUE);


   	$canonical = 'member/profile';
      $meta_title = 'Quản lý cá nhân';
      $meta_description = (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : '');
      $template = convertUrl('frontend.member.profile.index');
      $general = $this->general;
      return view(convertUrl('frontend.homepage.layout.home'), compact(
            'general',
            'og_type',
            'canonical',
            'meta_title',
            'meta_description',
            'province',
            'template'
         )
      );
	}

   public function info(){
      $member = $this->memberRepository->findById(['*'], Member::id());
      $validation = [];
      if($this->request->getMethod() == 'post'){
         $validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){

            if($this->memberService->update($member)){

               $this->session->setFlashdata('message-success', 'Cập nhật thông tin thành công!');
               return redirect()->to(BASE_URL.'member/info'.HTSUFFIX);
            }else{
               $this->session->setFlashdata('message-error', 'Có vấn đề xảy ra, Hãy thử lại.');
               return redirect()->to(BASE_URL.'member/profile'.HTSUFFIX);
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      // dd($member);
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $canonical = 'member/info';
      $meta_title = 'Quản lý cá nhân';
      $meta_description = (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : '');
      $template = convertUrl('frontend.member.profile.info');
      $general = $this->general;
      return view(convertUrl('frontend.homepage.layout.home'), compact(
            'general',
            'og_type',
            'canonical',
            'meta_title',
            'meta_description',
            'province',
            'member',
            'validate',
            'template'
         )
      );
   }

   public function changePassword(){
      $member = $this->memberRepository->findById(['*'], Member::id());
      $validation = $this->change_password();
      if($this->request->getMethod() == 'post'){
			if ($this->validate($validation['validate'], $validation['errorValidate'])){

            if($this->memberService->changePassword($member)){

               $this->session->setFlashdata('message-success', 'Cập nhật thông tin thành công!');
               return redirect()->to(BASE_URL.'member/info'.HTSUFFIX);
            }else{
               $this->session->setFlashdata('message-error', 'Có vấn đề xảy ra, Hãy thử lại.');
               return redirect()->to(BASE_URL.'member/profile'.HTSUFFIX);
            }
         }else{
            $validate = $this->validator->listErrors();
         }
      }

      // dd($member);
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $canonical = 'member/info';
      $meta_title = 'Quản lý cá nhân';
      $meta_description = (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : '');
      $template = convertUrl('frontend.member.profile.changePassword');
      $general = $this->general;
      return view(convertUrl('frontend.homepage.layout.home'), compact(
            'general',
            'og_type',
            'canonical',
            'meta_title',
            'meta_description',
            'province',
            'member',
            'validate',
            'template'
         )
      );
   }

   private function change_password(){
      $validate = [
         'password' => 'required|min_length[6]',
         're_password' => 'matches[password]',
      ];
      $errorValidate = [
         'password' => [
            'required' => 'Bạn phải nhập vào nhật khẩu!',
         ],
      ];
      return [
         'validate' => $validate,
         'errorValidate' => $errorValidate,
      ];
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

}
