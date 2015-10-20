
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>SI Notaris</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Login <strong>Sistem Informasi</strong> Kenotariatan</h1>
      <div class="panel panel-login">
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismisable" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <div class="panel-body">
          <form id="login-form" action = "<?php echo base_url() . 'login'; ?>" method = "POST" class="form-horizontal" style="display:block;">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <?php if ($this->session->flashdata('username')):
                  $jeneng = $this->session->flashdata('username');
                  else:
                  $jeneng = "";  
                endif ?>
                <input type="text" class="form-control" name="un" id="inputEmail3" placeholder="Username" value="<?php echo $jeneng;?>" autofocus required >
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="pwd" id="inputPassword3" placeholder="Password" required >
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Log In</button>
                <a class="text-danger text-sm pull-right" href="#" id="forgotPass"><i class="glyphicon glyphicon-question-sign"></i> Lupa Password?</a>
              </div>
            </div>
          </form>
          <form id="forgot-form" action = "<?php echo base_url('Login/forgot_pass') ?>" method = "POST" class="form-horizontal" style="display:none;">
                <p class="text-success">Password akan dikirimkan ke alamat email anda</p>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <?php if ($this->session->flashdata('username')):
                    $jeneng = $this->session->flashdata('username');
                    else:
                    $jeneng = "";
                    endif ?>
                    <input type="text" class="form-control" name="un" id="inputEmail3" placeholder="Username" value="<?php echo $jeneng;?>" autofocus required >
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Kirim Password</button>
                    <a class="btn btn-default" href="#" id="loginForm">Kembali</a>
                  </div>
                </div>
              </form>
        </div>
        <div class="panel-footer">
          <p class="text-center">Tugas Akhir | M Ichsan Adhiim | 21120110141059</p>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.11.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($){

        $("#forgotPass").click(function(e){
                $("#forgot-form").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                e.preventDefault();
            });

            $("#loginForm").click(function(e){
                $("#login-form").delay(100).fadeIn(100);
                $("#forgot-form").fadeOut(100);
                e.preventDefault();
            });

      });
    </script> 
  </body>
</html>
