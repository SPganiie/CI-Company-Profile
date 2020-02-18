<!DOCTYPE html>
<?php $ci =& get_instance(); $mysetting_web = $ci->template->mysetting_web(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Log In | Web Admin</title>
    <link rel="icon" href="<?php echo $mysetting_web->url_favicon ?>" type="image/x-icon">
    <?php $ci->load->view('auth/part/head.php'); ?> 
</head>

<body class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <div class="logo" style="vertical-align:middle; text-align:center" >
                    <img src="<?php echo $mysetting_web->url_favicon ?>" style="width: 70px;height: 70px;">
                    <h3 style="text-align: center;">WEB MANAGEMENT</h3> 
                </div>
                <?php echo form_open('user/login',array('name'=>'login-form','class'=>'login-form')); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">person</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off" autofocus="true">
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">lock</i></span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="off">
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="form-line">
                            <p style="text-align:center"><?php echo $cap_img;?> *case sensitive</p>
                            <p><input type="text" name="kode_captcha" value="" placeholder="Captcha" autocomplete="off" required class="form-control"><?php echo form_error('kode_captcha', '<span class="text-error">* ', '</span>'); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="<?php echo base_url().'user/forgot' ?>"><?php echo $ci->lang->line('lupa_pass') ?>?</a>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-blue waves-effect" type="submit">LOG IN</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <?php $ci->load->view('auth/part/js.php'); ?>

</body>

</html>