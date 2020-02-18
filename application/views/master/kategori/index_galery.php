<?php $ci =& get_instance(); $mysetting_web = $ci->template->mysetting_web();?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">list</i> <?php echo $ci->lang->line('kategori') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('Galery_Category') ?>
                    <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' '.$ci->lang->line('kategori'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("'.$ci->lang->line('tambah').' '.$ci->lang->line('kategori').'","null","master/kategori/tambah_galery","width:35%")\''); ?>
                </h2>
            </div>
            <div class="body  table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/kategori/galery?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/kategori/galery?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list_parent)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="25%"><?php echo $ci->lang->line('Kategori') ?> | Link</th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach ($list_parent as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?>.</td>
                                    <td>
                                        <a href="<?php echo base_url().'category-gallery/'.strtolower(str_replace(' ', '-', $key['nama_kategori'])).'.'.$mysetting_web->ext; ?>" target="_blank">
                                            <?php echo ucwords(str_replace('-', ' ', $key['nama_kategori'])); ?>
                                        </a> 
                                    </td>
                                    <td align="center"> 
                                        <?php echo "
                                            ".akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit Kategori","null","master/kategori/edit_galery/'.$key['id_kategori'].'")\'' )."&nbsp; 
                                            ".akses_crud(base_url('master/kategori/hapus_galery/'.$key['id_kategori']), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'')."";
                                        ?>
                                    </td>

                                <?php 
                                    if(is_array($key['child'])) 
                                        {
                                        $this->padding++;
                                        echo $ci->show_child_galery($key);
                                        $this->padding--;
                                        }
                                ?>
                                </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>

                <?php else : ?>
                    <div><p>Data <?php echo $ci->lang->line('kosong') ?></p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- #END#-->
