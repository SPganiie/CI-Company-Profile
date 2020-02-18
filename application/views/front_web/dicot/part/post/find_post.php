<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	$ci =& get_instance(); 
    $set = $ci->template->mysetting_web(); 
?>

	<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<header class="page-header">
			<h1 class="page-title">Keyword : <?php echo ucwords($key); ?></h1>					
		</header>
		
		<?php if (!empty($list)): ?>
			<?php foreach ($list as $val): ?>
				<?php $link = base_url().$set->page_news.'/'.$val->nama_post.'.'.$set->ext ?>

				<article id="post-121" class="post-121 post type-post status-publish format-standard has-post-thumbnail hentry wow fadeIn" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

					<figure class="post-thumbnail">
						<a href="<?php echo $link ?>">
							<img width="600" height="600" src="<?php echo base_url().$val->gambar_post ?>" 
							class="img-featured img-responsive wp-post-image" alt="" />
						</a>
					</figure><!-- .post-thumbnail -->

					<div class="hentry-content">

						<div class="entry-meta entry-meta-header">
							<ul>
								<li><span class="byline"> by <span class="author vcard"><?php echo $val->penulis_post ?></span></span></li>
								<li>
									<span class="posted-on">
										<span class="screen-reader-text">Posted on</span>
										<?php $tgl = substr($val->waktu_publish, 0, 10); $tgl = dd_mm_yyyy($tgl); ?>
										<a href="<?php echo base_url().'archive/'.$tgl.'.'.$set->ext ?>" rel="bookmark">
											<time class="entry-date published"><?php echo $tgl ?></time>
										</a>
									</span>
								</li>
							</ul>
						</div><!-- .entry-meta -->

						<header class="entry-header">
							<h1 class="entry-title" itemprop="headline">
								<a href="<?php echo $link ?>" rel="bookmark"><?php echo $val->judul_post ?></a>
							</h1>
						</header><!-- .entry-header -->

						<div class="more-link-wrapper">
							<a href="<?php echo $link ?>" class="more-link">Read More</a>
						</div><!-- .more-link-wrapper -->

					</div><!-- .hentry-content -->

				</article><!-- #post-## -->

			<?php endforeach ?>
		<?php else : ?>
		    <div>
		        <div class="archive">
		        	<br><p><?php echo $ci->lang->line('masih_diinput') ?></p>
				</div>
			</div>
		<?php endif ?>

	</main><!-- #main -->