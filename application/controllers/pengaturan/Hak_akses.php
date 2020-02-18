<?php if(!defined ('BASEPATH')) exit ('no direct script access allowed');

class Hak_akses extends CI_Controller
{
  public $padding;
  public $id_module_now;
  public $id_level_now;

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->model('dbm');
		$this->load->model('model_user_level');
		$this->load->helper('other');

    $this->padding = 0;

    $this->id_module_now  = $this->db->like('url_module', 'pengaturan/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
    $this->id_level_now   = $this->session->userdata('level');
    $setting = $this->template->mysetting_web();
    $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
    $this->auth->restrict($this->id_module_now);

    define('view', 'pengaturan/hak_akses/');
	}

	function index()
	{
		$data['title']	   = "User Level";
		$data['_list']	   = $this->dbm->get_all_data('user_level',NULL,'id_level','ASC');

		$this->template->display(view."index",$data);
	}

  function tambah()
  {
    $this->auth->restrict($this->id_module_now, 'tambah');
    $data['title']     = "Tambah User Level";

    $this->template->display(view."form",$data);

  }

  function tambah_simpan()
  {
    $this->form_validation->set_rules('level', 'Nama Level', 'required');

    if($this->form_validation->run()) 
      {
      $in = $this->dbm->insert('user_level', array("level"=>$this->input->post('level')));

      echo 'sukses|||||'.$this->index();

      echo "<script>alert('Data berhasil disimpan !');</script>";

      } else 
        {
        echo strip_tags(validation_errors());
        }
  }

  function edit($id)
  {
    $this->auth->restrict($this->id_module_now, 'edit');

    $data['title']  = "Edit User Level";
    $data['dta']    = $this->dbm->get_data_where('user_level', array('id_level'=>$id))->row();

    $this->template->display(view."form",$data);
  }

  function edit_simpan($id)
  {
    $this->form_validation->set_rules('level', 'Nama Level', 'required');

    if($this->form_validation->run()) 
      {

      $in = $this->dbm->update('user_level', array('id_level'=>$id), array("level"=>$this->input->post('level')));

      echo 'sukses|||||'.$this->index();

      } else 
        {
        echo strip_tags(validation_errors());
        }
  }

  function hapus($id)
  {
    $this->auth->restrict($this->id_module_now, 'hapus'); 
    
    $del = $this->dbm->delete('user_level', array('id_level'=>$id));

    redirect(base_url('pengaturan/hak_akses'));
  }
  
  function manage($id_level)
  {
    $data['module']       = strtolower(get_class());
    $data['title']	      =	"Hak Akses";    
    $data['id_level']     = $id_level;
		$data['list_parent']  = $this->model_user_level->get_top();
    $data['list']         = $this->dbm->get_all_data('aksi')->result();
    
		$this->template->display(view."manage",$data);
  }

  function get_child($data, $list, $on, $off, $id_level)
  {
    $max_parent_id = $this->dbm->max_data('id_module', 'module', array('parent'=>'0'))->row('id_module');
    $ret = "";

    foreach($data['child'] as $key)
    {
      $no     = $key['id_module'];
      $crud   = $this->get_akses($key['id_module'], $id_level);

      $parent = $this->dbm->get_data_where('module', array('id_module'=>$key['id_module']))->row('parent');

      if($parent != '0')
        {
        $cek_module   = $this->get_akses($parent, $id_level)->num_rows();
        $aksi_parent  = ($cek_module == '0') ? "aksi('pengaturan/hak_akses/toggle_active/akses/".$parent."/".$id_level."/0', 'akses_".$parent."');" : "";
        }

      $akses   = "<a href='javascript:void(0)' onClick=\"".$aksi_parent."aksi('pengaturan/hak_akses/toggle_active/akses/".$key['id_module']."/".$id_level."/".($crud->num_rows() > "0" ? "1" : "0")."', 'akses_".$key['id_module']."')\">".($crud->num_rows() > "0" ? $on : $off)."</a>";

      $ret .= '
        <tr align="center">
          <td></td>
          <td align="left" style="padding-left:'.($this->padding * 20).'px;"><li> '.$key['nama_module'].'</li></td>
          <td id="wrap_akses_'.$no.'" colspan="' . (count($list) + 1) . '">
           <table border=0 id="akses_'.$key['id_module'].'"><tr align="center">
            <td width="50" style="text-align:center">'.$akses.'</td>';
            foreach ($list as $keys) :
              $link = "<a href='javascript:void(0)' onClick=\"".$aksi_parent."aksi('pengaturan/hak_akses/toggle_active/aksi/".$key['id_module']."/".$id_level."/".($this->cek_module_akses($key['id_module'], $id_level, $keys->id_aksi) > "0" ? "1" : "0")."/".$keys->id_aksi."', 'akses_".$key['id_module']."')\">".($this->cek_module_akses($key['id_module'], $id_level, $keys->id_aksi) > "0" ? $on : $off)."</a>";
              $ret .= '<td width="50" style="text-align:center">'.($this->cek_module($key['id_module'], $keys->id_aksi) == '0' ? '-' : $link).'</td>';
            endforeach;

      $ret .= '
            </tr></table>
          </td>
        </tr>
      ';

      if(is_array($key['child'])) 
        {
        $this->padding++;
        $ret .= $this->get_child($key, $list, $on, $off, $id_level);
        $this->padding--;
        }
    }

    return $ret;
  }
  
  function get_akses($id_module, $level) 
  {
    $get    = $this->dbm->get_data_where('user_akses',array('id_level'=>$level, 'id_module'=>$id_module, 'id_aksi'=>'0'));
    
    return $get;
  }
  
  function toggle_active($mode, $id_module, $id_level, $status=null, $id_aksi=NULL)
  { 
    $on   = img('assets/img/icon/active16.png');
    $off  = img('assets/img/icon/delete16.png');

    $list       = $this->dbm->get_all_data('aksi')->result();
    $get_module = $this->dbm->get_data_where('module_aksi', array('id_module'=>$id_module))->result();

    $parent       = $this->dbm->get_data_where('module', array('id_module'=>$id_module))->row('parent');
    $cek_module   = ($parent != '0') ? $this->get_akses($parent, $id_level)->num_rows() : '-';
    $aksi_parent  = ($cek_module == '0') ? "aksi('pengaturan/hak_akses/toggle_active/akses/".$parent."/".$id_level."/0', 'akses_".$parent."');" : "";

    $status   = ($status == '0') ? '1' : '0' ;
    $html     = ($status == '0' && $mode == 'akses') ? $off : $on ;
    $akses    = "<a href='javascript:void(0)' onClick=\"".$aksi_parent."aksi('pengaturan/hak_akses/toggle_active/akses/".$id_module."/".$id_level."/".$status."', 'akses_".$id_module."')\">".$html."</a>";

    if($mode == "akses") {

      if($status == "0") {
        $delete   = $this->dbm->delete('user_akses', array('id_module'=>$id_module, 'id_level'=>$id_level));
      }        

      elseif($status == "1") {

        $in     = $this->dbm->insert('user_akses', array('id_level'=>$id_level, 'id_module'=>$id_module, 'id_aksi'=>'0'));
        foreach ($get_module as $key) {
          $insert = $this->dbm->insert('user_akses', array('id_level'=>$id_level, 'id_module'=>$id_module, 'id_aksi'=>$key->id_aksi));
        }
      }
      
      echo ' 
        <tr align="center">
          <td width="50" style="text-align:center">'.$akses.'</td>';
          foreach ($list as $keys) :
            $status = ($id_aksi == $keys->id_aksi) ? $status : $this->cek_module_akses($id_module, $id_level, $keys->id_aksi);
            $link = "<a href='javascript:void(0)' onClick=\"".$aksi_parent."aksi('pengaturan/hak_akses/toggle_active/aksi/".$id_module."/".$id_level."/".$status."/".$keys->id_aksi."', 'akses_".$id_module."')\">".($status > "0" ? $on : $off)."</a>";
            echo '<td width="50" style="text-align:center">'.($this->cek_module($id_module, $keys->id_aksi) == '0' ? '-' : $link).'</td>';
          endforeach;
      echo '
        </tr>
      ';

    } elseif($mode == 'aksi') {

      $cek      = $this->dbm->get_data_where('user_akses', array('id_module'=>$id_module, 'id_level'=>$id_level))->num_rows();
      if($cek == '0')
        $insert = $this->dbm->insert('user_akses', array('id_level'=>$id_level, 'id_module'=>$id_module, 'id_aksi'=>'0'));

      if($status == "0")
        $delete   = $this->dbm->delete('user_akses', array('id_module'=>$id_module, 'id_level'=>$id_level, 'id_aksi'=>$id_aksi));

      elseif($status == "1")
        $insert = $this->dbm->insert('user_akses', array('id_level'=>$id_level, 'id_module'=>$id_module, 'id_aksi'=>$id_aksi));
      
     echo ' 
        <tr align="center">
          <td width="50" style="text-align:center">'.$akses.'</td>';
          foreach ($list as $keys) :
            $status = $this->cek_module_akses($id_module, $id_level, $keys->id_aksi);
            $link = "<a href='javascript:void(0)' onClick=\"".$aksi_parent."aksi('pengaturan/hak_akses/toggle_active/aksi/".$id_module."/".$id_level."/".$status."/".$keys->id_aksi."', 'akses_".$id_module."')\">".($status > "0" ? $on : $off)."</a>";
            echo '<td width="50" style="text-align:center">'.($this->cek_module($id_module, $keys->id_aksi) == '0' ? '-' : $link).'</td>';
          endforeach;

      echo '
        </tr>
      ';
    } 

  }

  function cek_module($id_module, $id_aksi)
  {
    $cek = $this->dbm->get_data_where('module_aksi', array('id_module'=>$id_module, 'id_aksi'=>$id_aksi))->num_rows();

    return $cek;
  }

  function cek_module_akses($id_module, $id_level, $id_aksi)
  {
    $cek      = $this->dbm->get_data_where('user_akses', array('id_level'=>$id_level, 'id_module'=>$id_module, 'id_aksi'=>$id_aksi))->num_rows();

    return $cek;
  }

}

?>