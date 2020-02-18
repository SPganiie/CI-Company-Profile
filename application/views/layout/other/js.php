    <script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/node-waves/waves.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/autosize/autosize.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/momentjs/moment.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/dropzone/dropzone.js"></script>
    <script src="<?php echo base_url()?>assets/plugins/chartjs/Chart.bundle.js"></script>
    <script src="<?php echo base_url()?>assets/tag/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jscolor.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/custom.js"></script>
    <script src="<?php echo base_url()?>assets/js/admin.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.price').priceFormat({
                prefix: '',
                centsLimit: '0',
                thousandsSeparator: '.',
                allowNegative: true
            });
        });
        
        /*for media modal manager file*/
        $(document).on("click", ".btngambar", function () {
            var myfor = $(this).data('for');
            
            $(".modal-body #setfield").val(myfor);
            
            if ((myfor=='')||(myfor=='undefined')) {
                myfor = 'field_gambar';
            };

            var mytype = $(this).data('tp');
            $(".modal-body #settype").val(mytype);

            if (mytype=='') { mytype = '1'; };
            if (mytype=='undefined') { mytype = '1'; };

            var srcMe = "/assets/plugins/filemanager/dialog.php?type="+mytype+"&relative_url=1&akey=a123&field_id="+myfor+"'&fldr="
            $(".modal-body #myiframe").attr('src', srcMe);
        });
         
        function open_palate() { 
            $('#fmenu').prop('hidden',false);
            ShowContent('palete');
            ShowContent_b('palete2');
            ShowContent_c('palete3');
        }

        function change_warna(warna) { styleSet(warna); }        
        function change_warna2(warna) { styleSetMenu(warna); }
        function change_warna3(warna) { styleSetContent(warna); }
        
        var x = readCookie('wcookie')
        if (x!='') { styleSet(x); }
        
        var y = readCookie_b('wcookie_b')
        if (y!='') { styleSetMenu(y); }
        
        var z = readCookie_c('wcookie_c')
        if (z!='') { styleSetContent(z); }

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        $('.datetimepicker').bootstrapMaterialDatePicker({
            format: 'DD-MM-YYYY HH:mm:ss',
            clearButton: true,
            weekStart: 1
        });
    </script>
