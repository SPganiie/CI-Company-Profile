<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url()?>master/post"><i class="material-icons">comment</i> <?php echo $ci->lang->line('komentar') ?></a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="card">
    <div class="header"><h2> <?php echo $ci->lang->line("balas").' '.$ci->lang->line('komentar') ?></h2></div>
    <div class="body">
        <form id="id_calon">
        <div>               
        	<div class="form-group">
                <label><?php echo $ci->lang->line('post') ?></label>
                <div class="form-line">
                    <input type="hidden" name="id_post" value="<?php echo (!empty($dta) ? $dta->id_post : '') ?>">
                    <input type="text" name="post" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $dta->judul_seo_post)) : '') ?>" readonly/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?php echo $ci->lang->line('nama') ?></label>
                    <div class="form-line">
                        <input type="text" name="nama" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords($dta->nama) : '') ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>E-mail</label>
                    <div class="form-line">
                        <input type="text" name="email" class="form-control input-large" value="<?php echo (!empty($dta) ? $dta->email : '') ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo $ci->lang->line('komentar') ?></label>
                <div class="form-line">
                    <textarea name="komentar" class="form-control input-large" readonly ><?php echo (!empty($dta) ? $dta->isi_komentar : '') ?></textarea>
                </div>
            </div>            
            <div class="form-group">
                <label><?php echo $ci->lang->line('balasan') ?></label>
                <div class="form-line"><textarea name="komentar_balasan" class="form-control input-large" autofocus></textarea> </div>
            </div>
            <a href="<?php echo base_url() ?>master/komentar" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
            <button type="button" onclick="simpan()" class="btn btn-small btn-primary" style="border:0px;"><?php echo strtoupper($ci->lang->line('simpan')) ?></button>
        </div>
       </form>
    </div>
</div>

<script type="text/javascript">
    function simpan()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
            $.ajax({
                type:'POST',
                url :'<?php echo base_url()."master/komentar/simpan_balas/".$dta->id_komentar ?>',
                data:$('#id_calon').serialize(),
                success:function(i)
                    {
                    if(i == 'ok')
                        {
                        alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                        window.location.href = '<?php echo base_url() ?>master/komentar/';
                        } else
                            {
                            alert(i);
                            }
                    }
                });
            }
    }
</script>