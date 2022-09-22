<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('BACKEND_DIRECTORY', '/admin');

define('AUTH', 'HTVIETNAM_');
define('COMPANY_NAME', 'VANH CMS');
define('ASSET_BACKEND', 'public/backend/');

define('BASE_URL', 'http://doantotnghiep.com/');
define('HTSUFFIX', '.html');

define('BROKER', 'broker/');

define('DEBUG', 0);
define('COMPRESS', 0);
define('CMS_NAME', 'HT CMS 3.0');
define('API_WIDGET', 'http://widget.htweb.vn');

define('HTSEARCH', 'tim-kiem');
define('HTCONTACT', 'contact-us');
define('HTMAP', 'contact-map');

define('HTDBHOST', 'localhost');
define('HTDBUSER', 'root');
define('HTDBPASS', '');
define('HTDBNAME', 'datn_data');

const PRODUCT_FORM = [
   'Cần bán', 'Cần mua', 'Cần thuê', 'Cần cho thuê'
];


const DIRECTION = [
   '---- Chọn Hướng ---',
   'Đông', 'Tây', 'Nam', 'Bắc',
   'Đông Nam', 'Đông Bắc', 'Tây Nam', 'Tây Bắc'
];

const AREA = [
   '---- Chọn Diện tích ---',
   '0|30' => 'Dưới 30 m2',
   '30|50' => 'Từ 30 - 50m2',
   '50|70' => 'Từ 50 - 70m2',
   '70|100' => 'Từ 70 - 100m2',
   '100|150' => 'Từ 100 - 150m2',
   '150|200' => 'Từ 150 - 200m2',
   '200|250' => 'Từ 200 - 250m2',
   '250|300' => 'Từ 250 - 300m2',
   '250|300' => 'Từ 250 - 300m2',
   '350|400' => 'Từ 350 - 400m2',
   '400|450' => 'Từ 400 - 450m2',
   '450|500' => 'Từ 400 - 500m2',
   '500|10000' => 'Trên 500m2',
];

const VIP_DAYS = [
   '' => '--- Loại VIP ---',
   'V5_DAYS' => 'VIP 5 / 10.000đ / ngày',
   'V4_DAYS' => 'VIP 4 / 12.000đ / ngày',
   'V3_DAYS' => 'VIP 3 / 14.000đ / ngày',
   'V2_DAYS' => 'VIP 2 / 20.000đ / ngày',
   'V1_DAYS' => 'VIP 1 / 40.000đ / ngày',
   'VHOT_DAYS' => 'VIP Đặc Biệt / 80.000đ / ngày',
];

const VIP_DAYS_VALUE = [
   '' => '--- Loại VIP ---',
   'V5_DAYS' => '10000',
   'V4_DAYS' => '12000',
   'V3_DAYS' => '14000',
   'V2_DAYS' => '20000',
   'V1_DAYS' => '40000',
   'VHOT_DAYS' => '80000',
];

const VIP_MONTHS = [
   '' => '--- Loại VIP ---',
   'V5_MONTHS' => 'VIP 5 / 250.000đ / tháng',
   'V4_MONTHS' => 'VIP 4 / 300.000đ / tháng',
   'V3_MONTHS' => 'VIP 3 / 350.000đ / tháng',
   'V2_MONTHS' => 'VIP 2 / 500.000đ / tháng',
   'V1_MONTHS' => 'VIP 1 / 1.000.000đ / tháng',
   'VHOT_MONTHS' => 'VIP Đặc Biệt / 2.000.000đ / tháng',
];

const VIP_MONTHS_VALUE = [
   '' => '--- Loại VIP ---',
   'V5_MONTHS' => '250000',
   'V4_MONTHS' => '300000',
   'V3_MONTHS' => '350000',
   'V2_MONTHS' => '500000',
   'V1_MONTHS' => '1000000',
   'VHOT_MONTHS' => '2000000',
];

const DAYS_NUMBER = [
   '0' => '--- Chọn ngày ---',
   '1' => 1,
   '2' => 2,
   '3' => 3,
   '4' => 4,
   '5' => 5,
   '6' => 6,
   '7' => 7,
   '8' => 8,
   '9' => 9,
   '10' => 10,
   '11' => 11,
   '12' => 12,
   '13' => 13,
   '14' => 14,
   '15' => 15,
   '16' => 16,
   '17' => 17,
   '18' => 18,
   '19' => 19,
   '20' => 20,
];