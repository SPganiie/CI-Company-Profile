<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        define('view', 'front_web/');
        define('part', '/part/kategori');
        $this->load->model('dbm');
        $this->load->library('webpaging');

        $this->setting = $this->template->mysetting_web();
        $this->lang->load($this->setting->bahasa_web.'_lang', 'admin');

        $this->tema =  $this->setting->use_tema;
		$this->ext =  empty($setting->ext) ? 'html' : $setting->ext;
    }

    function index()
    {
        $this->list_post();
    }

    function list_post()
    {
        $id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = empty($_POST['bhs']) ? $id_bhs : $_POST['bhs'];
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $bhs_now = $this->session->userdata('id_bhs');
        if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

                         $this->db->join('kategori_post_list pl', 'pl.id_kategori=kategori_post.id_kategori_post');
        $data['list']  = $this->dbm->get_data_where('kategori_post', array('id_bahasa'=>$id_bhs))->result();

        $this->template->themes(view.$this->tema.part.'/list_post', $data);
    }

    function detail_post($judul=null)
    {
        $id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = empty($_POST['bhs']) ? $id_bhs : $_POST['bhs'];
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $bhs_now = $this->session->userdata('id_bhs');
        if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

        $tmp = explode('?', $_SERVER['REQUEST_URI']);
        $judul = $tmp[0];

		$tmp = explode('/', $judul);
        $judul = end($tmp);

        $judul = str_replace('.'.$this->ext, '', $judul);

                  $this->db->join('kategori_post_list pl', 'pl.id_kategori=kategori_post.id_kategori_post');
                  $this->db->where('(nama_kategori_post ="'. $judul .'")');
        $query  = $this->dbm->get_data_where('kategori_post', array('id_bahasa'=>$id_bhs));

        $cek    = $query->num_rows();

        //post terbaru
        $data['post_baru'] = $this->db->join('post_list','post_list.id_post=post.id_post')
                                         ->where(array('publish'=>'1','aktif'=>'1','id_bahasa'=>$id_bhs))
                                         ->order_by('waktu_publish','desc')->get('post', 8)->result();

        //post terpopuler
        $data['post_fav'] = $this->db->join('post_list','post_list.id_post=post.id_post')
                                     ->join('post_kategori_list pk','pk.id_post=post.id_post')
                                     ->where(array('publish'=>'1','aktif'=>'1','pk.id_kategori'=>'1','id_bahasa'=>$id_bhs))
                                     ->order_by('waktu_publish','desc')->get('post', 8)->result();
        //archive
        $data['archive'] = $this->db->select('YEAR(waktu_publish) as tahun')
                                    ->where(array('YEAR(waktu_publish) >= '=>(date('Y')-5),'YEAR(waktu_publish) <='=>(date('Y')+5)))
                                    ->order_by('tahun','desc')->group_by('tahun')
                                    ->get('post')->result();

         if (($judul==NULL) || ($cek=='0') )
            {
            echo "<script type='text/javascript'>alert('Sorry, not found'); window.location = '".base_url().$this->setting->page_news.'.'.$this->setting->ext."'</script>";
            }
            else
                {
                $data['dta'] = $query->row();

                $cek = $this->dbm->get_data_where('post_kategori_list',array('id_kategori'=>$data['dta']->id_kategori_post))->num_rows();

                if ($cek==0)
                    {
                    $data['list']  = NULL ;
                    }
                    else
                        {
                        //dengan pagging web depan
                        $data['ext']  = $this->setting->ext ;
                        $page = empty($_GET['page']) ? 1 : $_GET['page'];

                        $this->db->join('post_kategori_list ak', 'ak.id_post=post.id_post')
                                 ->join('post_list','post_list.id_post=post.id_post')
                                 ->where(array('aktif'=>'1','publish'=>'1','post_list.id_bahasa'=>$id_bhs,'id_kategori'=>$data['dta']->id_kategori_post))
                                 ->order_by('waktu_publish','desc');

                        $data['list'] = $this->webpaging->config('post', $page, '5'); //5
                        }

                $data['dta']->judul_seo = $data['dta']->nama_kategori_list;

                $this->template->themes(view.$this->tema.part.'/detail_post', $data);
                }
    }

    function find()
    {
		$tmp = explode('/', $_SERVER['REQUEST_URI']); $tag = end($tmp);
        $tag = str_replace('.'.$this->ext, '', $tag);

        $id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $data['id_bhs'] = $id_bhs;

        if (isset($tag))
            {
            $this->db->join('post_list','post_list.id_post=post.id_post')->where('(tag LIKE "%'.$tag.'%")');
            $q  = $this->dbm->get_data_where('post', array('aktif'=>'1','publish'=>'1','id_bahasa'=>$id_bhs));

			$h1 = $q->result();
			$h1 = count($h1)<1 ? array() : $h1;

			$query = $h1;//array_merge($h1, $h2);
            $cek   = count($query);

             if (($tag==NULL) || ($cek=='0') )
                {
                echo "<script>alert('Sorry, Tag not found'); window.location = '".base_url($this->setting->page_news.'.'.$this->ext)."'</script>";
                }
                else
                    {
                    $data['key'] = $tag;
                    $data['list'] = $query;

					$this->template->themes(view.$this->tema.part.'/list_tag', $data);
                }
            }
    }

    function get_bulan($tahun)
    {
        $bulan = $this->db->select('MONTH(waktu_publish) as bulan, COUNT(id_post) as jum')
                          ->where('YEAR(waktu_publish)',$tahun)
                          ->order_by('bulan','desc')->group_by('bulan')
                          ->get('post')->result();
        return $bulan;
    }
}
