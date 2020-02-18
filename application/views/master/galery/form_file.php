<?php $ci =& get_instance() ?>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <form id="id_calon">
        <div class="col-md-12">
            <div class="col-md-8">
                <div class="form-group"><label><?php echo $ci->lang->line('nama') ?> File</label>
                    <div class="form-line">
                		<input type="hidden" name="id_file" value="<?php echo (!empty($dta) ? $dta->id_file : '') ?>">
                        <input type="text" name="judul_file" value="<?php echo (!empty($dta) ? $dta->judul_file : '') ?>" required class="form-control" autofocus/>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><label>Order</label>
                    <div class="form-line">
                        <input type="number" name="order" value="<?php echo (!empty($dta) ? $dta->order : '') ?>" class="form-control">
                    </div>
                </div>
            </div>            
            <div class="col-md-12">
                <div class="form-group"><label>File</label>
                    <div class="form-line">
                        <div class="input-append">
                            <a data-toggle="modal" href="javascript:;" data-target="#myModal_manager" class="btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_file') ?></a>
                            <input type="text" name="gambar" id="field_gambar" value="<?php echo (!empty($dta) && $dta->file!='/upload/') ? $dta->file : '' ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <?php foreach ($bhs as $key) : ?>
                        <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
                            <a href="#file_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <?php foreach ($bhs as $key) : ?>
                        <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="file_<?php echo $key->id_bahasa ?>">
                    		<?php $list = !empty($dta) ? $ci->get_file_list($key->id_bahasa, $dta->id_file) : '' ; ?>
                    		<input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">
			                <div class="form-group"><label>Translate <?php echo $ci->lang->line('nama') ?></label>
			                    <div class="form-line">
			                        <input type="text" name="judul_translate[<?php echo $key->id_bahasa ?>]" value="<?php echo (empty($dta) ? '' : (!empty($list->translate_judul)) ? $list->translate_judul : '') ?>" required class="form-control" autofocus/>
			                    </div>
			                </div>
			                <div class="form-group"><label>Deskripsi</label>
			                    <div>
			                        <textarea name="deskripsi_file[<?php echo $key->id_bahasa ?>]" style="width: 100%; height: 40%"><?php echo (empty($dta) ? '' : (!empty($list->translate_deskripsi)) ? $list->translate_deskripsi : '') ?></textarea>
			                    </div>
			                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

	        <td colspan='4' align="right">
	            <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo (empty($dta) ? strtoupper($ci->lang->line('simpan')) : 'UPDATE') ?></button>
	        </td>
        </div>
    </form>
</div>
</div>

<script type="text/javascript">
    function simpan()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."master/galery/simpan_file/".$id_galery ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');

                    $("#myModal2").modal("hide");

                    aksi('master/galery/file/<?php echo $id_galery ?>', 'modal_page');
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>