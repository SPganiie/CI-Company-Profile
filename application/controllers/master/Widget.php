<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/widget/');
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
            $this->db->where('(nama_widget LIKE "%'. $data['src'] .'%" || nama_posisi LIKE "%'. $data['src'] .'%")');

                        $this->db->join('widget_posisi','widget_posisi.id_posisi=widget.id_posisi');
                        $this->db->order_by('widget.id_posisi');
        $data['list'] = $this->mypaging->config('widget', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function get_list($bhs, $id) 
    {
        return  $this->dbm->get_data_where('widget_list', array('id_bahasa'=>$bhs,'id_widget'=>$id))->row();
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['_dropdown_posisi']  = $this->dbm->dropdown('widget_posisi', '- Pilih Posisi -', 'id_posisi', 'nama_posisi');

        $this->template->display(view.'form', $data);
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['_dropdown_posisi']  = $this->dbm->dropdown('widget_posisi', '- Pilih Posisi -', 'id_posisi', 'nama_posisi');

        $data['dta']    = $this->dbm->get_data_where('widget', array('id_widget'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama_utama_widget', 'Nama Widget', 'required');
        $this->form_validation->set_rules('id_posisi', 'Posisi Widget', 'required');
        $this->form_validation->set_rules('nama_widget[1]', 'Nama Widget', 'required');
        $this->form_validation->set_rules('konten[1]', 'Konten Widget', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_widget']!='') ? $_POST['id_widget'] : null;
            
            $_POST['gambar'] = str_replace('/upload/', '', $_POST['gambar']);
            $gambar =  !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';
            
            $posisi = $_POST['id_posisi'];
            $nama   = $_POST['nama_utama_widget'];
            $urutan = $_POST['urutan'];
            $aktif  = $_POST['aktif'];
            $id_bhs = $_POST['id_bhs'];

            if ($id==null)
                {
                $value  = array(
                    "nama_widget"   => $nama,
                    "gambar_widget" => $gambar,
                    "id_posisi"     => $posisi,
                    "urutan"        => $urutan,
                    "aktif"         => $aktif
                    );

                $db     = $this->dbm->insert('widget', $value);
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $nm_list      = $_POST['nama_widget'][$key];
                    $konten       = $_POST['konten'][$key];
                    $konten       = str_replace('upload/', '/upload/', $konten);

                    $value_list   = array
                                (
                                'id_bahasa'         => $id_bhs_list,
                                'id_widget'         => $new_id,
                                'nama_widget_list'  => $nm_list,
                                'konten_widget'     => $konten,
                                );

                    $db_list     = $this->dbm->insert('widget_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $set    = array(
                        "nama_widget"   => $nama,
                        "gambar_widget" => $gambar,
                        "id_posisi"     => $posisi,
                        "urutan"        => $urutan,
                        "aktif"         => $aktif
                        );

                    $db     = $this->dbm->update('widget', array('id_widget'=>$id), $set);

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $nm_list      = $_POST['nama_widget'][$key];
                        $konten       = $_POST['konten'][$key];
                        $konten       = str_replace('upload/', '/upload/', $konten);

                        $value_list   = array
                                    (
                                    'nama_widget_list'  => $nm_list,
                                    'konten_widget'     => $konten,
                                    );

                        $db_list     = $this->dbm->update('widget_list', array('id_widget'=>$id,'id_bahasa'=>$id_bhs_list), $value_list);
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

        $del = $this->dbm->delete('widget', array('id_widget'=>$id));
        
        $del = $this->dbm->delete('widget_list', array('id_widget'=>$id));

        redirect(base_url('master/widget'));
    }
}
