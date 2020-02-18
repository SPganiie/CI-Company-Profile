<?php 
$ci =& get_instance();
$editor = isset($_GET['editor']) ? $_GET['editor'] : '';
$on = $ci->lang->line('tambah').' '.$ci->lang->line('halaman').' - <a href="?editor=off">'.$ci->lang->line('non_editor').'</a>';
$off = $ci->lang->line('tambah').' '.$ci->lang->line('halaman').' - <a href="?editor=on">'.$ci->lang->line('editor').'</a>';
$title_page = $editor=='off' ? $off : $on;
$tipe = $editor=='off' ? 'c' : 't';
?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url()?>master/halaman"><i class="material-icons">assignment</i> <?php echo $ci->lang->line('halaman') ?></a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header"><h2> <?php echo $title_page; ?> </h2> 
			</div>
            <div class="body">
                <form id="id_calon">
				<input type="hidden" name="tipe" value="<?php echo $tipe;?>">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <div class="form-group"><label><?php echo $ci->lang->line('nama_page') ?></label>
                                <div class="form-line">
                                    <input type="hidden" name="id_halaman" value="<?php echo (!empty($dta) ? $dta->id_halaman : '') ?>">
                                    <input type="text" name="nama_halaman" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $dta->nama_halaman)) : '') ?>" class="form-control">
									<input type="hidden" name="penulis_halaman" value="<?php echo $this->session->userdata('nama_user');?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group"><label>Meta Title</label>
                                <div class="form-line">
                                    <input type="text" name="judul_utama" value="<?php echo (!empty($dta) ? $dta->judul_seo : '') ?>" required class="form-control" autofocus/>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-4">
                        <div class="form-group">
						<label>Meta Keyword</label>
                            <div class="form-line">
                                <input type="text" name="meta_keyword" value="<?php echo (!empty($dta) ? $dta->meta_keyword : '') ?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
						<div class="form-group"><label>Meta Description</label>
							<div class="form-line">
								<input type="text" name="meta_description" value="<?php echo (!empty($dta) ? $dta->meta_description : '') ?>" class="form-control" />
							</div>
						</div> 
                    </div>
                        <div class="col-md-9">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php foreach ($bhs as $key) : ?>
                                    <li role="presentation" <?php echo ($key->id_bahasa=='1') ? 'class="active"' : '' ?> >
                                        <a href="#halaman_<?php echo $key->id_bahasa ?>" data-toggle="tab"><?php echo ucwords($key->bahasa) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="tab-content">
                                <?php foreach ($bhs as $key) : ?> 
                                <div role="tabpanel" class="tab-pane fade <?php echo ($key->id_bahasa=='1') ? 'in active' : '' ?>" id="halaman_<?php echo $key->id_bahasa ?>">                           
                                    
                                    <?php $list = !empty($dta) ? $ci->get_list($key->id_bahasa,$dta->id_halaman) : '' ; ?>
                                    <input type="hidden" name="id_bhs[<?php echo $key->id_bahasa ?>]" value="<?php echo $key->id_bahasa ?>">

                                    <div class="form-group"><label><?php echo $ci->lang->line('judul') ?></label>
                                        <div class="form-line">
                                            <input type="text" id="judul" name="judul_halaman[<?php echo $key->id_bahasa ?>]" value="<?php echo (empty($dta) ? '' : (!empty($list->judul_halaman)) ? $list->judul_halaman : '') ?>" maxlength="80" class="form-control" autofocus/>
                                        </div>
                                    </div>
                                    <div class="form-group"><label><?php echo $ci->lang->line('konten') ?></label>
                                        <textarea id="myeditor" name="konten[<?php echo $key->id_bahasa ?>]" class="myeditor" style="height:500px;<?php echo $editor=='off' ? 'width:100%;' : '';?>"><?php echo (empty($dta) ? '' : (!empty($list->konten_halaman)) ? $list->konten_halaman : '') ?></textarea>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="col-md-3">           
                            <div class="form-group"><label>Tag</label>
                                <div class="bootstrap-tagsinput"><input type="text" placeholder="" size="1"></div>
                                <div class="form-line">
                                    <input type="text" name="tag" value="<?php echo (!empty($dta) ? $dta->tag : '') ?>" data-role="tagsinput" style="display: none;" class="form-control input-medium">
                                </div>
                            </div> 

                            <div class="form-group"><label><?php echo $ci->lang->line('gambar') ?></label>
                                <div class="form-line">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal_manager" class="btn btn-warning" type="button"><?php echo $ci->lang->line('pilih_gambar') ?></a>
                                        <input type="text" name="gambar" id="field_gambar" value="<?php echo (!empty($dta) ? $dta->gambar_page : '') ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                    </div>
                    
                    <a href="<?php echo base_url() ?>master/halaman" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
                    <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo (empty($dta) ? strtoupper($ci->lang->line('simpan')) : 'UPDATE') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if($editor!='off')
{
?>
<!-- Load again for mobile -->
<script src="<?php echo base_url()?>assets/plugins/tinymce/tinymce.js"></script>
<?php
}
?>
<script type="text/javascript">
<?php
if($editor!='off')
{
?>
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
<?php
}
?>
    function simpan()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
<?php
if($editor!='off')
{
?>            
            tinyMCE.triggerSave();
<?php
}
?>
            if ($('#id_halaman').val() == '')
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
            url :'<?php echo base_url() ?>master/halaman/cek_judul/',
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
            url :'<?php echo base_url()."master/halaman/simpan/" ?>',
            data:$('#id_calon').serialize(),
            success:function(i)
                {
                if(i == 'ok')
                    {
                    alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                    window.location.href = '<?php echo base_url() ?>master/halaman/';
                    } else
                        {
                        alert(i);
                        }
                }
            });
    }
</script>