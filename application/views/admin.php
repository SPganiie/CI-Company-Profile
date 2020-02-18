<?php $ci =& get_instance();?>
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange hover-expand-effect">
            <div class="icon">
                <i class="material-icons">pageview</i>
            </div>
            <div class="content">
                <div class="text"><?php echo strtoupper($ci->lang->line('pengunjung')) ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $sum_pengunjung ?>" data-speed="1000" data-fresh-interval="5">
                    <?php echo $sum_pengunjung ?>
                </div>
            </div>
        </div>
    </div>
    <a href="<?php echo base_url()?>master/post">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">content_copy</i>
            </div>
            <div class="content">
                <div class="text"><?php echo strtoupper($ci->lang->line('post')) ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $sum_post ?>" data-speed="15" data-fresh-interval="5">
                    <?php echo $sum_post ?>
                </div>
            </div>
        </div>
    </div>
	</a>
	<a href="<?php echo base_url()?>master/komentar">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text"><?php echo strtoupper($ci->lang->line('komentar')) ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $sum_komentar ?>" data-speed="1000" data-fresh-interval="5">
                    <?php echo $sum_komentar ?>
                </div>
            </div>
        </div>
    </div>
	</a>
	<a href="<?php echo base_url()?>master/halaman">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">assignment</i>
            </div>
            <div class="content">
                <div class="text"><?php echo strtoupper($ci->lang->line('halaman')) ?></div>
                <div class="number count-to" data-from="0" data-to="<?php echo $sum_halaman ?>" data-speed="1000" data-fresh-interval="5">
                    <?php echo $sum_halaman ?>
                </div>
            </div>
        </div>
    </div>
	</a>
</div>

<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>DASHBOARD</h2>
            </div>
            <div class="body">
                <h5><?php echo $ci->lang->line('home_statistik') ?></h5>
                <div style="width: 65%" class="form-group">
                    <div class="col-sm-4">
                        <div class="form-line"><input type="text" id="tgl_dari" value="<?php echo $tgl_dari ?>" class="datepicker form-control" placeholder="Dari Tgl"></div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-line"><input type="text" id="tgl_sampai" value="<?php echo $tgl_sampai ?>" class="datepicker form-control" placeholder="Sampai Tgl"></div>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" onclick="window.location.href='admin?tgl_dari='+$('#tgl_dari').val()+'&tgl_sampai='+$('#tgl_sampai').val()" class="btn btn-sm btn-primary" title="Search"><i class="material-icons">search</i></button>
                        <button type="button" onclick="cleartrafic()" class="btn btn-sm btn-primary" title="Clear traffic"><i class="material-icons">delete_forever</i></button>
                    </div>
                </div>
                <div class="clear"><br></div>
                <canvas id="line_chart" height="56%"></canvas>
            </div>
        </div>
    </div>
</div>
<?php
    if ($traffic!='0')
        {
        foreach ($traffic as $key)
            {
            $tgl [] = tgl($key->tgl);
            $tot [] = $key->tot;
            }
        } else
            {
            $tgl [] = 0;
            $tot [] = 0;
            }
?>
<script type="text/javascript">
    $(function () { new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs()); });

    function getChartJs()
    {
        var config = null;

        config = {
            type: 'line',
            data: {
                labels: <?php echo json_encode($tgl) ?>,
                datasets: [{
                    label: "<?php echo $ci->lang->line('pengunjung') ?> ",
                    data: <?php echo json_encode($tot) ?>,
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
        return config;
    }

    function cleartrafic()
    {
        if(confirm('<?php echo $ci->lang->line("yakin") ?>?'))
            {
            window.location.href="admin/clear_trafic/"+$('#tgl_dari').val()+"/"+$('#tgl_sampai').val();
            }
    }
</script>
