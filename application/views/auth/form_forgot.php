<!DOCTYPE html>
<?php $ci =& get_instance(); $mysetting_web = $ci->template->mysetting_web(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Forgot Password | Web Admin</title>
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
                <?php echo form_open('user/forgot',array('name'=>'login-form','class'=>'login-form')); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">person</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off" autofocus="true">
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">email</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="email" placeholder="E-mail" required autocomplete="off">
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="material-icons">phone</i></span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="telp" placeholder="Telp" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a class="btn btn-block bg-red waves-effect" type="button" href="<?php echo base_url().'user/login' ?>"><?php echo strtoupper($ci->lang->line('kembali')) ?> LOG-IN</a>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-blue waves-effect" type="submit" onclick="">SUBMIT</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <?php $ci->load->view('auth/part/js.php'); ?>

</body>

</html>