<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/komentar/');
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }
    
    function index($page=1)
    {        
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(isi_komentar LIKE "%'. $data['src'] .'%" || nama LIKE "%'. $data['src'] .'%")');

        $data['list']   = $this->mypaging->config('komentar', $page, '10');

        $this->template->display(view.'index', $data);
    } 

    function lihat($id_post,$page=1)
    {               
        $data['src'] = '';
		if ($id_post>0) $this->db->where('id_post='.$id_post);
        $data['list']   = $this->mypaging->config('komentar', $page, '10');

        $this->template->display(view.'lihat', $data);
    } 

    function balas($id)
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

                        $this->db->join('post','post.id_post=komentar.id_post');
        $data['dta']  = $this->dbm->get_data_where('komentar', array('id_komentar'=>$id))->row();

        $this->template->display(view.'form', $data);
    }   

    function terbitkan($id)
    {
        $set    = array("terbitkan"=>'1');

        $db     = $this->dbm->update('komentar', array('id_komentar'=>$id), $set);
                    
        if ($db)
            echo "<script>alert('Berhasil!');</script>".$this->index();
        
        redirect(base_url('master/komentar'));
    }    

    function batal_terbitkan($id)
    {
        $set    = array("terbitkan"=>'0');

        $db     = $this->dbm->update('komentar', array('id_komentar'=>$id), $set);
                    
        if ($db)
            echo "<script>alert('Berhasil!');</script>".$this->index();
        
        redirect(base_url('master/komentar'));
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('komentar', 'Komentar', 'required');

        if($this->form_validation->run()) 
            {
            $id_parent  = empty($_POST['parent_id']) ? NULL : $_POST['parent_id'] ;
            $id_post = $_POST['id'];
            $nama       = $_POST['nama'];
            $email      = $_POST['email'];
            $komentar   = $_POST['komentar'];
            $waktu      = date('Y-m-d H:i:s');

            $value      = array(
                "id_post"    => $id_post,
                "nama"          => $nama,
                "email"         => $email,
                "waktu_komentar"=> $waktu,
                "isi_komentar"  => $komentar,
                "terbitkan"     => '0'
                );
            
            $value  = ($id_parent!=NULL) ? array_merge($value, array('id_parent' => $id_parent)) : $value ;

            $db     = $this->dbm->insert('komentar', $value);

            if ($db)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function simpan_balas($id)
    {
        $this->form_validation->set_rules('komentar_balasan', 'Komentar Balasan', 'required');

        if($this->form_validation->run()) 
            {
            $id_komentar= $id;
            $id_post = $_POST['id_post'];
            $nama       = $this->session->userdata('nama_user');
            $email      = $this->session->userdata('email');
            $waktu      = date('Y-m-d H:i:s');
            $balasan    = $_POST['komentar_balasan'];

            $value  = array(
                "id_post"    => $id_post,
                "nama"          => $nama,
                "email"         => $email,
                "waktu_komentar"=> $waktu,
                "isi_komentar"  => $balasan,
                "id_parent"     => $id_komentar,
                "terbitkan"     => '1'
                );

            $db     = $this->dbm->insert('komentar', $value);

            $db     = $this->dbm->update('komentar', array('id_komentar'=>$id_komentar), array("terbitkan"=>'1'));

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

        $del = $this->dbm->delete('komentar', array('id_komentar'=>$id));

        $del = $this->dbm->delete('komentar', array('id_parent'=>$id));

        redirect(base_url('master/komentar'));
    }
}
