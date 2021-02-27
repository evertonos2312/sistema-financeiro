<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
	<head>
		<title>{$title} - Cursos Contmatic</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="initial-scale=1">
		<link rel="shortcut icon" href="{$app_url}images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="{$app_url}images/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="images/favicon.ico"/>
		<link rel="stylesheet" href="{$app_url}css/bootstrap.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/fontawesome-all.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/sweetalert2.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/jquery-ui.structure.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/jquery-ui.theme.min.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/bootstrap-datetimepicker.css?v={$ch_ver}">
		<link rel="stylesheet" href="{$app_url}css/default.css?v={$ch_ver}">
		<script language="javascript" type="text/javascript" src="{$app_url}js/jquery-3.5.1.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/jquery-ui-1.12.1.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/datepicker-pt-BR.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/bootstrap.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/sweetalert2.all.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/popper.min.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/moment-with-locales.js?v={$ch_ver}"></script>
		<script language="javascript" type="text/javascript" src="{$app_url}js/bootstrap-datetimepicker.js?v={$ch_ver}"></script>
		<script type="text/javascript" src="{$app_url}js/utils.js?v={$ch_ver}"></script>
		<script type="text/javascript" src="{$app_url}js/Admin/app.js?v={$ch_ver}"></script>
		<script type="text/javascript">
			var app_url = '{$app_url}';
			$.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );
		</script>
	</head>
	<body>
		<div class="page-wrapper chiller-theme toggled">
		<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
		<i class="fas fa-bars"></i>
		</a>
		<nav id="sidebar" class="sidebar-wrapper">
			<div class="sidebar-content">
				<div class="sidebar-brand">
					<div class="col-10">
						<img src="{$app_url}images/logo.png" style="width: 100%" />
					</div>
					<div class="col-2">
						<div id="close-sidebar">
							<i class="fas fa-times"></i>
						</div>
					</div>
				</div>
				<div class="sidebar-menu">
					<ul>
						<li>
							<a href="{$app_url}home/index">
							<i class="fas fa-globe"></i>
							<span>Ir para o Site</span>
							</a>
						</li>
						<li class="sidebar-dropdown {if $breadcrumb.admin.cursos OR $breadcrumb.admin.apostilas OR $breadcrumb.admin.feedbacks}active{/if}">
							<a href="#">
								<i class="fas fa-list"></i>
								<span>Cursos</span>
							</a>
							<div class="sidebar-submenu" style="{if $breadcrumb.admin.cursos OR $breadcrumb.admin.apostilas OR $breadcrumb.admin.feedbacks}display: block{/if}"> 
								<ul>
									<li class="{if $breadcrumb.admin.cursos}active{/if}" >
										<a href="{$app_url}admin/cursos/index">
										<i class="fas fa-list"></i>
										<span>Cursos</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.cursos_aulas}active{/if}" >
										<a href="{$app_url}admin/cursos_aulas/index">
										<i class="fas fa-list"></i>
										<span>Cursos Aulas</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.apostilas}active{/if}" >
										<a href="{$app_url}admin/apostilas/index">
										<i class="fas fa-list"></i>
										<span>Apostilas/Manuais</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.feedbacks}active{/if}" >
										<a href="{$app_url}admin/feedbacks/index">
										<i class="fas fa-list"></i>
										<span>Feedbacks</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="{if $breadcrumb.admin.participantes}active{/if}">
							<a href="{$app_url}admin/participantes/index">
							<i class="fas fa-list"></i>
							<span>Participantes</span>
							</a>
						</li>
						<li class="{if $breadcrumb.admin.turmas}active{/if}">
							<a href="{$app_url}admin/turmas/index">
							<i class="fas fa-list"></i>
							<span>Turmas</span>
							</a>
						</li>
						<li class="{if $breadcrumb.admin.instrutores}active{/if}">
							<a href="{$app_url}admin/instrutores/index">
							<i class="fas fa-list"></i>
							<span>Instrutores</span>
							</a>
						</li>
						<li class="sidebar-dropdown {if $breadcrumb.admin.categorias OR $breadcrumb.admin.locais OR $breadcrumb.admin.subcategorias OR $breadcrumb.admin.arquivos OR $breadcrumb.admin.cursos_imagens}active{/if}">
							<a href="#">
								<i class="fas fa-list"></i>
								<span>Cadastros</span>
							</a>
							<div class="sidebar-submenu" style="{if $breadcrumb.admin.categorias OR $breadcrumb.admin.locais OR $breadcrumb.admin.subcategorias OR $breadcrumb.admin.arquivos OR $breadcrumb.admin.cursos_imagens}display: block{/if}"> 
								<ul>
									<li class="{if $breadcrumb.admin.categorias}active{/if}" >
										<a href="{$app_url}admin/categorias/index">
										<i class="fas fa-list"></i>
										<span>Categorias</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.subcategorias}active{/if}" >
										<a href="{$app_url}admin/subcategorias/index">
										<i class="fas fa-list"></i>
										<span>Subcategorias</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.locais}active{/if}" >
										<a href="{$app_url}admin/locais/index">
										<i class="fas fa-list"></i>
										<span>Locais</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.cursos_imagens}active{/if}" >
										<a href="{$app_url}admin/cursos_imagens/index">
										<i class="fas fa-list"></i>
										<span>Cursos Imagens</span>
										</a>
									</li>
									<li class="{if $breadcrumb.admin.arquivos}active{/if}" >
										<a href="{$app_url}admin/arquivos/index">
										<i class="fas fa-list"></i>
										<span>Arquivos</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="{if $breadcrumb.admin.usuarios}active{/if}">
							<a href="{$app_url}admin/usuarios/index">
							<i class="fas fa-users"></i>
							<span>Usuários</span>
							</a>
						</li>
						<li>
							<a href="{$app_url}admin/login/logout">
							<i class="fas fa-power-off"></i>
							<span>Logout</span>
							</a>
						</li>
					</ul>
				</div>
				<!-- sidebar-menu  -->
			</div>
		</nav>
		<!-- sidebar-wrapper  -->
		<main class="page-content">
			<div class="container-fluid primary-container">
				<div class="box box-primary">
					<div class="box-body">
						<div class="row">
							<div class="col-12 div-title">
								<h4>{$title}</h4>
							</div>
						</div>
						{$content}
					</div>
				</div>
		</main>
		<!-- page-content" -->
		</div>
		<!-- page-wrapper -->
		</body>
</html>