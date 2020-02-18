<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tema extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/tema/');
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }
    
    function index()
    {
        $this->template->display(view.'index');
    }

    function tambah()
    {
        $this->template->display(view.'form');
    }
}
