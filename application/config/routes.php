<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// $route['default_controller'] = 'PropertTrack';
 

$route['default_controller'] = 'home';
$route['admin'] = 'Admin/index';
$route['404_override'] = 'Home/page_404';
$route['translate_uri_dashes'] = FALSE;

// modify by Jfrost
$route['Restaurant/Category/(:any)'] = 'Restaurant/Category/$1';
$route['Restaurant/Menu/(:any)/(:any)'] = 'Restaurant/Menu/$1/$2';
$route['Restaurant/addMenuItem/(:any)'] = 'Restaurant/addMenuItem/$1';
$route['Restaurant/editMenu/(:num)/(:any)'] = 'Restaurant/editMenu/$1/$2';
$route['Restaurant/acceptedOrders'] = 'Restaurant/orderManagement/accepted';
$route['Restaurant/pendingOrders'] = 'Restaurant/orderManagement/pending';
$route['Restaurant/rejectedOrders'] = 'Restaurant/orderManagement/rejected';
$route['Restaurant/finishedOrders'] = 'Restaurant/orderManagement/finished';
$route['Restaurant/clientOrder/(:num)/(:any)'] = 'Restaurant/clientOrder/$1/$2';
$route['Restaurant/pendingOrders'] = 'Restaurant/orderManagement/pending';
$route['Restaurant/rejectedOrders'] = 'Restaurant/orderManagement/rejected';
$route['Restaurant/finishedOrders'] = 'Restaurant/orderManagement/finished';
$route['api/change_lang'] = 'API/change_lang';
$route['Admin/Menu'] = 'Admin/Menu/0';
$route['Admin/Menu/(:any)'] = 'Admin/Menu/$1';
$route['Admin/Category'] = 'Admin/Category/0';
$route['Admin/Category/(:any)'] = 'Admin/Category/$1';
$route['Admin/Category/(:any)'] = 'Admin/Category/$1';

$route['wishList/(:any)/(:any)'] = 'Home/wishlist/$1/$2';
$route['checkout/(:any)/(:any)/(:any)'] = 'Home/checkout/$1/$2/$3';
$route['view/(:any)/(:any)'] = 'Home/viewMenu/$1/$2';
$route['choose/(:any)/(:any)'] = 'Home/chooseMenu/$1/$2';
$route['help/(:any)/(:any)'] = 'Home/help/$1/$2';
$route['onTable/(:any)/(:any)'] = 'Home/onTableMenu/$1/$2';
$route['getAddress/(:any)/(:any)/(:any)'] = 'Home/getAddress/$1/$2/$3';
$route['Delivery/(:any)/(:any)'] = 'Home/Delivery/$1/$2';
$route['Pickup/(:any)/(:any)'] = 'Home/Pickup/$1/$2';
$route['Home/cart/(:any)/(:any)/(:any)'] = 'Home/cart/$1/$2/$3';
$route['main/(:any)/(:any)'] = 'Home/Main_page/$1/$2';
$route['contactus/(:any)/(:any)'] = 'Home/contact_us/$1/$2';
$route['reservation/(:any)/(:any)'] = 'Home/reservation/$1/$2';


$route['main/(:any)'] = 'Home/Main_page/$1';
$route['view/(:any)'] = 'Home/viewMenu/$1';
$route['choose/(:any)'] = 'Home/chooseMenu/$1/';
$route['contactus/(:any)'] = 'Home/contact_us/$1';
$route['getAddress/(:any)/(:any)'] = 'Home/getAddress/$1/$2';
$route['onTable/(:any)'] = 'Home/onTableMenu/$1';
$route['Delivery/(:any)'] = 'Home/Delivery/$1';
$route['Pickup/(:any)'] = 'Home/Pickup/$1';
$route['wishList/(:any)'] = 'Home/wishlist/$1';
$route['Home/cart/(:any)/(:any)'] = 'Home/cart/$1/$2';
$route['checkout/(:any)/(:any)'] = 'Home/checkout/$1/$2';
$route['help/(:any)'] = 'Home/help/$1';
$route['legal/(:any)/(:any)'] = 'Home/legal_page/$1/$2';
$route['reservation/(:any)'] = 'Home/reservation/$1';
$route['Restaurant/orderDetail/(:num)'] = 'Restaurant/orderDetail/$1';

$route['main'] = 'Home/Main_page/';
$route['view'] = 'Home/viewMenu/';
$route['choose'] = 'Home/chooseMenu/';
$route['contactus'] = 'Home/contact_us/';
$route['onTable'] = 'Home/onTableMenu/$1';
$route['Delivery'] = 'Home/Delivery/$1';
$route['Pickup'] = 'Home/Pickup/$1';
$route['wishList'] = 'Home/wishlist/';
$route['Home/cart/(:any)'] = 'Home/cart/$2';
$route['checkout/(:any)'] = 'Home/checkout/$2';
$route['help'] = 'Home/help/';
$route['reservation'] = 'Home/reservation/';

// $route['paypal/Express_checkout/SetExpressCheckout'] = 'Express_checkout/SetExpressCheckout';





