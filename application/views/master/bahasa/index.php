<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">list</i> <?php echo $ci->lang->line('Bahasa') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('Bahasa') ?>
                    <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' '.$ci->lang->line('Bahasa'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("'.$ci->lang->line('tambah').' '.$ci->lang->line('bahasa').'","null","master/bahasa/tambah","width:35%")\''); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/bahasa?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/bahasa?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="25%"><?php echo $ci->lang->line('Bahasa') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aktif') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?></td>
                                    <td>
                                        <?php echo ucwords($key->bahasa) ?>
                                    </td>
                                    <td align="center"><?php echo ($key->aktif=='1') ? 'Y' : 'N' ?></td>
                                    <td align="center"> 
                                        <?php echo akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit bahasa","null","master/bahasa/edit/'.$key->id_bahasa.'")\'' )."&nbsp;"; ?>
                                        <?php echo ($key->id_bahasa!='1') ? akses_crud(base_url('master/bahasa/hapus/'.$key->id_bahasa), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'') : '<i class="material-icons md-18" style="color:#000">lock</i>' ; ?>
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
