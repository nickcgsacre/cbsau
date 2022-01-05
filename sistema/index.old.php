<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <title>SISTEMA FUNDSEG</title>
  <link rel="apple-touch-icon" href="./app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="./app-assets/images/ico/favicon-32.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="./app-assets/vendors/css/line-awesome/css/line-awesome.min.css" rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="./app-assets/css/vendors.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/weather-icons/climacons.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/fonts/meteocons/style.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/charts/morris.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/charts/chartist.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/vendors/css/charts/chartist-plugin-tooltip.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="./app-assets/css/app.min.css">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="./app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/css/core/colors/palette-gradient.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/fonts/simple-line-icons/style.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/css/core/colors/palette-gradient.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/timeline.min.css">
  <link rel="stylesheet" type="text/css" href="./app-assets/css/pages/dashboard-ecommerce.min.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  <!-- END Custom CSS-->
</head>
<body class="horizontal-layout horizontal-menu 2-columns   menu-expanded" data-open="hover"
data-menu="horizontal-menu" data-col="2-columns">
  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
            <a class="navbar-brand" href="index.html">
              <img class="brand-logo" alt="modern admin logo" src="./app-assets/images/logo/logo.png">
              <h3 class="brand-text">FUNDSEG</h3>
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
            
            <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
              <div class="search-input">
                <input class="input" type="text" placeholder="Buscar Estabelecimento">
              </div>
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">Boa tarde,
                  <span class="user-name text-bold-700">Aliton Silva</span>
                </span>
                <span class="avatar">
                  <img src="./app-assets/images/portrait/small/avatar-A.png" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Editar Perfil</a>
                <a class="dropdown-item" href="#"><i class="la la-key"></i> Alterar Senha</a>
                <div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">
					<i class="ft-power"></i> Sair
				</a>
              </div>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">1</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Notificações</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-danger float-right m-0">1 Novas</span>
                </li>
                <li class="scrollable-container media-list w-100">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">Cadastro aprovado!</h6>
                        <p class="notification-text font-small-3 text-muted">Administrador aprovou o seu cadastro</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutos atràs</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Ver todas as modificações</a></li>
              </ul>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
  </nav>
  
  
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
  role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="index.html" data-toggle="dropdown"><i class="la la-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-folder-open"></i><span>Estabelecimentos</span></a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-users"></i><span>Usuários</span></a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-notebook"></i><span>Agenda</span></a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-paper-clip"></i><span>Tarefas</span></a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-money"></i><span>Financeiro</span></a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-pie-chart"></i><span>Relatórios</span></a>
        </li>
      </ul>
    </div>
  </div>
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <!-- eCommerce statistic -->
        <div class="row">
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="info">850</h3>
                      <h6>Estabelecimentos</h6>
                    </div>
                    <div>
                      <i class="la la-beer info font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="warning">748</h3>
                      <h6>Licenças Vencidas</h6>
                    </div>
                    <div>
                      <i class="la la-money warning font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 35%"
                    aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="warning">48</h3>
                      <h6>Taxas Vencidas</h6>
                    </div>
                    <div>
                      <i class="la la-money warning font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 12%"
                    aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="danger">3.015</h3>
                      <h6>Autuações</h6>
                    </div>
                    <div>
                      <i class="icon-info danger font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%"
                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="success">146</h3>
                      <h6>Eventos Mensais</h6>
                    </div>
                    <div>
                      <i class="la la-history success font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="success">445</h3>
                      <h6>Eventos Ocasional</h6>
                    </div>
                    <div>
                      <i class="la la-ticket success font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="success">8.445</h3>
                      <h6>Visitas Realizadas</h6>
                    </div>
                    <div>
                      <i class="la la-binoculars success font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
          <div class="col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                      <h3 class="success">445</h3>
                      <h6>Visitas este Mês</h6>
                    </div>
                    <div>
                      <i class="la la-binoculars success font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                    <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 100%"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  
		  
        </div>
        <!--/ eCommerce statistic -->
		
        
        <!-- Recent Transactions -->
        <div class="row">
          <div id="recent-transactions" class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Movimentações financeira</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right"
                      href="boletos.php" target="_blank">Todos os boletos</a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content">
                <div class="table-responsive">
                  <table id="recent-orders" class="table table-hover table-xl mb-0">
                    <thead>
                      <tr>
                        <th class="border-top-0">Situação</th>
                        <th class="border-top-0">Fatura</th>
                        <th class="border-top-0">Estabelecimento</th>
                        <th class="border-top-0">Serviço</th>
                        <th class="border-top-0">Vencimento</th>
                        <th class="border-top-0">Valor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-truncate"><i class="la la-dot-circle-o success font-medium-1 mr-1"></i> Pago</td>
                        <td class="text-truncate"><a href="#">001001</a></td>
                        <td class="text-truncate">
                          <span class="avatar avatar-xs">
                            <img class="box-shadow-2" src="./app-assets/images/portrait/small/avatar-M.png"
                            alt="avatar">
                          </span>
                          <span>Maison Borges</span>
                        </td>
                        <td>
                          Taxa de renovação do serviços
                        </td>
                        <td>
                          01/05/2018
                        </td>
                        <td class="text-truncate">R$ 120,00</td>
                      </tr>
					  
                      <tr>
                        <td class="text-truncate"><i class="la la-dot-circle-o danger font-medium-1 mr-1"></i> Vencido</td>
                        <td class="text-truncate"><a href="#">001001</a></td>
                        <td class="text-truncate">
                          <span class="avatar avatar-xs">
                            <img class="box-shadow-2" src="./app-assets/images/portrait/small/avatar-M.png"
                            alt="avatar">
                          </span>
                          <span>Maison Borges</span>
                        </td>
                        <td>
                          Taxa de renovação do serviços
                        </td>
                        <td>
                          01/05/2018
                        </td>
                        <td class="text-truncate">R$ 120,00</td>
                      </tr>
					  
                      <tr>
                        <td class="text-truncate"><i class="la la-dot-circle-o warning font-medium-1 mr-1"></i> Cancelada</td>
                        <td class="text-truncate"><a href="#">001001</a></td>
                        <td class="text-truncate">
                          <span class="avatar avatar-xs">
                            <img class="box-shadow-2" src="./app-assets/images/portrait/small/avatar-M.png"
                            alt="avatar">
                          </span>
                          <span>Maison Borges</span>
                        </td>
                        <td>
                          Taxa de renovação do serviços
                        </td>
                        <td>
                          01/05/2018
                        </td>
                        <td class="text-truncate">R$ 120,00</td>
                      </tr>
					  
                      <tr>
                        <td class="text-truncate"><i class="la la-dot-circle-o info font-medium-1 mr-1"></i> Não Pago</td>
                        <td class="text-truncate"><a href="#">001001</a></td>
                        <td class="text-truncate">
                          <span class="avatar avatar-xs">
                            <img class="box-shadow-2" src="./app-assets/images/portrait/small/avatar-M.png"
                            alt="avatar">
                          </span>
                          <span>Maison Borges</span>
                        </td>
                        <td>
                          Taxa de renovação do serviços
                        </td>
                        <td>
                          01/05/2018
                        </td>
                        <td class="text-truncate">R$ 120,00</td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--/ Recent Transactions -->
		
		<!-- MAPA -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Geolocalização</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
							<ul class="list-inline mb-0">
								<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="card-content collapse show">
						<div class="card-body">
							<div id="map" class="height-400"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ MAPA -->
        
      </div>
    </div>
  </div>
  
  <footer class="footer footer-static footer-light navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
      <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"><!-- DESENVOLVIDO POR ACRE SITES --></span>
    </p>
  </footer>
  <!-- BEGIN VENDOR JS-->
  <script src="./app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script type="text/javascript" src="./app-assets/vendors/js/ui/jquery.sticky.js"></script>
  <script type="text/javascript" src="./app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
  <script src="./app-assets/vendors/js/charts/chartist.min.js" type="text/javascript"></script>
  <script src="./app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"
  type="text/javascript"></script>
  <script src="./app-assets/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
  <script src="./app-assets/vendors/js/charts/morris.min.js" type="text/javascript"></script>
  <script src="./app-assets/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>
  <script src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAWJvXZ2T34MFZJIGW5kRcUZjN6WJQHMb8"></script>
  <script src="./app-assets/vendors/js/charts/gmaps.min.js" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="./app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
  <script src="./app-assets/js/core/app.min.js" type="text/javascript"></script>
  <script src="./app-assets/js/scripts/customizer.min.js" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script type="text/javascript" src="./app-assets/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
  <script src="./app-assets/js/scripts/charts/gmaps/maps.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
</body>
</html>