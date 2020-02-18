<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_web extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        define('view', 'pengaturan/pengaturan_web/');
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', 'pengaturan/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
				$this->bahasa = $setting->bahasa_admin;
				$this->bahasa2 = $setting->bahasa_web;

        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }

    function index()
    {
        $data = array(
            'dta'           => $this->dbm->get_all_data('setting_web')->row(),
            'zona_waktu'    => $this->time_zonelist(),
            'list_bahasa'   => $this->list_bahasa(),
            'list_kategori' => $this->list_kategori(),
            'id_bahasa'     => $this->bahasa,
            'id_bahasa2'    => $this->bahasa2,
        );

        $this->template->display(view.'index', $data);
    }

    function update()
    {
        if ($_GET['a'] == 'umum')
            {
            $this->form_validation->set_rules('nama_web', 'Nama Website', 'required');
            $this->form_validation->set_rules('meta_deskripsi', 'Deskripsi', 'required');
            $this->form_validation->set_rules('meta_keyword', 'Keyword', 'required');
            $this->form_validation->set_rules('pemilik', 'Pemilik', 'required');
            } elseif ($_GET['a'] == 'konfig')
                {
                $this->form_validation->set_rules('zona_waktu', 'Zona Waktu', 'required');
                }

        if($this->form_validation->run())
            {
            $id = '1';

            $old_pass = $this->db->get('setting_web')->row('email_pass');
            $old_pass = mydecrypt($old_pass);
            $pass = myencrypt(isset($_POST['email_pass']) ? $_POST['email_pass'] : $old_pass);

            if ($_GET['a'] == 'umum')
                {
                $set    = array
                        (
                        'nama_web'      => $_POST['nama_web'],
                        'deskripsi_web' => $_POST['deskripsi_web'],
                        'meta_deskripsi'=> $_POST['meta_deskripsi'],
                        'meta_keyword'  => $_POST['meta_keyword'],
                        'pemilik'       => $_POST['pemilik'],
                        'email'         => $_POST['email'],
                        'email_pass'    => $pass,
                        'telp'          => $_POST['telp'],
                        'wa'            => $_POST['wa'],
                        'alamat'        => $_POST['alamat'],
                        'latitude'      => $_POST['latitude'],
                        'langitude'     => $_POST['langitude'],
                        'url_facebook'  => $_POST['url_facebook'],
                        'url_twitter'   => $_POST['url_twitter'],
                        'url_youtube'   => $_POST['url_youtube'],
                        'url_instagram' => $_POST['url_instagram']
                        );
                }
                else # konfig
                    {
                    $_POST['gambar']= str_replace('/upload/', '', $_POST['gambar']);
                    $gambar         =  !empty($_POST['gambar']) ? '/upload/'.$_POST['gambar'] : '';

                    $_POST['gambar_logo']= str_replace('/upload/', '', $_POST['gambar_logo']);
                    $gambar_logo    =  !empty($_POST['gambar_logo']) ? '/upload/'.$_POST['gambar_logo'] : '';

                    $set    = array
                        (
                        'bahasa_admin'  => $_POST['bahasa_admin'],
												'bahasa_web'	=> $_POST['bahasa_web'],
                        'zona_waktu'    => str_replace(' ', '_', $_POST['zona_waktu']),
                        'maintenance'   => $_POST['maintenance'],
                        'ext'           => $_POST['ext'],
                        'url_favicon'   => $gambar,
                        'logo_website'  => $gambar_logo,
                        'width_tumbs'   => $_POST['width_tumbs'],
                        'height_tumbs'  => $_POST['height_tumbs'],
                        'page_news'     => $_POST['page_news'],
                        'admin_link'    => $_POST['admin_link'],
                        'id_kategori_top'     => $_POST['id_kategori_top'],
                        'id_kategori_topside' => $_POST['id_kategori_topside'],
                        'id_kategori_footer1' => $_POST['id_kategori_footer1'],
                        'id_kategori_footer2' => $_POST['id_kategori_footer2'],
                        );
                    }

            $db     = $this->dbm->update('setting_web', array('id' => $id), $set);

            if ($db)
                echo "ok";
            }
            else
                {
                echo strip_tags(validation_errors());
                }
    }

    function list_bahasa()
    {
		return $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();
    }

    function list_kategori()
    {
        // $this->db->where(array('parent'=>'0'));
        $this->db->join('kategori_post_list', 'kategori_post_list.id_kategori = kategori_post.id_kategori_post');
        $this->db->order_by('parent', 'ASC');
        $this->db->order_by('id_kategori_post', 'ASC');
        $this->db->group_by('id_kategori_post');
        return $this->db->get('kategori_post')->result();
    }

    function time_zonelist()
    {
        $return = array();

        $timezone_identifiers_list = timezone_identifiers_list();

        foreach($timezone_identifiers_list as $timezone_identifier)
            {
            $date_time_zone = new DateTimeZone($timezone_identifier);
            $date_time      = new DateTime('now', $date_time_zone);
            $hours          = floor($date_time_zone->getOffset($date_time) / 3600);
            $mins           = floor(($date_time_zone->getOffset($date_time) - ($hours*3600)) / 60);
            $hours          = 'GMT' . ($hours < 0 ? $hours : '+'.$hours);
            $mins           = ($mins > 0 ? $mins : '0'.$mins);
            $text           = str_replace("_"," ",$timezone_identifier);

            $return[]       = array('val'=>$text,'show'=>$text.' ('.$hours.':'.$mins.')');
            }

        return $return;
    }
}
