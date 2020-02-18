<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home </a></li>
        <li class="active"><i class="material-icons">settings</i> <?php echo $ci->lang->line('Pengaturan Web') ?></li>
    </ol>
</div>
<!-- #CONTENT# -->
<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header"><h2> <?php echo $ci->lang->line('Pengaturan Web') ?> </h2></div>
        <div class="body">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#umum" data-toggle="tab"><i class="material-icons">credit_card</i> <?php echo $ci->lang->line('umum') ?></a>
                </li>
                <li role="presentation">
                    <a href="#konfigurasi" data-toggle="tab"><i class="material-icons">settings_applications</i> <?php echo $ci->lang->line('konfigurasi') ?></a>
                </li>
                <li role="presentation">
                    <a href="#menu" data-toggle="tab"><i class="material-icons">settings_applications</i> Menu Website</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="umum">
                    <?php $ci->load->view('pengaturan/pengaturan_web/umum') ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="konfigurasi">
                    <?php $ci->load->view('pengaturan/pengaturan_web/konfigurasi') ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="menu">
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- #END#-->
<script type="text/javascript">
    $.ajax({
        type: 'POST',
        url : '<?php echo base_url() ?>pengaturan/menu_web',
        data: null,
        success:function(i)
            {
            $('#menu').html(i);
            }
        });
</script>