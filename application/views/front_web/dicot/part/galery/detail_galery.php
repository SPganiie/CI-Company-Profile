<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

    $ci =& get_instance();
    $set = $ci->template->mysetting_web();

    $link = $_SERVER['REQUEST_URI'];
    $judul_show = $dta->translate_judul_galery;
?>
<style>
.baris {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create four equal koloms that sits next to each other */
.kolom {
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}

.kolom img {
  margin-top: 8px;
  vertical-align: middle;
}

/* Responsive layout - makes a two kolom-layout instead of four koloms */
@media screen and (max-width: 800px) {
  .kolom {
    flex: 50%;
    max-width: 50%;
  }
}

/* Responsive layout - makes the two koloms stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .kolom {
    flex: 100%;
    max-width: 100%;
  }
}
</style>

<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
<div style="margin:10px;padding:10px;">
	<article id="post-0" class="post-0 post type-post status-publish format-standard has-post-thumbnail hentry wow fadeIn" itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

		<header class="page-header">
			<h1 class="page-title"><?php echo $judul_show ?></h1>
		</header><!-- .page-header -->

		<div class="entry-content" itemprop="text">

			<?php if (!empty($dta->translate_konten_galery)): ?>
				<p><?php echo $dta->translate_konten_galery; ?></p><br>
			<?php endif ?>

			<?php if (!empty($list)) : ?>

				<div class="baris" id="gallery">
	                <?php $no=1;
					foreach ($list as $key)
						{
						if($no == 1)
							{
							echo '<div class="kolom">';
							}
					?>

	                    <?php
	                        $name = $key->translate_judul;
	                        $desc = $key->translate_deskripsi;
	                        $ex   = explode('.', $key->file); $ex = end($ex);
	                        $src  = base_url().(empty($key->file) ? '/assets/img/default.png' : substr($key->file,1));

							list($width, $height) = @getimagesize($src);
	                    ?>

	                    <a href="<?php echo $link ?>">
							<img alt="<?php echo $name ?>"
						     src="<?php echo $src ?>"
						     data-image="<?php echo $src ?>"
						     data-description="<?php echo $desc ?>">
						</a>

	                <?php
						if($no == 2)
							{
							echo '</div>';
							$no = 0;
							}
						$no++;
						}
					?>
				</div>
	        <?php endif; ?>

		</div><!-- .entry-content -->
	</article>
</div>
</main>
