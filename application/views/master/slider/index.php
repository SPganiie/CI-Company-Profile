<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">list</i> <?php echo $ci->lang->line('Slider') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('Slider') ?>
                    <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' '.$ci->lang->line('Slider'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("'.$ci->lang->line('tambah').' '.$ci->lang->line('slider').'","null","master/slider/tambah","width:50%")\''); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/slider?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/slider?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th><?php echo $ci->lang->line('Slider') ?></th>
                                <th>Link</th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?></td>
                                    <td><?php echo $key->nama_slider ?></td>
                                    <td><a href="<?php echo base_url().$key->link ?>" target="_blank"><?php echo base_url().$key->link ?></a></td>
                                    <td align="center"> 
                                        <?php echo akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit slider","null","master/slider/edit/'.$key->id_slider.'","width:50%")\'' )."&nbsp;"; ?>
                                        <?php echo akses_crud(base_url('master/slider/hapus/'.$key->id_slider), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\''); ?>
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