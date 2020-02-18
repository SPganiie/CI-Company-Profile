<?php $ci =& get_instance(); $set = $ci->template->mysetting_web(); ?>

<style>
  table[border="1"] { border-collapse: collapse; border:0; }
  table[border="1"] td { padding:6px 5px; border: 1px solid #99bce8; }
  table[border="0"] td {  border: 0;  }
</style>

<!-- ##Jika menu sendiri##
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">settings</i> <?php echo $ci->lang->line('Pengaturan') ?></li>
    </ol>
</div> 
-->
<!-- Table -->
<div class="row" id="ListMain"> <!--  clearfix -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div  id="b_content"> <!-- class="card" -->
            <div class="header">
              <h2>Data <?php echo $ci->lang->line('Menu Website') ?>
                <?php echo akses_crud('javascript:void(0)', $ci->lang->line('tambah').' Menu', $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("'.$ci->lang->line('tambah').' '.$ci->lang->line('Menu Website').'","null","pengaturan/menu_web/tambah","width:60%")\''); ?>
              </h2>
            </div>
            <div class="body table-responsive">
              <div class="col-md-12 col-sm-12">
                <label for="posisiFind" style="float: left;"><?php echo $ci->lang->line('posisi') ?> : </label>
                <div class="col-md-4 col-sm-12"><?php echo form_dropdown('', $drop_posisi, $posisi, 'id="posisiFind" class="form-control show-tick"'); ?></div>
              </div>
            <?php if ($list_parent=='NULL') : ?>
              <p>Data Menu <?php echo $ci->lang->line('kosong') ?></p>
            <?php else : ?>
              <table width="100%" class="table table-bordered table-striped table-hover ">
                <thead>  
                  <tr>
                    <th width='30' align="center">No</th>
                    <th>Menu</th>
                    <th>URL</th>
                    <th width=70>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $angka = 1;
                  foreach($list_parent as $key) 
                    {
                      $ext = (!empty($key['url_module'])) ? '.'.$set->ext : '';
                      echo '
                        <tr align="center" id="no_'.$key['id_module'].'">
                          <td align="center">'.$angka.'</td>
                          <td align="left">'.$key['nama_module'].'</td>
                          <td align="left"><a href="'.base_url().$key['url_module'].$ext.'" target="_blank">'.base_url().$key['url_module'].$ext.'</a></td>';
                          echo '<td>'
                                  .akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, "edit", 'title="Edit" onclick=\'ajax_modals("Edit Menu","null","pengaturan/menu_web/edit/'.$key['id_module'].'","width:60%")\'').'&nbsp;'
                                  .akses_crud("javascript:void(0)", '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, "hapus", 'title="Hapus" onclick=\'if(confirm("'.$ci->lang->line("yakin").'?")) aksi("pengaturan/menu_web/hapus/'.$key['id_module'].'", "no_'.$key['id_module'].'")\'').'
                                </td>
                        </tr>';

                      if(is_array($key['child'])) 
                        {
                        $this->padding++;
                        echo $ci->get_child($key);
                        $this->padding--;
                        }

                      $angka++;
                    }
                ?>
                </tbody>
                
              </table>
            <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('#posisiFind').change(function(){
    aksi('pengaturan/menu_web/index?posisi='+$('#posisiFind').val(), 'ListMain');
  });
</script>
<!-- #END#-->

