<?php defined('BASEPATH') OR exit('No direct script access allowed');

class bahasa extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/bahasa/');
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
            $this->db->where('(nama_bahasa LIKE "%'. $data['src'] .'%")');

        $data['list']   = $this->mypaging->config('bahasa', $page, '5');

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

        $data['dta']    = $this->dbm->get_data_where('bahasa', array('id_bahasa'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama_bahasa', 'Nama bahasa', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_bahasa']!='') ? $_POST['id_bahasa'] : null;
            $nama   = $_POST['nama_bahasa'];
            $aktif  = $_POST['aktif'];

            if ($id==null)
                {
                $value  = array("bahasa"=>$nama,'aktif'=>$aktif);

                $db     = $this->dbm->insert('bahasa', $value);

                } elseif ($id!=null)
                    {
                    $set    = array("bahasa"=>$nama,'aktif'=>$aktif);

                    $db     = $this->dbm->update('bahasa', array('id_bahasa'=>$id), $set);
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

        $del = $this->dbm->delete('bahasa', array('id_bahasa'=>$id));

        redirect(base_url('master/bahasa'));
    }
}
