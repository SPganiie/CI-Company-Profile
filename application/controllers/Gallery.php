<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        define('view', 'front_web/');
        define('part', '/part/galery');
        $this->load->model('dbm');
        $this->load->library('webpaging');

        $this->padding = 0;
        $this->setting = $this->template->mysetting_web();

        $this->lang->load($this->setting->bahasa_web.'_lang', 'admin');
        $this->tema = $this->setting->use_tema;
		$this->ext  = empty($setting->ext) ? 'html' : $setting->ext;
    }

    function index()
    {
        $this->list_gallery();
    }

    function list_gallery()
    {
        /*list kategori*/
        $bhs_now = $this->session->userdata('id_bhs');
        $id_bhs = empty($_POST['bhs']) ? $bhs_now : $_POST['bhs'];
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        if ($id_bhs>0 && $id_bhs<>$bhs_now) $this->session->set_userdata(array("id_bhs"=>$id_bhs));
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

                         $this->db->join('kategori_galery_list pl', 'pl.id_kategori = kategori_galery.id_kategori_galery');
        $data['list']  = $this->dbm->get_data_where('kategori_galery', array('id_bahasa'=>$id_bhs))->result();

        $data['list_parent'] = $this->get_parent_galery();

        $this->template->themes(view.$this->tema.part.'/list_galery', $data);
    }

    function detail_gallery($judul=null)
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

                  $this->db->join('kategori_galery_list pl', 'pl.id_kategori=kategori_galery.id_kategori_galery');
                  $this->db->where('(nama_kategori_galery ="'. $judul .'")');
        $query  = $this->dbm->get_data_where('kategori_galery', array('id_bahasa'=>$id_bhs));

        $cek    = $query->num_rows();

         if (($judul==NULL) || ($cek=='0') )
            {
            echo "<script type='text/javascript'>alert('Sorry, not found'); window.location = '".base_url().'category-gallery.'.$this->setting->ext."'</script>";

            } else
                {
                $data['dta'] = $query->row();

                $cek = $this->dbm->get_data_where('galery_kategori_list',array('id_kategori'=>$data['dta']->id_kategori_galery))->num_rows();

                if ($cek==0)
                    {
                    $data['list']  = NULL ;

                    } else
                        {
                        $data['ext']  = $this->setting->ext ;
                        $page = empty($_GET['page']) ? 1 : $_GET['page'];

                        $this->db->join('galery_list','galery_list.id_galery = galery.id_galery', 'LEFT')
                                 ->join('galery_kategori_list ak', 'ak.id_galery = galery.id_galery', 'LEFT')
                                 ->join('galery_file file', 'file.id_galery = galery.id_galery', 'LEFT')
                                 ->group_by('galery.id_galery')
                                 ->where(array('aktif'=>'1','galery_list.id_bahasa'=>$id_bhs,'id_kategori'=>$data['dta']->id_kategori_galery));

                        $data['list'] = $this->db->get('galery')->result();//$this->webpaging->config('galery', $page, '3');

                        }

                $data['dta']->judul_seo = $data['dta']->nama_kategori_list;

                $this->template->themes(view.$this->tema.part.'/detail_list_galery', $data);
                }
    }

    function show_gallery($judul=null)
    {
        $id_bhs = $this->session->userdata('id_bhs');
        $id_bhs = $id_bhs>0 ? $id_bhs : $this->setting->bahasa_web;
        $this->lang->load($id_bhs.'_lang', 'admin');
        $data['id_bhs'] = $id_bhs;

        $tmp = explode('?', $_SERVER['REQUEST_URI']);
        $judul = $tmp[0];

        $tmp = explode('/', $judul);
        $judul = end($tmp);

        $judul = str_replace('.'.$this->ext, '', $judul);

                  $this->db->join('galery_list','galery_list.id_galery=galery.id_galery');
        $query  = $this->dbm->get_data_where('galery', array('aktif'=>'1','id_bahasa'=>$id_bhs,'judul_galery'=>$judul));

        $cek    = $query->num_rows();

        if (($judul==NULL) || ($cek=='0') )
            {
            echo "<script type='text/javascript'>alert('Sorry, not found'); window.location = '".base_url()."'</script>";
            }
            else
                {
                $data['dta'] = $query->row();

                $data['dta']->judul_seo = $data['dta']->translate_judul_galery;

                $data['ext']  = $this->setting->ext ;
                $page = empty($_GET['page']) ? 1 : $_GET['page'];

                $this->db->join('galery_file_list','galery_file_list.id_file = galery_file.id_file', 'LEFT')
                         ->where(array('id_galery'=>$data['dta']->id_galery,'galery_file_list.id_bahasa'=>$id_bhs));

                $data['list'] = $this->db->get('galery_file')->result();

				//$this->webpaging->config('galery_file', $page, '9');

                $this->template->themes(view.$this->tema.'/part/galery/detail_galery', $data);
                }
    }

    function get_parent_galery()
    {
        $top = $this->db->join('kategori_galery_list gl', 'gl.id_kategori = kategori_galery.id_kategori_galery')
                        ->where(array('parent'=>'0', 'id_bahasa'=>$this->session->userdata('id_bhs')))
                        ->get('kategori_galery')->result();

        $list= array();

        foreach($top as $row)
            {
            $list[] = array
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'nama_list'     => $row->nama_kategori_list,
                'parent'        => $row->parent,
                'child'         => $this->get_child_galery($row->id_kategori_galery)
                );
            }

        return $list;
    }

    function get_child_galery($id)
    {
        $sql = $this->db->join('kategori_galery_list gl', 'gl.id_kategori = kategori_galery.id_kategori_galery')
                        ->where(array('parent'=>$id, 'id_bahasa'=>$this->session->userdata('id_bhs')))
                        ->get('kategori_galery');

        $ret = array();

        foreach($sql->result() as $row)
            {
            $ret[] = array
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'nama_list'     => $row->nama_kategori_list,
                'parent'        => $row->parent,
                'child'         => $this->get_child_galery($row->id_kategori_galery)
                );
            }

        return (empty($ret)) ? "NULL" : $ret ;
    }

    function show_child_galery($data)
    {
        $ret = '';
        if ($data['child']!='NULL')
            {
            foreach($data['child'] as $key)
                {

                $ret .= '<li style="padding-left:'.($this->padding * 20).'px;"><a href="'.base_url().'category-gallery/'.$key['nama_kategori'].'.'.$this->ext.'" > '.str_replace('-', ' ', ucwords($key['nama_kategori'])).'</a></li>';

                if(is_array($key['child']))
                    {
                    $this->padding++;
                    $ret .= $this->show_child_galery($key);
                    $this->padding--;
                    }
                }
            }

        return $ret;
    }
}
