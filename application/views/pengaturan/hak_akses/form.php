<?php
	$ci =& get_instance();
	$action = !empty($dta) ? 'pengaturan/hak_akses/edit_simpan/'.$dta->id_level : 'pengaturan/hak_akses/tambah_simpan' ;
	echo form_open($action, 'id="id_calon"'); 
?>

<table border='0' width="100%">
	<tr>
		<td width=100><?php echo $ci->lang->line('nama') ?> Level</td>
		<td width=10>:</td>
		<td><?php echo form_input(array('name'=>'level', 'value'=>(!empty($dta) ? $dta->level : ''), 'class'=>'form-control input-large' )); ?></td>
	</tr>
	<tr>
		<td colspan=3 align="right">
		<br/>
			<?php echo form_input(array('value'=>strtoupper($ci->lang->line('simpan')), "type"=>"submit","style"=>"border:0px;", 'class'=>'btn btn-primary btn-small waves-effect', "onclick"=>"".(!empty($dta) ? "if(confirm('Anda yakin data ini diubah?'))" : "")." submit_form('id_calon', 'loadicon')")); ?>
		</td>
	</tr>
</table>

<?php echo form_close(); ?>