<?php
function getip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
      else
				{
				$ip = $_SERVER['REMOTE_ADDR'];
				}

	return $ip;
}

function dirdel($dir)
{
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? dirdel("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}

function id_to_name($table,$field,$id,$output_name)
{
  $db    = (array)get_instance()->db;
  $con   = mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);
	$db    = mysqli_query($con,"SELECT ".$output_name." FROM ".$table." WHERE ".$field."='".$id."' LIMIT 1");

	while($dbs=mysqli_fetch_array($db))
		{
		return $dbs[''.$output_name.''];
		}
}

function akses_crud($url, $text, $level, $id_module, $tipe, $attr=NULL)
{
  $db     = (array)get_instance()->db;
  $con    = mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);
  $tipe   = strtolower($tipe);
  $anchor = "<a href='".$url."'  ".$attr.">".$text."</a>";
  $cek    = mysqli_query($con,"SELECT * FROM aksi WHERE aksi='".strtolower($tipe)."' LIMIT 1");

  $key    = mysqli_fetch_array($cek);

  $db     = mysqli_query($con,"SELECT * FROM user_akses WHERE id_level='".$level."' && id_module='".$id_module."' && id_aksi='".$key['id_aksi']."' ");

  $izin   = mysqli_num_rows($db);

  return ($izin == "1") ? $anchor : "";
}

function akses_modul($content, $level, $id_module)
{
  $db     = mysql_query("SELECT * FROM user_akses WHERE id_level='".$level."' && id_module='".$id_module."' LIMIT 1");

  $izin   = mysql_num_rows($db);

  return ($izin == "1") ? $content : "";
}

// jika tidak mempunyai izin content di sembunyikan
function akses_form($content, $level, $id_module, $tipe)
{
  $tipe   = strtolower($tipe);
  $cek    = mysql_query("SELECT * FROM aksi WHERE aksi='".strtolower($tipe)."' LIMIT 1");
  $key    = mysql_fetch_array($cek);

  $db     = mysql_query("SELECT * FROM user_akses WHERE id_level='".$level."' && id_module='".$id_module."' && id_aksi='".$key['id_aksi']."' ");

  $izin   = mysql_num_rows($db);

  return ($izin == "1") ? $content : "";
}

// jika tidak mempunyai izin content di tampilkan
function akses_form_reverse($content, $level, $id_module, $tipe)
{
  $tipe   = strtolower($tipe);
  $cek    = mysql_query("SELECT * FROM aksi WHERE aksi='".strtolower($tipe)."' LIMIT 1");
  $key    = mysql_fetch_array($cek);

  $db     = mysql_query("SELECT * FROM user_akses WHERE id_level='".$level."' && id_module='".$id_module."' && id_aksi='".$key['id_aksi']."' ");

  $izin   = mysql_num_rows($db);

  return ($izin == "1") ? $content : "";
}

// function cek mempunyai izin atau tidak
function hak_akses($level, $id_module, $tipe)
{
  $tipe   = strtolower($tipe);
  $cek    = mysql_query("SELECT * FROM aksi WHERE aksi='".strtolower($tipe)."' LIMIT 1");
  $key    = mysql_fetch_array($cek);

  $db     = mysql_query("SELECT * FROM user_akses WHERE id_level='".$level."' && id_module='".$id_module."' && id_aksi='".$key['id_aksi']."' ");

  $izin   = mysql_num_rows($db);

  return ($izin == "1") ? TRUE : FALSE;
}

function currency($data)
{
  $currency = 'Rp '.number_format($data,2,",",".");

  return $currency;
}

function kop_laporan()
{
  $cek       = mysql_query("SELECT * FROM cabang LIMIT 1");
  $data      = mysql_fetch_array($cek);
  $kop_surat =
  '
    <style>
      div.hr hr{
        padding-top:0px;
        margin-top:-2px;
        border:1px solid #666;
        margin-bottom:1px;
      }
    </style>

    <div align="center">
      <table border="0" width="100%">
          <tr>
            <td rowspan="4" valign="middle" width="50">'.img('assets/img/logo_sma.png').'</td>
            <td height="25" style="font-family:times new roman; font-size:14px; font-weight:bold; margin-bottom:5px; padding:0px;">
              '.$data['nama_cabang'].'
            </td>
          </tr>
          <tr>
            <td style="font-family:times new roman; font-size:12px; border-bottom:dashed 1px; border-color:#ccc; padding:0px;">
              Alamat : '.$data['alamat_cabang'].'
            </td>
          </tr>
          <tr>
            <td style="font-family:times new roman; font-size:12px; border-bottom:dashed 1px; border-color:#ccc; padding:0px;">
              Telpon : '.$data['telp_cabang'].', Fax : '.$data['fax_cabang'].'
            </td>
          </tr>
          <tr>
            <td style="font-family:times new roman; font-size:12px; border-bottom:dashed 1px; border-color:#ccc; padding:0px;">
              Email : '.$data['email_cabang'].'
            </td>
          </tr>
      </table>
    </div>
  ';

  return $kop_surat;
}

function aasort (&$array, $key, $order='asc') {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }

    if($order == 'asc')
      asort($sorter);
    elseif($order == 'desc')
      arsort($sorter);

    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;

    return $array;
}

// get class
function ambil_class($filename = '', $folder = '', $app_folder = 'controllers')
{
    $path = './application/'. $app_folder .'/'. ($folder == '' ? '' : $folder .'/') . strtolower($filename) .'.php';

    if ( ! file_exists($path))
        die('File '. $filename .'.php tidak ditemukan, coba cek penulisannya dan filenya');

    require_once($path);

    $obj = new $filename(false);

    return $obj;
}
?>
