<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">comment</i> <?php echo $ci->lang->line('komentar') ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header"><h2><?php echo $ci->lang->line('Komentar') ?> </h2></div>
            <div class="body table-responsive">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div style="float:left"><input type="text" id="src" class="form-control" onkeypress="if(event.which==13) {aksi('master/komentar?src='+this.value)}" placeholder="<?php echo $ci->lang->line('ketik_cari') ?>" value="<?php echo $src ?>"></div>
                    <button type="button" class="btn btn-sm btn-primary waves-effect waves-float" onclick="aksi('master/komentar?src='+ $('#src').val())"> <i class="material-icons">search</i> </button>
                </div>
                <?php if (!empty($list)) : ?>
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th><?php echo $ci->lang->line('post') ?></th>
                                <th width="15%"><?php echo $ci->lang->line('waktu') ?></th>
                                <th><?php echo $ci->lang->line('nama') ?></th>
                                <th>E-mail</th>
                                <th width="30%"><?php echo $ci->lang->line('komentar') ?></th>
                                <th><?php echo $ci->lang->line('terbit') ?></th>
                                <th width="10%"><?php echo $ci->lang->line('aksi') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=$this->mypaging->nomor(); foreach ($list as $key) : ?>
                                <?php $post = id_to_name('post', 'id_post', $key->id_post, 'judul_seo_post') ?>
                                <?php $tgl = substr($key->waktu_komentar, 0, 10); $jam = substr($key->waktu_komentar, 10); ?>
                                <tr>
                                    <td align="center"><?php echo $no ?>.</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url().'post/detail_post/'.$post ?>">
                                            <?php echo ucwords(str_replace('-', ' ', $post)) ?>
                                        </a>
                                    </td>
                                    <td><?php echo tgl($tgl).','.$jam ?></td>
                                    <td><?php echo $key->nama ?></td>
                                    <td><?php echo $key->email ?></td>
                                    <td><?php echo $key->isi_komentar ?></td>
                                    <td align="center"><?php echo ($key->terbitkan=='1') ? 'Y' : 'N' ?></td>
                                    <td align="center">
                                        <?php echo ($key->terbitkan=='0') ? akses_crud(base_url('master/komentar/terbitkan/'.$key->id_komentar), '<i class="material-icons md-18" style="color:#000" title="'.$ci->lang->line("terbitkan").'">check_circle</i>', $this->id_level_now, $this->id_module_now, 'edit', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'' )."&nbsp;" : 
                                            akses_crud(base_url('master/komentar/batal_terbitkan/'.$key->id_komentar), '<i class="material-icons md-18" style="color:#000" title="'.$ci->lang->line("batal_terbit").'">cancel</i>', $this->id_level_now, $this->id_module_now, 'edit', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'' ) ?>
                                        <?php echo "
                                            ".akses_crud(base_url('master/komentar/balas/'.$key->id_komentar), '<i class="material-icons md-18" style="color:#000" title="'.$ci->lang->line("balas").'">reply_all</i>', $this->id_level_now, $this->id_module_now, 'edit' )." 
                                            ".akses_crud(base_url('master/komentar/hapus/'.$key->id_komentar), '<i class="material-icons md-18" style="color:#000" title="Delete">delete_forever</i>', $this->id_level_now, $this->id_module_now, 'hapus', 'onclick=\'return confirm("'.$ci->lang->line("yakin").'?")\'')."";
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
