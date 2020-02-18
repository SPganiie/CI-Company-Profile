<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a> </li>
        <li class="active"><i class="material-icons">perm_identity</i> <?php echo $ci->lang->line('User') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('User') ?>
                    <?php echo akses_crud(base_url("pengaturan/hak_akses"), 'Level Akses', $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-red waves-effect pull-right" '); ?>
                    <?php echo akses_crud(base_url("master/user/tambah"), $ci->lang->line('tambah').' '.$ci->lang->line('User'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" '); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered table-hover"> 
                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th width="120"><?php echo $ci->lang->line('nama') ?></th>
                            <th width="120">Username</th>
                            <th width="120">Level</th>
                            <th width="100">Telp</th>
                            <th width="150">E-mail</th>
                            <th width="50"><?php echo $ci->lang->line('aktif') ?></th>
                            <th align='center' width="50"><?php echo $ci->lang->line('aksi') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=$this->mypaging->nomor(); foreach($list as $key) :  ?>
                        <tr align="center" id="b_<?php echo $no; ?>">
                            <td><?php echo $no; ?>.</td>
                            <td align="left"><?php echo $key->nama_user; ?></td>
                            <td align="left"><?php echo $key->username; ?></td>
                            <td align="left"><?php echo id_to_name('user_level', 'id_level', $key->id_level, 'level'); ?></td>
                            <td align="left"><?php echo $key->telp; ?></td>
                            <td align="left"><?php echo $key->email; ?></td>
                            <td align="center"><?php echo ($key->status == '1' ? 'Y' : 'N'); ?></td>
                            <td align='center'>
                            <?php echo akses_crud(base_url('master/user/edit/'.$key->id_user), '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit Data User","null","master/user/edit/'.$key->id_user.'")\'')."&nbsp;" ?>
                            <?php echo ($key->id_level=='1') ? '<i class="material-icons md-18" style="color:#000">lock</i>' : akses_crud('javascript:void(0);', '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'if (confirm("'.$ci->lang->line("yakin").'?")) aksi("master/user/hapus/'.$key->id_user.'", "b_'.$no.'")\'') ?>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
                <span><?php echo $this->mypaging->create(); ?></span>
            </div>
        </div>
    </div>
</div>
<!-- #END#-->
