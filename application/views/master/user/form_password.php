<?php 
	$ci =& get_instance(); 
	$level = $ci->session->userdata('level'); 
    $action = 'master/user/passwordku/'.$dta->id_user ;
?>
<form id="id_calon">
	<input type="hidden" name="data" value="1">
    <div class="form-group">
        <label><?php echo $ci->lang->line('nama') ?></label>
        <div><?php echo ucwords($dta->nama_user) ?></div>
    </div>
    <div class="form-group">
        <label>Username</label>
        <div><?php echo $dta->username ?></div>
    </div>
    <div class="form-group">
        <label><?php echo $ci->lang->line('new_pass') ?></label> 
        <div class="form-line">
            <input type="password" class="form-control" id="password" name="password" maxlength="20" minlength="5" onkeyup="konfirmasi()"/>
        </div>
    </div>
    <div class="form-group" id="konfirm_pass">
        <label><?php echo $ci->lang->line('konf_pass') ?></label>
        <div class="form-line">
            <input type="password" class="form-control" name="password_konfirmasi" maxlength="20" minlength="5" />
        </div>
    </div>
    <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo strtoupper($ci->lang->line('simpan')) ?></button>
</form>

<script type="text/javascript">
    
    jQuery(document).ready(function() {
        konfirmasi();
    });

    function konfirmasi()
    {
        if ($('#password').val()!='') {
            $('#konfirm_pass').css('display', 'block');
        } else {
            $('#konfirm_pass').css('display', 'none');
        }
    }

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