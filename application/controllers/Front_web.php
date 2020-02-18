<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Front_web extends CI_Controller {
  function __construct()
	{
        parent::__construct();
        define('view', 'front_web/');
        $this->load->model('dbm');
        $this->load->library('webpaging');
        $this->setting = $this->template->mysetting_web();
        $this->lang->load($this->setting->bahasa_web.'_lang', 'admin');
        $this->tema = $this->setting->use_tema;
				$this->ext = empty($setting->ext) ? 'html' : $setting->ext;
        // email
        $config['protocol']  = $this->config->item('protocol');
        $config['smtp_host'] = $this->config->item('smtp_host');
        $config['smtp_port'] = $this->config->item('smtp_port');
        $config['smtp_user'] = $this->config->item('smtp_user');
        $config['smtp_pass'] = $this->config->item('smtp_pass');
        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
    }
  function index()
  {
    $tmp = explode('?', $_SERVER['REQUEST_URI']);
    $judul = $tmp[0];

    $tmp = explode('/', $judul);
    $judul = end($tmp);

    $judul = str_replace('.'.$this->ext, '', $judul);

    $id_bhs = $this->session->userdata('id_bhs');
    $id_bhs = empty($_POST['bhs']) ? $id_bhs : $_POST['bhs'];
    $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
    $bhs_now = $this->session->userdata('id_bhs');
    if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
    $this->lang->load($id_bhs.'_lang', 'admin');
    $data['id_bhs'] = $id_bhs;
    if ($this->setting->maintenance=='1')
        {
        $this->load->view(view.$this->setting->use_tema.'/part/maintenance');
        }
  else
            {
            $data['ext']  = $this->setting->ext;

            # slide
        $this->db->join('galery_list','galery_list.id_galery=galery.id_galery');
    $query  = $this->dbm->get_data_where('galery', array('aktif'=>'1','id_bahasa'=>$id_bhs,'judul_galery'=>'home-slider'));
    $dta = $query->row();

    $this->db->join('galery_file_list','galery_file_list.id_file = galery_file.id_file', 'LEFT')
                     ->where(array('id_galery'=>$dta->id_galery,'galery_file_list.id_bahasa'=>$id_bhs));

            $data['top_slide'] = $this->db->get('galery_file')->result();

    $judul = 'home';
          $this->db->join('halaman_list','halaman_list.id_halaman=halaman.id_halaman');
    $query  = $this->dbm->get_data_where('halaman', array('aktif'=>'1','halaman_list.id_bahasa'=>$id_bhs,'halaman.nama_halaman'=>$judul));
    $data['dta'] = $query->row();

    // $data['widget_atas'] = $this->db->join('widget_list','widget_list.id_widget=widget.id_widget')
    //                ->join('widget_posisi','widget_posisi.id_posisi=widget.id_posisi')
    //                ->where(array('aktif'=>'1','widget.id_posisi'=>'1','id_bahasa'=>$id_bhs))
    //                ->like('nama_widget', 'Project')
    //                ->limit(3)
    //                ->get('widget')->result();
    //
    // $data['testimonials'] = $this->db->join('widget_list','widget_list.id_widget=widget.id_widget')
    //                ->join('widget_posisi','widget_posisi.id_posisi=widget.id_posisi')
    //                ->where(array('aktif'=>'1','nama_widget'=>'Testimonials','id_bahasa'=>$id_bhs))
    //                ->limit(3)
    //                ->get('widget')->result();

            // $this->traffic();
            $this->template->themes(view.$this->setting->use_tema.'/part/index', $data);
            }
}
  function traffic()
  {
      $sekarang   = date('Y-m-d H:i:s');
      $ip         = getip();
      //$ua         = $this->getBrowser();
      //$browser    = $ua['name'].' '.$ua['version'];
      //$platform   = $ua['platform'];

      //$query      = $this->db->query('SELECT country_name FROM ip_country,ip_list WHERE ip < INET_ATON("'.$ip.'") AND ip_list.kd_country=ip_country.kd_country ORDER BY ip DESC LIMIT 0,1');
      //$cek_ip     = $query->row();
      //$negara     = $cek_ip->country_name;

      $value      = array(
          'ip'          => $ip,
          'waktu_akses' => $sekarang
          // 'browser'     => '',
          // 'platform'    => '',
          // 'negara'      => '',
          );
      $db         = $this->dbm->insert('traffic', $value);
  }


}
