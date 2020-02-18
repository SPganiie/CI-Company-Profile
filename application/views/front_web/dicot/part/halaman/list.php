<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	$ci =& get_instance(); 
    $set = $ci->template->mysetting_web(); 
?>
	<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<header class="page-header">
			<h1 class="page-title">List <?php echo $ci->lang->line('halaman') ?></h1>
		</header><!-- .page-header -->

		<?php if (!empty($list)): ?>
			<?php foreach ($list as $val): ?>

				<h3><a href="<?php echo base_url().'page/'.$val->nama_halaman.'.'.$ext; ?>" style="text-decoration: none;"><?php echo $val->judul_halaman; ?></a></h3>

			<?php endforeach ?>
		<?php else : ?>
		    <div>
		        <div class="archive">
		        	<br><p><?php echo $ci->lang->line('masih_diinput') ?></p>
				</div>
			</div>
		<?php endif ?>

	</main><!-- #main -->