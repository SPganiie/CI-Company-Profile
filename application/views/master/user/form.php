<?php $ci =& get_instance(); $level = $ci->session->userdata('level'); ?>

<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url()?>master/user"><i class="material-icons">perm_identity</i> <?php echo $ci->lang->line('User') ?></a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo !empty($dta) ? 'Edit' : $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">
                <?php 
                    $action = !empty($dta) ? 'master/user/edit_simpan/'.$dta->id_user : 'master/user/tambah_simpan' ;
                ?>
                <form id="id_calon">
                    <div class="form-group">
                        <label>Level</label>                     
                        <div class="form-line"><?php echo form_dropdown('level',$_dropdown_level, (!empty($dta) ? $dta->id_level : '' ), 'id="f_level" class="form-control show-tick"'); ?></div>
                    </div>
                	<div class="form-group">
                        <label>Username <?php echo (!empty($dta) ? ' : <b>'.$dta->username.'</b>' : '') ?></label>
                        <div class="form-line" <?php echo !empty($dta) ? 'style="display:none;"' : '' ?> >
                            <input type="text" class="form-control input-medium" name="username" maxlength="15" minlength="5" <?php echo (!empty($dta) ? 'readonly="readonly" style="color: #a9a3a3;"  placeholder="* username '.$ci->lang->line('edit_username').'"' : '') ?> value="<?php echo (empty($dta) ? '' : $dta->username ) ?>"/> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="form-line">
                            <input type="password" class="form-control" id="password" name="password" maxlength="20" minlength="5" onkeyup="konfirmasi()" <?php echo ((!empty($dta) && ($level!='1')) ? 'readonly="readonly" placeholder="* password '.$ci->lang->line('edit_user').'"' : ((!empty($dta)) && ($level=='1')) ? 'placeholder="* '.$ci->lang->line('edit_abaikan').'"' : '') ?> />
                        </div>
                    </div>
                    <div class="form-group" id="konfirm_pass">
                        <label><?php echo $ci->lang->line('konf_pass') ?></label>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_konfirmasi" maxlength="20" minlength="5" <?php echo ((!empty($dta) && ($level!='1')) ? 'readonly="readonly" placeholder="* password '.$ci->lang->line('edit_user').'"' : ((!empty($dta)) && ($level=='1')) ? 'placeholder="* '.$ci->lang->line('edit_abaikan').'"' : '') ?> />
                        </div>
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

                    <?php if (($level=='1') || (empty($dta))) : ?>
                        <div class="form-group">
                            <label>Status</label>
                            <div class="box-category">                                    
                                <div class="form-group">
                                    <input type="radio" name="status" id="Y" value="1" class="with-gap" <?php echo (empty($dta)) ? 'checked' : ($dta->status=='1') ? 'checked' : '' ?> ><label for="Y">Y</label>
                                    <input type="radio" name="status" id="N" value="0" class="with-gap" <?php echo (empty($dta)) ? '' : ($dta->status=='0') ? 'checked' : '' ?> ><label for="N" class="m-l-20">N</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                        
                    <a href="<?php echo base_url() ?>master/user" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
                    <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo (empty($dta) ? strtoupper($ci->lang->line('simpan')) : 'UPDATE') ?></button>
	            </form>
            </div>
        </div>
    </div>
</div>

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
                        window.location.href = '<?php echo base_url() ?>master/user/';
                        } else
                            {
                            alert(i);
                            }
                    }
                });
            }
    }
</script>


