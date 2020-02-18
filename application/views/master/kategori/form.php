<?php $ci =& get_instance() ?>
<div class="body">
    <form id="id_calon">
    	<div class="form-group">
            <label><?php echo $ci->lang->line('judul') ?></label>
            <div class="form-line">
                <input type="hidden" name="id_kategori" value="<?php echo (!empty($dta) ? $dta->id_kategori_post : '') ?>">
                <input type="text" name="nama_kategori" onkeypress="if (event.which==13){simpan();}" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $dta->nama_kategori_post)) : '') ?>" autofocus />
            </div>
        </div>
        <div class="form-group">
            <label>Parent</label>
            <div class="form-line">
                <?php echo $ci->dropdown_parent( (!empty($dta) ? $dta->parent : null) ); ?>
            </div>
        </div>

        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($bhs as $key) : ?>
                    <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
                        <a href="#kategori_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content">
                <?php foreach ($bhs as $key) : ?> 
                <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="kategori_<?php echo $key->id_bahasa ?>">
                    <?php $list = !empty($dta) ? $ci->get_list($key->id_bahasa,$dta->id_kategori_post) : '' ; ?>

                    <input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">
                    <div class="form-group">
                        <label>Translate <?php echo $ci->lang->line('judul') ?></label>
                        <div class="form-line">
                            <input type="text" name="nama_kategori_list[<?php echo $key->id_bahasa ?>]" class="form-control input-large" value="<?php echo (empty($dta) ? '' : (!empty($list->nama_kategori_list)) ? ucwords(str_replace('-', ' ', $list->nama_kategori_list)) : '') ?>" />
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <td colspan='4' align="right">
            <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo (empty($dta) ? strtoupper($ci->lang->line('simpan')) : 'UPDATE') ?></button>
        </td>
    </form>
</div>

<script type="text/javascript">
    function simpan()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."master/kategori/simpan/" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>master/kategori/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>