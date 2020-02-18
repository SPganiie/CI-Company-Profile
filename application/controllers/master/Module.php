<?php if(!defined ('BASEPATH')) exit ('no direct script access allowed');

class Module extends CI_Controller
{	
	public $id_module_now;
	public $id_level_now;

	private $tambah_rules = array(
		array (
			'field'	=> 'nama_module',
			'label'	=> 'Nama Module',
			'rules' => 'required'
		)
	);

	private $edit_rules = array(
		array (
			'field'	=> 'nama_module',
			'label'	=> 'Nama Module',
			'rules' => 'required'
		)
	);

  	public $padding;

	function __construct()
	{
		parent::__construct();
		$this->load->model('dbm');
		$this->load->model('model_module');

		$this->padding = 0;

		$this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
		$this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
		$this->auth->restrict($this->id_module_now);

		define('view', 'master/module/');
	}

	function index()
	{
		/*menu module master disembunyikan dengan mengubah id di database tabel module id_module 10 jadi 100*/

		$data['module']       	= strtolower(get_class());
	    $data['title']	      	= "Module";    
	    $data['id_level']     	= 1;
		$data['list_parent']  	= $this->model_module->get_top();

		$data['list'] 			= $this->db->get('aksi')->result();

		$this->template->display(view."index",$data);
	}

	function tambah()
	{
		$this->form_validation->set_rules($this->tambah_rules);

		if($this->form_validation->run()) {

			$is_admin 		= $this->dbm->get_data_where('user_level', array('is_admin'=>'1'))->result();
			$id_module		= $this->dbm->max_data('id_module', 'module')->row('id_module')+1;
			$nama_module 	= $this->input->post('nama_module');
			$icon 		 	= $this->input->post('icon_module');
			$url 			= $this->input->post('url');
			$parent 		= $this->input->post('parent');
			$urutan			= $this->input->post('urutan');

			$in = $this->dbm->insert('module', array (
				'id_module' 	=> $id_module,
				'nama_module'	=> $nama_module,
				'icon_module'	=> ($icon == '') ? null : $icon ,
				'url_module'	=> $url,
				'parent'		=> $parent,
				'order'			=> $urutan
			));

			if($in) {
				
				foreach ($this->input->post('aksi') as $key => $val) {
					if($val == '1') {
						$this->dbm->insert('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$key));

						/* memberikan langsung administrator hak akses */
						foreach($is_admin as $row) {
							$in_admin = $this->dbm->insert('user_akses', array(
								'id_level'	=> $row->id_level,
								'id_module'	=> $id_module,
								'id_aksi'	=> $key
							));
						}
						$in_admin = $this->dbm->insert('user_akses', array(
								'id_level'	=> $row->id_level,
								'id_module'	=> $id_module,
								'id_aksi'	=> '0'
							));
					}
				}
			}

			redirect(base_url('master/module'));

		} else {

			$data['title']	= "Tambah Module";
			$data['dd']		= $this->dropdown_parent();
			$data['list'] 	= $this->dbm->get_all_data('aksi')->result();

			$this->template->display(view."form",$data);
		}
	}

	function edit($id_module)
	{	
    	$this->auth->restrict($this->id_module_now, 'edit');

		$this->form_validation->set_rules($this->edit_rules);

		if($this->form_validation->run()) {

			$nama_module 	= $this->input->post('nama_module');
			$icon 		 	= $this->input->post('icon_module');
			$url 			= $this->input->post('url');
			$parent 		= $this->input->post('parent');
			$urutan			= $this->input->post('urutan');

			$in = $this->dbm->update('module', array('id_module'=>$id_module), array (
				'nama_module'	=> $nama_module,
				'icon_module'	=> ($icon == '') ? null : $icon ,
				'url_module'	=> $url,
				'parent'		=> $parent,
				'order'			=> $urutan
			));

			if($in) {
				$delete = $this->dbm->delete('module_aksi', array('id_module'=>$id_module));

				foreach ($this->input->post('aksi') as $key => $val) {
					if($val == '1')
						$this->dbm->insert('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$key));
				}
				$this->dbm->insert('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>'0'));
			}

			redirect(base_url('master/module'));

		} else {

			$data['title']	= "Edit Module";
			$data['dd']		= $this->dropdown_parent();
			$data['dta']	= $this->dbm->get_data_where('module', array('id_module'=>$id_module))->row();
			$data['list'] 	= $this->dbm->get_all_data('aksi')->result();

			$this->template->display(view."form",$data);

		}
	}

	function hapus($id_module)
	{
		$this->auth->restrict($this->id_module_now, 'hapus');

		$del_child	= $this->dbm->delete('module', array('parent'=>$id_module));
		$del_akses	= $this->dbm->delete('user_akses', array('id_module'=>$id_module));
		$del_this	= $this->dbm->delete('module', array('id_module'=>$id_module));

		die();
	}

	function dropdown_parent($selected=null)
	{
		$ret = '';
		$top = $this->model_module->get_top();

		$ret .= '<select name="parent" class="form-control show-tick"><option value="0">-</option>';

		foreach($top as $key) 
		{
			$ret .= '<option value="'.$key['id_module'].'" '.($key['id_module'] == $selected ? 'SELECTED' : '').'>'.$key['nama_module'].'</option>';

			if(is_array($key['child'])) {
				$this->padding++;
				$ret .= $this->dropdown_child($key, $selected);
				$this->padding--;
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

	function get_child($data, $list, $on, $off, $id_level)
	{
		$ret = '';
	    foreach($data['child'] as $key)
	    {
	      $no = $key['id_module'];
	      $ret .= '
	        <tr align="center" id="no_'. $key['id_module'] .'">
		        <td></td>
		        <td align="left" style="padding-left:'.($this->padding * 20).'px;"><li> '.$key['nama_module'].'</li></td>
		        <td><i class="'.$key['icon_module'].'"></i></td>
		        <td align="left">'.$key['url_module'].'</td>';

	            foreach ($list as $keys) :
		            $cek_module = $this->cek_module($key['id_module'], $keys->id_aksi); 
		            $link = '<a href="javascript:void(0)" onClick=\'aksi("master/module/toggle_active/'.$cek_module.'/'.$key['id_module'].'/'.$keys->id_aksi.'", "link_'.$key['id_module'].'_'.$keys->id_aksi.'")\'>'.($cek_module == '0' ? $off : $on).'</a>';
		            $ret .= '<td id="link_'.$key['id_module'].'_'.$keys->id_aksi.'">'.$link.'</td>';
		        endforeach;

		       	$ret .= '
		        <td>
		        	'.akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, "edit", 'title="Edit" onclick=\'ajax_modals("Edit Module","null","master/module/edit/'.$key['id_module'].'","width:35%")\'').'&nbsp
            		'.akses_crud('javascript:void(0);', '<i class="material-icons md-18" style="color:#000" title="Hapus">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', ' onclick=\'if(confirm("Hapus data ini ?")) aksi("master/module/hapus/'.$key['id_module'].'", "no_'.$key['id_module'].'")\'').'
		        </td>
	        </tr>
	      ';
		          	//akses_crud(base_url("master/module/edit/".$key['id_module']), img("assets/img/icon/edit.png"), $this->id_level_now, $this->id_module_now, "edit").'&nbsp;

	      if(is_array($key['child'])) {
	        $this->padding++;
	        $ret .= $this->get_child($key, $list, $on, $off, $id_level);
	        $this->padding--;
	      }
	    }

	    return $ret;
	}
	  
	function get_akses($id_module) 
	{
		$level  = $this->id_level_now;
	    $get    = $this->dbm->get_data_where('user_akses',array('id_module'=>$id_module,'id_level'=>$level));
	    
	    return $get;
	}
	  
	function toggle_active($cek, $id_module, $id_aksi)
	{
		if($cek == '0') {

			$insert = $this->dbm->insert('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$id_aksi));
		} else {

			$delete = $this->dbm->delete('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$id_aksi));
		}

	    $on   = img('assets/img/icon/active16.png');
	    $off  = img('assets/img/icon/delete16.png');
	    $cek  = ($cek == '0') ? '1' : '0';
        $link = '<a href="javascript:void(0)" onClick=\'aksi("master/module/toggle_active/'.$cek.'/'.$id_module.'/'.$id_aksi.'", "link_'.$id_module.'_'.$id_aksi.'")\'>'.($cek == '0' ? $off : $on).'</a>';
		
		echo $link;
	}

	function cek_module($id_module, $id_aksi)
	{
		$cek = $this->dbm->get_data_where('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$id_aksi))->num_rows();

		return $cek;
	}
}

?>