<!-- <h4 class="judulhalaman">Pengaturan Hak Akses</h4> -->
<?php $ci =& get_instance(); ?>

<style>
  table[border="1"] { border-collapse: collapse; border:0; }
  table[border="1"] td { padding:5px 5px; border: 0; border-bottom: 1px solid #99bce8; }
  table[border="0"] td {  border: 0;  }
</style>

<table width="100%" class="table table-custom table-bordered table-hover">
  <thead>
    <tr align="center">
      <th width='30' align="center">No</th>
      <th>Modul</th>
      <th width=50 align="center">Akses</th>

      <?php foreach ($list as $key) : ?>
        <th width=50 align="center"><?php echo ucwords($key->aksi); ?></th>
      <?php endforeach; ?>

    </tr>
  </thead>

  <?php 
    $on   = img('assets/img/icon/active16.png');
    $off  = img('assets/img/icon/delete16.png');

    $angka = 1;

    foreach($list_parent as $key) {

      $no     = $key['id_module'];
      $crud   = $ci->get_akses($key['id_module'], $id_level);
      
      $akses   = "<a href='javascript:void(0)' onClick=\"aksi('pengaturan/hak_akses/toggle_active/akses/".$key['id_module']."/".$id_level."/".($crud->num_rows() > "0" ? "1" : "0")."', 'akses_".$key['id_module']."')\">".($crud->num_rows() > "0" ? $on : $off)."</a>";

      echo '
        <tr align="center">
          <td align="center">'.$angka.'</td>
          <td align="left">'.$key['nama_module'].'</td>
          <td id="wrap_akses_'.$no.'" colspan=' . (count($list) + 1) . '>
            <table border=0 id="akses_'.$key['id_module'].'">
              <tr align="center">
                <td width="50" style="text-align:center">'.$akses.'</td>';
                foreach ($list as $keys) :
                  $link = "<a href='javascript:void(0)' onClick=\"aksi('pengaturan/hak_akses/toggle_active/aksi/".$key['id_module']."/".$id_level."/".($ci->cek_module_akses($key['id_module'], $id_level, $keys->id_aksi) > "0" ? "1" : "0")."/".$keys->id_aksi."', 'akses_".$key['id_module']."')\">".($ci->cek_module_akses($key['id_module'], $id_level, $keys->id_aksi) > "0" ? $on : $off)."</a>";
                  echo '<td width="50" style="text-align:center">'.($ci->cek_module($key['id_module'], $keys->id_aksi) == '0' ? '-' : $link).'</td>';
                endforeach;
           echo '</tr>
            </table>
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
  
</table>
