<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
        parent::__construct();
		    $this->load->helper('other');
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }

    function index()
    {
        $data['sum_post']       = $this->db->select('COUNT(id_post) as tot')->get('post')->row('tot');
        $data['sum_halaman']    = $this->db->select('COUNT(id_halaman) as tot')->get('halaman')->row('tot');
        $data['sum_komentar']   = $this->db->select('COUNT(id_komentar) as tot')->get('komentar')->row('tot');
        $data['sum_pengunjung'] = $this->db->select('COUNT(id_traffic) as tot')->get('traffic')->row('tot');

        $data['tgl_dari']       = empty($_GET['tgl_dari']) ? date('01-m-Y') : $_GET['tgl_dari'];    //, strtotime('-7 days')
        $data['tgl_sampai']     = empty($_GET['tgl_sampai']) ? date('30-m-Y') : $_GET['tgl_sampai'];

        // $this->db->select('DATE(waktu_akses) as tgl, count(id_traffic) as tot')->group_by('DATE(waktu_akses)');
        // $this->db->where(array('DATE(waktu_akses) >='=>tgl_sql($data['tgl_dari']), 'DATE(waktu_akses) <='=>tgl_sql($data['tgl_sampai'])));
        // $query                  =  $this->dbm->get_all_data('traffic')->result();

				// $data['traffic']        = (empty($query)) ? '0' : $query ;
        $data['traffic']        = (empty($query)) ? '0' : '1' ;

        $this->template->display('admin', $data);
    }

    function clear_trafic($start, $end)
    {
        $del = $this->dbm->delete('traffic', array('waktu_akses >=' => tgl_sql($start), 'waktu_akses <=' => tgl_sql($end)));

        if ($del)
            echo "<script type='text/javascript'>alert('Success clear traffic data.'); window.location = '".base_url('admin')."'</script>";
        // redirect(base_url('admin'));
    }

    function access_forbidden()
    {
        echo "<script type='text/javascript'>alert('Anda tidak di izinkan atau tidak memiliki izin untuk membuka halaman ini!'); window.location = '".base_url('admin')."'</script>";
    }
}
