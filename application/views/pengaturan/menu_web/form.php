<?php $ci =& get_instance(); ?>

<?php //echo form_open(current_url()); ?>
<form id="id_calon">
<input type="hidden" name="id_module" value="<?php echo (!empty($dta) ? $dta->id_module : '') ?>">
<table border='0' width="100%">
	<tr>
		<td width=180><?php echo $ci->lang->line('nama') ?></td>
		<td width=10>:</td>
		<td><?php echo form_input(array('name'=>'nama_module', 'class'=>'form-control input-medium', 'value'=>(!empty($dta) ? $dta->nama_module : set_value('nama_module')) )); ?><br></td>
		<td></td>
	</tr>
	<tr>
		<td valign="">Translate <?php echo $ci->lang->line('nama') ?> Menu</td>
		<td>:</td>
		<td>
			<div class="col-md-12">
	            <ul class="nav nav-tabs" role="tablist">
	                <?php foreach ($bhs as $key) : ?>
	                    <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
	                        <a href="#module_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
	                    </li>
	                <?php endforeach; ?>
	            </ul>

	            <div class="tab-content">
	                <?php foreach ($bhs as $key) : ?> 
	                   	<?php $list = !empty($dta) ? $ci->get_list($key->id_bahasa, $dta->id_module) : '' ; ?>

		                <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="module_<?php echo $key->id_bahasa ?>">
	                    	<input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">
	                        <input type="text" name="nama_module_list[<?php echo $key->id_bahasa ?>]" class="form-control" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $list->nama_module)) : '') ?>" />
		                </div>

	                <?php endforeach; ?>
	            </div>
	        </div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td valign="top">URL Menu</td>
		<td valign="top">:</td>
		<td>
			<div>
				<input type="radio" id="tipe_page" name="tipe_url" value="page"  onclick="ajax_modals2('<?php echo $ci->lang->line("halaman") ?>', '', 'pengaturan/menu_web/open_page', 'width:75%');"><label for="tipe_page"><?php echo $ci->lang->line("halaman") ?></label>
				<input type="radio" id="tipe_post" name="tipe_url" value="post" onclick="ajax_modals2('<?php echo $ci->lang->line("post") ?>', '', 'pengaturan/menu_web/open_post', 'width:75%');" ><label for="tipe_post"><?php echo $ci->lang->line("post") ?></label>
				<input type="radio" id="tipe_kategori" name="tipe_url" value="kategori" onclick="ajax_modals2('<?php echo $ci->lang->line("Kategori") ?>', '', 'pengaturan/menu_web/open_kategori', 'width:75%');" ><label for="tipe_kategori"><?php echo $ci->lang->line("Kategori") ?></label>
				<input type="radio" id="tipe_custom" name="tipe_url" value="custom"><label for="tipe_custom">Custom</label>
			</div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="2"><span><?php echo base_url() ?></span></td>
		<td colspan="2">
			<div class="col-sm-12">
				<?php echo form_input(array('name'=>'url', 'id'=>'url', 'class'=>'form-control', 'value'=>(!empty($dta) ? $dta->url_module : set_value('url')), "style"=>"background-color:#c5c5c5; width: 80%; float: left;", "readonly"=>"" )); ?>
				<button type="button" class="btn btn-primary waves-effect" id="find" onclick="find_url()"><i class="material-icons">search</i></button>
			</div>
		</td>
	</tr>
	<tr><td><p><br></p></td></tr>
	<tr>
		<td><?php echo $ci->lang->line('posisi') ?></td>
		<td>:</td>
		<td><?php echo form_dropdown('id_posisi', $drop_posisi, (!empty($dta) ? $dta->id_posisi : '' ), 'id="id_posisi" class="form-control show-tick"'); ?><br></td>
		<td></td>
	</tr>
	<tr>
		<td>Parent</td>
		<td>:</td>
		<td id="sel-parent"><?php echo $ci->dropdown_parent((!empty($dta) ? $dta->parent : null), (!empty($dta) ? $dta->id_posisi : null)); ?></td>
		<td></td>
	</tr>
	<tr><td colspan="4"><br></td></tr>
	<tr>
		<td><?php echo $ci->lang->line('urutan') ?></td>
		<td>:</td>
		<td><?php echo form_input(array('type'=>'number', 'name'=>'urutan', 'class'=>'form-control input-medium', 'style'=>'width:30%;', 'value'=>(!empty($dta) ? $dta->order : set_value('urutan')) )); ?><br></td>
		<td></td>
	</tr>
	<tr>
		<td colspan='4' align="right">
			<button type="button"  class="btn btn-small btn-primary btnSmbt" style="border:0px;"><?php echo strtoupper($ci->lang->line('simpan')) ?></button>
		</td>
	</tr>
</table>
</form>
<?php //echo form_close(); ?>

<script type="text/javascript">

	function find_url()
	{
		if ($('#tipe_page').is(':checked'))
			{
			ajax_modals2('<?php echo $ci->lang->line("pilih_page") ?>', '', 'pengaturan/menu_web/open_page', 'width:75%');
			} else
				{
				ajax_modals2('<?php echo $ci->lang->line("pilih_post") ?>', '', 'pengaturan/menu_web/open_post', 'width:75%');
				}
	}

	$('#id_posisi').change(function() {	
		$.ajax({
            type:'GET',
            url :'<?php echo base_url()."pengaturan/menu_web/parent_web/null/" ?>'+$('#id_posisi').val(),
            data:null,
            success:function(i)
                {
                // alert(i)
				 $('#sel-parent').html(i);
                }
            });
	});

	$('.btnSmbt').click(function() {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."pengaturan/menu_web/simpan" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>pengaturan/pengaturan_web/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    });

	$('input:radio[name="tipe_url"]').change(function(){
        if ($(this).is(':checked') && $(this).val() == 'page') 
        	{
			$('#url').prop('readonly', true);
			$('#url').css('background-color', '#c5c5c5');
        	} 
        	else if ($(this).is(':checked') && $(this).val() == 'post') 
	        	{
	        	$('#url').prop('readonly', true);
				$('#url').css('background-color', '#c5c5c5');
	        	} 
	        	else if ($(this).is(':checked') && $(this).val() == 'kategori') 
		        	{
		        	$('#url').prop('readonly', true);
					$('#url').css('background-color', '#c5c5c5');
		        	} 
		        	else
		        		{
			        	$('#url').prop('readonly', false);
						$('#url').css('background-color', '#fff');
						$('#url').val('');
						$('#url').focus();
		        		}
    });
</script>