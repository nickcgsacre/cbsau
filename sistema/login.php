<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title><?=TITULO_SISTEMA?> - LOGIN</title>
	<link rel="apple-touch-icon" href="<?=URL_SISTEMA?>/app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?=URL_SISTEMA?>/app-assets/images/ico/favicon-32.png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
	rel="stylesheet">
	<link href="<?=URL_SISTEMA?>/app-assets/vendors/css/line-awesome/css/line-awesome.min.css" rel="stylesheet">
	<!-- BEGIN VENDOR CSS-->
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/vendors.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/forms/icheck/icheck.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/forms/icheck/custom.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/vendors/css/extensions/toastr.css">
	<!-- END VENDOR CSS-->
	<!-- BEGIN MODERN CSS-->
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/app.min.css">
	<!-- END MODERN CSS-->
	<link rel="stylesheet" href="<?=URL_SISTEMA?>/app-assets/css/plugins/ladda/ladda.min.css">
	<!-- BEGIN Page Level CSS-->
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/pages/login-register.min.css">
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/app-assets/css/plugins/extensions/toastr.min.css">
	<!-- END Page Level CSS-->
	<!-- BEGIN Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?=URL_SISTEMA?>/assets/css/style.css">
	<!-- END Custom CSS-->
	<script>var URL_SISTEMA = "<?=URL_SISTEMA?>";</script>
</head>
<body class="horizontal-layout horizontal-menu 1-column   menu-expanded blank-page blank-page"
data-open="hover" data-menu="horizontal-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
						<a class="navbar-brand">
						  <img class="brand-logo" src="<?=URL_SISTEMA?>/app-assets/images/logo/logo.png">
						  <h3 class="brand-text"><?=NOME_SISTEMA?></h3>
						</a>
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Acessar o sistema</span>
                  </h6>
                </div>
                <div class="card-content">
                  <div class="card-body">
                    <form id="logar" class="form-horizontal form-simple" novalidate>
					  <input type="hidden" name="acao" value="logar" />
                      <fieldset class="form-group position-relative has-icon-left mb-0">
                        <input type="text" class="form-control form-control-lg input-lg" id="usuario" name="usuario" placeholder="Usuário"
                        required>
                        <div class="form-control-position">
                          <i class="ft-user"></i>
                        </div>
                      </fieldset>
                      <fieldset class="form-group position-relative has-icon-left">
                        <input type="password" class="form-control form-control-lg input-lg" id="senha" name="senha"
                        placeholder="Senha" required>
                        <div class="form-control-position">
                          <i class="la la-key"></i>
                        </div>
                      </fieldset>
                      <div class="form-group row">
                        <div class="col-md-6 col-12 text-center text-md-left">
                          <fieldset>
                            <input type="checkbox" id="remember-me" name="lembrar" class="chk-remember">
                            <label for="remember-me"> Lembrar dados</label>
                          </fieldset>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-info btn-lg btn-block ladda-button" data-style="zoom-in" id="btn-logar">
						<i class="ft-unlock"></i> ACESSAR SISTEMA
					  </button>
                    </form>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="">
                    <p class="float-sm-left text-center m-0"><a href="redefinir-senha" class="card-link">REDEFINIR SENHA</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"
  type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/spin/spin.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/scripts/ladda/ladda.min.js"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="<?=URL_SISTEMA?>/app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/core/app.min.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="<?=URL_SISTEMA?>/app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="<?=URL_SISTEMA?>/app-assets/js/sistema/login.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>