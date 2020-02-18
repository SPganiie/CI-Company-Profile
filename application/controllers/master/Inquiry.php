<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/inquiry/');
        $this->load->model('dbm');
        $this->padding = 0;
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');        
        $this->auth->restrict($this->id_module_now);
    }
    
    function index($page = '1')
    {        
        $data['id']  = empty($_GET['id']) ? NULL : $_GET['id'];
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];

        if ($data['id']!='')
        	{        		
        	if ($data['src']!='')
            	$this->db->where('(nama_ck LIKE "%'. $data['src'] .'%" || telp_ck LIKE "%'. $data['src'] .'%" || note_inquiry LIKE "%'. $data['src'] .'%")');

        	$this->db->where('id_product = ', $data['id']);

	        $data['list'] = $this->mypaging->config('inquiry', $page, '10');

	        $this->template->display(view.'lihat', $data);

        	} else
        		{
		        if ($data['src']!='')
		            $this->db->where('(judul_seo_product LIKE "%'. $data['src'] .'%")');

		        $this->db->join('product', 'product.id_product=inquiry.id_product');

		        $data['list'] = $this->mypaging->config('inquiry', $page, '5');

		        $this->template->display(view.'index', $data);
        		}
    }

    function balas($id)
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

                        $this->db->join('product','product.id_product=inquiry.id_product');
        $data['dta']  = $this->dbm->get_data_where('inquiry', array('id_inquiry'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function simpan_balas($id_inquiry)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('telp', 'Telp', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('inquiry', 'Inquiry', 'required');

        if($this->form_validation->run()) 
            {
            $id_product = $_POST['id_product'];
            $nama       = $this->session->userdata('nama_user');
            $email      = $this->session->userdata('email');
            $telp       = $this->session->userdata('telp');
            $nama_ck    = $_POST['nama'];
            $telp_ck    = $_POST['telp'];
            $email_ck   = $_POST['email'];
            $note       = $_POST['inquiry'];
            $waktu      = date('Y-m-d H:i:s');
            $balasan    = !empty($_POST['inquiry_balasan']) ? $_POST['inquiry_balasan'] : NULL;

            if (!empty($balasan)) 
                {
                $value  = array(
                    "id_product"    => $id_product,
                    "nama"          => $nama,
                    "telp"          => $telp,
                    "email"         => $email,
                    "waktu"         => $waktu,
                    "note_inquiry"  => $balasan,
                    "id_parent"     => $id_inquiry,
                    "status"        => '1'
                    );

                $db     = $this->dbm->insert('inquiry', $value);                
                }

            $set    = array(
                "id_product"    => $id_product,
                "nama"          => $nama_ck,
                "telp"          => $telp_ck,
                "email"         => $email_ck,
                "note_inquiry"  => $note,
                "status"        => '1'
                );

            $db     = $this->dbm->update('inquiry', array('id_inquiry'=>$id_inquiry), $set);

            if ($db)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function terbitkan($id)
    {
        $db = $this->dbm->update('inquiry', array('id_inquiry'=>$id), array("status"=>'1'));
                    
        if ($db)
            echo "<script>alert('Berhasil!');</script>".$this->index();
        
        redirect(base_url('master/inquiry'));
    }    

    function batal_terbitkan($id)
    {
        $db = $this->dbm->update('inquiry', array('id_inquiry'=>$id), array("status"=>'0'));
                    
        if ($db)
            echo "<script>alert('Berhasil!');</script>".$this->index();
        
        redirect(base_url('master/inquiry'));
    }

    function hapus($id)
    {
    	$this->auth->restrict($this->id_module_now, 'hapus'); 

		$del = $this->dbm->delete('inquiry', array('id_inquiry'=>$id));

		redirect(base_url('master/inquiry'));
    }
}