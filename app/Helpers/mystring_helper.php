<?php
use App\Libraries\Authentication;

function read_num( $num = false ) {
    $str = '';
    $num  = trim($num);

    $arr = str_split($num);
    $count = count( $arr );

    $f = number_format($num);
       //KHÔNG ĐỌC BẤT KÌ SỐ NÀO NHỎ DƯỚI 999 ngàn
    if ( $count < 7 ) {
        $str = $num;
    } else {
        // từ 6 số trở lên là triệu, ta sẽ đọc nó !
        // "32,000,000,000"
        $r = explode(',', $f);
        switch ( count ( $r ) ) {
            case 4:
                $str = $r[0] . ' tỉ';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' Tr'; }
            break;
            case 3:
                $str = $r[0] . ' Triệu';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' nghìn'; }
            break;
        }
    }
    return ( $str . ' ₫' );
}

function sell_city_url($name = '', $cityid = '', $remove = false){
   return 'can-ban/'.$cityid.'/'.slug($name).(($remove == false) ? HTSUFFIX : '');
}

function project_city_url($name = '', $cityid = '', $remove = FALSE){
   return 'du-an-bat-dong-san/'.$cityid.'/'.slug($name).(($remove == false) ? HTSUFFIX : '');
}

function format_city_name($name = ''){
   return str_replace('Tỉnh','', str_replace('Thành phố','', $name));
}

function project_type_url($name = '', $id = 0, $remove = false){
   return 'du-an/'.$id.'/'.slug($name).(($remove == false) ? HTSUFFIX : '');
}

function product_by_district_url($name = '', $id = 0, $type, $form, $remove = false){
   $string = ($form == 0 || $form == 1) ? 'nha-dat-ban' : 'nha-dat-cho-thue';
   return $string.'/'.$id.'/'.slug($name).'/'.$type.'/'.$form.(($remove == false) ? HTSUFFIX : '');
}

function product_by_project_url($name = '', $id = 0, $form){
   $string = ($form == 0 || $form == 1) ? 'nha-dat-ban' : 'nha-dat-cho-thue';
   return 'du-an/'.$string.'/'.$id.'/'.slug($name).HTSUFFIX;
}


if(!function_exists('gate')){
	function gate(string $allowUrl = ''){
   	$authentication = new Authentication();
      $session = session();
      $flag = $authentication->check_permission([
         'routes' => convertUrl($allowUrl),
      ]);
      if($flag == false){
         $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
	}
}

if(!function_exists('priceConvert')){
	function priceConvert(string $price = ''){
      return (int)str_replace('.','', $price);
	}
}

if(!function_exists('commas')){
	function commas($number = 0){
      return number_format($number, 0, ',', '.');
	}
}


if(!function_exists('pagination')){
	function pagination(string $allowUrl = ''){
   	$authentication = new Authentication();
      $session = session();
      $flag = $authentication->check_permission([
         'routes' => convertUrl($allowUrl),
      ]);
      if($flag == false){
         $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
         header('location:'.convertUrl('backend.dashboard.dashboard.index'));
         // return redirect()->to(BASE_URL.convertUrl('backend.dashboard.dashboard.index'));
      }
	}
}

if(!function_exists('current_time')){
   function current_time(){
     return gmdate('Y-m-d H:i:s', time() + 7*3600);
   }
}




if(!function_exists('view_fix')){
	function view_fix($string = ''){
	   $string = str_replace('.','/', $string);

      echo view($string);

	}
}

if(!function_exists('fix_url')){
	function convertUrl($string = ''){
	   $string = str_replace('.','/', $string);
      return $string;

	}
}

if(!function_exists('price')){
	function price($price = 0, $price_sale = 0){
		$finalPrice = ($price_sale > 0) ? $price_sale : $price;
		return [
			'finalPrice' =>$finalPrice,
			'flag' => ($price_sale > 0) ? TRUE : FALSE
		];

	}
}

if(!function_exists('percent')){
	function percent($price = 0, $saleoff = 0){
		if($price == 0){
			$percent = 0;
		}else{
			$percent = ($price - $saleoff)/$price*100;
		}
		return round($percent);
	}
}


if(!function_exists('makeCartOption')){
	function makeCartOption(){
		return [];
	}
}

if(!function_exists('start_and_date_of_month')){
	function start_and_date_of_month($date){
		$param['start'] = date('Y-m-01', strtotime($date));
		$param['end'] = date('Y-m-t', strtotime($date));
		return $param;
	}
}

if(!function_exists('month_number_ago')){
	function month_number_ago($limit = 0,$param = []){
		if($limit < 0) return $param;
		$date = new DateTime(); //Today
		$modify = '-'.$limit.' months';
		$dateMinus12 = $date->modify($modify); // Last day 12 months ago
		$new_date = $dateMinus12->format('Y-m-d');
		$result = start_and_date_of_month($new_date);
		$in_month = $dateMinus12->format('M');
		$result['month'] = $in_month;
		$param[] = $result;
		return month_number_ago($limit - 1, $param);
	}
}

if(!function_exists('translate')){
	function translate(string $string = '', string $language = '', array $param = []){

		if(in_array($language, ['vi','en']) == false){
			$language = 'en';
		}

		return lang($string, $param, $language);
	}
}

if(!function_exists('check_array')){
	function check_array(array $param = []){
		if(isset($param) && is_array($param) && count($param)){
			return $param;
		}

		return '';
	}
}
//trả về: chuỗi bị cắt từ 0 tới kí tự thứ n
//đầu vào: $str chuỗi bị cắt, $n cắt bn kí tự
if(!function_exists('cutnchar')){
	function cutnchar($str = NULL, $n = 320){
		if(strlen($str) < $n) return $str;
		$html = substr($str, 0, $n);
		$html = substr($html, 0, strrpos($html,' '));
		return $html.'...';
	}
}

if(!function_exists('view_cells')){
	function view_cells(string $module = ''){
		$module = explode('_',  $module);
		$new_module = [];
		foreach ($module as $key => $value) {
			$new_module[] = ucwords($value);
		}
		if(!isset($new_module[1])){
			$new_module[1] = $new_module[0];
		}
		$view =  '\App\Controllers\Frontend\\';
		foreach ($new_module as $key => $value) {
			$view = $view.$value.((isset($new_module[$key + 1])) ? '\\' : '').((!isset($new_module[$key + 1])) ? '::index' : '');
		}
		return $view;
	}
}

if(!function_exists('get_first_img')){
	function get_first_img(string $album = ''){
		$image = json_decode($album);
		$image = $image[0];
		return $image;
	}
}

if(!function_exists('check_isset')){
	function check_isset(string $check = ''){
		return (isset($check) ? $check : '');
	}
}

if(!function_exists('match_2_arrays')){
	function match_2_arrays(array $catalogue = [], array $index = []){
		$new = [];
		foreach ($catalogue as $key => $val) {
			$new[$val['id']]['title'] = $val['title'];
			$new[$val['id']]['keyword'] = $val['keyword'];
			$new[$val['id']]['data'] = [];
			foreach ($index as $keyChild => $valChild) {
				if($val['id'] == $valChild['catalogueid']){
					$abc = array_push($new[$val['id']]['data'], $valChild);
				}
			}
		}

		return $new;
	}
}


if(!function_exists('gettime')){
	function gettime($time, $type = 'H:i - d/m/Y'){
		if($type == 'datetime'){
			$type = 'Y-m-d H:i:s';
		}
		if($type == 'date'){
			$type = 'Y-m-d';
		}
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('getthumb')){
	function getthumb(string $string = '', bool $thumb = true){
		$image = '';

		if(!file_exists(dirname(dirname(dirname(__FILE__))).$image) ){
			$image = 'public/not-found.png';
		}
		if($thumb == TRUE){
			$thumbUrl = str_replace('/upload/image', '/upload/thumb/Images', $string);
			if (file_exists(dirname(dirname(dirname(__FILE__))).$thumbUrl)){
				return $thumbUrl;
			}
		}
		return $string;
	}
}




if (! function_exists('validate_input')){
	function validate_input(string $string): string{
		return htmlspecialchars_decode(html_entity_decode($string));
	}
}


if (! function_exists('password_encode')){
	function password_encode(string $password, string $salt): string{
		return md5(md5($salt.$password));
	}
}


if (! function_exists('pre')){
	function pre($param, $flag = true){
		echo '<pre>';
		print_r($param);
		if($flag == true){
			die();
		}

	}
}



if (! function_exists('fix_canonical')){
	function fix_canonical($canonical = ''){
		$canonical = BASE_URL.$canonical.HTSUFFIX;
		return $canonical;
	}
}

if (! function_exists('convertArray')){
	function convert_array($param){
		$array[0] = 'Chọn '.$param['text'].'';
		if(isset($param['data']) && is_array($param['data']) && count($param['data'])){
			foreach($param['data'] as $key => $val){
				$array[$val[$param['field']]] = $val[$param['value']];
			}
		}

		return $array;
	}
}



// tạo thông báo
if(!function_exists('show_flashdata')){
	function show_flashdata($body = TRUE){;
		$result = [];
		$session = session();
		$message = $session->getFlashdata('message-success');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 0;
			return $result;
		}
		$message = $session->getFlashdata('message-danger');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 1;
		}


		return $result;
	}
}


if(!function_exists('removeutf8')){
	function removeutf8($value = NULL){
		$chars = array(
			'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'	=>	array('đ','Đ'),
		);
		foreach ($chars as $key => $arr)
			foreach ($arr as $val)
				$value = str_replace($val, $key, $value);
		return $value;
	}
}

if(!function_exists('slug')){
	function slug($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('-', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '-', trim($value)));
	}
}

if(!function_exists('slug_database')){
	function slug_database($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('_', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '_', trim($value)));
	}
}

?>
