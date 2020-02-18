<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci =& get_instance();
$ci->lang->load($id_bhs.'_lang', 'admin');
$myset = $ci->template->mysetting_web();

// echo"<pre>"; print_r($_menu_primary); die;
$title = !empty($dta->judul_seo) ? $title_head.' | '.ucwords($dta->judul_seo) : '';
$title = !empty($title) ? $title : (!empty($dta->judul_seo_post) ? $title_head.' | '.$dta->judul_seo_post : '');
$title = !empty($title) ? $title : $title_head;
$favico = $myset->url_favicon;
date_default_timezone_set($myset->zona_waktu);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo !empty($meta_description) ? $meta_description : $description ?>">
  <meta name="keywords" content="<?php echo !empty($meta_keyword) ? $meta_keyword : $keyword ?>" >
  <meta content='<?php echo base_url() ?>' property='og:url'>
  <meta name="author" content="<?php echo !empty($penulis) ? $penulis : $pemilik ?>">
  <meta content='<?php echo !empty($dta->judul_post) ? $dta->judul_post : $title_head ?>' property='og:title'>
  <meta content='<?php echo !empty($meta_description) ? $meta_description : $description ?>' property='og:description'>
	<title><?php echo $title ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $favico ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/front_web/krisna/img/icon/9a3d717c9b8a6708eb72ba05a96744c5(1).png" sizes="16x16">
  <link rel="icon" type="image/x-icon" href="<?php echo $favico ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo $favico;?>" sizes="16x16 24x24 32x32 48x48">
  <link rel="apple-touch-icon-precomposed" href="<?php echo $favico ?>">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css" >
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/bootstrap-theme.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/bootstrap3.min.css">
	<!-- <link rel="stylesheet" href="assets/bootstrap/MDB-Free_4.8.0/css/bootstrap.min.css"> -->
</head>
<body>
<!-- navBar -->
<div class="navbar">
  <?php if ($myset->url_facebook): ?>
    <div class="icon">
      <a href="<?php echo $myset->url_facebook ?>">
        <i class="fa fa-facebook" aria-hidden="true"></i>
      </a>
    </div>
  <?php endif; ?>
  <?php if ($myset->url_twitter): ?>
    <div class="icon">
      <a href="<?php echo $myset->url_twitter ?>">
        <i class="fa fa-twitter" aria-hidden="true"></i>
      </a>
    </div>
  <?php endif; ?>
  <?php if ($myset->url_youtube): ?>
    <div class="icon">
      <a href="<?php echo $myset->url_youtube ?>">
        <i class="fa fa-youtube-play" aria-hidden="true"></i>
      </a>
    </div>
  <?php endif; ?>
  <?php if ($myset->url_instagram): ?>
    <div class="icon">
      <a href="<?php echo $myset->url_instagram ?>">
        <i class="fa fa-instagram" aria-hidden="true"></i>
      </a>
    </div>
  <?php endif; ?>
	<div class="icon pull-right bg-danger" style="border:none;">
    <a href="#">
      <i class="fa fa-search" aria-hidden="true" ></i>
    </a>
	</div>
  <div class="search">
    <form class="" action="" method="get">
      <input type="text" name="find" value="">
    </form>
  </div>
	<div class="d-block p-5 fix">
		<h1 class="text-center" style="font-family: 'Anton', sans-serif;color:black;font-size:60px;">ARCANE</h1>
		<i class="fa fa-circle " id="dot" aria-hidden="true"></i>
	</div>
</div>
<!-- endNavbar -->
<!-- menuBar -->
<div id="sideNavigation" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php foreach ($_menu_primary as $i =>  $navbar): ?>
    <?php
      $child      = @$ci->template->dropdown_child_web($navbar['child']);
      $link        = (!empty($navbar['url_module'])) ? base_url().$navbar['url_module'].'.'.$ext : base_url();
      $link        = (!$child) ? $link : '#';
      $subMenu       =  (!$child) ? '' : '<ul class="sub-menu" >'.$child.'</ul>';
      ?>
      <ul>
        <li <?php echo (@$child) ? 'onclick="down(this)"' : ' '?>>
          <a href="<?php echo $link ?>" ><?php echo $navbar['nama_module']?><?php echo (!$child) ? '' : '<i class="pull-right fa fa-chevron-down mr-4" aria-hidden="true"></i>'?></a>
          <?php echo $subMenu ?>
        </li>
      </ul>

  <?php endforeach; ?>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light menu d-block p-4  mt-5" id="menu">
<div class="navbar-toggler" onclick="openNav()" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
	<div class="burger"></div>
	<div class="burger"></div>
	<div class="burger"></div>
</div>
<?php
$endpoint = $_SERVER['REQUEST_URI'];
 ?>
 <?php if ($_menu_primary): ?>
   <div class="collapse navbar-collapse menu-box p-1" id="menuNav" >
     <ul class="navbar-nav">
       <?php foreach ($_menu_primary as $ve): ?>
         <?php
           $chd      = @$ci->template->dropdown_child_web($ve['child']);
           $anchor   = (!empty($ve['url_module'])) ? base_url().$ve['url_module'].'.'.$ext : base_url();
           $ul       = (!$chd) ? '' : '<ul class="sub-menu">'.$chd.'</ul>';
           ?>
            <li class="nav-item" id="hover">
            <a href="<?php echo $anchor?>"><?php echo $ve['nama_module'] ?></a>
            <?php echo $ul ?>
            </li>
       <?php endforeach; ?>
     </ul>
   </div>
 <?php endif; ?>

</nav>

<!-- endMenu -->
<!-- slider -->
<?php if (@$top_slide): ?>
<div class="col-md-8 col-sm-8 offset-2 mt-5 sliders" >
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		 <!-- Indicators -->
     <ol class="carousel-indicators">
       <?php $i=0 ?>
     <?php foreach ($top_slide as $index => $value): ?>
       <?php
          ($i == 0 ) ? $active = 'class="active"' : $active = "";
        ?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $index ?>"  <?php echo $active ?>></li>
       <?php $i++ ?>
     <?php endforeach; ?>
   </ol>
		 <!-- deklarasi carousel -->
       <div class="carousel-inner" role="listbox">
         <?php foreach ($top_slide as $key => $value): ?>
             <div class="item <?php echo (!$key) ? 'active':"";?>">
               <img class="sliding" alt="images" src="<?php echo $value->file?>">
               <div class="carousel-caption">
                 <h3><?php echo $value->translate_judul?></h3>
                 <p><?php echo $value->translate_deskripsi?></p>
               </div>
             </div>
           <?php endforeach; ?>
         </div>
		 </div>
	 </div>
 <?php endif; ?>
 </div>
 <?php echo $_container?>
 <!-- footer -->
 	 <div class="footer">
 		<h5><?php echo $myset->deskripsi_web ?></h5>
 	</div>
	<button type="button" id="tombolScrollTop" onclick="scrolltotop()" class="up" name="button"><i class="fa fa-angle-up" aria-hidden="true"></i></button>
<script src="<?php echo base_url()?>/assets/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>/assets/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>/assets/js/main.js"></script>
</body>
</html>
