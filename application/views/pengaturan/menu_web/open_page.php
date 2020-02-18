<?php $ci =& get_instance(); ?>
<div id="modal_page">
<div class="body table-responsive">
    <?php if (!empty($list)) : ?> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('pengaturan/menu_web/open_page?src='+this.value, 'modal_page')}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
        <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('pengaturan/menu_web/open_page?src='+ $('#src').val(), 'modal_page')"> <i class="material-icons">search</i> </button>
    </div>
    
	<table width="100%" class="table table-bordered table-striped table-hover ">
		<thead>
			<tr>
				<th width="5%">No</th>
                <th><?php echo $ci->lang->line('judul') ?></th>
			</tr>
		</thead>
		<tbody>
            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                <tr onclick="pilih_page('<?php echo $key->id_halaman ?>')" title="<?php echo 'Select : '.ucwords(str_replace('-', ' ', $key->judul_seo)) ?>" style="cursor:pointer">
                    <td align="center"><?php echo $no ?>.</td>
                    <td>
                        <?php echo ucwords(str_replace('-', ' ', $key->judul_seo)) ?>
                    </td>
                </tr>
            <?php $no++; endforeach; ?>
		</tbody>
	</table>
    <span><?php echo $this->mypaging->create(true, 'open_page', 'modal_page') ?></span>
    <?php else : ?>
        <div><p>Data <?php echo $ci->lang->line('kosong') ?></p></div>
    <?php endif; ?>
</div>
</div>
<script type="text/javascript">
	function pilih_page(val) 
	{
		var hasil = ajax_data({id:val}, 'pengaturan/menu_web/get_page');

		var pch = hasil.split('|');

		$("#url").val(pch[0]);

		$("#myModal2").modal("hide");
	}
</script>