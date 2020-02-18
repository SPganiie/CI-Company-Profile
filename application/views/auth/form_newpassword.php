<!DOCTYPE html>
<?php $ci =& get_instance(); $mysetting_web = $ci->template->mysetting_web(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>New Password | Web Admin</title>
    <link rel="icon" href="<?php echo $mysetting_web->url_favicon ?>" type="image/x-icon">
    <?php $ci->load->view('auth/part/head.php'); ?> 
</head>

<body class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <div class="logo" style="vertical-align:middle; text-align:center" >
                    <img src="<?php echo $mysetting_web->url_favicon ?>" style="width: 70px;height: 70px;">
                    <h3 style="text-align: center;">ADMIN - <?php echo strtoupper($mysetting_web->nama_web) ?> </h3> 
                </div>
                <form id="newpass_form">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">person</i></span>
                        <div class="form-line">
                            <input type="hidden" name="id_user" value="<?php echo $info->id_user ?>">
                            <input type="text" class="form-control" name="username" value="<?php echo $info->username ?>" readonly >
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">email</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email"value="<?php echo $info->email ?>" readonly>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">phone</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="telp" value="<?php echo $info->telp ?>" readonly>
                        </div>
                    </div>                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">lock</i></span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="<?php echo $ci->lang->line('new_pass') ?>" maxlength="20" minlength="5" required autofocus="true">
                        </div>
                    </div>                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">lock</i></span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="<?php echo $ci->lang->line('konf_pass') ?>" maxlength="20" minlength="5" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-blue waves-effect" type="button" onclick="send()">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $ci->load->view('auth/part/js.php'); ?>
    <script type="text/javascript">
        function send() 
        {
            var pass   = $('#new_password').val();
            var kofrm  = $('#confirm_password').val();

            if ( pass != kofrm)
                {
                alert('Password konfirmasi yang anda masukan tidak sesuai');
                } else
                    {
                    $.ajax({
                        type: 'POST',
                        url : '<?php echo base_url()."user/new_password" ?>',
                        data: $('#newpass_form').serialize(),
                        success:function(i)
                            {
                            if(i == 'sukses')
                                {
                                alert(i);
                                window.location.href = '<?php echo base_url() ?>user/login/';
                                } else
                                    {
                                    alert(i);
                                    }
                            }
                    });
                        
                    }
        }
    </script>
</body>

</html>