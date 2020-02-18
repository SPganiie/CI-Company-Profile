<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/halaman/');
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
            $this->db->where('(judul_seo LIKE "%'. $data['src'] .'%")');

                          $this->db->order_by('id_halaman','DESC');
        $data['list']   = $this->mypaging->config('halaman', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $this->template->display(view.'form', $data);
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['dta']  = $this->dbm->get_data_where('halaman', array('id_halaman'=>$id))->row();

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $this->template->display(view.'form', $data);
    }

    function get_list($bhs, $id) 
    {
        return  $this->dbm->get_data_where('halaman_list', array('id_bahasa'=>$bhs,'id_halaman'=>$id))->row();
    }

    function simpan()
    {
        $this->form_validation->set_rules('nama_halaman', 'Nama Halaman', 'required');
        $this->form_validation->set_rules('judul_utama', 'Title Halaman', 'required');
        $this->form_validation->set_rules('judul_halaman[1]', 'Translate Judul Halaman', 'required');
        $this->form_validation->set_rules('konten[1]', 'Translate Konten Halaman', 'required');

        if($this->form_validation->run()) 
            {
            $_POST['gambar'] = str_replace('/upload/', '', $_POST['gambar']);
            $gambar =  !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';

            $id           = ($_POST['id_halaman']!='') ? $_POST['id_halaman'] : null;
            
            $nama_halaman  = strtolower($_POST['nama_halaman']);
            $nama_halaman  = preg_replace('~[\\\\/:*?"<>()&|]~', '', $nama_halaman);
            $nama_halaman  = str_replace(' ', '-', $nama_halaman);
            
            $judul_utama  = $_POST['judul_utama'];
            $penulis      = $_POST['penulis_halaman'];
            $description  = $_POST['meta_description'];
            $keyword      = $_POST['meta_keyword'];
            $tag          = $_POST['tag'];
            $aktif        = $_POST['aktif'];
            $id_bhs       = $_POST['id_bhs'];
			$tipe		  = $_POST['tipe'];

            if ($id==null)
                {
                $value  = array
                        (
                        'nama_halaman'      => $nama_halaman,
                        'penulis_halaman'   => $penulis,
                        'judul_seo'         => $judul_utama,
                        'meta_description'  => $description,
                        'meta_keyword'      => $keyword,
                        'tag'               => $tag,
                        'gambar_page'       => $gambar,
                        'aktif'             => $aktif
                        );

                $db     = $this->dbm->insert('halaman', $value);
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $judul        = $_POST['judul_halaman'][$key];
                    $konten       = $_POST['konten'][$key];
                    $konten       = str_replace('upload/', '/upload/', $konten);

                    $value_list   = array
                                (
                                'id_bahasa'         => $id_bhs_list,
                                'id_halaman'        => $new_id,
                                'judul_halaman'     => $judul,
                                'konten_halaman'    => $konten,
								'tipe'				=> $tipe
                                );

                    $db_list     = $this->dbm->insert('halaman_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $set    = array
                            (
                            'nama_halaman'      => $nama_halaman,
                            'penulis_halaman'   => $penulis,
                            'judul_seo'         => $judul_utama,
                            'meta_description'  => $description,
                            'meta_keyword'      => $keyword,
							'tag'               => $tag,
							'gambar_page'       => $gambar,
                            'aktif'             => $aktif
                            );

                    $db     = $this->dbm->update('halaman', array('id_halaman' => $id), $set);

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $judul        = $_POST['judul_halaman'][$key];
                        $konten       = $_POST['konten'][$key];
                        $konten       = str_replace('upload/', '/upload/', $konten);

                        $value_list   = array
                                    (
                                    'judul_halaman'     => $judul,
                                    'konten_halaman'    => $konten,
									'tipe'				=> $tipe
                                    );

                        $db_list     = $this->dbm->update('halaman_list', array('id_halaman'=>$id,'id_bahasa'=>$id_bhs_list), $value_list);
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

        $del = $this->dbm->delete('halaman', array('id_halaman'=>$id));

        $del = $this->dbm->delete('halaman_list', array('id_halaman'=>$id));

        redirect(base_url('master/halaman'));
    }

    function cek_judul()
    {
        $judul  = strtolower(str_replace(' ', '-', $_GET['judul']));

        $cek    = $this->dbm->get_data_where('halaman', array('judul_post'=>$judul))->num_rows();
            
        echo $cek;
    }
}
