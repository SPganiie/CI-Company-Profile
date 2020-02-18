<?php $ci =& get_instance(); ?>

<?php echo form_open(current_url()); ?>
<?php //echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>'); ?>

<table border='0' width="100%">
	<tr>
		<td width=100>Nama Module</td>
		<td width=10>:</td>
		<td><?php echo form_input(array('name'=>'nama_module', 'class'=>'form-control input-medium', 'value'=>(!empty($dta) ? $dta->nama_module : set_value('nama_module')) )); ?><br></td>
		<td></td>
	</tr>
	<tr>
		<td>Icon Module</td>
		<td>:</td>
		<td><?php echo form_input(array('name'=>'icon_module', 'class'=>'form-control input-medium', 'value'=>(!empty($dta) ? $dta->icon_module : set_value('icon_module')) )); ?><br></td>
		<td>* Material Design icon</td>
	</tr>
	<tr>
		<td>URL</td>
		<td>:</td>
		<td><?php echo form_input(array('name'=>'url', 'class'=>'form-control input-medium', 'value'=>(!empty($dta) ? $dta->url_module : set_value('url')) )); ?><br></td>
		<td></td>
	</tr>
	<tr>
		<td>Parent</td>
		<td>:</td>
		<td><?php echo $ci->dropdown_parent( (!empty($dta) ? $dta->parent : null) ); ?><br></td>
		<td></td>
	</tr>

	<?php foreach ($list as $key) : ?>
	<?php 
		if(!empty($dta))
			$aksi = ($ci->cek_module($dta->id_module, $key->id_aksi) > '0') ? '1' : '0';
	?>
	<tr>
		<td><?php echo ucwords($key->aksi); ?></td>
		<td>:</td>
		<td><?php echo form_dropdown('aksi['.$key->id_aksi.']',array('0'=>'N', '1'=>'Y'), (!empty($dta) ? $aksi : '' ), 'style="width:30%;"  class="form-control show-tick"'); ?><br></td>
		<td></td>
	</tr>
	<?php endforeach; ?>

	<tr>
		<td>Urutan</td>
		<td>:</td>
		<td><?php echo form_input(array('type'=>'number', 'name'=>'urutan', 'class'=>'form-control input-medium', 'style'=>'width:30%;', 'value'=>(!empty($dta) ? $dta->order : set_value('urutan')) )); ?></td>
		<td></td>
	</tr>
	<tr>
		<td colspan='4' align="right">
			<!-- <button type="button" style="border:0px;" onClick="location.href='<?php //echo base_url('master/module'); ?>'" class="btn btn-small btn-danger"><i class="icon-remove icon-white"></i>  Kembali</button> -->
			<button class="btn btn-small btn-primary" style="border:0px;">Simpan</button>
		</td>
	</tr>
</table>

<?php echo form_close(); ?>