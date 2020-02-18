<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">web</i> <?php echo ucwords($ci->lang->line('Tema')) ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header"><h2><?php echo $ci->lang->line('Tema') ?></h2></div>
            <div class="body">
                <div style="margin-left: 10%;margin-right: 10%;"  class="row">
                    <div name="tema_satu" style="float:left;">
                        <div>
                            <h5 style="float:left;">Tema Satu</h5> &nbsp;
                            <button class="btn btn-sm btn-info waves-effect">Terapkan Tema</button>
                        </div>
                        <i>
                            <p>** Note :</p>
                            <p>1 = Widget Atas</p>
                            <p>2 = Widget Kanan Kiri</p>
                            <p>3 = Widget Bawah</p>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>