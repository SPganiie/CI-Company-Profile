<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/post/');
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
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];

        if ($data['src']!='')
            $this->db->where('(judul_seo_post LIKE "%'. $data['src'] .'%")');

                        $this->db->order_by('waktu_buat','DESC');
        $data['list'] = $this->mypaging->config('post', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['kategori'] = $this->get_parent();

        $this->template->display(view.'form', $data);
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']      = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['kategori'] = $this->get_parent();

        $data['dta']      = $this->dbm->get_data_where('post', array('id_post'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function get_list($bhs, $id) 
    {
        return  $this->dbm->get_data_where('post_list', array('id_bahasa'=>$bhs,'id_post'=>$id))->row();
    }

    function publish($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $db = $this->dbm->update('post', array('id_post' => $id), array('publish' => '1', 'waktu_publish' => date('Y-m-d H:i:s')) );

        if ($db)
            redirect(base_url('master/post'));
    }

    function simpan()
    {
        $this->form_validation->set_rules('judul_utama', 'SEO Post', 'required');
        $ktg_list     = $_POST['ak_list']; 
        foreach ($ktg_list as $key => $val) 
            {
            $this->form_validation->set_rules('ak_list['.$key.']', 'Kategori', 'required');
            }
            
        $id_bhs = $_POST['id_bhs'];
        foreach ($id_bhs as $key => $val) 
            {
            $this->form_validation->set_rules('judul_post['.$key.']', 'Judul Post', 'required');
            $this->form_validation->set_rules('konten['.$key.']', 'Konten Post', 'required');
            }

        if($this->form_validation->run()) 
            {
            $_POST['gambar'] = str_replace('/upload/', '', $_POST['gambar']);
            $gambar =  !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';
            
            $id           = ($_POST['id_post']!='') ? $_POST['id_post'] : null;
            
            $nama_post    = strtolower(str_replace(' ', '-', $_POST['nama_post']));
            $nama_post    = preg_replace('~[\\\\/:*?"<>()&|]~', '', $nama_post);

            $judul_utama  = $_POST['judul_utama'];
            $waktu_buat   = date('Y-m-d H:i:s');
			$penulis      = $_POST['penulis_post'];
            $description  = $_POST['meta_description'];
            $tag          = $_POST['tag'];
            $aktif        = $_POST['aktif'];
            $komentar     = $_POST['komentar'];
            $waktu_publish= ($aktif=='1') ? $waktu_buat : '';

            if ($id==null)
                {
                $value  = array
                        (
                        'judul_seo_post'    => $judul_utama,
			            'nama_post'			=> $nama_post,
                        'penulis_post'      => $penulis,
                        'waktu_buat'        => $waktu_buat,
                        'meta_description'  => $description,
                        'tag'               => $tag,
                        'aktif'             => $aktif,
                        'komentar'          => $komentar,
                        'gambar_post'       => $gambar,
                        'publish'           => $aktif,
                        'waktu_publish'     => $waktu_publish
                        );

                $db     = $this->dbm->insert('post', $value);
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $judul        = $_POST['judul_post'][$key];
                    $konten       = $_POST['konten'][$key];
                    $konten       = str_replace('upload/', '/upload/', $konten);

                    $value_list   = array
                                (
                                'id_bahasa'      => $id_bhs_list,
                                'id_post'        => $new_id,
                                'judul_post'     => $judul,
                                'konten_post'    => $konten,
                                );

                    $db_list     = $this->dbm->insert('post_list', $value_list);
                    }

                foreach ($ktg_list as $key => $val) 
                    {
                    $value_kat = array
                                (
                                'id_post'        => $new_id,
                                'id_kategori'    => $_POST['ak_list'][$val]
                                );

                    $db_kat     = $this->dbm->insert('post_kategori_list', $value_kat);
                    }

                } elseif ($id!=null)
                    {
                    $set    = array
                            (
                            'judul_seo_post'    => $judul_utama,
							'nama_post'			=> $nama_post,
                            'penulis_post'      => $penulis,
                            'meta_description'  => $description,
                            'tag'               => $tag,
                            'aktif'             => $aktif,
                            'komentar'          => $komentar,
                            'gambar_post'       => $gambar 
                            );

                    $db     = $this->dbm->update('post', array('id_post' => $id), $set);

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $judul        = $_POST['judul_post'][$key];
                        $konten       = $_POST['konten'][$key];
                        $konten       = str_replace('upload/', '/upload/', $konten);

                        $value_list   = array
                                    (
                                    'judul_post'     => $judul,
                                    'konten_post'    => $konten,
                                    );

                        $db_list     = $this->dbm->update('post_list', array('id_post'=>$id,'id_bahasa'=>$id_bhs_list), $value_list);
                        }

                    $del_kat= $this->dbm->delete('post_kategori_list', array('id_post'=>$id));
                    foreach ($ktg_list as $key => $val) 
                        {
                        $value_kat = array
                                    (
                                    'id_post'        => $id,
                                    'id_kategori'    => $_POST['ak_list'][$val]
                                    );

                        $db_kat     = $this->dbm->insert('post_kategori_list', $value_kat);
                        }
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

        $del    = $this->dbm->delete('post', array('id_post'=>$id));

        $list   = $this->dbm->delete('post_list', array('id_post'=>$id));

        $kat    = $this->dbm->delete('post_kategori_list', array('id_post'=>$id));

        $kom    = $this->dbm->delete('komentar', array('id_post'=>$id));

        redirect(base_url('master/post'));
    }

    function cek_judul()
    {
        //$judul  = strtolower(str_replace(' ', '-', $_GET['judul']));
        //$cek    = $this->dbm->get_data_where('post', array('judul_post'=>$judul))->num_rows();
            
        //echo $cek;
    }

    function get_kategori($id)
    {
        return $this->dbm->get_data_where('post_kategori_list', array('id_post'=>$id))->result();
    }

    function cek_post_kat($id_art,$id_kat)
    {
        $cek = $this->dbm->get_data_where('post_kategori_list', array('id_post'=>$id_art,'id_kategori'=>$id_kat))->row();

        return ($cek) ? '1' : '0' ;
    }

    function get_parent() 
    {
        $list= array();
        $top = $this->db->where('parent','0')->get('kategori_post')->result();

        foreach($top as $row) 
            {
            $list[] = array
                (
                'id_kategori'   => $row->id_kategori_post,
                'nama_kategori' => $row->nama_kategori_post,
                'parent'        => $row->parent,
                'child'         => $this->get_child($row->id_kategori_post)
                );
            }

        return $list;
    }

    function get_child($id)
    {    
        $sql = $this->db->where('parent', $id)->get('kategori_post');
        $ret = array();
        
        foreach($sql->result() as $row)
            {
            $ret[] = array 
                (
                'id_kategori'   => $row->id_kategori_post,
                'nama_kategori' => $row->nama_kategori_post,
                'parent'        => $row->parent,
                'child'         => $this->get_child($row->id_kategori_post)
                );
            }
        
        return (empty($ret)) ? NULL : $ret ;
    }

    function show_child($data,$dta)
    {
        $ret = '';

        foreach($data['child'] as $key)
            {

            $kat = !empty($dta) ? $this->cek_post_kat($dta->id_post, $key['id_kategori']) : null;
            $kat = ($kat==null) ? "" : ($kat=='1') ? "checked" : "" ;

            $ret .= '<div class="box-category" style="padding-left: 25px;">
                     <ul class="list-unstyled">
                        <li>
                            <input type="checkbox" id="checkbox_'. $key['id_kategori'].'" name="ak_list['. $key['id_kategori'].']" value="'. $key['id_kategori'].'" class="filled-in" '. $kat .' />
                            <label for="checkbox_'. $key['id_kategori'].'">'. ucwords(str_replace('_', ' ', $key['nama_kategori'])).'</label>';

            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->show_child($key);
                $this->padding--;
                }

            $ret .= '</li></ul></div>';
            }

        return $ret;
    }
}
