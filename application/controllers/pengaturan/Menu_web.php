<?php if(!defined ('BASEPATH')) exit ('no direct script access allowed');

class Menu_web extends CI_Controller
{	
	public $id_module_now;
	public $id_level_now;

	private $tambah_rules = array(
		array(
			'field'	=> '',
			'label'	=> '',
			'rules' => 'required'
		),
		array(
			'field'	=> '',
			'label'	=> '',
			'rules' => 'required'
		),
		array(
			'field'	=> '',
			'label'	=> '',
			'rules' => 'required'
		)
	);


	private $edit_rules = array(
		array(
			'field'	=> 'nama_module',
			'label'	=> 'Nama Menu',
			'rules' => 'required'
		),
		array(
			'field'	=> 'url_module',
			'label'	=> 'Url',
			'rules' => 'required'
		),
		array(
			'field'	=> 'id_posisi',
			'label'	=> 'Posisi',
			'rules' => 'required'
		)
	);

  	public $padding;

	function __construct()
	{
		parent::__construct();
		define('view', 'pengaturan/menu_web/');
		$this->load->model('dbm');
		$this->load->model('model_module');

		$this->id_module_now  = $this->db->like('url_module', 'pengaturan/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
		$this->id_level_now   = $this->session->userdata('level');
		$this->auth->restrict($this->id_module_now);

        $this->setting = $this->template->mysetting_web();
		$this->ext = $this->setting->ext;
        $this->lang->load($this->setting->bahasa_admin.'_lang', 'admin');
		$this->padding = 0;
	}

	function index()
	{
		$data['drop_posisi'] = $this->dbm->dropdown('module_web_posisi', null, 'id_posisi', 'nama_posisi');

		$data['posisi'] = !empty($_GET['posisi']) ? $_GET['posisi'] : 1;

		// $data['list_menu'] 	 = $this->db->get('module_web')->result();

		$data['list_parent'] = $this->model_module->top_web($data['posisi']);

		// $this->template->display(view."index", $data); /*jika diload dimenu sendiri*/
		$this->load->view(view."index", $data);
	}

    function get_list($bhs, $id) 
    {
        return  $this->dbm->get_data_where('module_web_list', array('id_bahasa'=>$bhs,'id_module'=>$id))->row();
    }

	function tambah()
	{
		$this->form_validation->set_rules($this->tambah_rules);

		if($this->form_validation->run()) 
			{
			$in = $this->dbm->insert('module', array(
				'nama_module'	=> $_POST['nama_module'],
				'url_module'	=> $_POST['url'],
				'parent'		=> $_POST['parent'],
				'order'			=> $_POST['urutan'],
				'id_posisi'		=> $_POST['id_posisi']
			));

			$new_id = $this->db->insert_id();

            $id_bhs = $_POST['id_bhs'];

            foreach ($id_bhs as $key => $val) 
                {
                $id_bhs_list  = $_POST['id_bhs'][$key];
                $nama_list    = $_POST['nama_module_list'][$key];

                $val_list   = array
                            (
                            'id_bahasa'    => $id_bhs_list,
                            'id_module'    => $new_id,
                            'nama_module'  => $nama_list
                            );

                $db_list     = $this->dbm->insert('module_web_list', $val_list);
                }

            if ($in && $db_list)
                echo "ok";

			// redirect(base_url('pengaturan/menu_web'));
			redirect(base_url('pengaturan/pengaturan_web'));
			} 
			else 
				{
        		$data['bhs']  	= $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

				$data['dd']		= $this->dropdown_parent();

				$data['list'] 	= $this->dbm->get_all_data('aksi')->result();

        		$data['drop_posisi']  = $this->dbm->dropdown('module_web_posisi', null, 'id_posisi', 'nama_posisi');

				$this->template->display(view."form",$data);
				}
	}

	function edit($id_module)
	{	
    	$this->auth->restrict($this->id_module_now, 'edit');

		$this->form_validation->set_rules($this->edit_rules);

		if($this->form_validation->run()) 
			{
			$up = $this->dbm->update('module_web', array('id_module'=>$id_module), 
				array(
					'nama_module'	=> $_POST['nama_module'],
					'url_module'	=> $_POST['url'],
					'parent'		=> $_POST['parent'],
					'order'			=> $_POST['urutan'],
					'id_posisi'		=> $_POST['id_posisi']
				)
			);
			
            $id_bhs = $_POST['id_bhs'];

            foreach ($id_bhs as $key => $val) 
                {
                $id_bhs_list  = $_POST['id_bhs'][$key];

                $value_list   = array('nama_module' => $_POST['nama_module_list'][$key]);

                $db_list      = $this->dbm->update('module_web_list', array('id_module'=>$id_module, 'id_bahasa'=>$id_bhs_list), $value_list);
                }

            if ($up && $db_list)
                echo "ok";

			// redirect(base_url('pengaturan/menu_web'));
			redirect(base_url('pengaturan/pengaturan_web'));
			} 
			else 
				{
        		$data['bhs']  	= $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

				$data['dta']	= $this->dbm->get_data_where('module_web', array('id_module'=>$id_module))->row();

				$data['dd']		= $this->dropdown_parent(null, $data['dta']->id_posisi);

        		$data['drop_posisi']  = $this->dbm->dropdown('module_web_posisi', null, 'id_posisi', 'nama_posisi');

				$this->template->display(view."form", $data);
				}
	}

    function simpan()
    {
        $this->form_validation->set_rules('nama_module', 'Nama Menu', 'required');
        $this->form_validation->set_rules('id_posisi', 'Posisi', 'required');

        if($this->form_validation->run()) 
            {
            $id = ($_POST['id_module']!='') ? $_POST['id_module'] : null;

            if ($id==null)
                {
	        	$db = $this->dbm->insert('module_web', array(
					'nama_module'	=> $_POST['nama_module'],
					'url_module'	=> $_POST['url'],
					'parent'		=> $_POST['parent'],
					'order'			=> $_POST['urutan'],
					'id_posisi'		=> $_POST['id_posisi']
				));

				$new_id = $this->db->insert_id();

	            $id_bhs = $_POST['id_bhs'];

	            foreach ($id_bhs as $key => $val) 
	                {
	                $id_bhs_list  = $_POST['id_bhs'][$key];
	                $nama_list    = $_POST['nama_module_list'][$key];

	                $val_list   = array
	                            (
	                            'id_bahasa'    => $id_bhs_list,
	                            'id_module'    => $new_id,
	                            'nama_module'  => $nama_list
	                            );

	                $db_list     = $this->dbm->insert('module_web_list', $val_list);
	                }
                } 
                elseif ($id!=null)
                    {
		            $db = $this->dbm->update('module_web', array('id_module'=>$id), 
						array(
							'nama_module'	=> $_POST['nama_module'],
							'url_module'	=> $_POST['url'],
							'parent'		=> $_POST['parent'],
							'order'			=> $_POST['urutan'],
							'id_posisi'		=> $_POST['id_posisi']
						)
					);
					
		            $id_bhs = $_POST['id_bhs'];

		            foreach ($id_bhs as $key => $val) 
		                {
		                $id_bhs_list  = $_POST['id_bhs'][$key];

		                $value_list   = array('nama_module' => $_POST['nama_module_list'][$key]);

		                $db_list      = $this->dbm->update('module_web_list', array('id_module'=>$id, 'id_bahasa'=>$id_bhs_list), $value_list);
		                }
                    }

            if ($db && $db_list)
                echo "ok";
            } 
            else 
                {
                echo strip_tags(validation_errors());
                }
    }


	function hapus($id_module)
	{
		$this->auth->restrict($this->id_module_now, 'hapus');

		$del_child	= $this->dbm->delete('module_web', array('parent'=>$id_module));

		$del_this	= $this->dbm->delete('module_web', array('id_module'=>$id_module));

		$del_list	= $this->dbm->delete('module_web_list', array('id_module'=>$id_module));

		die();
	}

    function open_page($page = '1')
    {
    	$data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(judul_seo LIKE "%'. $data['src'] .'%")');

    	 				$this->db->where('aktif', '1');
    	$data['list'] =	$this->mypaging->config('halaman', $page, '6');
		$data['ext'] =	$this->ext;

    	$this->load->view(view.'open_page', $data);
    }

    function get_page()
    {
    	$cek = $this->dbm->get_data_where('halaman', array('id_halaman'=>$_POST['id']))->row();

    	echo 'page/'.$cek->nama_halaman;
    }

    function open_post($page = '1')
    {
    	$data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(judul_seo_post LIKE "%'. $data['src'] .'%")');

    	 				$this->db->where(array('aktif'=>'1','publish'=>'1'));
    	$data['list'] =	$this->mypaging->config('post', $page, '6');

    	$this->load->view(view.'open_post', $data);
    }

    function get_post()
    {
    	$cek = $this->dbm->get_data_where('post', array('id_post'=>$_POST['id']))->row();

    	echo 'post/'.$cek->nama_post;
    }

    function open_kategori($page = '1')
    {
    	$data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(nama_kategori_list LIKE "%'. $data['src'] .'%")');

    	$this->db->join('kategori_post_list', 'kategori_post_list.id_kategori = kategori_post.id_kategori_post');
    	$this->db->order_by('parent');
    	$this->db->group_by('id_kategori_post');
    	// $this->db->where(array('parent'=>'0'));

    	$data['list'] =	$this->mypaging->config('kategori_post', $page, '6');

    	$this->load->view(view.'open_kategori', $data);
    }

    function get_kategori()
    {
    	$cek = $this->dbm->get_data_where('kategori_post', array('id_kategori_post'=>$_POST['id']))->row();

    	echo 'category/'.$cek->nama_kategori_post;
    }

	function get_child($data)
	{
		$ret = '';
	    foreach($data['child'] as $key)
	    	{
	    	$ext = (!empty($key['url_module'])) ? '.'.$this->setting->ext : '';

	      	$no = $key['id_module'];

			$ret .= '
			<tr align="center" id="no_'. $key['id_module'] .'">
			<td></td>
			<td align="left" style="padding-left:'.($this->padding * 20).'px;"><li> '.$key['nama_module'].'</li></td>
			<td align="left"><a href="'.base_url().$key['url_module'].$ext.'" target="_blank">'.base_url().$key['url_module'].$ext.'</a></td>';
				$ret .= '
			<td>
				'.akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, "edit", 'title="Edit" onclick=\'ajax_modals("Edit Menu","null","pengaturan/menu_web/edit/'.$key['id_module'].'","width:60%")\'').'&nbsp
				'.akses_crud('javascript:void(0);', '<i class="material-icons md-18" style="color:#000" title="Hapus">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', ' onclick=\'if(confirm("Hapus menu ini ?")) aksi("pengaturan/menu_web/hapus/'.$key['id_module'].'", "no_'.$key['id_module'].'")\'').'
			</td>
			</tr>';

			if(is_array($key['child'])) 
				{
				$this->padding++;
				$ret .= $this->get_child($key);
				$this->padding--;
				}
	    	}

	    return $ret;
	}

	function dropdown_parent($selected=null, $posisi=null)
	{
		$ret = '';
		$top = $this->model_module->top_web($posisi);

		$ret .= '<select name="parent" class="form-control show-tick"><option value="0">-</option>';

		if ($top != 'NULL') 
			{
			foreach($top as $key) 
				{
				$ret .= '<option value="'.$key['id_module'].'" '.($key['id_module'] == $selected ? 'SELECTED' : '').'>'.$key['nama_module'].'</option>';

				if(is_array($key['child'])) 
					{
					$this->padding++;
					$ret .= $this->dropdown_child($key, $selected);
					$this->padding--;
					}
				}
			}

		$ret .= '</select>';

		return $ret;
	}
	
	function dropdown_child($data, $selected) 
	{
		$ret = '';

		foreach ($data['child'] as $key)
		{
			$ret .= '<option value="'.$key['id_module'].'" '.($key['id_module'] == $selected ? 'SELECTED' : '').'>'.str_repeat('---', $this->padding).' '.$key['nama_module'].'</option>';

			if(is_array($key['child'])) {
				$this->padding++;
				$ret .= $this->dropdown_child($key, $selected);
				$this->padding--;
			}
		}

		return $ret;
	}

	function parent_web($selected=null, $posisi=null)
	{
		$ret = '';
		$top = $this->model_module->top_web($posisi);

		$ret .= '<select name="parent" class="form-control show-tick"><option value="0">-</option>';

		if ($top != 'NULL') 
			{
			foreach($top as $key) 
				{
				$ret .= '<option value="'.$key['id_module'].'" '.($key['id_module'] == $selected ? 'SELECTED' : '').'>'.$key['nama_module'].'</option>';

				if(is_array($key['child'])) 
					{
					$this->padding++;
					$ret .= $this->dropdown_child($key, $selected);
					$this->padding--;
					}
				}
			}

		$ret .= '</select>';

		echo $ret;
	}

}