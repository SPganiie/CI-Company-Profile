<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*include ci setting db*/
if (!defined('gpp'))
	   define('gpp', true);

if (!defined('ENVIRONMENT'))
    define('ENVIRONMENT', 'production');

    $mydb = include 'database.php';
  	$db = $db['default'];
  	$connect 	= mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']) or die('Error connecting server: ' . mysqli_error($connect));
  	$get 	 	= mysqli_query($connect, 'SELECT * FROM setting_web')->fetch_object();
  	$admin_link = $get->admin_link;
  	$post_link 	= $get->page_news;
		$route['default_controller'] = 'front_web';
		$route['404_override'] = 'front_web';
		$route['translate_uri_dashes'] = FALSE;

		$route['index.:any'] 	= '/';

		$route['find:any']		= 'front_web/find';
		$route['comment:any'] 	= 'front_web/add_komen';

		$route['page/:any'] 	= 'page/detail_page';

		$route['tags/:any'] 	= 'kategori/find';
		$route['category/:any'] = 'kategori/detail_post';

		$route['gallery/:any'] 			= 'gallery/show_gallery/';
		$route['category-gallery:any'] 	= 'gallery/list_gallery/';
		$route['category-gallery/:any'] = 'gallery/detail_gallery/';

		$route[$post_link.':any']  	= 'kategori/list_post';
		$route[$post_link.'/:any'] 	= 'post/detail_post';
		$route['archive/:any'] 		= 'post/tahun_post/';
		$route[$admin_link] = 'user/login';
