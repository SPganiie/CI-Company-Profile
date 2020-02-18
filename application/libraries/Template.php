<?php
class Template {
	protected $_ci;
	public $av = null;

	function __construct()
	{
		$this->_ci=&get_instance();
        $setting = $this->mysetting_web();
        $this->_ci->lang->load($setting->bahasa_admin.'_lang', 'admin');
	}

	function level_login($id_level)
	{
		$this->_ci->db	->select('level')
						->where('id_level',$id_level);

		$db = $this->_ci->db->get('user_level',1)->row();

		foreach($db as $val)
		{
			return $val;
		}
	}

	function tampilan_menu($kat=null)
	{
		$ret = array();

    	if ($kat==null)
			{
			$this->_ci->db->where(array('id_module_kategori' => '1', 'id_aksi' => '0'));
			$this->_ci->db->join('module_aksi','module_aksi.id_module=module.id_module');
			}
			else
				{
				$bhs_now = $this->_ci->session->userdata('id_bhs');

				$this->_ci->db->join('module_web_list','module_web_list.id_module=module.id_module')
							  ->where(array('id_module_kategori'=>$kat,'id_bahasa'=>$bhs_now));
				}

		$db = $this->_ci->db->where('parent','0')->where('tampil','1')
							->order_by('order','asc')
							->get('module')->result();

		foreach($db as $row)
			{
			$id = $row->id_module;
			if(!isset($ada[$id]))
				{
				$ret[] = array
					(
					'id_module'		=> $row->id_module,
					'nama_module'	=> $row->nama_module,
					'icon_module'	=> $row->icon_module,
					'url_module'	=> $row->url_module,
					'parent'		=> $row->parent,
					'child'			=> $this->get_child($row->id_module,$kat)
					);
				$ada[$id] = 1;
				}
			}

		return (empty($ret)) ? "NULL" : $ret ;
	}

	function get_child($id_module,$kat=null)
	{
		if ($kat==null)
			{
			$this->_ci->db->where('id_module_kategori','1');
			} else
				{
				$bhs_now = $this->_ci->session->userdata('id_bhs');

				$this->_ci->db->join('module_web_list','module_web_list.id_module=module.id_module')
							  ->where(array('id_module_kategori'=>$kat,'id_bahasa'=>$bhs_now));
				}

		$sql = $this->_ci->db	->where('parent',$id_module)
								->order_by('order','asc')
                      			->get('module');

		$ret = array();

		foreach($sql->result() as $row)
		{
			$ret[] = array
			(
				'id_module'		=> $row->id_module,
				'nama_module'	=> $row->nama_module,
				'icon_module'	=> $row->icon_module,
				'url_module'	=> $row->url_module,
				'parent'		=> $row->parent,
				'child'			=> $this->get_child($row->id_module)
			);
		}

		return (empty($ret)) ? "NULL" : $ret ;
	}

	function dropdown_child($data=array())
	{
		$level = $this->_ci->session->userdata('level');

		if($data['child'] != 'NULL')
		{
			foreach($data['child'] as $row)
			{
				$izin = $this->izin($row['id_module'], $level);
				if($izin == true) {
					$ret .= '<li>'.
					'<a href="'.base_url().$row['url_module'].'" class="ajax" '.($row['url_module'] == NULL ? 'style="pointer-events:none"' : '').'>'.$this->_ci->lang->line($row['nama_module']).'</a>'.
					@$this->dropdown_child($row).
					'</li>';
				}
			}
		}

		return ($ret == '') ? '' : $ret ;
	}


	function izin($id_module, $level)
	{
		$cek = $this->_ci->db->where('id_level', $level)->where('id_module', $id_module)->get('user_akses', 1)->num_rows();

		return ($cek > 0) ? TRUE : FALSE ;
	}

	function display($template,$data=null)
	{
		if(!$this->is_ajax())	//new condition 13 jan 2014
		{
			$data['_level']		= $this->level_login($this->_ci->session->userdata('level'));
			$data['level']		= $this->_ci->session->userdata('level');
			$data['_menus']		= $this->tampilan_menu();
			$data['_content']	= $this->_ci->load->view($template,$data, true);

			$this->_ci->load->view('/layout/plain.php', $data);
		}
		else	//new condition 13 jan 2014
		{
			$this->_ci->load->view($template,$data);
		}
	}

	/*06/07/17*/
	function count_notif()
	{
		return $this->_ci->db->get('chat_session')->num_rows();
	}

	/*06/03/17*/
	function mysetting_web()
	{
		return $this->_ci->db->get('setting_web')->row();
	}

	/* web depan */
	function themes($template, $data=null)
	{
		$pengaturan	  			= $this->mysetting_web();
		$tema_pakai         	= $pengaturan->use_tema;
		$data['title_head']		= $pengaturan->nama_web;
		$data['pemilik']		= $pengaturan->pemilik;
		$data['description']	= $pengaturan->meta_deskripsi;
		$data['keyword']		= $pengaturan->meta_keyword;
		$data['ext']			= $pengaturan->ext;

    $data['bhs']     		= $this->_ci->db->where('aktif','1')->get('bahasa')->result();
		$data['_halaman']		= $this->_ci->db->where('aktif','1')->get('halaman')->result();

		$data['_menu_primary']	= $this->tampilan_menu_web('1');
		$data['_menu_footer']	= $this->tampilan_menu_web('3');
		$data['atv_now']		= $this->av;

        $data['_widget_atas']   = $this->get_widget('1');
        $data['_widget_bawah']  = $this->get_widget('2');

        $data['_side_popular']	= $this->get_postkategori(1, null, 5);
        $data['_side_top']		= $this->get_postkategori($pengaturan->id_kategori_topside, null, 5);
        $data['_side_recent']	= $this->get_postkategori(null, null, 5);
        $data['_side_category']	= $this->get_kategori(null, array('parent'=>'0'))->result();
        $data['_side_archives']	= $this->get_archive()->result();

        $data['_footer1']  		= $this->get_footer('1');
        $data['_cat_foot1']		= $this->get_postkategori($pengaturan->id_kategori_footer1, null, 4);
        $data['_cat_foot2']		= $this->get_postkategori($pengaturan->id_kategori_footer2, null, 4);

		if(!$this->is_ajax())
			{
			$data['_container']	 = $this->_ci->load->view($template, $data, true);
			$this->_ci->load->view('front_web/'.$tema_pakai.'/plain.php', $data);
			}
			else
				{
				$this->_ci->load->view($template,$data);
				}
	}

	function tampilan_menu_web($posisi=null)
	{
		$bhs_now = $this->_ci->session->userdata('id_bhs');

		if ($posisi!=null) {
			$this->_ci->db->where('id_posisi', $posisi);
		}
		else {
			$this->_ci->db->where('id_posisi', '1');
		}

		if ($posisi==2) {
			$this->_ci->db->order_by('order','desc');
		}
		else {
			$this->_ci->db->order_by('order','asc');
		}

		$db = $this->_ci->db->join('module_web_list','module_web_list.id_module=module_web.id_module')
							->where(array('id_bahasa'=>$bhs_now, 'parent'=>'0'))
							->get('module_web')->result();

		$ret = array();

		foreach($db as $row)
			{
			$id = $row->id_module;

			if(!isset($ada[$id]))
				{
				$ret[] = array
					(
					'id_module'		=> $row->id_module,
					'nama_module'	=> $row->nama_module,
					'url_module'	=> $row->url_module,
					'parent'		=> $row->parent,
					'child'			=> $this->get_child_web($row->id_module)
					);
				$ada[$id] = 1;
				}
			}

		return (empty($ret)) ? "NULL" : $ret ;
	}

	function get_child_web($id_module)
	{
		$bhs_now = $this->_ci->session->userdata('id_bhs');

		$sql = $this->_ci->db->join('module_web_list','module_web_list.id_module=module_web.id_module')
							 ->where(array('id_bahasa'=>$bhs_now, 'parent'=>$id_module))->order_by('order','asc')
							 ->get('module_web');

		$ret = array();

		foreach($sql->result() as $row)
			{
			$ret[] = array
				(
				'id_module'		=> $row->id_module,
				'nama_module'	=> $row->nama_module,
				'url_module'	=> $row->url_module,
				'parent'		=> $row->parent,
				'child'			=> $this->get_child_web($row->id_module)
				);
			}

		return (empty($ret)) ? "NULL" : $ret ;
	}

	function dropdown_child_web($data=array())
	{
		$pengaturan	= $this->mysetting_web();
		$ext = $pengaturan->ext;

		$uri = $_SERVER['REQUEST_URI'];
		$check_uri = str_replace('.'.$ext, '', $uri);
		$lgh = strlen($check_uri);
		$check_uri = substr($check_uri, 1, $lgh-1);

		if($data != 'NULL')
			{
			foreach($data as $row)
				{
				$active = ($row['url_module']==$check_uri) ? 'current-menu-item current_page_item' : '';

				$ret .= '<li id="menu-item-'.$row['id_module'].'" class="menu-item menu-item-type-custom menu-item-object-custom '.$active.' menu-item-'.$row['id_module'].'">'.
							'<a href="'.base_url().$row['url_module'].'.'.$ext.'" class="ajax" '.($row['url_module'] == NULL ? 'style="pointer-events:none"' : '').'>'.$row['nama_module'].'</a>'.
							@$this->dropdown_child($row).
						'</li>';
				}
			}

		return ($ret == '') ? '' : $ret ;
	}

	function set_active($id_cek)
	{
		$pengaturan	= $this->mysetting_web();
		$tema_pakai = $pengaturan->use_tema;
		$ext		= $pengaturan->ext;

		$uri = $_SERVER['REQUEST_URI'];
		$check_uri = str_replace('.'.$ext, '', $uri);

		$lgh = strlen($check_uri);
		$check_uri = substr($check_uri, 1, $lgh-1);

		$db = $this->_ci->db->where(array('id_posisi'=>'1','id_module'=>$id_cek))->get('module_web')->row();

		$ch = $this->_ci->db->where('parent', $id_cek)->get('module_web')->row();

		if (!empty($ch))
			{
			return $this->active_child($id_cek);
			}
			elseif ($check_uri==$db->url_module)
				{
				return '1';
				// break;
				}
				else
					{
					return '0';
					}
	}

	function active_child($id_parent)
	{
		$pengaturan	= $this->mysetting_web();
		$tema_pakai = $pengaturan->use_tema;
		$ext		= $pengaturan->ext;

		$uri = $_SERVER['REQUEST_URI'];
		$check_uri = str_replace('.'.$ext, '', $uri);

		$lgh = strlen($check_uri);
		$check_uri = substr($check_uri, 1, $lgh-1);

		$sql = $this->_ci->db->where(array('parent'=>$id_parent))->get('module_web')->result();

		foreach($sql as $row)
			{
			$ch = $this->_ci->db->where('parent', $row->id_module)->get('module_web')->row();

			if ($check_uri==$row->url_module)
				{
				return '1';
				break;
				}
				elseif (!empty($ch))
					{
					return $this->active_child($row->id_module);
					}
			}
	}

	function get_widget($posisi)
	{
        $bhs   = $this->_ci->session->userdata('id_bhs');

		$query = $this->_ci->db->join('widget_list', 'widget_list.id_widget=widget.id_widget')
							   ->where(array('id_posisi'=>$posisi,'aktif'=>'1','id_bahasa'=>$bhs))
							   ->order_by('urutan')
							   ->get('widget');

		return $query->result();
	}

	function get_footer($posisi)
	{
        $bhs   = $this->_ci->session->userdata('id_bhs');

		$query = $this->_ci->db->join('footer_list', 'footer_list.id_footer=footer.id_footer')
							   ->where(array('id_posisi'=>$posisi,'aktif'=>'1','id_bahasa'=>$bhs))
							   ->order_by('urutan')
							   ->get('footer');
		return $query->row();
	}

	function get_postkategori($ktg=null, $where=null, $limit=null)
	{
		$bhs  = $this->_ci->session->userdata('id_bhs');

		if (!empty($ktg)) {
			$this->_ci->db->where(array('id_kategori'=>$ktg));
		}

		if (!empty($where)) {
			$this->_ci->db->where($where);
		}

		if (!empty($limit)) {
			$this->_ci->db->limit($limit);
		}

		return $this->_ci->db->join('post_kategori_list ak', 'ak.id_post=post.id_post')
				          ->join('post_list','post_list.id_post=post.id_post')
				          ->where(array('aktif'=>'1','publish'=>'1','post_list.id_bahasa'=>$bhs))
				          ->order_by('waktu_publish','desc')
				          ->group_by('post.id_post')
				          ->get('post')->result();
	}

	function get_kategori($ktg=null, $where=null, $limit=null)
	{
		$bhs = $this->_ci->session->userdata('id_bhs');

		if (!empty($ktg)) {
			$this->_ci->db->where(array('id_kategori'=>$ktg));
		}

		if (!empty($where)) {
			$this->_ci->db->where($where);
		}

		if (!empty($limit)) {
			$this->_ci->db->limit($limit);
		}

		return $this->_ci->db->join('kategori_post_list pl', 'pl.id_kategori=kategori_post.id_kategori_post')
							->where('id_bahasa', $bhs)
							->group_by('id_kategori_post')
							->get('kategori_post');
	}

	function get_archive()
	{
		return $this->_ci->db->select('YEAR(waktu_publish) as tahun')
                    ->where(array('YEAR(waktu_publish) >= '=>(date('Y')-8),'YEAR(waktu_publish) <='=>(date('Y')+8)))
                    ->order_by('tahun','desc')->group_by('tahun')
                    ->get('post');
	}

    function get_bulan($tahun)
    {
        return $this->_ci->db->select('MONTH(waktu_publish) as bulan, COUNT(id_post) as jum')
                          ->where('YEAR(waktu_publish)',$tahun)
                          ->order_by('bulan','desc')->group_by('bulan')
                          ->get('post')->result();
    }

	function cetak($template, $data=null)
	{
		$data['_isi']=$this->_ci->load->view($template,$data, true);
		$this->_ci->load->view('/template_print.php', $data);
	}

	function is_ajax()		//new function 13 jan 2014
	{
		return ($this->_ci->input->server('HTTP_X_REQUESTED_WITH')&&($this->_ci->input->server('HTTP_X_REQUESTED_WITH')=='XMLHttpRequest'));
	}

	/*function get_bahasa($bahasa)
	{
		return $this->_ci->load->file("application/views/layout/bahasa/".$bahasa.".php");
	}
	*/
}
