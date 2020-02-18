<?php
$ci =& get_instance();
$mysetting_web = $ci->template->mysetting_web();

$route = $mysetting_web->page_news;

$link = base_url().$route.'/'.$dta->nama_halaman.'.'.$ext;
?>

<main id="main" class="site-main" role="main" itemprop="mainContentOfPage">
<div style="margin:10px;padding:10px;">
	<article id="post-465" class="post-465 page type-page status-publish hentry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
		<div class="entry-header-wrapper text-center" style="padding:10px 20px;background-color:black; color:#ffff; display:inline-block;border:1px;border-radius:10px;">
			<header class="entry-header">
				<h1 class="entry-title" itemprop="headline"><?php echo $dta->judul_seo;?></h1>
			</header><!-- .entry-header -->
		</div><!-- .entry-header-wrapper -->

		<div class="entry-content" itemprop="text">
			<?php if (!empty($dta->gambar_page)): ?>
				<img src="<?php echo base_url().$dta->gambar_page;?>" style="float:left; width:100%; background-color:#1C3F94;max-width: 475px; margin-right:20px; margin-bottom:20px;">
			<?php endif ?>

			<?php echo $dta->konten_halaman; ?>
		</div><!-- .entry-content -->

	</article><!-- #post-## -->
</div>
</main><!-- #main -->
