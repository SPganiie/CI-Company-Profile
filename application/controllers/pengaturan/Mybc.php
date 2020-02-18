<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mybc extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
        define('view', 'pengaturan/mybc/');
        $this->load->model('dbm');
        $this->id_module_now  = $this->db->like('url_module', 'pengaturan/'.strtolower(get_class()), 'both')->get('module')->row('id_module');
        $this->id_level_now   = $this->session->userdata('level');

        $setting = $this->template->mysetting_web();
        $this->lang->load($setting->bahasa_admin.'_lang', 'admin');
        // $this->auth->restrict($this->id_module_now);
    }
    
    function index()
    {
        $this->load->view(view.'index');
    }

    function backup_db()
    {
        $this->load->dbutil();

        $now = date("d-m-Y[H.i.s]");

        $prefs = array(     
                'format'      => 'zip',
                'add_drop'    => TRUE, 
                'add_insert'  => TRUE,
                'newline'     => "\n",
                'filename'    => 'db_backup_'.$now.'.sql'
              );

        $backup =& $this->dbutil->backup($prefs); 

        $db_name = 'db_backup_'. $now .'.zip';
        $save = 'upload/database/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 

        $this->load->helper('download');
        if (force_download($db_name, $backup)) unlink($save);
    }

    function restore_db()
    {
        if ($_FILES['file']['name']!='')
            {
            $filename = $_FILES["file"]["name"];
            $source   = $_FILES["file"]["tmp_name"];
            $type     = $_FILES["file"]["type"];

            $last3 = strrev($filename); 
            $last3 = $last3{2}.$last3{1}.$last3{0};
            
            $last2 = strrev($filename); 
            $last2 = $last2{1}.$last2{0};

            $cek3 = strpos($last3, '.');
        
            if ($cek3===false)
                {
                if (($last3!='sql')&&($last3!='zip'))
                    die("file harus berxtensi sql, zip atau gz, silahkan gunakan file hasil backup database program");
                else
                    $last = $last3;
                }
                else
                    {
                    if ($last2!='gz')
                        die("file harus berxtensi sql, zip atau gz, silahkan gunakan file hasil backup database program");
                    else
                        $last = $last2;
                    }

            $dir = "upload/thumbs/mydb/";
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $location = $dir.$filename;
            if(file_exists($location)) @unlink($location);
        
            if(move_uploaded_file($source, $location)) 
                {
                $file_bc = '';

                if (($last=='zip')||($last=='gz')) 
                    {
                    //export zip file
                    if ($last=='zip')
                        {
                        $zip = new ZipArchive();
                        $x = $zip->open($location);
                        if ($x === true) 
                            {
                            $zip->extractTo($dir);
                            $zip->close();
                    
                            unlink($location);
                            }
                        }

                    //export gz file
                    if ($last=='gz')
                        {
                        $file_name = $location;
                        $buffer_size = 4096;
                        $out_file_name = str_replace('.gz', '', $file_name);
                        $file = gzopen($file_name, 'rb');
                        $out_file = fopen($out_file_name, 'wb'); 
                        while(!gzeof($file)) 
                            {
                            fwrite($out_file, gzread($file, $buffer_size));
                            }  
                        fclose($out_file);
                        gzclose($file);
                        unlink($location);
                        }
                
                    // $sql = str_replace('zip', 'sql', $location);
                    // $sql = str_replace('gz', 'sql', $location);
                    // $sql = str_replace('.sql.sql', '.sql', $sql);

                    //validasi isi file yg sudah diextract
                    $o_dir = opendir($dir);
                    while($isi_dir=readdir($o_dir))
                        {
                        if($isi_dir!="." && $isi_dir!="..") 
                            {
                            if (!is_dir($isi_dir)) 
                                {
                                $info = pathinfo($dir.$isi_dir);
                                $exten= $info['extension'];
                                $name = $info['filename'];

                                if($exten=="sql") 
                                    {
                                    $file_bc = $dir.$name.'.'.$exten;
                                    }
                                    else
                                        {
                                        dirdel($dir);
                                        die('file yang anda upload bukan file backup database');
                                        }
                                }
                                else
                                    {
                                    dirdel($dir);
                                    die('file yang anda upload bukan file backup database');
                                    }
                            }
                        }
                    }
                    else
                        {
                        $file_bc = $location;
                        }

                if($file_bc == '') die('terjadi kesalahan saat file akan di restore');

                //restore dengan CI /*masih error ketika import query dijalankan*/
                /*
                    $isi = file_get_contents($sql);
                    $string_query = rtrim($isi, "\n");
                    $array_query = explode(";", $string_query);
                    foreach($array_query as $query)
                        {
                        if (!$this->db->query($query)) 
                            {
                            echo "gagal di query : ".$query; die();
                            }
                            else
                                continue;
                        }
                */

                //restore dengan php native
                if (!$this->import_native($file_bc))
                    die('gagal import');

                unlink($file_bc);

                }
                else
                    die('gagal upload');

            echo "ok";

            }
            else
                {
                echo "file kosong";
                }
    }

    function backup_folder() 
    { 
        $this->load->library('zip'); 

        $path = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

        $location = $_SERVER['DOCUMENT_ROOT'].'/upload/uploaded_file_backup.zip';

        $this->zip->read_dir($path.'/upload/', FALSE);
        $this->zip->archive('/upload/uploaded_file_backup.zip'); 

        if ($this->zip->download('uploaded_file_backup.zip')) unlink($location);
    } 

    function restore_media()
    {
        
        if ($_FILES['file']['name']!='')
            {
            $filename = $_FILES["file"]["name"];
            $source   = $_FILES["file"]["tmp_name"];
            $type     = $_FILES["file"]["type"];
            
            $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
            foreach($accepted_types as $mime_type) 
                {
                if($mime_type == $type) 
                    {
                    $okay = true;
                    break;
                    } 
                }
            
            $last = strrev($filename); 
            $last = $last{2}.$last{1}.$last{0};

            if($last!='zip') {
                echo "file harus berxtensi .zip, silahkan gunakan file hasil download backup file media"; die();
            }

            $dir = $_SERVER['DOCUMENT_ROOT']."/";
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $location = $dir.$filename;
            if(move_uploaded_file($source, $location)) 
                {
                $zip = new ZipArchive();
                $x = $zip->open($location);
                if ($x === true) 
                    {
                    $zip->extractTo($dir);
                    $zip->close();
            
                    unlink($location);
                    }
                }
                else
                    die('gagal upload');
            
            // unlink($location);

            echo "ok";

            }
            else
                {
                echo "file kosong";
                }
    }

    function repair()
    {
        # repair database
        $tables = $this->db->list_tables();

        foreach ( $tables as $table )
        {
            $this->dbutil->repair_table($table);
        }

        $var['success'] = 'Database berhasil diperbaiki!';

        $content = $this->load->view($this->template_directory.'home', $var, true);

        if ( $this->input->is_ajax_request() )
        {
            echo json_encode(array('html' => $content, 'message' => $var['success']));
        }
        else
        {
            $var['content'] = $content;

            $this->load->view($this->template_directory.'template', $var);
        }
    }

    function optimize()
    {
        # optimize database
        $this->dbutil->optimize_database();

        $var['success'] = 'Database berhasil dioptimalkan!';

        $content = $this->load->view($this->template_directory.'home', $var, true);

        if ( $this->input->is_ajax_request() )
        {
            echo json_encode(array('html' => $content, 'message' => $var['success']));
        }
        else
        {
            $var['content'] = $content;

            $this->load->view($this->template_directory.'template', $var);
        }
    }

    function koneksi_native()
    {
        $myhost     = $this->db->hostname;
        $myusername = $this->db->username;
        $mypassword = $this->db->password;
        $mydatabase = $this->db->database;

        $connect = mysqli_connect($myhost, $myusername, $mypassword, $mydatabase) or die('Error connecting server: ' . mysqli_error($connect));

        return $connect;
    }

    function import_native($on_file)
    {
        $connect  = $this->koneksi_native();

        $templine = '';
        $lines    = file($on_file);

        foreach ($lines as $line)
            {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';')
                {
                $import   = mysqli_query($connect, $templine) or print('Error query \'<strong>' . $templine . '\': ' . mysqli_error($connect) . '<br/><br />');
                $templine = '';
                }
            }

        return ($import) ? true : false;
    }
}