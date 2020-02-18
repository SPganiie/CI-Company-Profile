<?php 
die("C");
	defined('BASEPATH') OR exit('No direct script access allowed');

	$ci =& get_instance(); 
    $set = $ci->template->mysetting_web(); 
?>
<main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
<div style="margin:10px;padding:10px;">
	<header class="page-header">
		<h1 class="page-title">List <?php echo $ci->lang->line('Kategori Gallery') ?></h1>
	</header><!-- .page-header -->

	<ol>
		<?php if (isset($list_parent)): ?>
			<?php foreach ($list_parent as $key) : ?>
				<li>
					<h3><a href="<?php echo base_url().'category-gallery/'.$key['nama_kategori'].'.'.$ext ?>" style="text-decoration: none;"><?php echo $key['nama_list']; ?></a></h3>
					<?php if (!empty($key['child'])) : ?>
						<ul>
							<?php echo $ci->show_child_galery($key);  ?>
						</ul>	
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php else : ?>
			<li>
				<p><?php echo $ci->lang->line('masih_diinput') ?></p>
			</li>
		<?php endif ?>	
	</ol>
</div>
</main><!-- #main -->