<?php if(!defined('BASEPATH')) exit("No direct access script allowed");

class User extends CI_Controller
{
	private $edit_profil = array (
        array (
          'field'   => 'nama',
          'label'   => 'Nama Lengkap',
          'rules'   => 'required'
        ),
        array (
          'field'   => 'username',
          'label'   => 'Username',
          'rules'   => 'required'
        )
    );

    private $password_rules = array(
        array(
            'field' => 'old_password',
            'label' => 'Katasandi lama',
            'rules' => 'required|callback_check_password'
        ),
        array(
            'field' => 'password',
            'label' => 'Katasandi Baru',
            'rules' => 'required|min_length[5]'
        ),
        array(
            'field' => 'repeat_password',
            'label' => 'Konfirmasi katasandi',
            'rules' => 'required|matches[password]'
        )
    );

    private $id_user;
	public $id_level_now;

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->model('dbm');
		$this->load->helper('captcha');
		$setting = $this->template->mysetting_web();
		$this->setting = $setting;
    $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
		$this->id_level_now   = $this->session->userdata('level');
		$this->id_user = $this->session->userdata('user_id');
	}

	function index()
	{
		redirect(base_url('user/login'));
	}

	function login()
	{
		$tmp = explode('/', $_SERVER['REQUEST_URI']);
		$end = end($tmp);
		$ses = empty($this->session->userdata($this->setting->admin_link)) ? false : $this->session->userdata($this->setting->admin_link);

		if (($end != $this->setting->admin_link) && (empty($_POST)) && ($ses===false))
			{
			$this->session->sess_destroy();
			redirect(base_url());
			}
			else
				{
				$this->session->set_userdata($this->setting->admin_link, true);
				}

		if($this->auth->is_logged_in() === TRUE )
			redirect(base_url()."admin");

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('kode_captcha', 'Kode Captcha', 'required');

		if($this->form_validation->run() == FALSE)
			{
			$cap 			 = $this->buat_captcha();
			$data['cap_img'] = $cap['image'];
			$this->session->set_userdata('kode_captcha', $cap['word']);

			$this->load->view('auth/form_login', $data);
			}
			else
				{
				$cek_capt 	= $this->cek_captcha($this->input->post('kode_captcha'));

				if($cek_capt == FALSE)
					{
					echo '<script>alert("'.$this->lang->line('captcha_salah').'!");location.href="'.base_url($this->setting->admin_link).'"</script>';

					}
					else
						{
						$cek_login  = $this->auth->do_login($username,$password);

						if($cek_login == FALSE)
							{
							echo '<script>alert("'.$this->lang->line('wrong_login').'");location.href="'.base_url($this->setting->admin_link).'"</script>';
							}
							else
								{
								$this->session->unset_userdata('kode_captcha');

								redirect(base_url().'admin');
								}
						}
				}
	}

	function logout()
	{
		$lastlogin = $this->dbm->update('user', array('id_user'=>$this->id_user), array('lastlogin'=>date("Y-m-d H:i:s")));

		$onlinelog = $this->dbm->delete('online_log', array('id_user'=>$this->id_user));

		$unset = $this->session->unset_userdata(array(
				"user_id",
				"username",
				"password",
				"level")
		);

		$is_admin = $this->session->userdata($this->setting->admin_link);

		$this->session->sess_destroy();

		// $this->login();

		if ($is_admin)
			redirect(base_url($this->setting->admin_link));
		else
			redirect(base_url());
	}

	function forgot()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required');
		$this->form_validation->set_rules('telp', 'Telp', 'required');

		if($this->form_validation->run() == FALSE)
			{
			$this->load->view('auth/form_forgot');
			} else
				{
				$cek = $this->dbm->get_data_where('user', array('username'=>$_POST['username'], 'email'=>$_POST['email'], 'telp'=>$_POST['telp']))->row();

				if ($cek==TRUE)
					{
					$data['info'] = $cek;

					$this->load->view('auth/form_newpassword', $data);

					} else
						{
						echo "<script>alert('Maaf data yang anda tidak sesuai'); window.location = '".base_url('user/forgot')."'</script>";
						}

				}
	}

	function check_password($old_password)
    {
        $old_password = md5($old_password);

        $dta = $this->dbm->get_data_where('user', array('id_user'=>$this->id_user))->row('password');

        if ($dta != $old_password)
        	{
            $this->form_validation->set_message('check_password', '%s tidak sesuai.');
            return false;
        	}
        return true;
    }

	function new_password()
	{
		$up = $this->dbm->update('user', array('id_user'=>$_POST['id_user']), array('password'=>md5($_POST['new_password'])));

		if ($up) {echo "sukses";}
	}

	function buat_captcha()
	{
		$vals = array(
            'word'      => 'h',
					  'img_path'  =>'./captcha/',
					  'img_url'   =>base_url().'captcha/',
					  'font_path' =>'./font/timesbd.ttf',
					  'img_width' =>'200',
					  'img_height'=>'40',
					  'expiration'=>'80'
					  );

		$cap = create_captcha($vals);

		return $cap;
	}

	function cek_captcha($input)
	{
		return ($input === $this->session->userdata('kode_captcha')) ? TRUE : FALSE;
	}
}
