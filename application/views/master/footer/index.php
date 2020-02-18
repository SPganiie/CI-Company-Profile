<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">line_weight</i> Footer</li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Footers
                    <?php //echo akses_crud(base_url('master/footer/tambah'), $ci->lang->line('tambah').' Footer', $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" '); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/footer?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/footer?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th align="10">No.</th>
                                <th>Footer</th>
                                <!-- <th><?php //echo $ci->lang->line('posisi') ?></th> -->
                                <!-- <th align="10"><?php //echo $ci->lang->line('urutan') ?></th> -->
                                <th align="10"><?php echo $ci->lang->line('aktif') ?></th>
                                <th align="10"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                            <tr>
                                <td align="center"><?php echo $no ?>.</td>
                                <td><?php echo ucwords($key->nama_footer) ?></td>
                                <!-- <td><?php //echo ucwords($key->nama_posisi) ?></td> -->
                                <!-- <td align="center"><?php //echo uang_separator($key->urutan) ?></td> -->
                                <td align="center"><?php echo ($key->aktif=='1') ? 'Y' : 'N' ?></td>
                                <td align="center">
                                    <?php echo akses_crud(base_url('master/footer/edit/'.$key->id_footer), '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit' ); ?>
                                    &nbsp;
                                    <?php //echo akses_crud(base_url('master/footer/hapus/'.$key->id_footer), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\''); ?>
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
