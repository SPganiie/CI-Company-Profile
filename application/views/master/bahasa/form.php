<?php $ci =& get_instance() ?>
<div class="body">
    <form id="id_calon">
    	<div class="form-group">
            <label><?php echo $ci->lang->line('Bahasa') ?></label>
            <div class="form-line">
                <input type="hidden" name="id_bahasa" value="<?php echo (!empty($dta) ? $dta->id_bahasa : '') ?>">
                <input type="text" name="nama_bahasa" onkeypress="if (event.which==13){simpan();}" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords($dta->bahasa) : '') ?>" autofocus />
            </div>
        </div>                 
        <div class="form-group" <?php echo (empty($dta) ? '' : ($dta->id_bahasa=='1') ? 'hidden="true"' : '') ?> >
            <label><?php echo $ci->lang->line('aktif') ?></label>
            <div class="box-category">                                    
                <div class="form-group">
                    <input type="radio" name="aktif" id="Y" value="1" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='1') ? 'checked' : 'checked') ?>><label for="Y">Y</label>
                    <input type="radio" name="aktif" id="N" value="0" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='0') ? 'checked' : '') ?> ><label for="N" class="m-l-20">N</label>
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
            url :'<?php echo base_url()."master/bahasa/simpan/" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>master/bahasa/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>