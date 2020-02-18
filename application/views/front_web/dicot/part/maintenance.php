<?php $ci =& get_instance(); $mysetting_web = $ci->template->mysetting_web();  ?>
<html lang="en">
<head>
	<title><?php echo strtoupper($mysetting_web->nama_web) ?></title> 
	<?php date_default_timezone_set($mysetting_web->zona_waktu) ?>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="Copyright" content="Jogjashop.com" />
    
	<link href="<?php echo $mysetting_web->url_favicon ?>" rel="icon" type="image/x-icon">
	<link rel='stylesheet' id='all-css-0-1' href='<?php echo base_url()?>assets/front_web/dc/css/s2.min.css' type='text/css' media='all' />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/front_web/dc/css/font-awesome.min.css">
</head>
<body>
	<div id="page-wrapper">
		<div align="center">
			<h1>Maaf, website sedang dalam proses maintenance</h1>
			<h3>Silakan kembali beberapa saat lagi</h3>
		</div>
	</div>
</body>