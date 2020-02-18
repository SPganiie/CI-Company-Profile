<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$ci =& get_instance();
$set = $ci->template->mysetting_web();
?>
<?php if ($dta): ?>
  <div class="Wrapper col-md-12">
    <img alt="images" src="<?php echo $dta->gambar_page ?>" class=" pict1 mt-5">
    <div class="wrapper-text">
      <h1><?php echo $dta->judul_halaman ?></h1>
      <p><?php echo $dta->konten_halaman ?></p>
      <button type="submit" class="btn lear" name="button">LEAN MORE</button>
    </div>
  </div>
<?php endif; ?>
<div class="wrapper2">
 <h1 class="text-center">TESTIMONIALS</h1>
 <div id="quotes">
   <i class="fa fa-quote-left" aria-hidden="true" ></i>
 </div>
 <ul>
   <?php foreach ($testimonials as $vanue): ?>
     <li>
       <p><?php echo $vanue->konten_widget ?></p>
       <b><?php echo $vanue->nama_widget_list ?></b>
       <h6>
         <img alt="images" src="<?php echo $vanue->gambar_widget ?>" class="rounded-circle" width="50" >
       </h6>
     </li>
   <?php endforeach; ?>
 </ul>
</div>
<!-- line3 -->
 <div class="wrapper3">
		<h5 class="text-center mb-5">RECENT POSTS</h5>
    <?php
  	if ($_side_recent)
  		{
  		$i = 0;
  		foreach ($_side_recent as $key => $val)
  			{
  			if($val->gambar_post)
  				{
  				$i++;
  				if($i < 2)
  					{
  			?>
			<img alt="images" class="img3" src="<?php echo $val->gambar_post ?>">
				<div class="box">
					<div class="time">BY <?php echo $val->penulis_post ?> 12, 2017</div>
					<h1><?php echo $val->judul_post ?></h1>
					<p><?php echo substr(strip_tags($val->konten_post),0,160) ?>...</p>
					<a href="#">CONTINUE READING</a>
			</div>
      <ul>
    <?php }else{ ?>
				 <li>
					 <img alt="images" src="<?php echo $val->gambar_post; ?>">
						 <div class="entry-meta">
							 <span>BY <?php echo $val->penulis_post; ?></span>
							 <span>APR 4,2017</span>
						 </div>
						 <div class="content">
							 <h2><?php echo $val->judul_post ?></h2>
							 <p><?php echo substr(strip_tags($val->konten_post),0,180)?>. . .</p>
							 <a href="#">CONTINUE READING</a>
						 </div>
				 </li>
    <?php }
    if($i > 5) break;

   }}
echo "</ul>";
 }?>
			<div class="bottom-post">
				<button type="submit" class="btn more-post btn-dark" name="button">MORE POST</button>
			</div>
	</div>
<!-- endLine3 -->
<!-- line4 -->
	<div class="wrapper4">
		<div class="left">
			<div class="wrapA" >
				<span>ABOUT VERITY</span><br><br>
				<p>Verity – Portfolio Slash Blog WordPress Theme is a minimalistic modern theme for bloggers and creative professionals, who are looking for a simple-yet-stylish online presence. We have sacrificed over-the-top design elements so that your website looks sleek and straightforward.</p>
			</div>
			<div class="wrapB">
				<span>CATEGORIES</span>
				<ul>
					<li>Blog</li>
					<li>Design</li>
					<li>Life</li>
					<li>Originals</li>
					<li>Photography</li>
				</ul>
			</div>
		</div>
		<div class="right">
			<p>NUMBERED ARCHIVES</p>
				<ul>
					<li>April 2017<span>(2)</span></li>
					<li>March 2017<span>(6)</span></li>
					<li>February 2017<span>(3)</span></li>
					<li>January 2017<span>(10)</span></li>
				</ul>
		</div>
	</div>
<!-- endLine4 -->
