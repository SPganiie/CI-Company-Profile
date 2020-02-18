<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$ci =& get_instance(); 
$set = $ci->template->mysetting_web(); 
$route = 'gallery';
?>
<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
<div style="margin:10px;padding:10px;">
	<header class="page-header">
		<h1 class="page-title">Gallery : <?php echo $dta->nama_kategori_list ?></h1>
	</header><!-- .page-header -->

	<?php if (!empty($list)): ?>
		<?php foreach ($list as $val): ?>

			<h3><a href="<?php echo base_url().$route.'/'.$val->judul_galery.'.'.$ext;; ?>" style="text-decoration: none;"><?php echo $val->translate_judul_galery; ?></a></h3>

		<?php endforeach ?>
	<?php else : ?>
		<div>
			<div class="archive">
				<br><p><?php echo $ci->lang->line('masih_diinput') ?></p>
			</div>
		</div>
	<?php endif ?>
</div>
</main><!-- #main -->