<?php
namespace App\Controllers\Backend\Project;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Project extends BaseController{
	protected $data;
	public $nestedsetbie;
   public $module;
   protected $session;
   protected $language;
   protected $projectService;
   protected $authen;
   protected $typeRepository;
   protected $array;
   protected $provinceRepository;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->authen = service('auth');
      $this->array = service('array');
      $this->session = session();
		$this->module = 'project';
      $this->projectService = service('ProjectService',['language' => $this->language]);
      $this->projectTypeRepository = service('ProjectTypeRepository', 'project_type');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->nestedsetbie = service('nestedSetBie', ['table' => 'project_catalogue', 'language' => $this->language]);

	}

	public function index($page = 1){
      if(!$this->authen->gate('backend.project.project.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      $project = $this->projectService->pagination($page);
		$config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
		$template = convertUrl('backend.project.project.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('project', 'template', 'config'));
	}

	public function create(){
      if(!$this->authen->gate('backend.project.project.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->projectService->create()){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.project.project.create'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
      }
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $projectType = $this->array->convertArrayByValue($this->projectTypeRepository->all('id, title'));

      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
      $config['method'] = 'create';
		$template = convertUrl('backend.project.project.create');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'template', 'config','province', 'validate','projectType'
         )
      );
	}

	public function update($id = 0){
		$id = (int)$id;
      if(!$this->authen->gate('backend.project.project.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $project = $this->projectService->findById($id);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->projectService->update($project)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.project.project.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }


         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}

      $projectType = $this->array->convertArrayByValue($this->projectTypeRepository->all('id, title'));
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
      $config['method'] = 'update';
      $template = convertUrl('backend.project.project.update');
      return view(convertUrl('backend.dashboard.layout.home'), compact(
         'template', 'config', 'projectType', 'project', 'province', 'validate'
         )
      );
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/project/project/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->get_data_module($id);
		if($this->data[$this->data['module']] == false){
			$session->setFlashdata('message-danger', 'Dự Án không tồn tại!');
 			return redirect()->to(BASE_URL.'backend/project/project/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $_id
				]
			]);
			delete_router($id,$this->data['module'], $this->currentLanguage());
			$session = session();
			if($flag > 0){
				$this->nestedsetbie->Get('level ASC, order ASC');
				$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
				$this->nestedsetbie->Action();
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/project/project/index');
		}

		$this->data['template'] = 'backend/project/project/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router['.$this->data['module'].']',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập tên Dự Án!'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn!',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác!',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho Dự Án!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}


}
