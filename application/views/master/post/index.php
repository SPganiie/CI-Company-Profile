<?php $ci =& get_instance();
$mysetting_web = $ci->template->mysetting_web();  
?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">content_copy</i> <?php echo $ci->lang->line('post') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>
                    <?php echo $ci->lang->line('Post') ?>
                    <?php echo akses_crud(base_url('master/komentar'), $ci->lang->line('lihat').' '.$ci->lang->line('komentar'), $this->id_level_now, $this->id_module_now, 'lihat', 'class="btn bg-red waves-effect pull-right" '); ?>
					<?php echo akses_crud(base_url('master/post/tambah'), $ci->lang->line('tambah').' '.$ci->lang->line('post'), $this->id_level_now, $this->id_module_now, 'tambah', 'class="btn bg-green waves-effect pull-right" '); ?>
                </h2>
            </div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/post?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/post?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo $ci->lang->line('judul') ?> | Link</th>
                                <th><?php echo $ci->lang->line('Kategori') ?></th>
                                <th><?php echo $ci->lang->line('penulis') ?></th>
                                <th width="50"><?php echo $ci->lang->line('Komentar') ?></th>
                                <th width="50"><?php echo $ci->lang->line('aktif') ?></th>
                                <th width="100"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <tr>
                                    <td align="center"><?php echo $no ?>.</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url().$mysetting_web->page_news.'/'.$key->nama_post.'.'.$mysetting_web->ext;?>">
                                            <?php echo $key->judul_seo_post;?> 
                                        </a>
                                    </td>
                                    <td>
                                    <?php 
                                        $kat = $ci->get_kategori($key->id_post);
                                        foreach ($kat as $list) 
                                            {
                                            $kategori = str_replace('-', ' ', id_to_name('kategori_post', 'id_kategori_post', $list->id_kategori, 'nama_kategori_post'));
                                            echo ucwords($kategori).", ";
                                            } 
									$jml_komentar = 0;
									if($key->aktif)
										{
										$jml_komentar = $this->db->select('COUNT(id_komentar) as tot')->where('id_post',$key->id_post)->get('komentar')->row('tot');
										}
                                    ?>
                                    </td>
                                    <td><?php echo ucwords($key->penulis_post) ?> </td>
                                    <td align="center"><a href="<?php echo base_url().'master/komentar/lihat/'.$key->id_post;?>/1"><?php echo ($key->komentar=='1') ? $jml_komentar : '-' ?></a></td>
                                    <td align="center"><?php echo ($key->aktif=='1') ? 'Y' : 'N' ?></td>
                                    <td align="right" style="padding-right: 13px;"> 
                                        <?php echo ($key->publish=='0') ? akses_crud(base_url('master/post/publish/'.$key->id_post), '<i class="material-icons md-18" style="color:#000" title="Publish">check_circle</i>', $this->id_level_now, $this->id_module_now, 'edit', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'') : '' ?>
                                        <?php echo "&nbsp;".
                                            akses_crud(base_url('master/post/edit/'.$key->id_post), '<i class="material-icons md-18" style="color:#000" title="Edit">create</i>', $this->id_level_now, $this->id_module_now, 'edit')."&nbsp;".
                                            akses_crud(base_url('master/post/hapus/'.$key->id_post), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'')."";
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