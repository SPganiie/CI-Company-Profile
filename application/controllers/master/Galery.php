<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Galery extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        define('view', 'master/galery/');
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
            $this->db->where('(judul_galery LIKE "%'. $data['src'] .'%")');

        $this->db->order_by('id_galery', 'desc');

        $data['list']   = $this->mypaging->config('galery', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['kategori'] = $this->get_parent();

        $this->template->display(view.'form', $data);
    }

    function edit($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['kategori'] = $this->get_parent();

        $data['dta']  = $this->dbm->get_data_where('galery', array('id_galery'=>$id))->row();

        $this->template->display(view.'form', $data);
    }

    function get_list($bhs, $id)
    {
        return  $this->dbm->get_data_where('galery_list', array('id_bahasa'=>$bhs,'id_galery'=>$id))->row();
    }

    function simpan()
    {
        $this->form_validation->set_rules('judul_galery', 'Nama', 'required');

        $ktg_list = $_POST['ak_list'];
        foreach ($ktg_list as $key => $val)
            {
            $this->form_validation->set_rules('ak_list['.$key.']', 'Kategori', 'required');
            }

        $id_bhs = $_POST['id_bhs'];
        foreach ($id_bhs as $key => $val)
            {
            $this->form_validation->set_rules('translate_judul_galery['.$key.']', 'Translate Judul Galery', 'required');
            // $this->form_validation->set_rules('translate_konten_galery['.$key.']', 'Translate Konten Galery', 'required');
            }

        if($this->form_validation->run())
            {
            $id     = ($_POST['id_galery']!='') ? $_POST['id_galery'] : null;

            $judul_galery  = strtolower(str_replace(' ', '-', $_POST['judul_galery']));
            $judul_galery  = preg_replace('~[\\\\/:*?"<>()&|]~', '', $judul_galery);

            $id_bhs        = $_POST['id_bhs'];

            $value  = array(
                    "judul_galery"  => $judul_galery,
                    "aktif"         => $_POST['aktif']
                );

            if ($id==null)
                {
                $db = $this->dbm->insert('galery', $value);
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val)
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $judul        = $_POST['translate_judul_galery'][$key];
                    $konten       = $_POST['translate_konten_galery'][$key];
                    $konten       = str_replace('upload/', '/upload/', $konten);

                    $value_list   = array
                                (
                                'id_bahasa' => $id_bhs_list,
                                'id_galery' => $new_id,
                                'translate_judul_galery'  => $judul,
                                'translate_konten_galery' => $konten,
                                );

                    $db_list     = $this->dbm->insert('galery_list', $value_list);
                    }

                foreach ($ktg_list as $key => $val)
                    {
                    $value_kat = array
                                (
                                'id_galery'        => $new_id,
                                'id_kategori'    => $_POST['ak_list'][$val]
                                );

                    $db_kat     = $this->dbm->insert('galery_kategori_list', $value_kat);
                    }
                }
                else
                    {
                    $db = $this->dbm->update('galery', array('id_galery'=>$id), $value);

                    foreach ($id_bhs as $key => $val)
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $judul        = $_POST['translate_judul_galery'][$key];
                        $konten       = $_POST['translate_konten_galery'][$key];
                        $konten       = str_replace('upload/', '/upload/', $konten);

                        $value_list   = array
                                    (
                                    'translate_judul_galery'  => $judul,
                                    'translate_konten_galery' => $konten,
                                    );

                        $db_list     = $this->dbm->update('galery_list', array('id_galery'=>$id,'id_bahasa'=>$id_bhs_list), $value_list);
                        }

                    $del_kat= $this->dbm->delete('galery_kategori_list', array('id_galery'=>$id));
                    foreach ($ktg_list as $key => $val)
                        {
                        $value_kat = array
                                    (
                                    'id_galery'        => $id,
                                    'id_kategori'    => $_POST['ak_list'][$val]
                                    );

                        $db_kat     = $this->dbm->insert('galery_kategori_list', $value_kat);
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

        $del = $this->dbm->delete('galery', array('id_galery'=>$id));

        $del = $this->dbm->delete('galery_list', array('id_galery'=>$id));

        $file = $this->dbm->get_data_where('galery_file', array('id_galery'=>$id));

        foreach ($file->result() as $val)
            {
            $del = $this->dbm->delete('galery_file_list', array('id_file'=>$val->id_file));
            }

        $del = $this->dbm->delete('galery_file', array('id_galery'=>$id));

        redirect(base_url('master/galery'));
    }

    function get_kategori($id)
    {
        return $this->dbm->get_data_where('galery_kategori_list', array('id_galery'=>$id))->result();
    }

    function cek_galery_kat($id_art,$id_kat)
    {
        $cek = $this->dbm->get_data_where('galery_kategori_list', array('id_galery'=>$id_art,'id_kategori'=>$id_kat))->row();

        return ($cek) ? '1' : '0' ;
    }

    function get_parent()
    {
        $list= array();
        $top = $this->db->where('parent','0')->get('kategori_galery')->result();

        foreach($top as $row)
            {
            $list[] = array
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'parent'        => $row->parent,
                'child'         => $this->get_child($row->id_kategori_galery)
                );
            }

        return $list;
    }

    function get_child($id)
    {
        $sql = $this->db->where('parent', $id)->get('kategori_galery');
        $ret = array();

        foreach($sql->result() as $row)
            {
            $ret[] = array
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'parent'        => $row->parent,
                'child'         => $this->get_child($row->id_kategori_galery)
                );
            }

        return (empty($ret)) ? NULL : $ret ;
    }

    function show_child($data)
    {
        $ret = '';

        foreach($data['child'] as $key)
            {

            $kat = !empty($dta) ? $this->cek_galery_kat($dta->id_galery, $key['id_kategori']) : null;
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

    function file($id_galery)
    {
        $data['id_galery'] = $id_galery;

        $data['list'] = $this->db->where(array('id_galery'=>$id_galery))->order_by('order', 'ASC')->get('galery_file')->result();

        $this->template->display(view."file", $data);
    }

    function get_file_list($bhs, $id_file)
    {
        return  $this->dbm->get_data_where('galery_file_list', array('id_bahasa'=>$bhs,'id_file'=>$id_file))->row();
    }

    function tambah_file($id_galery)
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['id_galery'] = $id_galery;

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $this->template->display(view."form_file", $data);
    }

    function edit_file($id_file)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['dta']  = $this->dbm->get_data_where('galery_file', array('id_file'=>$id_file))->row();

        $data['id_galery'] = $data['dta']->id_galery;

        $this->template->display(view."form_file", $data);
    }

    function hapus_file($id_file)
    {
        $this->auth->restrict($this->id_module_now, 'hapus');

        $del  = $this->dbm->delete('galery_file', array('id_file'=>$id_file));

        $list = $this->dbm->delete('galery_file_list', array('id_file'=>$id_file));

        echo "ok";
    }

    function simpan_file($id_galery)
    {
        $this->form_validation->set_rules('judul_file', 'Judul File', 'required');
        $this->form_validation->set_rules('judul_translate[1]', 'Translate Judul', 'required');

        if($this->form_validation->run())
            {
            $_POST['gambar'] = str_replace('/upload/', '', $_POST['gambar']);
            $file =  !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';

            $id      = ($_POST['id_file']!='') ? $_POST['id_file'] : null;
            $judul   = $_POST['judul_file'];
            $order   = $_POST['order'];
            $id_bhs  = $_POST['id_bhs'];

            if ($id==null)
                {
                $value  = array(
                        'id_galery'     => $id_galery,
                        'judul_file'    => $judul,
                        'file'          => $file,
                        'order'         => $order
                        );

                $db     = $this->dbm->insert('galery_file', $value);

                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val)
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $trans_judul  = $_POST['judul_translate'][$key];
                    $trans_desc   = $_POST['deskripsi_file'][$key];

                    $value_list   = array(
                                    'id_file'         => $new_id,
                                    'id_bahasa'       => $id_bhs_list,
                                    'translate_judul' => $trans_judul,
                                    'translate_deskripsi'  => $trans_desc
                                    );

                    $db_list = $this->dbm->insert('galery_file_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $up = array(
                            'judul_file' => $judul,
                            'file'       => $file,
                            'order'      => $order
                            );

                    $db = $this->dbm->update('galery_file', array('id_file' => $id), $up);

                    foreach ($id_bhs as $key => $val)
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $trans_judul  = $_POST['judul_translate'][$key];
                        $trans_desc   = $_POST['deskripsi_file'][$key];

                        $up_list    = array(
                                    'translate_judul' => $trans_judul,
                                    'translate_deskripsi'  => $trans_desc
                                    );

                        $db_list    = $this->dbm->update('galery_file_list', array('id_file' => $id,'id_bahasa'=>$id_bhs_list), $up_list);
                        }
                    }

            if ($db)
                echo "ok";

            } else
                {
                echo strip_tags(validation_errors());
                }
    }
}
