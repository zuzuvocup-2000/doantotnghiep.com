<?php
namespace App\Controllers\Backend\Project;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Catalogue extends BaseController{
	protected $data;
   public $nestedsetbie;
   public $module;
   protected $session;
   protected $language;
   protected $authen;


	public function __construct(){
      $this->language = $this->currentLanguage();
		$this->module = 'project_catalogue';
      $this->authen = service('auth');
      $this->projectCatalogueService = service('ProjectCatalogue',['language' => $this->language]);
      $this->nestedsetbie = service('nestedSetBie', ['table' => $this->module, 'language' => $this->language]);
      $this->session = session();

	}

	public function index($page = 1){
		if(!$this->authen->gate('backend.project.catalogue.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $projectCatalogue = $this->projectCatalogueService->pagination($page);
      $config['module'] = $this->module;
		$template = convertUrl('backend.project.catalogue.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('projectCatalogue', 'template', 'config'));
	}

	public function create(){
      if(!$this->authen->gate('backend.project.catalogue.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();

			if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->projectCatalogueService->create($this->language)){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.project.catalogue.create'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['method'] = 'create';
      $config['module'] = $this->module;
      $template = convertUrl('backend.project.catalogue.create');
      return view(convertUrl('backend.dashboard.layout.home'), compact('config', 'template', 'validate'));
	}

	public function update($id = 0){
      if(!$this->authen->gate('backend.project.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
		$id = (int)$id;
      $projectCatalogue = $this->projectCatalogueService->findById($id, $this->language);

		if(!isset($projectCatalogue) || is_array($projectCatalogue) == false || count($projectCatalogue) == 0){
			$this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.convertUrl('backend.project.catalogue.index'));
		}

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->projectCatalogueService->update($projectCatalogue)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.project.catalogue.index'));
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
		$template = convertUrl('backend.project.catalogue.update');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'projectCatalogue')
      );
	}

	public function delete($id = 0){
      if(!$this->authen->gate('backend.project.catalogue.update')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      $id = (int)$id;
      $projectCatalogue = $this->projectCatalogueService->findById($id, $this->language);
      if(!isset($projectCatalogue) || is_array($projectCatalogue) == false || count($projectCatalogue) == 0){
         $this->session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
         return redirect()->to(BASE_URL.convertUrl('backend.project.catalogue.index'));
      }

      if($this->request->getMethod() == 'post'){
         if($this->projectCatalogueService->delete($projectCatalogue)){
            $this->session->setFlashdata('message-success', 'Xóa bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
            return redirect()->to(BASE_URL.convertUrl('backend.project.catalogue.index'));
         }else{
            $this->session->setFlashdata('message-error', 'Xóa bản ghi không thành công! Hãy thử lại.');
            return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
         }
      }

      $config['method'] = 'update';
      $config['module'] = $this->module;
      $template = convertUrl('backend.project.catalogue.delete');
      return view(convertUrl('backend.dashboard.layout.home'), compact(
         'config', 'template', 'validate', 'projectCatalogue')
      );
	}



	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_canonical['.$this->data['module'].']',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_canonical' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
