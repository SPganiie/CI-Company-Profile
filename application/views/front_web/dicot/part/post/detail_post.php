<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	$ci =& get_instance(); 
	$set = $ci->template->mysetting_web(); 
	$link = base_url().$set->page_news.'/'.$dta->nama_post.'.'.$set->ext;
?>
<main id="main" class="site-main" role="main" itemprop="mainContentOfPage">		
<div style="margin:10px;padding:10px;">
	<article id="post-465" class="post-465 page type-page status-publish hentry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
		<div class="entry-header-wrapper">
			<header class="entry-header">
				<h1 class="entry-title" itemprop="headline"><?php echo $dta->judul_post;?></h1>		
			</header><!-- .entry-header -->
		</div><!-- .entry-header-wrapper -->

		<div class="entry-content" itemprop="text">
				<?php if (!empty($dta->gambar_post)): ?>
					<img src="<?php echo base_url().$dta->gambar_post;?>" style="float:left; width:100%; background-color:#1C3F94;max-width: 475px; margin-right:20px; margin-bottom:20px;">
				<?php endif ?>
				<?php echo $dta->konten_post;?>
		</div><!-- .entry-content -->

	</article><!-- #post-## -->
</div>
</main><!-- #main -->