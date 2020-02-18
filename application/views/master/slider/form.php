<?php $ci =& get_instance() ?>
<div class="body">
    <form id="id_calon">
    	<div class="form-group">
            <label><?php echo $ci->lang->line('Slider') ?></label>
            <div class="form-line">
                <input type="hidden" name="id_slider" value="<?php echo (!empty($dta) ? $dta->id_slider : '') ?>">
                <input type="text" name="nama_slider" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords($dta->nama_slider) : '') ?>" autofocus />
            </div>
        </div>
        <div class="form-group">
            <label>Slider Link</label>
            <div class="form-line"> 
                <span style="float: left"><?php echo base_url() ?></span>
                <input type="text" name="link" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords($dta->link) : '') ?>" style="width: 65%;" />
            </div>
        </div>
        <div class="form-group"><label><?php echo $ci->lang->line('gambar') ?></label>
            <div class="form-line">
                <div class="input-append">
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal_manager" class="btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_gambar') ?></a>
                    <input type="text" name="gambar" id="field_gambar" value="<?php echo (!empty($dta) ? $dta->gambar : '') ?>" class="form-control">
                </div>
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
            url :'<?php echo base_url()."master/slider/simpan/" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>master/slider/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>