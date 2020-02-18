<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        define('view', 'front_web/');
        define('part', '/part/halaman');
        $this->load->model('dbm');

        $this->setting = $this->template->mysetting_web();
        $this->lang->load($this->setting->bahasa_web.'_lang', 'admin');
        $this->tema =  $this->setting->use_tema;
		    $this->ext =  empty($setting->ext) ? 'html' : $setting->ext;
    }

    function index()
    {
        $this->detail_page(null);
    }

    function detail_page($judul=null)
    {
		$id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = empty($_POST['bhs']) ? $id_bhs : $_POST['bhs'];
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $bhs_now = $this->session->userdata('id_bhs');
        if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

		$tmp = explode('/', $_SERVER['REQUEST_URI']); $judul = end($tmp);
        $judul = str_replace('.'.$this->ext, '', $judul);

                  $this->db->join('halaman_list','halaman_list.id_halaman=halaman.id_halaman');
        $query  = $this->dbm->get_data_where('halaman', array('aktif'=>'1','halaman_list.id_bahasa'=>$id_bhs,'halaman.nama_halaman'=>$judul));
				// echo"<pre>"; print_r($judul); die;

        $cek    = $query->num_rows();

        if ((!$judul) || ($cek=='0') )
            {
            	echo "<script type='text/javascript'>alert('Sorry, not found'); window.location = '".base_url('/page'.'.'.$this->ext)."'</script>";
            }
			else
                {
                $data['dta']              = $query->row();
                $data['meta_description'] = $data['dta']->meta_description;
                $data['meta_keyword']     = $data['dta']->meta_keyword;
                $data['meta_title']       = $data['dta']->judul_seo;

                $this->template->themes(view.$this->tema.part.'/detail_halaman', $data);
                }
    }

    function list_page()
    {
        $id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = empty($_POST['bhs']) ? $id_bhs : $_POST['bhs'];
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $bhs_now = $this->session->userdata('id_bhs');
        if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

                         $this->db->join('halaman_list','halaman_list.id_halaman=halaman.id_halaman');
        $data['list']  = $this->dbm->get_data_where('halaman', array('aktif'=>'1','halaman_list.id_bahasa'=>$id_bhs))->result();

        $this->template->themes(view.$this->tema.part.'/list', $data);
    }
}
