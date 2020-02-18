<?php if(!defined('BASEPATH')) exit('No direct access script allowed');

class Auth
{
	var $ci = NULL;
	function __construct()
	{
		$this->ci = &get_instance();
	}

	// untuk validasi login
	function do_login($username,$password)
	{
		$this->ci->db->where('status','1');
		$this->ci->db->where('username',$username);
		$this->ci->db->where('password',md5($password));

		$result = $this->ci->db->get('user');

		if($result->num_rows() == 0)
			{
			return FALSE;
			} else
				{
				$userdata = $result->row();
				$session_data = array
					(
					"user_id"	=> $userdata->id_user,
					"username"	=> $userdata->username,
					"password"	=> $userdata->password,
					"nama_user"	=> $userdata->nama_user,
					"telp"		=> $userdata->telp,
					"email"		=> $userdata->email,
					"level"		=> $userdata->id_level
					);
				// buat session
				$this->ci->session->set_userdata($session_data);

				$_SESSION['KCFINDER'] = array( 'disabled' => false );

				//online_log admin login
				$ip 		= getip();
		        $ua         = $this->getBrowser();
		        $browser    = $ua['name'].' '.$ua['version'];
		        $platform   = $ua['platform'];

		        $cek = $this->ci->db->where(array('id_user'=>$userdata->id_user,'ip'=>$ip,'browser'=>$browser,'platform'=>$platform))->get('online_log')->row();

		        if (empty($cek))
		        	{
		        	$this->ci->db->insert('online_log', array('id_user'=>$userdata->id_user,"nama"=>$userdata->nama_user,'ip'=>$ip,'browser'=>$browser,'platform'=>$platform));
		        	}
		        	else
		        		{
		        		$this->ci->db->where('id_online',$cek->id_online)->update('online_log', array('id_user'=>$userdata->id_user,"nama"=>$userdata->nama_user,'ip'=>$ip,'browser'=>$browser,'platform'=>$platform));
		        		}

				return TRUE;
				}
	}

	// cek apakah user login apa belum
	function is_logged_in()
	{
		if($this->ci->session->userdata('user_id') == '')
			{
			return FALSE;
			}

		return TRUE;
	}

	function izin($id_module, $teh)
	{
		$level = $this->ci->session->userdata('level');

		//cek di tabel user akses
		$cek = $this->ci->db 	->where('id_level',$level)
								->where('id_module',$id_module)
								->get('user_akses');

		if($teh == null)
		{

			return ($cek->num_rows() == '0') ? FALSE : TRUE ;

		} else
			{

			return ($cek->row($teh) == '0') ? FALSE : TRUE ;

			}
	}

	// validasi di setiap halaman yang mengharuskan autentikasi
	// teh = Tambah Edit Hapus
	function restrict($id_module='0', $teh=null)
	{
		if($this->is_logged_in() === FALSE) {

			redirect(base_url());

		} else if($id_module != 0 && $this->izin($id_module, $teh) === FALSE) {

			redirect(base_url('admin/access_forbidden'));

			die();

		}
	}

    function getBrowser()
    {
        $u_agent    = $_SERVER['HTTP_USER_AGENT'];
        $bname      = 'Unknown';
        $platform   = 'Unknown';
        $Version    = "";

        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub    = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub    = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub    = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub    = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub    = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub    = "Netscape";
        } else {
            $bname = 'Other';
            $ub    = "Other";
            }

        $known   = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) { }

        $i = count($matches['browser']);

        if ($i != 1) {

            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version = $matches['version'][0];
            }
            else {
                $version = $matches['version'][1];
            }
        }
        else {
            $version = $matches['version'][0];
        }

        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'   => $pattern
        );
    }

}
