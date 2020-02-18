<?php $ci =& get_instance() ?>
<div class="row">
    <div class="body table-responsive" style="margin: 0 auto;">
        <table width="100%" border="0">
            <tr align="center">
                <td>Database</td>
                <td>Uploaded File</td>
            </tr>
            <tr align="center">
                <td height="80px"><a href="<?php echo base_url('pengaturan/mybc/backup_db') ?>" class="button btn btn-sm btn-primary"> Backup Database</a></td>
                <td><a href="<?php echo base_url('pengaturan/mybc/backup_folder') ?>" class="button btn btn-sm btn-primary"> Backup Uploaded File</a></td>
            </tr>
            <tr align="center">
                <td>
                    <a id="db" class="button btn btn-sm btn-primary"> Restore Database</a>
                    <form id="form_db" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" id="file_db_restore" style="display: none;">
                    </form>
                </td>
                <td>
                    <a id="media" class="button btn btn-sm btn-primary"> Restore Uploaded File</a>
                    <form id="form_media" method="post" enctype="multipart/form-data">
                        <input type="file" id="file_media_restore" style="display: none;">
                    </form>
                </td>
            </tr>
            <tr><td><br></td></tr>
        </table>
    </div>
</div>

<script type="text/javascript">
    $("#db").click(function() {
        $("#file_db_restore").trigger("click");
        $('#file_db_restore').change(function() {
            db_restore();
        });
    });

    $("#media").click(function() {
        $("#file_media_restore").trigger("click");
        $('#file_media_restore').change(function() {
            media_restore();
        });
    });

    function db_restore()
    {
        var formdata = new FormData($('#form_db')[0]);
        var files = $('#file_db_restore')[0].files[0];

        if ($('#file_db_restore').val()=='')
            {
            alert('File kosong');
            }
            else
                {
                if (confirm("<?php echo $ci->lang->line('yakin').'? \n'.$ci->lang->line('proses_waktu') ?> "))
                    {
                    formdata.append('file',files);
                    $('.page-loader-wrapper').fadeIn();

                    $.ajax({
                        url: '/pengaturan/mybc/restore_db',
                        type: 'post',
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function(res) 
                            {
                            if (res!='ok') {
                                alert(res);
                                $('#file_db_restore').val('');
                            }
                            else {
                                alert('sukses restore database');
                                location.reload();
                            }

                            $('.page-loader-wrapper').fadeOut();
                            },
                            error: function(er)
                                {
                                alert('Terjadi kesalahan server, coba ulangi lagi');
                                $('.page-loader-wrapper').fadeOut();
                                }
                        });
                    }else
                        return false;
                }
    }

    function media_restore()
    {
        var formdata = new FormData($('#form_media')[0]);
        var files = $('#file_media_restore')[0].files[0];

        if ($('#file_media_restore').val()=='')
            {
            alert('File kosong');
            }
            else
                {
                if (confirm("<?php echo $ci->lang->line('yakin').'? \n'.$ci->lang->line('proses_waktu') ?> "))
                    {
                    formdata.append('file',files);
                    $('.page-loader-wrapper').fadeIn();
                    
                    $.ajax({
                        url: '/pengaturan/mybc/restore_media',
                        type: 'post',
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function(res) 
                            {
                            if (res!='ok'){
                                alert(res);
                                $('#file_media_restore').val('');
                            }
                            else {
                                alert('sukses restore file media');
                                location.reload();
                            }

                            $('.page-loader-wrapper').fadeOut();
                            },
                            error: function(er)
                                {
                                alert('Terjadi kesalahan server, coba ulangi lagi');
                                $('.page-loader-wrapper').fadeOut();
                                }
                        });
                    }else
                        return false;
                }
    }
</script>