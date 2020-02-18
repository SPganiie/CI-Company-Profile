<?php 
    $ci =& get_instance();
    $mysetting_web = $ci->template->mysetting_web();  
?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">assignment</i> <?php echo ucwords($ci->lang->line('halaman')) ?></li>
    </ol>
</div>
<!-- Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo ucwords($ci->lang->line('halaman')) ?>
                    <?php echo akses_crud(base_url('master/halaman/tambah'), $ci->lang->line('tambah').' '.$ci->lang->line('halaman'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" '); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/halaman?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/halaman?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>

                <?php if (!empty($list)) : ?> 
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="50%"><?php echo $ci->lang->line('nama_page') ?></th>
                                <th width="20%"><?php echo $ci->lang->line('penulis') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aktif') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?>.</td>
                                    <td>
                                        <a href="<?php echo base_url().'page/'.$key->nama_halaman.'.'.$mysetting_web->ext ?>" target="_blank">
                                            <?php echo ucwords(str_replace('-', ' ', $key->nama_halaman)) ?> 
                                        </a>
                                    </td>
                                    <td><?php echo ucwords($key->penulis_halaman) ?> </td>
                                    <td align="center"><?php echo ($key->aktif=='1') ? 'Y' : 'N' ?></td>
                                    <td align="center">
                                        <?php 
											$tipe = id_to_name('halaman_list','id_halaman',$key->id_halaman,'tipe');
											$link_editor = $tipe == 'c' ? '?editor=off' : '';
                                            echo akses_crud(base_url('master/halaman/edit/'.$key->id_halaman.$link_editor), '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit')."&nbsp; 
                                                ".akses_crud(base_url('master/halaman/hapus/'.$key->id_halaman), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'')."";
                                        ?>
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
