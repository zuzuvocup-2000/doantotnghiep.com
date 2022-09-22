<?php
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Upload extends FrontendController{

	public function __construct(){
        $this->cookie = (isset($_COOKIE['member'])) ? json_decode($_COOKIE['member'], TRUE)  : '';
	}

	public function index(){
		$ds          = DIRECTORY_SEPARATOR;  //1
 		$member = $this->get_member_info();
 		$APPPATH = substr(APPPATH, 0 ,-5);
		$storeFolder = 'image_member';   //2
		if (!empty($_FILES)) {
		    $tempFile = $_FILES['file']['tmp_name'];          //3
		    $targetPath = $APPPATH. $ds. $storeFolder . $ds;  //4
		    if(file_exists($targetPath.'member_'.$member['id']) == false){
		    	mkdir($targetPath.'member_'.$member['id']);
		    }
		    $targetFile =  $targetPath."member_".$member['id'].$ds.slug(date('Y-m-d'), strtotime($this->currentTime)).'-'. $_FILES['file']['name'];  //5
		    move_uploaded_file($tempFile,$targetFile); //6
		}
	}

	public function delete(){
		$ds          = DIRECTORY_SEPARATOR;  //1
 		$member = $this->get_member_info();
 		$APPPATH = substr(APPPATH, 0 ,-5);
 		$storeFolder = 'image_member';
 		$targetPath = $APPPATH. $ds. $storeFolder . $ds;
		$storeFolder = 'image_member';   //2
		$targetFile =  $targetPath."member_".$member['id'].$ds.slug(date('Y-m-d'), strtotime($this->currentTime)).'-'. $_POST['name'];
		unlink($targetFile); exit;
	}
	public function file(){
		$ds          = DIRECTORY_SEPARATOR;  //1
 		$member = $this->get_member_info();
 		$APPPATH = substr(APPPATH, 0 ,-5);
		$storeFolder = 'file_member';   //2
		if (!empty($_FILES)) {
		    $tempFile = $_FILES['file']['tmp_name'];          //3             
		    
		    $targetPath = $APPPATH. $ds. $storeFolder . $ds;  //4
		    if(file_exists($targetPath.'member_'.$member['id']) == false){
		    	mkdir($targetPath.'member_'.$member['id']);
		    }
		    $targetFile =  $targetPath."member_".$member['id'].$ds. $_FILES['file']['name'];  //5
		    move_uploaded_file($tempFile,$targetFile); //6
		}
	}

	private function get_member_info(){
		if(!isset($this->cookie) || is_array($this->cookie) == false || count($this->cookie) == 0) return null;
		$member = $this->AutoloadModel->_get_where([
            'select' => 'id, fullname, phone, created_at, ',
            'table' => 'member',
            'where' => [
                'id' => $this->cookie['id']
            ]
        ]);
		return $member;
	}

}
