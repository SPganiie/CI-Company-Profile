    <?php $ci =& get_instance();  $action_umum = 'pengaturan/pengaturan_web/update?a=umum'; echo form_open($action_umum, 'id="id_calon_umum" class="form-horizontal"');  ?>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="nama_website" class="pull-left"><?php echo $ci->lang->line('nama_web') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="nama_web" value="<?php echo $dta->nama_web ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="nama_website" class="pull-left">Tagline Web</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="deskripsi_web" value="<?php echo $dta->deskripsi_web ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="deskripsi-meta" class="pull-left">Meta Deskripsi</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <textarea name="meta_deskripsi" class="form-control"><?php echo $dta->meta_deskripsi ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="keyword-meta" class="pull-left">Meta Keyword</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="meta_keyword" value="<?php echo $dta->meta_keyword ?>" class="form-control"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="pemilik-web" class="pull-left"><?php echo $ci->lang->line('pemilik_web') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="pemilik" value="<?php echo $dta->pemilik ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="email-pemilik-web" class="pull-left">Email</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="email" value="<?php echo $dta->email ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="email_pass" class="pull-left">Email Password</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" name="email_pass" value="" placeholder="Password encrypted, type for change password" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="telepon-pemilik-web" class="pull-left">Telp</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="telp" value="<?php echo $dta->telp ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="wa-pemilik-web" class="pull-left">Whatsapp</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="wa" name="wa" value="<?php echo $dta->wa ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="alamat-pemilik-web" class="pull-left"><?php echo $ci->lang->line('alamat') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <textarea name="alamat" class="form-control"><?php echo $dta->alamat ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="latitude" class="pull-left">Latidude</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="latitude" value="<?php echo $dta->latitude ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="langitude" class="pull-left">Langitude</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="langitude" value="<?php echo $dta->langitude ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="url_facebook" class="pull-left">Url Facebook</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="url_facebook" value="<?php echo $dta->url_facebook ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="url_twitter" class="pull-left">Url Twitter</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="url_twitter" value="<?php echo $dta->url_twitter ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="url_youtube" class="pull-left">Url Youtube</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="url_youtube" value="<?php echo $dta->url_youtube ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="url_instagram" class="pull-left">Url Instagram</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="url_instagram" value="<?php echo $dta->url_instagram ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-offset-1">
                <?php echo form_input(array('value'=>'UPDATE', "type"=>"button","style"=>"border:0px;", 'class'=>'btn btn-primary btn-small waves-effect', "onclick"=>"if(confirm('".$ci->lang->line('yakin')."?')) simpan_umum()")); ?>
            </div>
        </div>
    <?php echo form_close(); ?>

<script type="text/javascript">
    function simpan_umum()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url().$action_umum ?>',
            data:$('#id_calon_umum').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>pengaturan/pengaturan_web/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>