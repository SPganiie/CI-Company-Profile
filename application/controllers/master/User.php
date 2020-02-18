<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public $id_module_now;
    public $id_level_now;

    private $tambah_rules = array(
        array(
          'field'   => 'nama_user',
          'label'   => 'Nama Lengkap',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'username',
          'label'   => 'Username',
          'rules'   => 'required|is_unique[user.username]'
        ),
        array(
          'field'   => 'password',
          'label'   => 'Password',
          'rules'   => 'required|min_length[5]'
        ),
        array(
          'field'   => 'password_konfirmasi',
          'label'   => 'Password Konfirmasi',
          'rules'   => 'required|matches[password]'
        ),
        array(
          'field'   => 'email',
          'label'   => 'Email',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'telp',
          'label'   => 'No. Telp',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'level',
          'label'   => 'Level',
          'rules'   => 'required'
        )
    );

    private $edit_rules = array(
        array(
          'field'   => 'nama_user',
          'label'   => 'Nama Lengkap',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'email',
          'label'   => 'Email',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'telp',
          'label'   => 'No. Telp',
          'rules'   => 'required'
        ),
        array(
          'field'   => 'level',
          'label'   => 'Level',
          'rules'   => 'required'
        )
    );

	function __construct() 
	{
        parent::__construct();
        define('view', 'master/user/');
        $this->load->model('dbm');        
        $this->id_module_now  = $this->db->like('url_module', 'master/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');
        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        $this->auth->restrict($this->id_module_now);
    }
    
    function index($page = '1')
    {
        $data['level']  = $this->session->userdata('level');

        $data['list']   = $this->mypaging->config('user', $page, '10');

        $this->template->display(view.'index', $data);
    }

    function tambah()
    {
        $this->auth->restrict($this->id_module_now, 'tambah');

        $data['_dropdown_level']    = $this->dbm->dropdown('user_level', '- Pilih level', 'id_level', 'level',array('is_admin'=>'0'));

        $this->template->display(view.'form', $data);
    }

    function tambah_simpan()
    {
      if(!empty($_POST))
        {
        $cek  = $this->dbm->get_data_where('user', array('username'=>$_POST['nama_user']))->row();

        if(!empty($cek->username))
            {
            die('<i style="color:red">Username <b style="color:black">'.$username.'</b> sudah pernah dipakai, gunakan yang lain</i>');
            }

        if($_POST['password_konfirmasi'] != $_POST['password'])
            {
            die('<script type="text/javascript">alert("Password konfirmasi anda tidak sesuai")</script>');
            }

        $this->form_validation->set_rules($this->tambah_rules);

        if($this->form_validation->run()) 
            {

            $id_user = $this->dbm->highest_id_plus_one('id_user', 'user');

            $value    = array(
                'id_user'       => $id_user,
                'username'      => $_POST['username'],
                'password'      => md5($_POST['password']),
                'nama_user'     => $_POST['nama_user'],
                'telp'          => $_POST['telp'],
                'email'         => $_POST['email'],
                'id_level'      => $_POST['level'],
                'status'        => $_POST['status']
                );

            $in     = $this->dbm->insert('user', $value );

            $this->session->set_flashdata('msg', 'Berhasil Menambah User');

            if ($in) 
                echo "ok";

            } else 
                {
                echo strip_tags(validation_errors());
                }
        }
    }

    function edit($id_user)
    {
        $this->auth->restrict($this->id_module_now, 'edit');

        $data['title']              = "Edit User";
        $data['dta']                = $this->dbm->get_data_where('user', array('id_user'=>$id_user))->row();
        $username                   = $data['dta']->username;

        $data['_dropdown_level']    = $this->dbm->dropdown('user_level', '- Pilih level', 'id_level', 'level');
        
        $this->template->display(view.'form',$data);
    }

    function edit_simpan($id_user)
    {
        if(!empty($_POST))
            {

            $this->form_validation->set_rules($this->edit_rules);

            if($this->form_validation->run()) 
                {

                $data = array(
                    'nama_user'     => $_POST['nama_user'],
                    'telp'          => $_POST['telp'],
                    'email'         => $_POST['email'],
                    'id_level'      => $_POST['level'],
                    'status'        => $_POST['status']
                  );

                if (!empty($_POST['password']))
                  {
                  if (empty($_POST['password_konfirmasi']))
                    {
                    die('konfirmasi password harus diisi');
                    } else
                      {
                      if ($_POST['password'] != $_POST['password_konfirmasi']) 
                        {
                        die('konfirmasi password tidak sesuai');
                        }
                        else
                          {                  
                          $data = array_merge($data, array('password' => md5($_POST['password'])));
                          }
                      }
                  }

                $up = $this->dbm->update('user', array('id_user' => $id_user), $data);

                if ($up) 
                    echo "ok";
                } 
                else 
                    {
                    echo strip_tags(validation_errors());
                    }
            }
    }

    function hapus($id_user)
    {
      $this->auth->restrict($this->id_module_now, 'hapus'); 
        
      $del = $this->dbm->delete('user', array('id_user'=>$id_user));

      die();
    }

    function profilku($id)
    { 
      if(!empty($_POST['data']))
        {
        $this->form_validation->set_rules('nama_user', 'Nama', 'required');
        $this->form_validation->set_rules('telp', 'Telp', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if($this->form_validation->run()) 
          {
          unset($_POST['data']);

          $up = $this->dbm->update('user', array('id_user' => $id), $_POST);

          if ($up) 
              echo "ok";
          }
          else 
              {
              echo strip_tags(validation_errors());
              }
        }
        else
          {
          $data['dta'] = $this->dbm->get_data_where('user', array('id_user'=>$id))->row();
          $username    = $data['dta']->username;
          
          $this->load->view(view.'form_profil',$data);
          }
    }

    function passwordku($id)
    {
      
      if(!empty($_POST['data']))
        {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password_konfirmasi', 'Konfirmasi Password', 'required');

        if($this->form_validation->run()) 
          {
          unset($_POST['data']);

          if (empty($_POST['password_konfirmasi']))
            {
            die('konfirmasi password harus diisi');
            } 
            else
              {
              if ($_POST['password'] != $_POST['password_konfirmasi']) 
                {
                die('konfirmasi password tidak sesuai');
                }
                else
                  {
                  $data = array('password' => md5($_POST['password']));
                  }
              }

          $up = $this->dbm->update('user', array('id_user' => $id), $data);

          if ($up) 
              echo "ok";
          }
          else 
              {
              echo strip_tags(validation_errors());
              }
        }
        else
          {
          $data['dta'] = $this->dbm->get_data_where('user', array('id_user'=>$id))->row();
          $username    = $data['dta']->username;
          
          $this->load->view(view.'form_password',$data);
          }
    }
}
