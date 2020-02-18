<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url()?>master/galery"><i class="material-icons">assignment</i> <?php echo $ci->lang->line('Galery') ?></a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo !empty($dta) ? 'Edit' : $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"><h2> <?php echo $ci->lang->line('tambah').' '.$ci->lang->line('Galery') ?> </h2></div>
            <div class="body">
                <form id="id_calon">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group"><label><?php echo $ci->lang->line('nama').' '.$ci->lang->line('Galery') ?></label>
                                <div class="form-line">
                                    <input type="hidden" name="id_galery" value="<?php echo (!empty($dta) ? $dta->id_galery : '') ?>">
                                    <input type="text" name="judul_galery" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $dta->judul_galery)) : '') ?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php foreach ($bhs as $key) : ?>
                                    <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
                                        <a href="#galery_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="tab-content">
                                <?php foreach ($bhs as $key) : ?> 
                                <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="galery_<?php echo $key->id_bahasa ?>">                           
                                    
                                    <?php $list = !empty($dta) ? $ci->get_list($key->id_bahasa,$dta->id_galery) : '' ; ?>
                                    <input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">

                                    <div class="form-group"><label>Translate <?php echo $ci->lang->line('judul') ?></label>
                                        <div class="form-line">
                                            <input type="text" id="judul" name="translate_judul_galery[<?php echo $key->id_bahasa ?>]" value="<?php echo (empty($dta) ? '' : (!empty($list->translate_judul_galery)) ? ucwords(str_replace('-', ' ', $list->translate_judul_galery)) : '') ?>" maxlength="80" class="form-control" autofocus/>
                                        </div>
                                    </div>
                                    <div class="form-group"><label>Translate <?php echo $ci->lang->line('konten') ?></label>
                                        <textarea id="myeditor" name="translate_konten_galery[<?php echo $key->id_bahasa ?>]" class="myeditor" style="height:100px"><?php echo (empty($dta) ? '' : (!empty($list->translate_konten_galery)) ? $list->translate_konten_galery : '') ?></textarea>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"><label><?php echo $ci->lang->line('Kategori') ?></label>
                                <div class="box-category">
                                <ul class="list-unstyled">
                                    <?php foreach ($kategori as $key) : ?>
                                        <?php $kat = !empty($dta) ? $ci->cek_galery_kat($dta->id_galery, $key['id_kategori']) : null ?>
                                        <li>
                                            <input type="checkbox" id="checkbox_<?php echo $key['id_kategori'] ?>" name="ak_list[<?php echo $key['id_kategori'] ?>]" value="<?php echo $key['id_kategori'] ?>" class="filled-in" <?php echo ($kat==null) ? '' : ($kat=='1') ? 'checked' : ''  ?> /> 
                                            <label for="checkbox_<?php echo $key['id_kategori'] ?>"><?php echo ucwords(str_replace('_', ' ', $key['nama_kategori'])) ?></label>

                                            <?php 
                                                if(is_array($key['child'])) 
                                                    {
                                                    $this->padding++;
                                                    echo $ci->show_child($key);
                                                    $this->padding--;
                                                    }
                                            ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group"><label><?php echo $ci->lang->line('aktif') ?></label>
                                <div class="box-category">
                                    <div class="form-group">
                                        <input type="radio" name="aktif" id="aktif_Y" value="1" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='1') ? 'checked' : 'checked') ?>><label for="aktif_Y">Y</label>
                                        <input type="radio" name="aktif" id="aktif_N" value="0" class="with-gap" <?php echo (empty($dta) ? '' : ($dta->aktif=='0') ? 'checked' : '') ?>><label for="aktif_N">N</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo base_url() ?>master/galery" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
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

    document.querySelector('form').onkeypress = checkEnter;
    function checkEnter(e)
    {
        e = e || event;
        var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
        return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
    }

    function simpan()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
            
            tinyMCE.triggerSave();

            if ($('#id_galery').val() == '')
                {
                cek_judul()
                } else
                    {
                    submit_data()
                    }            
            }
    }

    function cek_judul()
    {
        $.ajax({
            type:'GET',
            url :'<?php echo base_url() ?>master/galery/cek_judul/',
            data:{'judul':$('#judul').val()},
            success:function(i)
                {
                if(i == '0')
                    {
                    submit_data();
                    } else
                        {
                        alert('<?php echo $ci->lang->line("judul_sudah") ?>!');
                        }
                }
            });
    }

    function submit_data()
    {
        $.ajax({
            type:'POST',
            url :'<?php echo base_url()."master/galery/simpan/" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>master/galery/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>