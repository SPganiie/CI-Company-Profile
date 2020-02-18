<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/slider/');
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }
    
    function index($page = '1')
    {        
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(nama_slider LIKE "%'. $data['src'] .'%")');

        $data['list']   = $this->mypaging->config('slider', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $this->template->display(view.'form');
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['dta']    = $this->dbm->get_data_where('slider', array('id_slider'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama_slider', 'Nama', 'required');
        $this->form_validation->set_rules('gambar', 'Gambar Slider', 'required');
        // $this->form_validation->set_rules('link', 'Link Slider', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_slider']!='') ? $_POST['id_slider'] : null;
            $_POST['gambar'] = str_replace('upload/', '', $_POST['gambar']);

            $value  = array(
                    "nama_slider" => $_POST['nama_slider'],
                    "gambar"      => 'upload/'.$_POST['gambar'],
                    "link"        => $_POST['link']
                );

            if ($id==null)
                {
                $db = $this->dbm->insert('slider', $value);
                } 
                else
                    {
                    $db = $this->dbm->update('slider', array('id_slider'=>$id), $value);
                    }

            if ($db)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function hapus($id)
    {
        $this->auth->restrict($this->id_module_now, 'hapus'); 

        $del = $this->dbm->delete('slider', array('id_slider'=>$id));

        redirect(base_url('master/slider'));
    }
}