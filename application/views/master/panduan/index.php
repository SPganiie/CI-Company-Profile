<?php $ci =& get_instance() ?>
<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">help</i> <?php echo ucwords($ci->lang->line('Panduan')) ?></li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header"><h2><?php echo ucwords($ci->lang->line('Panduan')).' Admin - '.$ci->lang->line('cms') ?></h2></div>
            <div class="body">
                <div class="panel-group" id="accordion_4" role="tab">
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_1">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="false" aria-controls="collapseOne_1" class=""> <?php echo $ci->lang->line('Halaman') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_1" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat halaman baru di web</p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_2">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseOne_2" aria-expanded="false" aria-controls="collapseOne_2" class=""> <?php echo $ci->lang->line('Kategori') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_2" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat kategori baru di web</p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_3">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_3" href="#collapseOne_3" aria-expanded="false" aria-controls="collapseOne_3"> <?php echo $ci->lang->line('Post') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_3" aria-expanded="false">
                            <div class="panel-body">
                                <p style="height:250px">Cara membuat post baru di web</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_4">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapseOne_4" aria-expanded="false" aria-controls="collapseOne_4" class=""> <?php echo $ci->lang->line('Widgets') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_4" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat .......... </p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_5">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapseOne_5" aria-expanded="false" aria-controls="collapseOne_5" class=""> <?php echo $ci->lang->line('Komentar') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_5" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat .......... </p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_6">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapseOne_6" aria-expanded="false" aria-controls="collapseOne_6" class=""> <?php echo $ci->lang->line('Media') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_6" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat .......... </p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_7">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapseOne_7" aria-expanded="false" aria-controls="collapseOne_7" class=""> <?php echo $ci->lang->line('User') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_7" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat .......... </p>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-col-cyan">
                        <div class="panel-heading" role="tab" id="headingOne_8">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion_4" href="#collapseOne_8" aria-expanded="false" aria-controls="collapseOne_8" class=""> <?php echo $ci->lang->line('User Level') ?></a>
                            </h4>
                        </div>
                        <div id="collapseOne_8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_8" aria-expanded="false">
                            <div class="panel-body">
                              <p style="height:250px">Cara membuat .......... </p>  
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- #END#-->
