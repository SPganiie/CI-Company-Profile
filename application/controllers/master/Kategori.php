<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    public $padding;

    function __construct() 
    {
        parent::__construct();
        define('view', 'master/kategori/');
        $this->padding = 0;
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->ext = $setting->ext;
        $this->post_page = $setting->page_news;
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }
    
    function post($page = '1')
    {        
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(nama_kategori_post LIKE "%'. $data['src'] .'%")');

        $data['list_parent'] = $this->get_parent_post();

        $this->template->display(view.'index_post', $data);
    }

    function get_list_post($bhs, $id) 
    {
        return  $this->dbm->get_data_where('kategori_post_list', array('id_bahasa'=>$bhs,'id_kategori'=>$id))->row();
    }

    function tambah_post()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $this->template->display(view.'form_post', $data);
    }

    function edit_post($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['dta']  = $this->dbm->get_data_where('kategori_post', array('id_kategori_post'=>$id))->row();

        $this->template->display(view.'form_post', $data);
    }

    function simpan_post()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_kategori']!='') ? $_POST['id_kategori'] : null;
            $nama   = strtolower(str_replace(' ', '-', $_POST['nama_kategori']));
            $nama   = preg_replace('~[\\\\/:*?"<>()&|]~', '', $nama);
            
            $id_bhs = $_POST['id_bhs'];
            $parent = $_POST['parent'];

            if ($id==null)
                {
                $db     = $this->dbm->insert('kategori_post', array("nama_kategori_post"=>$nama, 'parent'=>$parent));
                
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $nama_list    = $_POST['nama_kategori_list'][$key];

                    $value_list   = array
                                    (
                                    'id_bahasa'          => $id_bhs_list,
                                    'id_kategori'        => $new_id,
                                    'nama_kategori_list' => $nama_list
                                    );

                    $db_list     = $this->dbm->insert('kategori_post_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $db = $this->dbm->update('kategori_post', array('id_kategori_post'=>$id), array("nama_kategori_post"=>$nama, 'parent'=>$parent));

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $nama_list    = $_POST['nama_kategori_list'][$key];

                        $db_list     = $this->dbm->update('kategori_post_list', array('id_kategori'=>$id,'id_bahasa'=>$id_bhs_list), array('nama_kategori_list'=>$nama_list));
                        }
                    }

            if ($db)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function hapus_post($id)
    {
        $this->auth->restrict($this->id_module_now, 'hapus'); 

        $del = $this->dbm->delete('kategori_post', array('id_kategori_post'=>$id));

        $del = $this->dbm->delete('kategori_post_list', array('id_kategori'=>$id));

        redirect(base_url('master/kategori/post'));
    }

    function get_parent_post() 
    {
        $list= array();
        $top = $this->db->where('parent','0')->get('kategori_post')->result();

        foreach($top as $row) 
            {
            $list[] = array
                (
                'id_kategori'   => $row->id_kategori_post,
                'nama_kategori' => $row->nama_kategori_post,
                'parent'        => $row->parent,
                'child'         => $this->get_child_post($row->id_kategori_post)
                );
            }

        return $list;
    }

    function get_child_post($id)
    {    
        $sql = $this->db->where('parent', $id)->get('kategori_post');
        $ret = array();
        
        foreach($sql->result() as $row)
            {
            $ret[] = array 
                (
                'id_kategori'   => $row->id_kategori_post,
                'nama_kategori' => $row->nama_kategori_post,
                'parent'        => $row->parent,
                'child'         => $this->get_child_post($row->id_kategori_post)
                );
            }
        
        return (empty($ret)) ? "NULL" : $ret ;
    }

    function dropdown_parent_post($selected=null)
    {
        $ret = '';
        $top = $this->get_parent_post();

        $ret .= '<select name="parent" class="form-control show-tick"><option value="0">-</option>';

        foreach($top as $key) 
            {
            $ret .= '<option value="'.$key['id_kategori'].'" '.($key['id_kategori'] == $selected ? 'SELECTED' : '').'>'.$key['nama_kategori'].'</option>';

            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->dropdown_child_post($key, $selected);
                $this->padding--;
                }
            }

        $ret .= '</select>';

        return $ret;
    }

    function dropdown_child_post($data, $selected) 
    {
        $ret = '';

        foreach ($data['child'] as $key)
            {
            $ret .= '<option value="'.$key['id_kategori'].'" '.($key['id_kategori'] == $selected ? 'SELECTED' : '').'>'.str_repeat('---', $this->padding).' '.$key['nama_kategori'].'</option>';

            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->dropdown_child_post($key, $selected);
                $this->padding--;
                }
            }

        return $ret;
    }

    function show_child_post($data)
    {
        $ret = '';

        foreach($data['child'] as $key)
            {

            $ret .= '
                    <tr align="center" id="no_'. $key['id_kategori'] .'">
                        <td></td>
                        <td align="left" style="padding-left:'.($this->padding * 20).'px;"><li><a href="'.base_url().$this->post_page.'/detail_kategori/'.$key['nama_kategori'].'.'.$this->ext.'" target="_blank"> '.str_replace('-', ' ', ucwords($key['nama_kategori'])).'</a></li></td>';

                        $ret .= '
                        <td>
                            '.akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit Kategori","null","master/kategori/edit_post/'.$key['id_kategori'].'")\'' ).'&nbsp
                            '.akses_crud(base_url('master/kategori/hapus_post/'.$key['id_kategori']), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$this->lang->line("yakin").'?")\'').'
                        </td>
                    </tr>
                  ';
            
            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->show_child_post($key);
                $this->padding--;
                }            
            }

        return $ret;
    }

    function galery($page = '1')
    {        
        $data['src'] = empty($_GET['src']) ? NULL : $_GET['src'];
        
        if ($data['src']!='')
            $this->db->where('(nama_kategori_galery LIKE "%'. $data['src'] .'%")');

        $data['list_parent'] = $this->get_parent_galery();

        $this->template->display(view.'index_galery', $data);
    }

    function get_list_galery($bhs, $id) 
    {
        return  $this->dbm->get_data_where('kategori_galery_list', array('id_bahasa'=>$bhs,'id_kategori'=>$id))->row();
    }

    function tambah_galery()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $this->template->display(view.'form_galery', $data);
    }

    function edit_galery($id)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['bhs']  = $this->dbm->get_data_where('bahasa', array('aktif'=>'1'))->result();

        $data['dta']  = $this->dbm->get_data_where('kategori_galery', array('id_kategori_galery'=>$id))->row();

        $this->template->display(view.'form_galery', $data);
    }

    function simpan_galery()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required');

        if($this->form_validation->run()) 
            {
            $id     = ($_POST['id_kategori']!='') ? $_POST['id_kategori'] : null;
            
            $nama   = strtolower(str_replace(' ', '-', $_POST['nama_kategori']));
            $nama   = preg_replace('~[\\\\/:*?"<>()&|]~', '', $nama);

            $id_bhs = $_POST['id_bhs'];
            $parent = $_POST['parent'];

            if ($id==null)
                {
                $db     = $this->dbm->insert('kategori_galery', array("nama_kategori_galery"=>$nama, 'parent'=>$parent));
                
                $new_id = $this->db->insert_id();

                foreach ($id_bhs as $key => $val) 
                    {
                    $id_bhs_list  = $_POST['id_bhs'][$key];
                    $nama_list    = $_POST['nama_kategori_list'][$key];

                    $value_list   = array
                                    (
                                    'id_bahasa'          => $id_bhs_list,
                                    'id_kategori'        => $new_id,
                                    'nama_kategori_list' => $nama_list
                                    );

                    $db_list     = $this->dbm->insert('kategori_galery_list', $value_list);
                    }

                } elseif ($id!=null)
                    {
                    $db = $this->dbm->update('kategori_galery', array('id_kategori_galery'=>$id), array("nama_kategori_galery"=>$nama, 'parent'=>$parent));

                    foreach ($id_bhs as $key => $val) 
                        {
                        $id_bhs_list  = $_POST['id_bhs'][$key];
                        $nama_list    = $_POST['nama_kategori_list'][$key];

                        $db_list     = $this->dbm->update('kategori_galery_list', array('id_kategori'=>$id,'id_bahasa'=>$id_bhs_list), array('nama_kategori_list'=>$nama_list));
                        }
                    }

            if ($db)
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
    }

    function hapus_galery($id)
    {
        $this->auth->restrict($this->id_module_now, 'hapus'); 

        $del = $this->dbm->delete('kategori_galery', array('id_kategori_galery'=>$id));

        $del = $this->dbm->delete('kategori_galery_list', array('id_kategori'=>$id));

        redirect(base_url('master/kategori/galery'));
    }

    function get_parent_galery() 
    {
        $list= array();
        $top = $this->db->where('parent','0')->get('kategori_galery')->result();

        foreach($top as $row) 
            {
            $list[] = array
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'parent'        => $row->parent,
                'child'         => $this->get_child_galery($row->id_kategori_galery)
                );
            }

        return $list;
    }

    function get_child_galery($id)
    {    
        $sql = $this->db->where('parent', $id)->get('kategori_galery');
        $ret = array();
        
        foreach($sql->result() as $row)
            {
            $ret[] = array 
                (
                'id_kategori'   => $row->id_kategori_galery,
                'nama_kategori' => $row->nama_kategori_galery,
                'parent'        => $row->parent,
                'child'         => $this->get_child_galery($row->id_kategori_galery)
                );
            }
        
        return (empty($ret)) ? "NULL" : $ret ;
    }

    function dropdown_parent_galery($selected=null)
    {
        $ret = '';
        $top = $this->get_parent_galery();

        $ret .= '<select name="parent" class="form-control show-tick"><option value="0">-</option>';

        foreach($top as $key) 
            {
            $ret .= '<option value="'.$key['id_kategori'].'" '.($key['id_kategori'] == $selected ? 'SELECTED' : '').'>'.$key['nama_kategori'].'</option>';

            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->dropdown_child_galery($key, $selected);
                $this->padding--;
                }
            }

        $ret .= '</select>';

        return $ret;
    }

    function dropdown_child_galery($data, $selected) 
    {
        $ret = '';

        foreach ($data['child'] as $key)
            {
            $ret .= '<option value="'.$key['id_kategori'].'" '.($key['id_kategori'] == $selected ? 'SELECTED' : '').'>'.str_repeat('---', $this->padding).' '.$key['nama_kategori'].'</option>';

            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->dropdown_child_galery($key, $selected);
                $this->padding--;
                }
            }

        return $ret;
    }

    function show_child_galery($data)
    {
        $ret = '';

        foreach($data['child'] as $key)
            {

            $ret .= '
                    <tr align="center" id="no_'. $key['id_kategori'] .'">
                        <td></td>
                        <td align="left" style="padding-left:'.($this->padding * 20).'px;"><li><a href="'.base_url().'category-gallery/'.$key['nama_kategori'].'.'.$this->ext.'" target="_blank"> '.str_replace('-', ' ', ucwords($key['nama_kategori'])).'</a></li></td>';

                        $ret .= '
                        <td>
                            '.akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit Kategori","null","master/kategori/edit_galery/'.$key['id_kategori'].'")\'' ).'&nbsp
                            '.akses_crud(base_url('master/kategori/hapus_galery/'.$key['id_kategori']), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$this->lang->line("yakin").'?")\'').'
                        </td>
                    </tr>
                  ';
            
            if(is_array($key['child'])) 
                {
                $this->padding++;
                $ret .= $this->show_child_galery($key);
                $this->padding--;
                }            
            }

        return $ret;
    }
}
