<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">settings</i> <?php echo $ci->lang->line('Pengaturan') ?></li>
    </ol>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                Data <?php echo $ci->lang->line('User Level') ?>
                <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' '.$ci->lang->line('User Level'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("'.$ci->lang->line('tambah').' '.$ci->lang->line('User Level').'","null","pengaturan/hak_akses/tambah","width:30%")\''); ?><p></p>
                </h2>
            </div>
            <div class="body">
            <table border="0" class="table table-custom table-bordered table-hover js-basic-example dataTable" >
              <thead>
                <tr >
                  <th width="30" align="center">No</th>
                  <th>Level</th>
                  <th width=130>Manage</th>
                  <th width="50"><?php echo $ci->lang->line('aksi') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $no=1;
                  foreach($_list->result() as $key) {
                    echo "
                      <tr align='center'>
                        <td align='center'>".$no."</td>
                        <td align='left'>".$key->level."</td>
                        <td>". ($key->id_level != '1' ? "<a href='javascript:void(0)' onclick=\"ajax_modals('".$ci->lang->line('atur_akses')." : ".$key->level."','null','pengaturan/hak_akses/manage/".$key->id_level."','width:60%;')\" class='ajax'>".$ci->lang->line('atur_akses')."</a>" : "<i class='material-icons'>lock</i>") ."</td>
                        <td align='center'>";

                    if ($key->id_level != '1') {
                      echo "
                          ".akses_crud('javascript:void(0)', img('assets/img/icon/edit.png'), $this->id_level_now, $this->id_module_now, 'edit','onclick=\'ajax_modals("Edit Data '.$ci->lang->line("User Level").'","null","pengaturan/hak_akses/edit/'.$key->id_level.'","width:30%;")\'' )."&nbsp; 
                          ".akses_crud(base_url('pengaturan/hak_akses/hapus/'.$key->id_level), img('assets/img/icon/trash.png'), $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'')."";
                    } else {
                      echo "<i class='material-icons'>lock</i>";
                    }

                    echo "</td>
                      </tr>
                    ";
                    $no++;
                  }
                ?>
              </tbody>
            </table>
            </div>
        </div>
    </div>
</div>