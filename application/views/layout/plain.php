<?php
    $ci =& get_instance();
    $mysetting_web = $ci->template->mysetting_web();
    $level_ses = $ci->session->userdata('level');
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <title><?php echo $mysetting_web->nama_web;?> | Admin</title>
    <?php date_default_timezone_set($mysetting_web->zona_waktu);  ?>
    <link href="<?php echo $mysetting_web->url_favicon ?>" rel="icon" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Copyright" content="CVIMS_CMS" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="<?php echo $mysetting_web->meta_deskripsi ?>" />
    <meta name="generator" content="CVIMS CMS 1.0" />
    <meta name="author" content="<?php echo $mysetting_web->pemilik ?>" />

    <?php $ci->load->view('layout/other/head.php'); ?>

</head>
<body class="theme-red">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left"><div class="circle"></div></div>
                    <div class="circle-clipper right"><div class="circle"></div></div>
                </div>
            </div>
            <p><?php echo $ci->lang->line('loading') ?>...</p>
        </div>
    </div>
    <div class="overlay"></div>

    <nav class="navbar" id="b_navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars" style="display: block;"></a>
            <a class="navbar-brand" href="<?php echo base_url()?>admin" style="float: left;"><?php echo strtoupper($mysetting_web->nama_web) .' - CMS' ?>  </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right"><!--
                <li>
                    <a href="<?php echo base_url() ?>master/chat" title="Active Chat">
                        <i class="material-icons">notifications</i>
                        <span class="label-count"><?php echo $ci->template->count_notif() ?></span>
                    </a>
                </li> -->
				<li class="dropdown">
                    <a href="<?php echo base_url() ?>master/bahasa" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                        <div class="image settings">
                            <i class="material-icons">settings</i>
                        </div>
                    </a>
					<ul class="dropdown-menu" style="margin-left: 10%;">
                        <li class="body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden;">
                            <ul class="menu" style="overflow: hidden;">
                                <?php if ($level_ses=='1'): ?>
                                    <li>
                                        <a href="<?php echo base_url() ?>master/user" class=" waves-effect waves-block">
                                            <div class="menu-info">
                                                <h4><?php echo $ci->lang->line('User') ?></h4>
                                            </div>
                                        </a>
                                    </li>
    								<!-- <li>
                                        <a href="<?php echo base_url() ?>master/module" class=" waves-effect waves-block">
                                            <div class="menu-info">
                                                <h4><?php echo $ci->lang->line('Module_Setting') ?></h4>
                                            </div>
                                        </a>
                                    </li> -->
    								<li>
                                        <a href="<?php echo base_url() ?>master/bahasa" class=" waves-effect waves-block">
                                            <div class="menu-info">
    											<h4><?php echo $ci->lang->line('Language_Setting') ?></h4>
                                            </div>
                                        </a>
                                    </li>
    								<li>
                                        <a href="<?php echo base_url() ?>pengaturan/pengaturan_web" class=" waves-effect waves-block">
                                            <div class="menu-info">
                                                <h4><?php echo $ci->lang->line('Web_Configuration') ?></h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="ajax_modals('Backup Data','null','pengaturan/mybc','width:90%')" class="waves-effect waves-block">
                                            <div class="menu-info">
                                                <h4>Backup Data</h4>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif ?>
                                <li>
                                    <a href="javascript:void(0)" onclick="ajax_modals('Edit Profil','null','master/user/profilku/<?php echo $ci->session->userdata('user_id') ?>','width:60%')" class="waves-effect waves-block">
                                        <div class="menu-info">
                                            <h4><?php echo $ci->lang->line('ubah_profil') ?></h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="ajax_modals('Edit Password','null','master/user/passwordku/<?php echo $ci->session->userdata('user_id') ?>','width:60%')" class="waves-effect waves-block">
                                        <div class="menu-info">
                                            <h4><?php echo $ci->lang->line('ubah_password') ?></h4>
                                        </div>
                                    </a>
                                </li>
								<li>
                                    <a href="<?php echo base_url() ?>master/panduan" class=" waves-effect waves-block">
                                        <div class="menu-info">
                                            <h4><?php echo $ci->lang->line('Panduan') ?></h4>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                        <div class="image icon-circle">
                            <i class="material-icons">account_circle</i>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="body">
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden;">
                            <ul class="menu" style="overflow: hidden;">
                                <li>
                                    <a target="_blank" href="<?php echo base_url() ?>" class="waves-effect waves-block">
                                        <div class="icon-circle bg-light-green"><i class="material-icons">important_devices</i></div>
                                        <div class="menu-info">
                                            <h4><?php echo $ci->lang->line('lihat_web') ?></h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="document.getElementById('fmenu').style.display = 'block';" class=" waves-effect waves-block">
                                        <div class="icon-circle bg-blue"><i class="material-icons">format_color_fill</i></div>
                                        <div class="menu-info">
                                            <h4><?php echo $ci->lang->line('warna_admin') ?></h4>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>user/logout"  onclick="return confirm('Anda yakin hendak Log Out?')" class=" waves-effect waves-block">
                                        <div class="icon-circle bg-cyan"><i class="material-icons">input</i></div>
                                        <div class="menu-info">
                                            <h4 style="color:red">Log out</h4>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    </nav>
    <section>
        <aside id="leftsidebar" class="sidebar" >
            <!-- Menu -->
            <div class="menu">
                <ul class="list b_menulist" id="b_menulist">
                    <li class="header">MAIN NAVIGATION</li>
                    <?php
                      foreach($_menus as $row)
                        {
                        $izin = $ci->template->izin($row['id_module'], $level);

                        $ch   = @$ci->template->dropdown_child($row);
                        $a    = ($ch==null) ? 'href="'.base_url().$row['url_module'].'" class=" ajax " '.($row['url_module'] == NULL ? 'style="pointer-events:none"' : '') : ' href="javascript:void(0);" class="menu-toggle waves-effect waves-block"';

                        if($izin == true)
                            {
                            echo ' <li>'.
                                    '<a '.$a.'>'.
                                        '<i class="material-icons">'.$row['icon_module'].'</i>
                                        <span>'.$ci->lang->line($row['nama_module']).'</span>
                                    </a>
                                        <ul class="ml-menu" >
                                            '.$ch.'
                                        </ul>
                                  </li>';
                            }
                        }
                    ?>
                </ul>
            </div>
            <!-- #Menu -->
        </aside>
    </section>
    <section class="content" style="margin-top: 100px;">
        <div class="container-fluid">
            <div class="page-content" id="primarycontent">
				<?php echo $_content ?>
			</div>
        </div>
        <div style="margin-left: -14px; width: 100%; " >
            <div class="card" id="footer" style="padding:10px; margin-right: -29px;">
                CMS 1.0 Copyrights &copy; 2017, Muhammad Shefin Gani <br />
                <a href="#" style="text-decoration:none" title="Web Development & Mobile Apps by Jogjashop.com " target="_blank">
                    Web Development & Mobile Apps by ShefinGani
                </a>
            </div>
        </div>
        <!-- Modals -->
        <div class="modal fade" id="myModal" role="document">
            <div class="modal-dialog" role="dialog" id="modalcontent">
                <div class="modal-content" >
                    <div class="modal-header" style="background-color: #0088CC">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body">
                        <p id="error-message" style="color:#f00;font-size:13px;"></p>
                        <p id="modal-teks"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal2" role="document">
            <div class="modal-dialog" role="dialog" id="modalcontent2">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0088CC">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel2"></h4>
                    </div>
                    <div class="modal-body">
                        <p id="error-message" style="color:#f00;font-size:13px;"></p>
                        <p id="modal-teks2"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal_manager">
            <div class="modal-dialog" style="width:80%;height:50%">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0088CC">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Media Manager</h4>
                    </div>
                    <div class="modal-body" style="height:500px">
                        <input type="hidden" id="setfield">
                        <input type="hidden" id="settype"> <!-- for just image type=1 -->
                        <iframe id="myiframe" width="100%" height="100%" src="<?php echo base_url();?>/assets/plugins/filemanager/dialog.php?type=1&relative_url=1&akey=a123&field_id=field_gambar'&fldr=" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="fmenu" hidden="true" style="background: #39f;">
	<center><a href="javascript:void(0)" onclick="document.getElementById('fmenu').style.display = 'none';" style="color:#000">[ <?php echo $ci->lang->line('tutup') ?> ]</a></center>
    <div style="margin:10px">
        <div id="palete" style="display:block;">
            <label> <?php echo $ci->lang->line('Warna_Atas') ?> </label><br>
            <input type="image" src="<?php echo base_url()?>assets/img/color.gif" class="jscolor" onchange="change_warna(this.value)">
        </div>
        <div id="palete2" style="display:block;">
            <label> <?php echo $ci->lang->line('Warna_Samping') ?> </label><br>
            <input type="image" src="<?php echo base_url()?>assets/img/color.gif" class="jscolor" onchange="change_warna2(this.value)">
        </div>
        <div id="palete3" style="display:block;">
            <label> <?php echo $ci->lang->line('Warna_Konten') ?> </label><br>
            <input type="image" src="<?php echo base_url()?>assets/img/color.gif" class="jscolor" onchange="change_warna3(this.value)">
        </div>
    </div>
	</div>

    <?php $ci->load->view('layout/other/js.php'); ?>
    <script src="<?php echo base_url()?>assets/js/pages/index.js"></script>
</body>
</html>
