<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "index"; //index/login
$route['404_override'] = 'index/error';

/* End of file routes.php */
/* Location: ./application/config/routes.php */

$route["products/(:num)"]                                                = 'products/index/$1';
$route["products/(:num)/(:num)"]                                = 'products/index/$1/$2';

$route["index/(:num)"]                                                    = 'index/index/$1';
$route["(:num)"]                                                                = 'index/index/$1';
$route['member_register']                                                = 'member_register/register';
$route['member_update']                                                = 'member_register/update';
$route['member_sms_code']                                            = 'member_register/sms_code';
$route['member_register_ok']                                        = 'member_register/register_ok';
$route['member_register_on']                                        = 'member_register/register_on';
$route['member_mobile']                                                = 'member_register/mobile';
$route['sms_mobile']                                                        = 'member_register/sms_change_mobile';

/** all-young */
$route['login'] = 'gold/login';
$route['register'] = 'member_register/register_on';

$route['member'] = 'gold/member';

$route['member/info'] = 'gold/member_info';
$route['member/info/update'] = '/gold/data_AED';
$route['member/change_password'] = '/gold/member_password';

$route['member/logout'] = 'gold/logout';
$route['member/login'] = 'gold/login_set';
$route['member/upgrade'] = 'gold/member_upgrade';
$route['member/upgrade/submit'] = '/gold/data_AED';

$route['forget_pass'] = 'gold/forgot';

$route['cart/checkout'] = 'cart/cart_checkout';
$route['cart/finish'] = '/cart/cart_checkout_ok';
