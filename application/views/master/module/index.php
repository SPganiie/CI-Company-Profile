<?php $ci =& get_instance(); ?>

<style>
  table[border="1"] { border-collapse: collapse; border:0; }
  table[border="1"] td { padding:6px 5px; /*border: 0; border-bottom: 1px solid #ddd;*/ border: 1px solid #99bce8; }
  table[border="0"] td {  border: 0;  }
</style>

<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">settings</i> Pengaturan</li>
    </ol>
</div>
<!-- Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
              <h2>MODULE
                <?php echo akses_crud('javascript:void(0)', 'Tambah Module', $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" onclick=\'ajax_modals("Tambah Module Baru","null","master/module/tambah","width:35%")\''); ?>
              </h2>
            </div>
            <div class="body">
            <table width="100%" class="table table-bordered table-striped table-hover ">
              <thead>  
                <tr>
                  <th width='30' align="center">No</th>
                  <th>Modul</th>
                  <th width="40" align="center">Icon</th>
                  <th>URL</th>

                  <?php foreach ($list as $key) : ?>
                   <th><?php echo ucwords($key->aksi); ?></th>
                  <?php endforeach; ?>

                  <th width=70>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $on   = img('assets/img/icon/active16.png');
                $off  = img('assets/img/icon/delete16.png');

                $angka = 1;

                foreach($list_parent as $key) {
                  echo '
                    <tr align="center" id="no_'.$key['id_module'].'">
                      <td align="center">'.$angka.'</td>
                      <td align="left">'.$key['nama_module'].'</td>
                      <td align="center"><i class="material-icons">'.$key['icon_module'].'</i></td>
                      <td align="left">'.$key['url_module'].'</td>';

                      foreach ($list as $keys) :
                        $cek_module = $ci->cek_module($key['id_module'], $keys->id_aksi); 
                        $link       = '<a href="javascript:void(0)" onClick=\'aksi("master/module/toggle_active/'.$cek_module.'/'.$key['id_module'].'/'.$keys->id_aksi.'", "link_'.$key['id_module'].'_'.$keys->id_aksi.'")\'>'.($cek_module == '0' ? $off : $on).'</a>';
                        echo '<td id="link_'.$key['id_module'].'_'.$keys->id_aksi.'">'.$link.'</td>';
                      endforeach;

                      echo '<td>'
                              .akses_crud('javascript:void(0)', '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, "edit", 'title="Edit" onclick=\'ajax_modals("Edit Module","null","master/module/edit/'.$key['id_module'].'","width:35%")\'').'&nbsp;'
                              .akses_crud("javascript:void(0)", '<i class="material-icons md-18" style="color:#000" title="Hapus">delete_forever</i>', $this->id_level_now, $this->id_module_now, "hapus", 'title="Hapus" onclick=\'if(confirm("Hapus data ini ?")) aksi("master/module/hapus/'.$key['id_module'].'", "no_'.$key['id_module'].'")\'').'
                            </td>
                    </tr>
                  ';

                  if(is_array($key['child'])) {
                    $this->padding++;
                    echo $ci->get_child($key, $list, $on, $off, $id_level);
                    $this->padding--;
                  }

                  $angka++;
                  
                }
              ?>
              </tbody>
              
            </table>
            </div>
        </div>
    </div>
</div>
<!-- #END#-->
