<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}
/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/','Frontend\Homepage\Home::index');
$routes->get('home.html','Frontend\Homepage\Home::index');
$routes->get('trang-chu.html','Frontend\Homepage\Home::index');

$routes->match(['get','post'],'dat-lich-tu-van'.HTSUFFIX, 'Frontend\Contact\Contact::datlich');
$routes->match(['get','post'],'gio-hang'.HTSUFFIX, 'Frontend\Product\Cart::index');
$routes->match(['get','post'],'dat-hang', 'Frontend\Product\Cart::pay');
$routes->match(['get','post'],'dat-hang-thanh-cong', 'Frontend\Product\Cart::method');
$routes->match(['get','post'],'wishlist'.HTSUFFIX, 'Frontend\Homepage\Home::wishlist');
$routes->get('thong-tin-don-hang'.HTSUFFIX, 'Frontend\Product\Cart::method');

/* Các ROUTE CẦN XỬ LÝ */
// bán tại thành phố, chỉ select ra tất cả các loại bất động sản mà là bán
$routes->get('can-ban/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::sellByCity/$1/$3');
$routes->get('can-ban/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::sellByCity/$1');


//Tìm dự án theo vị trí thành phố
$routes->get('du-an-bat-dong-san/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Project\Catalogue::projectByCity/$1/$3');
$routes->get('du-an-bat-dong-san/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Project\Catalogue::projectByCity/$1');

// bán nhà đất nhưng có thêm loại hình
$routes->get('nha-dat-ban/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/([0-9-]+)/([0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::sellByDistrictFormType/$1/$3/$4/$5');
$routes->get('nha-dat-ban/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/([0-9-]+)/([0-9-]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::sellByDistrictFormType/$1/$3/$4');


$routes->get('nha-dat-cho-thue/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/([0-9-]+)/([0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::rentByDistrictFormType/$1/$3/$4/$5');
$routes->get('nha-dat-cho-thue/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)/([0-9-]+)/([0-9-]+)'.HTSUFFIX, 'Frontend\Advertise\Advertise::rentByDistrictFormType/$1/$3/$4');

// Dự Án
$routes->get('du-an/([0-9-]+)/([a-zA-Z0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Project\Catalogue::findProjectByType/$1/$3');
$routes->get('du-an/([0-9-]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Project\Catalogue::findProjectByType/$1');

/* MEMBER */
$routes->get('member/profile'.HTSUFFIX, 'Frontend/Member/Profile::index', ['filter' => 'member']);
$routes->match(['get','post'],'member/info'.HTSUFFIX, 'Frontend/Member/Profile::info', ['filter' => 'member']);
$routes->match(['get','post'],'member/changePassword'.HTSUFFIX, 'Frontend/Member/Profile::changePassword', ['filter' => 'member']);
$routes->match(['get','post'],'member/create'.HTSUFFIX, 'Frontend/Member/Member::create', ['filter' => 'member']);


$routes->get('tag'.HTSUFFIX, 'Frontend\Tag\Tag::index');
$routes->get('login'.HTSUFFIX, 'Frontend\Auth\Auth::login',['filter' => 'login_frontend' ]);
$routes->get('signup'.HTSUFFIX, 'Frontend\Auth\Auth::signup',['filter' => 'login_frontend' ]);
$routes->get('forgot'.HTSUFFIX, 'Frontend\Auth\Auth::forgot');
$routes->get('verify'.HTSUFFIX, 'Frontend\Auth\Auth::verify');
$routes->get('thong-tin-chi-tiet'.HTSUFFIX, 'Frontend\Auth\DetailUser::index',['filter' => 'auth_frontend']);
$routes->get('tai-khoan.html', 'Frontend\Auth\DetailUser::update',['filter' => 'auth_frontend']);
$routes->get('don-hang-cua-toi.html', 'Frontend\Auth\DetailUser::bill',['filter' => 'auth_frontend']);
$routes->get('logout'.HTSUFFIX, 'Frontend\Auth\Auth::logout',['filter' => 'auth_frontend' ]);

$routes->get('tim-kiem-nang-cao'.HTSUFFIX, 'Frontend\Search\Search::product');

$routes->get('thuong-hieu'.HTSUFFIX, 'Frontend\Homepage\Router::list/$1');
$routes->get('thuong-hieu/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Homepage\Router::list/$1/$2');

$routes->get(HTSEARCH.HTSUFFIX, 'Frontend\Homepage\Router::search/$1');
$routes->get(HTSEARCH.'/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Homepage\Router::search/$1/$2');
$routes->get(HTSEARCH.'/trang-([0-9]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Homepage\Router::search/$1/$2/$3');

$routes->get('lien-he'.HTSUFFIX, 'Frontend\Contact\Contact::index');
$routes->post('lien-he'.HTSUFFIX, 'Frontend\Contact\Contact::index');
$routes->get('contact-us'.HTSUFFIX, 'Frontend\Contact\Contact::index');

$routes->get('([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Homepage\Router::index/$1');
$routes->get('([a-zA-Z0-9-]+)/trang-([0-9]+)'.HTSUFFIX, 'Frontend\Homepage\Router::index/$1/$2');
// $routes->get('([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Homepage\Router::silo/$1/$2');

$routes->get(BACKEND_DIRECTORY, 'Backend/Authentication/Auth::login');
$routes->get('backend/authentication/auth/forgot', 'Backend/Authentication/Auth::forgot');
$routes->match(['get','post'],'backend/dashboard/dashboard/index', 'Backend/Dashboard/Dashboard::index', ['filter' => 'authGuard']);




$name = [
    'user','user catalogue','article','article catalogue','attribute', 'attribute catalogue','location', 'location catalogue',
    'panel', 'product', 'product catalogue', 'tour', 'tour catalogue','media', 'media catalogue', 'language',
];
$product = [
     'store', 'warehouse'
];

/*MENU*/
$routes->group('backend/menu/menu', ['filter' => 'authGuard'] , function($routes){
    $routes->add('listmenu', 'Backend/Menu/Menu::listmenu');
    $routes->add('createmenu', 'Backend/Menu/Menu::createmenu');
    $routes->add('create', 'Backend/Menu/Menu::create');
});
/*BRAND*/
$routes->group('backend/product/brand/brand', ['filter' => 'authGuard'] , function($routes){
    $routes->add('index', 'Backend/Product/Brand/Brand::index');
    $routes->add('create', 'Backend/Product/Brand/Brand::create');
    $routes->add('update', 'Backend/Product/Brand/Brand::update');
    $routes->add('delete', 'Backend/Product/Brand/Brand::delete');
});
/*BRAND_CATALOGUE*/
$routes->group('backend/product/brand/catalogue', ['filter' => 'authGuard'] , function($routes){
    $routes->add('index', 'Backend/Product/Brand/Catalogue::index');
    $routes->add('create', 'Backend/Product/Brand/Catalogue::create');
    $routes->add('update', 'Backend/Product/Brand/Catalogue::update');
    $routes->add('delete', 'Backend/Product/Brand/Catalogue::delete');
});
/*SYSTEM_GENERAL*/
$routes->group('backend/system/general', ['filter' => 'authGuard'] , function($routes){
    $routes->add('index', 'Backend/System/General::index');
    $routes->add('translator', 'Backend/System/General::translator');
});
/*WIDGET*/
$routes->group('backend/widget/widget', ['filter' => 'authGuard'] , function($routes){
    $routes->add('index', 'Backend/Widget/Widget::index');
    $routes->add('create', 'Backend/Widget/Widget::create');
    $routes->add('store', 'Backend/Widget/Widget::store');
});
/*TRANSLATE*/
$routes->group('backend/translate/translate', ['filter' => 'authGuard'] , function($routes){
    $routes->add('translateobject', 'Backend/Translate/Translate::translateobject');
    $routes->add('translateproduct', 'Backend/Translate/Translate::translateproduct');
    $routes->add('translatetour', 'Backend/Translate/Translate::translatetour');
    $routes->add('translatecontact', 'Backend/Translate/Translate::translatecontact');
    $routes->add('translateattributecatalogue', 'Backend/Translate/Translate::translateattributecatalogue');
    $routes->add('translateattribute', 'Backend/Translate/Translate::translateattribute');
});

$routes->group('backend/slide/translate/translate', ['filter' => 'authGuard'] , function($routes){
    $routes->add('translate', 'Backend/Slide/Translate::translate');
});

/*SLIDE*/
$routes->group('backend/slide/slide', ['filter' => 'authGuard'] , function($routes){
    $routes->add('index', 'Backend/Slide/Slide::index');
    $routes->add('create', 'Backend/Slide/Slide::create');
    $routes->add('update', 'Backend/Slide/Slide::update');
    $routes->add('delete', 'Backend/Slide/Slide::delete');
});


foreach ($name as $key => $value) {
    $convert = ucwords($value);
    $extract_normal = explode(' ', $value);
    $group = ((isset($extract_normal[1]) && $extract_normal[1] != '') ? 'backend/'.$extract_normal[0].'/'.$extract_normal[1] : 'backend/'.$extract_normal[0].'/'.$extract_normal[0]);
    $extract_convert = explode(' ', $convert);
    $router = ((isset($extract_convert[1]) && $extract_convert[1] != '') ? 'Backend/'.$extract_convert[0].'/'.$extract_convert[1] : 'Backend/'.$extract_convert[0].'/'.$extract_convert[0]);

    $routes->router = $router;

    $routes->group($group, ['filter' => 'authGuard'], function($routes){

        $routes->add('index',  $routes->router.'::index');
        $routes->add('create',  $routes->router.'::create');
        $routes->add('update',  $routes->router.'::update');
        $routes->add('delete',  $routes->router.'::delete');
    });
}


foreach ($product as $key => $value) {
    $convert = ucwords($value);
    $group = 'backend/product/'.$value;
    $router = 'Backend/Product/'.$convert;
    $routes->router = $router;
    $routes->group($group, ['filter' => 'authGuard'] , function($routes){
        $routes->add('index', $routes->router.'::index');
        $routes->add('create', $routes->router.'::create');
        $routes->add('update', $routes->router.'::update');
        $routes->add('update/([0-9]+)',  $routes->router.'::update');
        $routes->add('delete/([0-9]+)',  $routes->router.'::delete');
        $routes->add('delete', $routes->router.'::delete');
    });
}




/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
