<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Footer extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/footer/');
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
            $this->db->where('(nama_footer LIKE "%'. $data['src'] .'%" || nama_posisi LIKE "%'. $data['src'] .'%")');

                        $this->db->join('footer_posisi','footer_posisi.id_posisi=footer.id_posisi');
                        $this->db->order_by('footer.id_posisi');
        $data['list'] = $this->mypaging->config('footer', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function get_list($bhs, $id) 
    {
        return  $this->dbm->get_data_where('footer_list', array('id_bahasa'=>$bhs,'id_footer'=>$id))->row();
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['_dropdown_posisi']  = $this->dbm->dropdown('footer_posisi', null, 'id_posisi', 'nama_posisi');

        $this->template->display(view.'form', $data);
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['_dropdown_posisi']  = $this->dbm->dropdown('footer_posisi', null, 'id_posisi', 'nama_posisi');

        $data['dta']    = $this->dbm->get_data_where('footer', array('id_footer'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama_utama_footer', 'Nama Footer', 'required');
        // $this->form_validation->set_rules('id_posisi', 'Posisi Footer', 'required');
        $this->form_validation->set_rules('nama_footer[1]', 'Nama Footer', 'required');
        $this->form_validation->set_rules('konten[1]', 'Konten Footer', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_footer']!='') ? $_POST['id_footer'] : null;
            
            // $_POST['gambar'] = str_replace('/upload/', '', $_POST['gambar']);
            $gambar = '';// !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';
            
            $nama   = $_POST['nama_utama_footer'];
            $posisi = '1';//$_POST['id_posisi'];
            $urutan = '1';//$_POST['urutan'];
            $aktif  = '1';//$_POST['aktif'];
            $id_bhs = $_POST['id_bhs'];

            if ($id==null)
                {
                $value  = array(
                    "nama_footer"   => $nama,
                    "gambar_footer" => $gambar,
                    "id_posisi"     => $posisi,
                    "urutan"        => $urutan,
                    "aktif"         => $aktif
                    );

                $db     = $this->dbm->insert('footer', $value);
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $nm_list      = $_POST['nama_footer'][$key];
                    $konten       = $_POST['konten'][$key];
                    $konten       = str_replace('upload/', '/upload/', $konten);

                    $value_list   = array
                                (
                                'id_bahasa'         => $id_bhs_list,
                                'id_footer'         => $new_id,
                                'nama_footer_list'  => $nm_list,
                                'konten_footer'     => $konten,
                                );

                    $db_list     = $this->dbm->insert('footer_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $set    = array(
                        "nama_footer"   => $nama,
                        "gambar_footer" => $gambar,
                        "id_posisi"     => $posisi,
                        "urutan"        => $urutan,
                        "aktif"         => $aktif
                        );

                    $db     = $this->dbm->update('footer', array('id_footer'=>$id), $set);

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $nm_list      = $_POST['nama_footer'][$key];
                        $konten       = $_POST['konten'][$key];
                        $konten       = str_replace('upload/', '/upload/', $konten);

                        $value_list   = array
                                    (
                                    'nama_footer_list'  => $nm_list,
                                    'konten_footer'     => $konten,
                                    );

                        $db_list     = $this->dbm->update('footer_list', array('id_footer'=>$id,'id_bahasa'=>$id_bhs_list), $value_list);
                        }
                    }

            if ($db && $db_list)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function hapus($id)
    {
        $this->auth->restrict($this->id_module_now, 'hapus'); 

        $del = $this->dbm->delete('footer', array('id_footer'=>$id));
        
        $del = $this->dbm->delete('footer_list', array('id_footer'=>$id));

        redirect(base_url('master/footer'));
    }
}
