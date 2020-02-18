<?php $ci =& get_instance();  $action = 'pengaturan/pengaturan_web/update?a=konfig'; echo form_open($action, 'id="id_calon_konfig" class="form-horizontal"');  ?>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('bhs_admin') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div>
                        <select class="form-control" name="bahasa_admin">
                        <?php foreach ($list_bahasa as $list) : ?>
                        	<option value="<?php echo $list->id_bahasa;?>" <?php echo ($list->id_bahasa==$id_bahasa) ? 'selected' : '' ?> > <?php echo $list->bahasa;?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('bhs_web') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <div>
                        <select class="form-control" name="bahasa_web">
                        <?php foreach ($list_bahasa as $list) : ?>
                        	<option value="<?php echo $list->id_bahasa;?>" <?php echo ($list->id_bahasa==$id_bahasa2) ? 'selected' : '' ?> > <?php echo $list->bahasa;?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('zona_time') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                <div >
                    <select class="form-control" data-live-search="true" name="zona_waktu">
                    	<?php $zona_now = str_replace('_', ' ', $dta->zona_waktu);  ?>
                        <?php foreach ($zona_waktu as $key => $list) : ?>
                        	<option value="<?php echo $list['val'] ?>" <?php echo ($list['val']==$zona_now) ? 'selected' : '' ?> > <?php echo $list['show'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('Kategori') ?> Top Slider</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                <div >
                    <select class="form-control" data-live-search="true" name="id_kategori_top">
                        <option value=""><?php echo $ci->lang->line('pilih').' '.$ci->lang->line('Kategori') ?></option>
                        <?php foreach ($list_kategori as $key => $list) : ?>
                            <option value="<?php echo $list->id_kategori_post;?>" <?php echo ($list->id_kategori_post==$dta->id_kategori_top) ? 'selected' : '' ?>> <?php echo $list->nama_kategori_list;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('kategori_samping_atas') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                <div >
                    <select class="form-control" data-live-search="true" name="id_kategori_topside">
                        <option value=""><?php echo $ci->lang->line('pilih').' '.$ci->lang->line('kategori_samping_atas') ?></option>
                        <?php foreach ($list_kategori as $key => $list) : ?>
                            <option value="<?php echo $list->id_kategori_post;?>" <?php echo ($list->id_kategori_post==$dta->id_kategori_topside) ? 'selected' : '' ?>> <?php echo $list->nama_kategori_list;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('kategori_footer') ?> 1</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                <div >
                    <select class="form-control" data-live-search="true" name="id_kategori_footer1">
                        <option value=""><?php echo $ci->lang->line('pilih').' '.$ci->lang->line('Kategori') ?></option>
                        <?php foreach ($list_kategori as $key => $list) : ?>
                            <option value="<?php echo $list->id_kategori_post;?>" <?php echo ($list->id_kategori_post==$dta->id_kategori_footer1) ? 'selected' : '' ?>> <?php echo $list->nama_kategori_list;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('kategori_footer') ?> 2</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                <div >
                    <select class="form-control" data-live-search="true" name="id_kategori_footer2">
                        <option value=""><?php echo $ci->lang->line('pilih').' '.$ci->lang->line('Kategori') ?></option>
                        <?php foreach ($list_kategori as $key => $list) : ?>
                            <option value="<?php echo $list->id_kategori_post;?>" <?php echo ($list->id_kategori_post==$dta->id_kategori_footer2) ? 'selected' : '' ?>> <?php echo $list->nama_kategori_list;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="nama_website" class="pull-left">Favicon Web</label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <img src="<?php echo $dta->url_favicon ?>" style="height:50px">
                    <input type="text" name="gambar" id="field_gambar" value="<?php echo (!empty($dta) ? $dta->url_favicon : '') ?>" class="form-control" readonly="">
                </div>
                <div class="form-group col-md-6">
                    <a href="#myModal_manager" data-toggle="modal" data-for="field_gambar" data-tp="1" data-target="#myModal_manager" class="btngambar btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_gambar') ?></a>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="nama_website" class="pull-left"><?php echo $ci->lang->line('logo_web') ?></label>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <div class="form-group">
                    <img src="<?php echo $dta->logo_website ?>" style="height:50px">
                    <input type="text" name="gambar_logo" id="gambar_logo" value="<?php echo (!empty($dta) ? $dta->logo_website : '') ?>" class="form-control" readonly="">
                </div>
                <div class="form-group col-md-6">
                    <a href="#myModal_manager" data-toggle="modal" data-for="gambar_logo" data-tp="1" data-target="#myModal_manager" class="btngambar btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_gambar') ?></a>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left">Mode Maintenance</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                        <input type="radio" name="maintenance" id="Y" value="1" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->maintenance=='1') ? 'checked' : 'checked') ?>><label for="Y">Y</label>
                        <input type="radio" name="maintenance" id="N" value="0" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->maintenance=='0') ? 'checked' : '') ?>><label for="N" class="m-l-20">N</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left"><?php echo $ci->lang->line('exten_halaman') ?></label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="ext" value="<?php echo empty($dta) ? 'html' : strtolower($dta->ext); ?>" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left">Link <?php echo $ci->lang->line('set_halaman_news') ?></label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="page_news" value="<?php echo empty($dta) ? '' : strtolower(str_replace(' ', '-', $dta->page_news)); ?>" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left">Width Image Thumbs</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                    <div class="form-line">
                        <input type="number" name="width_tumbs" value="<?php echo empty($dta) ? '' : $dta->width_tumbs; ?>" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left">Height Image Thumbs</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                    <div class="form-line">
                        <input type="number" name="height_tumbs" value="<?php echo empty($dta) ? '' : $dta->height_tumbs; ?>" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label class="pull-left">Link Admin</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 ">
                <div class="box-category">                                    
                    <div class="form-group">
                    <div class="form-line">
                        <input type="text" name="admin_link" value="<?php echo empty($dta) ? '' : $dta->admin_link; ?>" class="form-control">
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-offset-1">
                <?php echo form_input(array('value'=>'UPDATE', "type"=>"button","style"=>"border:0px;", 'class'=>'btn btn-primary btn-small waves-effect', "onclick"=>"if(confirm('".$ci->lang->line('yakin')."?')) simpan_konfig()")); ?>
            </div>
        </div>
<?php echo form_close(); ?>

<script type="text/javascript">
    function simpan_konfig()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url().$action ?>',
            data:$('#id_calon_konfig').serialize(),
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
