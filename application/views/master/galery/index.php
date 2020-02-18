<?php 
    $ci =& get_instance();
    $mysetting_web = $ci->template->mysetting_web();  
?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">list</i> <?php echo $ci->lang->line('Galery') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('Galery') ?>
                    <?php echo akses_crud(base_url('/master/galery/tambah'), $ci->lang->line('tambah').' '.$ci->lang->line('Galery'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right"'); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/galery?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/galery?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th><?php echo $ci->lang->line('Galery') ?> | Link</th>
                                <th><?php echo $ci->lang->line('Kategori') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aktif') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?></td>
                                    <td><a href="<?php echo $link = base_url().'gallery/'.$key->judul_galery.'.'.$mysetting_web->ext ?>" target="_blank"><?php echo ucwords(str_replace('-', ' ', $key->judul_galery)) ?></a></td>
                                    <td width="50%">
                                    <?php 
                                        $kat = $ci->get_kategori($key->id_galery);
                                        foreach ($kat as $list) 
                                            {
                                            $kategori = str_replace('-', ' ', id_to_name('kategori_galery', 'id_kategori_galery', $list->id_kategori, 'nama_kategori_galery'));
                                            echo ucwords($kategori).", ";
                                            } 
                                    ?>
                                    </td>
                                    <td align="center"><?php echo ($key->aktif=='1') ? 'Y' : 'N' ?></td>
                                    <td align="center"> 
                                        <?php echo akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="List File Gallery">assessment</i>', $this->id_level_now, $this->id_module_now, 'edit', 'onclick=\'ajax_modals("List File Gallery","null","master/galery/file/'.$key->id_galery.'","width:60%")\'')."&nbsp;" ?>
                                        <?php echo akses_crud(base_url('master/galery/edit/'.$key->id_galery), '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','' )."&nbsp;"; ?>
                                        <?php echo akses_crud(base_url('master/galery/hapus/'.$key->id_galery), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\''); ?>
                                    </td>
                                </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                    <span><?php echo $this->mypaging->create(); ?></span>
                <?php else : ?>
                    <div><p>Data <?php echo $ci->lang->line('kosong') ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- #END#-->