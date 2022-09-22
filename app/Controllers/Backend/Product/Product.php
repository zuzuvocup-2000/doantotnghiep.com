<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class Product extends BaseController{
	protected $data;
	public $nestedsetbie;
   public $module;
   protected $session;
   protected $language;
   protected $productService;
   protected $authen;
   protected $typeRepository;
   protected $array;
   protected $provinceRepository;
   protected $projectRepository;


	public function __construct(){
      $this->language = $this->currentLanguage();
      $this->authen = service('auth');
      $this->array = service('array');
      $this->session = session();
		$this->module = 'product';
      $this->productService = service('ProductService',['language' => $this->language]);
      $this->typeRepository = service('TypeRepository', 'product_type');
      $this->provinceRepository = service('ProvinceRepository', 'vn_province');
      $this->projectRepository = service('ProjectRepository', 'project');
      $this->nestedsetbie = service('nestedSetBie', ['table' => 'product_catalogue', 'language' => $this->language]);

	}

	public function index($page = 1){
      if(!$this->authen->gate('backend.product.product.index')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      $product = $this->productService->pagination($page);
		$config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
		$template = convertUrl('backend.product.product.index');
		return view(convertUrl('backend.dashboard.layout.home'), compact('product', 'template', 'config'));
	}

	public function create(){
      if(!$this->authen->gate('backend.product.product.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
      if($this->request->getMethod() == 'post'){
         $validate = $this->validation();
         if($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productService->create()){
               $this->session->setFlashdata('message-success', 'Tạo bản ghi mới! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.product.create'));
            }else{
               $this->session->setFlashdata('message-error', 'Tạo bản ghi mới không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }
         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
      }
      $project = $this->array->convertArrayByValue($this->projectRepository->getAllProject(), '[Chọn dự án]');
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'));
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
      $config['method'] = 'create';
		$template = convertUrl('backend.product.product.create');
		return view(convertUrl('backend.dashboard.layout.home'), compact(
         'template', 'config', 'productType','province','project'
         )
      );
	}

	public function update($id = 0){
		$id = (int)$id;
      if(!$this->authen->gate('backend.product.product.create')){
         $this->session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }

      $product = $this->productService->findById($id);
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
         if ($this->validate($validate['validate'], $validate['errorValidate'])){
            if($this->productService->update($product)){
               $this->session->setFlashdata('message-success', 'Cập nhật bản ghi thành công! Hãy tạo bản ghi tiếp theo.');
               return redirect()->to(BASE_URL.convertUrl('backend.product.product.index'));
            }else{
               $this->session->setFlashdata('message-error', 'Cập nhật bản ghi không thành công! Hãy thử lại.');
               return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
            }


         }else{
            $this->data['validate'] = $this->validator->listErrors();
         }
		}

      $project = $this->array->convertArrayByValue($this->projectRepository->getAllProject(), '[Chọn dự án]');
      $province = $this->array->converProvinceArray($this->provinceRepository->allProvince());
      $productType = $this->array->convertArrayByValue($this->typeRepository->all('id, title'));
      $config['dropdown'] = $this->nestedsetbie->dropdown();
      $config['module'] = $this->module;
      $config['method'] = 'update';
      $template = convertUrl('backend.product.product.update');
      return view(convertUrl('backend.dashboard.layout.home'), compact(
         'template', 'config', 'productType', 'product', 'province','project'
         )
      );
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/product/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->get_data_module($id);
		if($this->data[$this->data['module']] == false){
			$session->setFlashdata('message-danger', 'BĐS không tồn tại!');
 			return redirect()->to(BASE_URL.'backend/product/product/index');
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
			return redirect()->to(BASE_URL.'backend/product/product/index');
		}

		$this->data['template'] = 'backend/product/product/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function validation(){
		$validate = [
			'title' => 'required',
			'price' => 'required',
			'canonical' => 'required|check_router['.$this->data['module'].']',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập tên BĐS!'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn!',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác!',
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
