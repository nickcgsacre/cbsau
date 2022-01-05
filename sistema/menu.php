<body class="horizontal-layout horizontal-menu 2-columns   menu-expanded" data-open="hover"
data-menu="horizontal-menu" data-col="2-columns">
  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
            <a class="navbar-brand" href="<?=URL_SISTEMA?>">
              <img class="brand-logo" src="<?=URL_SISTEMA?>/app-assets/images/logo/logo.png">
              <h3 class="brand-text"><?=NOME_SISTEMA?></h3>
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
                <input class="input" type="text" placeholder="Buscar Associado">
              </div>
            </li>
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">
					<?=saudacao()?>,
                  <span class="user-name text-bold-700"><?=$DADOS_USUARIO->nome?></span>
                </span>
                <span class="avatar">
                  <img src="<?=URL_SISTEMA?>/app-assets/images/portrait/small/avatar-<?=strtoupper($DADOS_USUARIO->nome[0])?>.png" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Editar Perfil</a>
                <a class="dropdown-item" href="#"><i class="la la-key"></i> Alterar Senha</a>
                <div class="dropdown-divider"></div>
				<a class="dropdown-item" href="javascript:deslogar()">
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
  
  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
  role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="nav-link" href="<?=URL_SISTEMA?>"><i class="fa fa-tachometer"></i>
            <span>Dashboard</span>
          </a>
        </li>
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
		<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="<?=URL_SISTEMA?>/associados/listar" data-toggle="dropdown"><i class="fa fa-users"></i><span>Associados</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/associados/listar">LISTAR ASSOCIADOS</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/associados/novo">NOVO ASSOCIADO</a>
            </li>
          </ul>
        </li>
		<?php } ?>
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
		<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="<?=URL_SISTEMA?>/associados/listar" data-toggle="dropdown"><i class="fa fa-address-card-o"></i><span>Funcionários</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/usuarios/listar&tipo=internos&key=true">FUNCIONÁRIOS INTERNOS</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/usuarios/listar&tipo=externos&key=true">FUNCIONÁRIOS EXTERNOS</a>
            </li>
          </ul>
        </li>
		<?php } ?>
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
        <li class="dropdown nav-item"><a href="<?=URL_SISTEMA?>/fornecedores/listar" class="nav-link"><i class="fa fa-suitcase"></i><span>Fornecedores</span></a>
        </li>
		<?php } ?>
		
		<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="<?=URL_SISTEMA?>/associados/listar" data-toggle="dropdown"><i class="fa fa-folder-open-o"></i><span>Serviços</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/ficha/listar">FICHA MÉDICA</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/ficha/atestado">ATESTADO MÉDICO</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/ficha/receituario">RECEITUÁRIO MÉDICO</a>
            </li>
			<?php if($DADOS_USUARIO->tipo == 1) { ?>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/guias/listar">GUIAS DE ENCAMINHAMENTO</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/ficha/declaracao">DECLARAÇÕES/AUTORIZAÇÕES</a>
            </li>
			<?php } ?>
          </ul>
        </li>
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
        <li class="dropdown" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-money"></i><span>Financeiro</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/financeiro/servicos">SERVIÇOS</a></li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/financeiro/mensalidades">MENSALIDADES</a></li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/financeiro/contas/listar">CONTAS BANCARIAS</a></li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/financeiro/receitas/listar">RECEITAS</a></li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/financeiro/despesas/listar">DESPESAS</a></li>
          </ul>
        </li>	
		<?php } ?>	
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
		<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-pie-chart"></i><span>Relatórios</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="#">ASSOCIADOS</a></li>
            <li class="dropdown"><a class="dropdown-item" href="#">DEPENDENTES</a></li>
            <li class="dropdown"><a class="dropdown-item" href="#">FORNECEDORES</a></li>
            <li class="dropdown"><a class="dropdown-item" href="#">GUIAS</a></li>
            <li class="dropdown"><a class="dropdown-item" href="#">ORDEM DE SERVIÇO</a></li>
          </ul>
        </li>
		<?php } ?>	
		
		<?php if($DADOS_USUARIO->tipo == 1) { ?>
		<li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#configuracoes" data-toggle="dropdown"><i class="la la-cogs"></i><span>Configurações</span></a>
          <ul class="dropdown-menu">
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/cargos/listar">CONFIGURAR CARGOS</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/parentesco/listar">CONFIGURAR PARENTESCO</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/planos/listar">CONFIGURAR PLANOS</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/servicos/listar">CONFIGURAR SERVIÇOS</a>
            </li>
            <li class="dropdown"><a class="dropdown-item" href="<?=URL_SISTEMA?>/ajustes/listar">CONFIGURAR SISTEMA</a>
            </li>
          </ul>
        </li>
		<?php } ?>	
      </ul>
    </div>
  </div>