<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url('master/footer')?>"><i class="material-icons">line_weight</i> Footer</a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"><h2> <?php echo $ci->lang->line('tambah') ?> Footer </h2></div>
            <div class="body">
                <form id="id_calon">
                    <div class="col-md-12">
                        <div class="form-group"><label><?php echo $ci->lang->line('nama') ?> Footer</label>
                            <div class="form-line">
                                <input type="hidden" name="id_footer" value="<?php echo (!empty($dta) ? $dta->id_footer : '') ?>">
                                <input type="text" class="form-control" name="nama_utama_footer" value="<?php echo empty($dta) ? '' : $dta->nama_footer ?>" autofocus/>
                            </div>
                        </div>
                    </div><!-- 
                    <div class="col-md-6">
                        <div class="form-group"><label><?php echo $ci->lang->line('gambar') ?> Footer</label>
                            <div class="form-line">
                                <div class="input-append">
                                    <a data-toggle="modal" href="javascript:;" data-target="#myModal_manager" class="btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_gambar') ?></a>
                                    <input type="text" name="gambar" id="field_gambar" value="<?php echo (!empty($dta) ? $dta->gambar_footer : '') ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div> 
                    -->
                    <!--  
                    <div class="col-md-4">                    
                        <div class="form-group"><label><?php echo $ci->lang->line('posisi') ?></label>                     
                            <div class="form-line"><?php echo form_dropdown('id_posisi',$_dropdown_posisi, (!empty($dta) ? $dta->id_posisi : '' ), 'id="id_posisi" class="form-control show-tick"'); ?></div>
                        </div>
                        <div class="form-group"><label><?php echo $ci->lang->line('urutan') ?></label>
                            <div class="form-line" style="width:30%">
                                <input type="number" class="form-control" name="urutan" value="<?php echo empty($dta) ? '' : $dta->urutan ?>" />
                            </div>
                        </div>
                        <div class="form-group"><label><?php echo $ci->lang->line('aktif') ?></label>
                            <div class="box-category">                                    
                                <div class="form-group">
                                    <input type="radio" name="aktif" id="Y" value="1" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='1') ? 'checked' : 'checked') ?> ><label for="Y">Y</label>
                                    <input type="radio" name="aktif" id="N" value="0" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='0') ? 'checked' : '') ?>><label for="N" class="m-l-20">N</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->

                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($bhs as $key) : ?>
                                <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
                                    <a href="#footer_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($bhs as $key) : ?> 
                            <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="footer_<?php echo $key->id_bahasa ?>">
                                <?php $list = !empty($dta) ? $ci->get_list($key->id_bahasa,$dta->id_footer) : '' ; ?>
                                <input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">

                                <div class="form-group"><label>Translate <?php echo $ci->lang->line('nama') ?> Footer</label>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama_footer[<?php echo $key->id_bahasa ?>]" value="<?php echo empty($dta) ? '' : (!empty($list->nama_footer_list)) ? $list->nama_footer_list : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group"><label><?php echo $ci->lang->line('konten') ?></label>
                                    <textarea id="myeditor" name="konten[<?php echo $key->id_bahasa ?>]" class="myeditor" style="height:35%"><?php echo empty($dta) ? '' : (!empty($list->konten_footer)) ? $list->konten_footer : '' ?></textarea>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <a href="<?php echo base_url() ?>master/footer" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
                    <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo (empty($dta) ? strtoupper($ci->lang->line('simpan')) : 'UPDATE') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Load again for mobile -->
<script src="<?php echo base_url()?>assets/plugins/tinymce/tinymce.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: ".myeditor",
        theme: "modern",
        plugins: [
            "autoresize advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor code fullscreen"  
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor emoticons | print preview code fullscreen",
        menubar:false,
        image_advtab: true ,
        relative_urls: true,
        remove_script_host : true,
        document_base_url : '<?php echo base_url() ?>',
        filemanager_title:"Responsive Filemanager" ,
        external_filemanager_path:"<?php echo base_url()?>assets/plugins/filemanager/",
        filemanager_access_key:"a123",
        external_plugins: { "filemanager" : "<?php echo base_url()?>assets/plugins/filemanager/plugin.min.js"}
    });

    function simpan()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
            
            tinyMCE.triggerSave();
            
            $.ajax({
                type:'POST',
                url :'<?php echo base_url()."master/footer/simpan/" ?>',
                data:$('#id_calon').serialize(),
                success:function(i)
                    {
                    if(i == 'ok')
                        {
                        alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                        window.location.href = '<?php echo base_url() ?>master/footer/';
                        } else
                            {
                            alert(i);
                            }
                    }
                });
            }
    }
</script>

