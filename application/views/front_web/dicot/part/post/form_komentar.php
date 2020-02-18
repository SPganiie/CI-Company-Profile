<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	$ci =& get_instance(); 
	$set = $ci->template->mysetting_web(); 
?>

<div id="respond" class="comment-respond">
	<h3 id="reply-title" class="comment-reply-title"><?php echo $ci->lang->line('form_komentar'); ?></h3>
	<form action="" method="post" id="komen_form" class="comment-form" novalidate="">

		<p class="comment-form-comment">
			<label for="comment"><?php echo $ci->lang->line('Komentar'); ?> <span class="required">*</span></label>
			<textarea id="comment" name="komentar" cols="45" rows="4" maxlength="65525" required="required"></textarea>
		</p>

		<p class="comment-form-author">
			<label for="komen-nama"><?php echo $ci->lang->line('nama'); ?> <span class="required">*</span></label>
			<input id="komen-nama" name="nama" type="text" value="" size="30" maxlength="245" required="required">
		</p>
		
		<p class="comment-form-email">
			<label for="email">Email <span class="required">*</span></label>
			<input id="email" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" required="required">
		</p>
		
		<p class="comment-form-url">
			<label for="captcha">Captcha <span class="required">*</span></label>
			<span id="captcha_image"></span>
			<input id="captcha" name="input_captcha" type="text" value="" size="10" maxlength="10" placeholder="<?php echo $ci->lang->line('ulangi_captcha'); ?>" style="width: 80%;">
		</p>
		
		<p class="form-submit">
			<input name="submit" type="submit" id="send_komen" class="submit" value="Send Comment">
			<input type="hidden" name="id" id="id" value="<?php echo $id ?>">
			<input type="hidden" name="parent_id" id="parent_id" value="">
		</p>
	</form>
</div><!-- #respond -->

<script type="text/javascript">
    $(document).ready(function(){
        mycaptcha();
    });

 	$("#komen_form").on('submit',(function(e) {
		e.preventDefault();
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."comment.html"; ?>',
            data:$('#komen_form').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Terima Kasih.\nKomentar anda telah terkirim ke admin');
                    $("#komen_form")[0].reset();
                    mycaptcha();
                    } else
                        {
                        alert(i);
                        mycaptcha();
                        }
                }
            });
	}));

    function mycaptcha()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."front_web/buat_captcha"; ?>',
            data:null,
            success:function(data) { $("#captcha_image").html(data); }
        });
    }
</script>
