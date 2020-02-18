<?php $ci =& get_instance(); ?>
<div id="modal_page">
    <div>
        <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' File', $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect" onclick=\'ajax_modals2("File Galery","null","master/galery/tambah_file/'.$id_galery.'","width:60%")\''); ?> <br>
    </div>
    <div class="body table-responsive">
        <?php if (!empty($list)) : ?>        
    	<table width="100%" class="table table-bordered table-striped table-hover ">
    		<thead>
    			<tr>
    				<th width="30">No</th>
                    <th><?php echo $ci->lang->line('nama') ?></th>
                    <th>Aksi</th>
    			</tr>
    		</thead>
    		<tbody>
                <?php $no=1; foreach ($list as $key) : ?>
                    <tr>
                        <td align="center"><?php echo $no ?>.</td>
                        <td><?php echo $key->judul_file ?></td>
                        <td align="center" width="20%"> 
                            <?php echo "
                                ".akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals2("Edit File","null","master/galery/edit_file/'.$key->id_file.'","width:70%")\'' )."&nbsp;
                                ".akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'if (confirm("'.$ci->lang->line("yakin").'?")) {hapus('.$key->id_file.')}\'').""; 
                            ?>
                        </td>
                    </tr>
                <?php $no++; endforeach; ?>
    		</tbody>
    	</table>
        <?php else : ?>
            <div><p>Data <?php echo $ci->lang->line('kosong') ?></p></div>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    function hapus(id)
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."master/galery/hapus_file/" ?>'+id,
            data:null,
            success:function(i)
                {
                if(i == 'ok')
                    {
                    aksi('<?php echo base_url();?>master/galery/file/<?php echo $id_galery ?>', 'modal_page');
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>