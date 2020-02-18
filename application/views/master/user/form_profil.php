<?php 
	$ci =& get_instance(); 
	$level = $ci->session->userdata('level'); 
    $action = 'master/user/profilku/'.$dta->id_user ;
?>
<form id="id_calon">
	<input type="hidden" name="data" value="1">
    <div class="form-group">
        <label>Level</label>
        <div><?php echo id_to_name('user_level', 'id_level', $dta->id_level, 'level') ?></div>
    </div>
	<div class="form-group">
        <label>Username</label>
        <div><?php echo $dta->username ?></div>
    </div>
    <div class="form-group">
        <label><?php echo $ci->lang->line('nama') ?></label>
        <div class="form-line">
            <input type="text" class="form-control" name="nama_user" value="<?php echo (empty($dta) ? '' : $dta->nama_user ) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label>Telp</label>
        <div class="form-line">
            <input type="text" class="form-control" name="telp" value="<?php echo (empty($dta) ? '' : $dta->telp ) ?>" />
        </div>
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <div class="form-line">
            <input type="text" class="form-control" name="email" value="<?php echo (empty($dta) ? '' : $dta->email ) ?>" />
        </div>
    </div>
    <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo strtoupper($ci->lang->line('simpan')) ?></button>
</form>
<script type="text/javascript">
    function simpan()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
            $.ajax({
                type: 'POST',
                url : '<?php echo base_url().$action ?>',
                data: $('#id_calon').serialize(),
                success:function(i)
                    {
                    if(i == 'ok')
                        {
                        alert('Data <?php echo $ci->lang->line("tersimpan") ?>');

                    	$("#myModal").modal("hide");
                        } else
                            {
                            alert(i);
                            }
                    }
                });
            }
    }
</script>