<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li><a href="<?php echo base_url()?>master/product"><i class="material-icons">comment</i> <?php echo $ci->lang->line('Inquiry') ?></a></li>
        <li class="active"><i class="material-icons">add_circle</i> <?php echo $ci->lang->line('tambah') ?></li>
    </ol>
</div>
<div class="card">
    <div class="header"><h2> <?php echo $ci->lang->line("balas").' '.$ci->lang->line('Inquiry') ?></h2></div>
    <div class="body">
        <form id="id_calon">
        <div>               
        	<div class="form-group">
                <label><?php echo $ci->lang->line('Product') ?></label>
                <div class="form-line">
                    <input type="hidden" name="id_product" value="<?php echo (!empty($dta) ? $dta->id_product : '') ?>">
                    <input type="text" name="product" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords(str_replace('-', ' ', $dta->judul_seo_product)) : '') ?>" readonly/>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo $ci->lang->line('nama') ?></label>
                <div class="form-line">
                    <input type="text" name="nama" class="form-control input-large" value="<?php echo (!empty($dta) ? ucwords($dta->nama) : '') ?>"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telp</label>
                    <div class="form-line">
                        <input type="text" name="telp" class="form-control input-large" value="<?php echo (!empty($dta) ? $dta->telp : '') ?>"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>E-mail</label>
                    <div class="form-line">
                        <input type="text" name="email" class="form-control input-large" value="<?php echo (!empty($dta) ? $dta->email : '') ?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Note</label>
                <div class="form-line">
                    <textarea name="inquiry" class="form-control input-large" ><?php echo (!empty($dta) ? $dta->note_inquiry : '') ?></textarea>
                </div>
            </div>
            <?php if ((!empty($dta)) && ($dta->id_parent=='0')) : ?>   
                <div class="form-group">
                    <label><?php echo $ci->lang->line('balasan') ?></label>
                    <div class="form-line"><textarea name="inquiry_balasan" class="form-control input-large" autofocus></textarea> </div>
                </div>
            <?php endif; ?>
            <a href="<?php echo base_url() ?>master/inquiry" class="btn btn-danger waves-effect"><?php echo strtoupper($ci->lang->line('batal')) ?></a>
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
                url :'<?php echo base_url()."master/inquiry/simpan_balas/".$dta->id_inquiry ?>',
                data:$('#id_calon').serialize(),
                success:function(i)
                    {
                    if(i == 'ok')
                        {
                        alert('Data <?php echo $ci->lang->line("tersimpan") ?>');
                        window.location.href = '<?php echo base_url() ?>master/inquiry/';
                        } else
                            {
                            alert(i);
                            }
                    }
                });
            }
    }
</script>