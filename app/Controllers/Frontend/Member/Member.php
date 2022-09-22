<?php
namespace App\Controllers\Frontend\Member;
use App\Libraries\Nestedsetbie;
use App\Controllers\FrontendController;
use App\Libraries\MemberAuthentication as MemberAuth;

class Member extends FrontendController{

	public $data = [];
   protected $province;
   protected $memberService;
   protected $memberRepository;
   protected $provinceRepository;
   protected $productService;
   protected $projectRepository;
   protected $typeRepository;
   protected $language;
   public $nestedsetbie;
   protected $array;
   protected $session;

	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->memberRepository = service('MemberRepository', 'member');
      $this->memberService = service('MemberService',['language' => $this->language]);
      $this->productService = service('ProductFrontendService',['language' => $this->language]);
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->projectRepository = service('ProjectRepository', 'project');
      $this->typeRepository = service('TypeRepository', 'product_type');
      $this->array = service('array');
      $this->session = session();
      $this->nestedsetbie = service('nestedSetBie', ['table' => 'product_catalogue', 'language' => $this->language]);
	}


	public function create(){
      $member = $this->memberRepository->findById(['*'], MemberAuth::id());
   	$canonical = 'member/create';
      $og_type = 'website';
      $meta_title = 'Đăng tin bất động sản';
      $meta_description = (isset($general['seo_meta_description']) ? $general['seo_meta_description'] : '');
      $template = convertUrl('frontend.member.member.create');
      $general = $this->general;
      $project = $this->projectRepository->getTenProjectByOrder();
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $project_list = $this->array->convertArrayByValue($project, 'Dự án');
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'), 'Chọn loại bất động sản');
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation_product();
         if($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productService->create($member['id'])){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới thành công, chờ xét duyệt từ quản trị viên');
               return redirect()->to(BASE_URL.'member/create'.HTSUFFIX);
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
      }
      return view(convertUrl('frontend.homepage.layout.home'), compact(
            'general',
            'og_type',
            'canonical',
            'meta_title',
            'member',
            'meta_description',
            'province',
            'template',
            'project_list',
            'productType',
            'config',
         )
      );
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

   private function validation_product(){
      $validate = [
         'title' => 'required',
         'catalogueid' => 'is_natural_no_zero',
      ];
      $errorValidate = [
         'title' => [
            'required' => 'Bạn phải nhập tên BĐS!'
         ],
         'catalogueid' => [
            'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho BĐS!',
         ],
      ];

      return [
         'validate' => $validate,
         'errorValidate' => $errorValidate,
      ];
   }

}
