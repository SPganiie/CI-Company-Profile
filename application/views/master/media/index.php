<div class="block-header">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin')?>"><i class="material-icons">home</i> Home</a></li>
        <li class="active"><i class="material-icons">perm_media</i> Media</li>
    </ol>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card" id="b_content">
            <div class="header">
                <h2>Media</h2>
            </div>
            <div class="body">
               <div id="media_div" style="height: 600px;"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    openMedia();

    function openMedia() {
        var div = document.getElementById('media_div');
        window.div = {
            callBack: function(url) {
                window.div = null;
                div.style.display = 'none';
                div.innerHTML = '';
            }
        };

        div.innerHTML = '<iframe width="100%" height="100%" src="<?php echo base_url() ?>assets/plugins/filemanager/dialog.php?type=0&akey=a123&fldr=" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>';
    }
</script>
<!-- #END#-->
